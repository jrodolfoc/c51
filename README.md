# C51 Coding Challenge

This is a simple app that shows offers
and some attributes of them, like image and cash back values.
This is a solution for https://github.com/checkout51/c51-coding-challenge

## Solution
```
 3 containers:

 - MariaDB container
  -- Persists database files inside docker/database/data for multiple runs
  -- Runs on port 3306

 - php-fpm container
  -- Runs composer
  -- Execute cli command that migrates and populates database 
  -- Runs on port 9000

 - nginx container
  -- Runs on port 8000
```

## Requirements
For running app:
  * docker-compose

For running tests:
  * PHP 7.2.9 or higher;
  * phpunit;

## Installation
```
// Inside docker directory
docker-compose build
docker-compose up

// Open browser on http://localhost:8000
// WARNING: Composer can take some minutes to finish
// Please wait until you see a message similar to:
// NOTICE: fpm is running, pid 1
// NOTICE: ready to handle connections
```

## License
[MIT](https://choosealicense.com/licenses/mit/)