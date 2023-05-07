# Fourth section
Adding upload functionality and showing off http lambdas using the event driven method.
It should be notes that this step was never fully finished as development locally is far too unstable to be able to test this properly. It is currently on bref version 1 and will remain that way for now.

# Diagram
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_4_diagram.png)

# Steps
* Run `docker-compose down` on the last stack in the `3` folder if you have not already
* Run `composer install` + `npm install`
* Run `composer dump-autoloads`
* Run `composer require --dev bref/dev-server` to install the API Gateway and Lambda local server
* You should be able to see that the lambda can form a connection with DynamoDB
* To bootstrap container state you can run `./bin/bootstrap.sh`
* To run the console you can run `docker-compose run console bin/console` (locally)

