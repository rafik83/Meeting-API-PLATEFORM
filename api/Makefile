help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install:
	composer install
	docker-compose up -d
	make setup-database
	make migrate-database

start: # start the server
	docker-compose up -d
	symfony server:start --allow-http -d
	

test-unit: ## api unit tests
	bin/phpunit --testsuite Unit

test-func: APP_ENV=test ## api functionnal tests
test-func:
	bin/console doctrine:database:create --if-not-exists
	bin/console doctrine:schema:drop --force
	bin/console doctrine:schema:create
	bin/phpunit --testsuite Functional

test: test-unit test-func ## api tests
lint: lint.php-cs-fixer lint.phpstan ## api linting

install@integration: APP_ENV=test
install@integration:
	composer install --ansi --verbose --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs
	bin/phpunit install
	bin/console doctrine:migration:migrate --allow-no-migration -n

lint.php-cs-fixer:  ## api lint php-cs-fixer
lint: lint.php-cs-fixer lint.phpstan ## api linting

lint.php-cs-fixer:
	vendor/bin/php-cs-fixer fix

lint.php-cs-fixer@integration:
	vendor/bin/php-cs-fixer fix --dry-run --diff

lint.phpstan: ## api lint phpstan
	vendor/bin/phpstan analyse

lint.phpstan@integration:
	vendor/bin/phpstan analyse

test@integration:
	bin/phpunit

create-database :
	php bin/console doctrine:database:create

migrate-database :
	php bin/console doctrine:migration:migrate
