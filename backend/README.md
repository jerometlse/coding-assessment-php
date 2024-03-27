# Requirements
* Install [Docker (v20.10+)](https://docs.docker.com/engine/install/)
* Install [Docker Compose (v2.10+)](https://docs.docker.com/compose/install/)

# Install the project for the first time
1. Run `docker-compose build`
2. Run `docker run -it --rm -v $PWD:/srv/app coding-assessment-php_symfony /bin/sh -c 'composer install'`

# Start the project
1. Run `docker-compose up`
2. Go to http://localhost:8000

# Access Symfony CLI or Composer
1. Run `docker exec -it coding-assessment-php_symfony /bin/sh`
2. In the new shell, run `symfony --help` or any other Symfony or Composer command

# Stopping all the containers
1. Ctrl+C when the containers are running
2. Run `docker-compose down`

# Versions
* PHP version: `7.4.33`
* Symfony version: `5.4`
* PosgreSQL version: `14`
* Doctrine version: `3`
