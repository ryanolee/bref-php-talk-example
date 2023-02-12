#!/usr/bin/env bash
AWS_ACCESS_KEY_ID=local AWS_SECRET_ACCESS_KEY=local aws dynamodb create-table \
  --table-name elephpants-3 \
  --attribute-definitions AttributeName=id,AttributeType=S AttributeName=createdAt,AttributeType=N \
  --key-schema AttributeName=id,KeyType=HASH AttributeName=createdAt,KeyType=RANGE \
  --billing-mode PAY_PER_REQUEST \
  --endpoint-url http://localhost:8000 \
  --region=eu-west-1