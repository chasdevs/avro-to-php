SHELL := /bin/bash

# Colors used for more helpful log statements.
NO_COLOR=\x1b[0m
OK_COLOR=\x1b[32;01m
ERROR_COLOR=\x1b[31;01m
WARN_COLOR=\x1b[33;01m

# Log levels.
OK=$(OK_COLOR)[OK]$(NO_COLOR)
ERROR=$(ERROR_COLOR)[ERROR]$(NO_COLOR)
WARN=$(WARN_COLOR)[WARNING]$(NO_COLOR)
ERROR_STRING=$(ERROR_COLOR)%s$(NO_COLOR) # printf '$(ERROR_STRING) %s' 'Error text in red.' 'Rest of text in no color.'

VER?=0.0.12

.PHONY: init test release

init:
	composer install
	@echo -e "$(OK) init"

test:
	vendor/bin/phpunit tests
	@echo -e "$(OK) test"

release:
	@./release.sh $(VER)
	@echo -e "$(OK) released to github and packagist"

image:
	docker build -t chasdevs/avro-to-php --no-cache .
	docker tag chasdevs/avro-to-php chasdevs/avro-to-php:$(VER)
	docker push chasdevs/avro-to-php:latest
	docker push chasdevs/avro-to-php:$(VER)