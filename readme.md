# Second Section
Provisioning infrastructure and checking connectivity (All commands need to be run from this directory)

# Diagram
![Diagram](https://github.com/ryanolee/talks/raw/main/brum-php-jan-2022/brefphp/diagrams/bref_building_something_2_diagram.png)

# Steps
* Add `docker-compose.yml`
* Run `docker-compose up` to bootstrap the stack
* Create the dynamodb table using:
```
AWS_ACCESS_KEY_ID=local AWS_SECRET_ACCESS_KEY=local aws dynamodb create-table \
  --table-name elephpant-2 \
  --attribute-definitions AttributeName=id,AttributeType=S AttributeName=createdAt,AttributeType=N \
  --key-schema AttributeName=id,KeyType=HASH AttributeName=createdAt,KeyType=RANGE \
  --billing-mode PAY_PER_REQUEST \
  --endpoint-url http://localhost:8000 \
  --region=eu-west-1
```
 * You should be able to see that the lambda can form a connection with DynamoDB
