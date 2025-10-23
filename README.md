# Sheypoor Ranking Api V1
## Table of Contents

- [Up And Running](#up-and-running)
- [Project Structure](#project-structure)
- [Api Documentation](#api-documentation)

---
## Up And Running

Please make sure you have docker in your system along with Makefile.

```sh
$ cp .env.example .env
```

Please update the below values in .env file:
```
- CACHE_STORE=redis
- REDIS_CLIENT=phpredis
- REDIS_HOST=redis
- REDIS_PASSWORD=null
- REDIS_PORT=6379

- DB_DATABASE=sheypoor
- DB_USERNAME=default
- DB_PASSWORD=secret
```
Run the project:
```sh
$ make up
```
Available commands

```sh
$ make down
```

```sh
$ make migrate
```

```sh
$ make fresh-db
```

```sh
$ make clean
```

```sh
$ make test
```

```sh
$ make test-concurrency
```
---

### Project Structure

## System Design and Modular Structure
 This real-time player ladder service is implemented using a modular structure (`Modules/V1/Player`) to ensure **clarity of design**.

### Core Technology Stack

- Persistence SQL Database
- Real-Time Ranking using Redis Sorted Sets (ZSET)
- Concurrency Control	DB Transactions with lockForUpdate() Ensures that concurrent score updates for the same player are serialized, preventing race conditions.
***

### Modular Structure (`Modules/V1/Player`)

The module is broken down into separated directories.

#### 1. `Services`

#### 2. `Controllers`

#### 3. `Models`

#### 4. `Resources`

#### 5. `Tests/Feature`

## Api Documentation
The complete list of endpoints for creating players, updating scores, and retrieving ranks/leaderboards is documented and available via Postman:

https://documenter.getpostman.com/view/23692981/2sB3QRp8C2