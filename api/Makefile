help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

test-func: ## api functionnal tests
	APP_ENV=TEST php bin/console doctrine:database:create --if-not-exists
	APP_ENV=TEST php bin/console doctrine:schema:drop --force
	APP_ENV=TEST php bin/console doctrine:schema:create
	php vendor/bin/simple-phpunit --testsuite Functional

test-unit: ## api unit tests
	php vendor/bin/simple-phpunit --testsuite Unit

test: test-unit test-func ## api tests

install@integration: APP_ENV=test
install@integration:
	composer install -n --prefer-dist
	bin/console doctrine:migration:migrate --allow-no-migration -n

lint.php-cs-fixer:
	vendor/bin/php-cs-fixer fix

lint.php-cs-fixer@integration:
	vendor/bin/php-cs-fixer fix --dry-run --diff

lint.phpstan:
	vendor/bin/phpstan analyse

lint.phpstan@integration:
	vendor/bin/phpstan analyse

test@integration:
	vendor/bin/simple-phpunit
