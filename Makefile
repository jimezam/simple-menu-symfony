#---SYMFONY--#
SYMFONY = symfony
SYMFONY_SERVER_IP = 127.0.0.1
SYMFONY_SERVER_PORT = 8000
SYMFONY_SERVER_START = $(SYMFONY) serve -d
SYMFONY_SERVER_STOP = $(SYMFONY) server:stop
SYMFONY_CONSOLE = $(SYMFONY) console
SYMFONY_LINT = $(SYMFONY_CONSOLE) lint:
DATABASE_NAME = simple_menu
#------------#

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc test

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Serve 🧙 ——————————————————————————————————————————————————————————————
start: ## Start symfony server.
	$(SYMFONY) server:start --daemon --listen-ip=$(SYMFONY_SERVER_IP) --port=$(SYMFONY_SERVER_PORT)

stop: ## Stop symfony server.
	$(SYMFONY) server:stop

status: ## Check symfony server status
	$(SYMFONY) server:status

logs: ## Check symfony server logs
	$(SYMFONY) server:log

open: ## Open the symfony server in the browser
	$(SYMFONY) open:local

## —— Database 🧙 ——————————————————————————————————————————————————————————————
db.connect: ## Connect to the database
	sudo -u postgres psql -U postgres $(DATABASE_NAME)

## —— Migrations 🧙 ——————————————————————————————————————————————————————————————
migration.create: ## Create a new migration
	php bin/console make:migration

migration.migrate: ## Migrate the database
	php bin/console doctrine:migrations:migrate

## —— Fixtures 🧙 ——————————————————————————————————————————————————————————————
fixtures.run: ## Clear the database data and run fixtures
	php bin/console doctrine:fixtures:load

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf