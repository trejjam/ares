#!/bin/bash

TARGET_TEST="${1}"

mkdir -p ./temp

./vendor/bin/tester -s -c ./tests/php.ini-unix -j 32 "./tests/${TARGET_TEST}" --coverage ./temp/coverage.html --coverage-src ./src/
