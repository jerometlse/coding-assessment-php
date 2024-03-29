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

# environment variables
* to use Mapbox api
MAPBOX_TOKEN
MAPBOX_API_URL="https://api.mapbox.com/geocoding/v5"

# init project
1. Install dependencies run: `composer install`
2. Migrate the data base run: `php bin/console doctrine:migrations:migrate`
3. Insert data for test/dev run:  `php bin/console doctrine:fixtures:load`

# API END POINTS
* API documention: `http://localhost:8000/api/apidoc.json`
* Get all activity categories: GET `http://localhost:8000/api/activityCategory`
* Get all leisure bases: GET `http://localhost:8000/api/leisureBase?page=1&limit=2` 
* Add a leiseure base on POST `http://localhost:8000/api/leisureBase` with: 
    1. Use api key test `Bearer johnDoeApiKey` in headers
    2. Json like (be careful to put an existing activity ID in the database):
    {
        "name": "Flyway",
        "description": "Ecole de kitesurf",
        "link": "http://flyway.fr",
        "address": "8 Bd de l'Aérium, 33740 Arès France",
        "activityCategories": 
            [
                {
                    "id": 13,
                    "label": "Kitesurf"
                }
            ]
    }
* Delete a leiseure base: DELETE POST `http://localhost:8000/api/leisureBase/{id}` with api key test `Bearer johnDoeApiKey` in headers