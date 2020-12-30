help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install API and client
	cd client && npm i
lint : ## lint the project using eslint
	cd client && npm run lint
start-client:
	cd client && npm run dev
test-client:
	cd client && npm run test
test :
	make test-client
