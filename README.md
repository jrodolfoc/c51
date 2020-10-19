# C51 Coding Challenge

This is a simple app that shows offers
and some attributes of them, like image and cash back values.
This is a solution for https://github.com/checkout51/c51-coding-challenge

## Solution
This is a project implemented with symfony 5.1. The structure is simple:
```
 - Controllers:
  -- Uses a single controller, OfferController, that is used to show all offers and sort them
 - Views:
  -- Uses twig
  -- Site overall structure can be found in templates/default 
  -- Offers views be found in templates/offer
 - Models:
  -- I made use of doctrine
  -- Made use of a single repository, called OfferRepository
 - Migrations:
  -- Created a single migration that creates the offer table
 - Commands:
  -- Create a single command to be run in CLI, PopulateOffersCommand
  -- PopulateOffersCommand reads json provided for the challenge and populates offer table
```

### Containers
```
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
```

## Running The App
* Disclaimer: During installation, composer can take several minutes to finish
* Please wait until you see a message similar to:

```
NOTICE: fpm is running, pid 1
NOTICE: ready to handle connections
```

* Open browser on http://localhost:8000

## Running Unit Tests
* Make sure containers are up
* Run phpunit with the xml configuration file found in `challenge\phpunit.xml.dist`

```
//Example of unit tests being run in Windows
C:\PHP73\php.exe C:\PHP73\phpunit.phar --configuration c51\challenge\phpunit.xml.dist
```

## License
[MIT](https://choosealicense.com/licenses/mit/)