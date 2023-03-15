.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

console-php:
	docker compose exec php bash

db-migrate:
	docker compose exec php php /app/migrate.php

up: ## Up Docker-project
	docker compose up -d

down: ## Down Docker-project
	docker compose down --remove-orphans

stop: ## Stop Docker-project
	docker compose stop

build: ## Build Docker-project
	docker compose build --no-cache

ps: ## Show list containers
	docker compose ps

log: 
	docker compose logs

default: help
