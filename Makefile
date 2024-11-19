DOCKER_COMP = docker compose

# Conteneurs Docker
PHP_CONT = $(DOCKER_COMP) exec php

# Exécutables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console

# Divers
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh bash composer vendor sf cc test

## —— 🎵 🐳 Le Makefile Docker Symfony 🐳 🎵 ——————————————————————————————————
help: ## Affiche cet écran d'aide
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Construit les images Docker
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Démarre les conteneurs Docker en mode détaché (sans logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Construit et démarre les conteneurs

down: ## Arrête les conteneurs Docker
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Affiche les logs en direct
	@$(DOCKER_COMP) logs --tail=0 --follow

sh: ## Se connecte au conteneur FrankenPHP
	@$(PHP_CONT) sh

bash: ## Se connecte au conteneur FrankenPHP via bash pour que les flèches haut et bas aillent aux commandes précédentes
	@$(PHP_CONT) bash

test: ## Démarre les tests avec phpunit, passez le paramètre "c=" pour ajouter des options à phpunit, exemple : make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMP) exec -e APP_ENV=test php bin/phpunit $(c)

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Exécute composer, passez le paramètre "c=" pour exécuter une commande donnée, exemple : make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Installe les dépendances selon le fichier composer.lock actuel
	@$(COMPOSER) install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## Liste toutes les commandes Symfony ou passez le paramètre "c=" pour exécuter une commande donnée, exemple : make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: ## Vide le cache
	@$(SYMFONY) cache:clear
