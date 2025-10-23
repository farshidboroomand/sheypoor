COMPOSE := docker-compose
DOCKER_EXEC := docker exec -i sheypoor_app
up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

migrate:
	$(DOCKER_EXEC) php artisan migrate --seed

fresh-db:
	$(DOCKER_EXEC) php artisan migrate:refresh --seed

clean:
	$(DOCKER_EXEC) composer cs-fixer

test:
	$(DOCKER_EXEC) php artisan test

test-concurrency: fresh-db
	$(DOCKER_EXEC) php artisan test:concurrency