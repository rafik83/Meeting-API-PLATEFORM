help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install API and client
	$(MAKE) -C client install
	$(MAKE) -C api install

start: ## Start API and client server
	$(MAKE) -C api start	
	$(MAKE) -C client start

lint: 
	$(MAKE) -C api	lint.phpstan
	$(MAKE) -C client lint

test: 
	$(MAKE) -C api	test-unit
	$(MAKE) -C client test

watch-css:
	$(MAKE) -C client watch-css

load-fixtures :
	$(MAKE) -C api load-fixtures
