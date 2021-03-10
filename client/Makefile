help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install dependencies
	cp ./src/config.dist.ts ./src/config.ts
	npm install
	npm run build:tailwind

start: ## Start development server
	npm run dev

lint: ## lint the project using eslint
	npm run lint

test: # Run lint, test unit and a coverage rapport
	npm run test

watch-css: ## watch css changes
	npm run watch:tailwind

storybook: ## Start storybook server for development
	npm run storybook

build-storybook: ## Build storybook assets
	npm run build-storybook

prettify: ## Run prettify
	npm run prettify

generate-icons: ## Create Icon components from svg files
	node ./scripts/generate-icon-components.js
