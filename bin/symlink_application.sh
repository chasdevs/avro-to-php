#!/usr/bin/env bash

set -e

PROJECT_ROOT=$(git rev-parse --show-toplevel)
cd $PROJECT_ROOT

rm -f builds/avro-to-php
ln -s ./avro-to-php builds/avro-to-php