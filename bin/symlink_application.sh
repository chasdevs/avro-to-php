#!/usr/bin/env bash

set -e

PROJECT_ROOT=$(git rev-parse --show-toplevel)
cd $PROJECT_ROOT

rm -f $PROJECT_ROOT/builds/avro-to-php
ln -s $PROJECT_ROOT/avro-to-php builds/avro-to-php