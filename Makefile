#Setup automatically docker compose variables
include .env
-include .env.local

DOCKER=docker-compose
DOCKER_EXEC= ${DOCKER} exec
SF_CONSOLE := ${DOCKER_EXEC} php bin/console

setup: .env.local docker-compose.yaml .php-cs-fixer.php

.env.local:
	@touch .env.local

docker-compose.yaml: docker-compose.yaml.dist
	@cp docker-compose.yaml.dist docker-compose.yaml
	@sed -i "s/<DOCKER_USER_ID>/$(shell $(shell echo id -u ${USER}))/g" $@
	@sed -i "s/<DOCKER_USER>/$(shell echo ${USER})/g" $@
	@sed -i 's/<REMOTE_HOST>/$(shell hostname -I | grep -Eo "192\.168\.[0-9]{,2}\.[0-9]+" | head -1)/g' $@

.php-cs-fixer.php: .php-cs-fixer.dist.php
	@cp .php-cs-fixer.dist.php $@

reup:
	docker-compose down --remove-orphan
	docker-compose up -d
	docker ps

start_working: vendor

fix_style: up
	@$(DOCKER_EXEC) php vendor/bin/php-cs-fixer fix src

vendor: up
	@$(DOCKER_EXEC) php composer install --prefer-dist

up: down
	@$(DOCKER) up -d

down:
	@$(DOCKER) down --remove-orphan