SHELL := /bin/bash

# Colors used for more helpful log statements.
END=$(shell printf "\x1b[0m")
OK_COLOR=$(shell printf "\x1b[32;01m")
ERROR_COLOR=$(shell printf "\x1b[31;01m")
WARN_COLOR=$(shell printf "\x1b[33;01m")

# Log levels.
OK=$(OK_COLOR)[OK]$(END)
ERROR=$(ERROR_COLOR)[ERROR]$(END)
WARN=$(WARN_COLOR)[WARNING]$(END)
ERROR_STRING=$(ERROR_COLOR)%s$(END) # printf '$(ERROR_STRING) %s' 'Error text in red.' 'Rest of text in no color.'

VER?=3.0.2

.PHONY: init test release image

init:
	composer install
	# $(OK) init

test:
	vendor/bin/phpunit tests
	# $(OK) test

release:
	./avro-to-php app:build --build-version=$(VER) avro-to-php
	git add .
	git commit -m "$(VER)"
	git tag "$(VER)"
	git push && git push --tag
	# $(OK) released to github and packagist
	make image

image:
	docker build -t chasdevs/avro-to-php --no-cache .
	docker tag chasdevs/avro-to-php chasdevs/avro-to-php:$(VER)
	docker push chasdevs/avro-to-php:latest
	docker push chasdevs/avro-to-php:$(VER)
	# $(OK) Published to dockerhub

avsc:
	gradle generateAvsc
