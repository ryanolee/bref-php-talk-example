# First Section
Initial configuration for bref PHP + commands to run.

# Diagram
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_1_diagram.png)

# Steps
* First running npm `npm init` and going through the flow.
* Run `npm i serverless@3` to install version 3 of the serverless framework (Currently the latest version)
* Run `composer init` and fill in the arguments
* Run `composer require bref/bref`
* Run `vendor/bin/bref init` to init a serverless project and get some boilerplate code...

# Deployment
* Configure an AWS Profile called `bref-php` with correct access levels
* Add and AWS Profile and run `node_modules/.bin/serverless deploy --aws-profile=bref-php` deploy to do a test deployment for the bref php application
* Running this should give you 
```
Deploying app to stage dev (eu-west-1)

✔ Service deployed to stack app-dev (121s)

endpoint: ANY - https://xxx.execute-api.eu-west-1.amazonaws.com
functions:
  api: app-dev-api (1.1 MB)
```
* And visiting https://xxx.execute-api.eu-west-1.amazonaws.com should give you something like this
![Website image](img/capture.png)
