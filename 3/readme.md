# Third section
Setting up Slim boilerplate (All commands need to be run from this directory)

# Diagram
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_3_diagram.png)

# Steps
* Run `docker-compose down` on the last stack in the `2` folder if you have not already
* Run `composer install` + `npm install`
* Run `composer dump-autoloads`
* You should be able to see that the lambda can form a connection with DynamoDB
* To bootstrap container state you can run `./bin/bootstrap.sh`
* To run the console you can run `docker-compose run console bin/console` (locally)

# Deployment
Run `node_modules/.bin/serverless remove --aws-profile=bref-php` Replacing the profile name `bref-php` with your configured AWS Profile

Run `vendor/bin/bref cli bref-php-3-dev-console --region eu-west-1 --profile=bref-php  -- example` to see if your console is working