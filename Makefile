#!/bin/bash

OS = $(shell uname)
UID = $(shell id -u)
PHP_SERVER = php-server
NAMESERVER_IP = $(shell ip address | grep docker0)

ifeq ($(OS),Darwin)
	NAMESERVER_IP = host.docker.internal
else ifeq ($(NAMESERVER_IP),)
	NAMESERVER_IP = $(shell grep nameserver /etc/resolv.conf  | cut -d ' ' -f2)
else
	NAMESERVER_IP = 172.17.0.1 # replace this IP with your "docker0" one (run "ip a" in your terminal to check it)
endif

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start-colima:
	@echo "Checking if Colima is running..."
	@if ! colima status 2>/dev/null | grep -q '^Status: Running'; then \
		echo "Colima is not running. Starting Colima..."; \
		colima start --cpu 1 --memory 2 --disk 10 --network-address || true; \
	else \
		echo "Colima is already running."; \
	fi

start: ## Start the containers
	$(MAKE) start-colima || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose up -d
	$(MAKE) composer-install

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install
##	$(MAKE) migrations

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${PHP_SERVER} composer install --no-interaction

migrations: ## Runs the migrations
	U_ID=${UID} docker exec -it --user ${UID} ${PHP_SERVER} bin/console doctrine:migrations:migrate -n --allow-no-migration


logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec -it --user ${UID} ${PHP_SERVER} tail -f var/log/dev.log
# End backend commands

ssh: ## bash into the be php container
	U_ID=${UID} docker exec -it --user ${UID} ${PHP_SERVER} /bin/sh

code-style: ## Runs php-cs to fix code styling following Symfony rules
	U_ID=${UID} docker exec -it --user ${UID} ${PHP_SERVER} PHP_CS_FIXER_IGNORE_ENV=1 php-cs-fixer fix src --rules=@Symfony

.PHONY: migrations