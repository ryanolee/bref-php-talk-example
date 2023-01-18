#!/usr/bin/env bash
export AWS_ACCESS_KEY_ID=local
export AWS_SECRET_ACCESS_KEY=local

echo  "Creating DynamoDB tables..."
aws dynamodb create-table \
  --table-name elephpants-4 \
  --attribute-definitions AttributeName=id,AttributeType=S AttributeName=createdAt,AttributeType=N \
  --key-schema AttributeName=id,KeyType=HASH AttributeName=createdAt,KeyType=RANGE \
  --billing-mode PAY_PER_REQUEST \
  --endpoint-url http://localhost:4566 \
  --region=eu-west-1

echo "Creating Bucket..."
aws s3api create-bucket --bucket elephpants-4 --endpoint-url http://localhost:4566
aws s3api put-bucket-cors \
        --bucket elephpants-4 \
        --endpoint-url http://localhost:4566\
        --cors-configuration file://bin/CorsRules.json