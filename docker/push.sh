#!/bin/bash

TAG=${1:-latest}
CMD="docker push chasdevs/avro-to-php:$TAG"

echo "Running: $CMD"
$CMD
