help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install:
	composer install
	npm install
	npm run build
	docker-compose up -d
	make create-database
	make migrate-database

start: # start the server
	docker-compose up -d
	symfony server:start --allow-http --port 8365 -d
	npm run dev

stop: # stop the server
	symfony server:stop

restart: stop start

test-unit: ## api unit tests
	bin/phpunit --testsuite Unit

test-func: export APP_ENV=test
test-func: ## api functionnal tests
	bin/console doctrine:database:create --if-not-exists
	bin/console doctrine:schema:drop --force
	bin/console doctrine:schema:create
	bin/phpunit --testsuite Functional

test-e2e: export APP_ENV=e2e
test-e2e: ## launch e2e test
	make restart
	vendor/bin/behat
	make stop
test: test-unit test-func ## api tests

install@integration: export APP_ENV=test
install@integration: export COMPOSER_NO_INTERACTION=1
install@integration:
	composer install --ansi --verbose --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs
	composer dump-autoload
	bin/phpunit install
	bin/console doctrine:migration:migrate --allow-no-migration -n
	npm install
	npm run build

lint.php-cs-fixer:  ## api lint php-cs-fixer
lint: lint.php-cs-fixer  lint.phpstan  lint.js  ## lint server project
lint.js : ## lint js files
	npm run lint 

lint.php-cs-fixer:
	vendor/bin/php-cs-fixer fix

lint.php-cs-fixer@integration:
	vendor/bin/php-cs-fixer fix --dry-run --diff

lint.phpstan: ## api lint phpstan
	vendor/bin/phpstan analyse

lint.phpstan@integration:
	vendor/bin/phpstan analyse --memory-limit 512M

test@integration:
	bin/phpunit

create-database :
	php bin/console doctrine:database:create

migrate-database :
	php bin/console doctrine:migration:migrate

load-fixtures :
	php bin/console hautelook:fixtures:load -n

watch: # watch css & js changes
	npm run watch
