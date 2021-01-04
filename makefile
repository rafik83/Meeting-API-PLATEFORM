help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
install: ## Install API and client
	cd client && npm i
	cd api && composer install
lint : ## lint the project using eslint
	cd client && npm run lint
start-client:
	cd client && npm run dev
start-server :
	cd api && symfony server:start -d	
start:
	make start-client		
