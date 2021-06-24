help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install API and client
	$(MAKE) -C client install
	$(MAKE) -C server install

start: ## Start API and client server
	$(MAKE) -C server start
	$(MAKE) -C client start

test-e2e: export APP_ENV=e2e
test-e2e:
	$(MAKE) -C server test-e2e

lint: 
	$(MAKE) -C server	lint.phpstan
	$(MAKE) -C client lint

prettify: 
	$(MAKE) -C api	lint.phpstan
	$(MAKE) -C client prettify	

test: 
	$(MAKE) -C server	test-unit
	$(MAKE) -C client test

watch-css:
	$(MAKE) -C client watch-css

storybook:
	$(MAKE) -C client storybook

load-fixtures :
	$(MAKE) -C server load-fixtures
stop:
	$(MAKE) -C server stop
