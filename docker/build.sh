#!/bin/bash

set -e

SCRIPT_DIR=$( dirname "${BASH_SOURCE[0]}" )
cd ${SCRIPT_DIR}

TAG=${1:-latest}
CMD="docker build -t chasdevs/avro-to-php:$TAG ."

echo "Running: $CMD"
$CMD
