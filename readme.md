# Fifth section
Finishing up a possible implementation for the site... Serverlessly

# Diagram
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_5_diagram.png)

# Steps
* Run `docker-compose down` on the last stack in the `3` folder if you have not already
* Run `composer install` + `npm install`
* Run `composer dump-autoloads`
* You should be able to see a roughly working version of the site.
* To bootstrap container state you can run `./bin/bootstrap.sh`
* To run the console you can run `docker-compose run console bin/console` (locally)

# Improvements
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_6_diagram.png)
In theory a lambda could be triggered when a presigned POST submission is made back to the repo to update the image URL over endlessly scanning for images given it is really inefficient.
