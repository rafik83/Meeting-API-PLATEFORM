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