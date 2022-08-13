all: build

build:
	@docker build -t abellion/xenus .

install:
	@docker compose run --rm xenus-lib composer install -o

db:
	@docker compose run --rm --use-aliases xenus-db

tests:
	@docker compose run --rm xenus-lib php vendor/bin/phpunit

cli:
	@docker compose run --rm xenus-lib bash

.PHONY: all build install db tests cli
