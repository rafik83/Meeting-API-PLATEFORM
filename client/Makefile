help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
install: ## Install dependencies
	cp ./src/config.dist.ts ./src/config.ts
	npm install
	npm run build:tailwind
start:
	npm run dev

lint: ## lint the project using eslint
	npm run lint

test :
	npm run test

watch-css : ## watch css changes
	npm run watch:tailwind
