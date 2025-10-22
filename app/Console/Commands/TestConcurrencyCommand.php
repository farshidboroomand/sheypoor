<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Modules\V1\Player\Models\Player;
use Symfony\Component\Process\Process;

class TestConcurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:concurrency {requests=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests concurrency by sending N scores for a single player';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $requests = (int) $this->argument('requests');
        $fixedScore = 500;

        /** @var Player $player */
        $player = Player::query()
            ->firstOrCreate(
                ['username' => 'test_player'],
                ['score' => 0]
            );
        $playerId = $player->id;

        $player->score = 0;
        $player->save();

        $this->info("Player ID: {$playerId}");
        $endpoint = URL::route('api.v1.player.update.score', ['player' => $playerId], false);
        $baseUrl = config('app.url').$endpoint;

        $command = "curl -s -X PATCH '{$baseUrl}' -H 'Accept: application/json' -H 'Content-Type: application/json' -d '{\"score\": {$fixedScore}}'";

        $processes = [];
        $bar = $this->output->createProgressBar($requests);
        $startTime = microtime(true);

        for ($i = 0; $i < $requests; $i++) {
            $process = Process::fromShellCommandline($command);
            $process->start();
            $processes[] = $process;
        }

        while (count($processes) > 0) {
            foreach ($processes as $key => $process) {
                if (! $process->isRunning()) {
                    unset($processes[$key]);
                    $bar->advance();
                }
            }
            usleep(10000);
        }
        $bar->finish();
        $endTime = microtime(true);
        $this->newLine(2);

        $player->refresh();
        $finalScore = $player->score;
        $duration = round($endTime - $startTime, 2);

        $this->info("Total Time: {$duration} seconds");
        $this->info("Final Score Must be: {$finalScore}");
        $this->info("Expected Score (with lock): {$fixedScore}");

        if ($finalScore === $fixedScore) {
            $this->components->info('SUCCESS: test passed');

            return self::SUCCESS;
        }

        $this->components->error("FAILURE: test failed. Final score is {$finalScore}. Expected score was {$fixedScore}. This indicates a race condition occurred.");

        return self::FAILURE;
    }
}
