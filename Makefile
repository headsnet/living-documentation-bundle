.PHONY: help
.DEFAULT_GOAL := help
SHELL = bash

PHP = php
PHP_TEST = APP_ENV=test php

########################################################################################################################

cs: ## Run PHP Coding Standards analysis
	@${PHP} vendor/bin/ecs check

cs-fix: ## Fix PHP Coding Standards
	@${PHP} vendor/bin/ecs check --fix

tcs: ## Run Twig Coding Standards analysis
	@${PHP} vendor/bin/twig-cs-fixer lint templates/ src/UI/Feature/

tcs-fix: ## Fix Twig Coding Standards
	@${PHP} vendor/bin/twig-cs-fixer lint --fix templates/ src/UI/Feature/

lint-yaml: ## Run Yaml linting analysis
	@${PHP} bin/console lint:yaml src config tests translations

lint-twig: ## Run Yaml linting analysis
	@${PHP_TEST} bin/console lint:twig templates

static: ## Run static analysis
	@${PHP_TEST} vendor/bin/phpstan analyse

rector: ## Run Rector
	@${PHP_TEST} vendor/bin/rector process

rector-ci: ## Run Rector with CI configuration
	@${PHP_TEST} vendor/bin/rector process --config=rector-ci.php

########################################################################################################################

clean:
	@rm -rf apps/app/var/cache/dev
	@${PHP} bin/console c:w

test: ## Run the automated test suite
	-@${PHP} vendor/bin/phpunit \
        --coverage-html var/coverage \
        --coverage-text=var/coverage/coverage.txt
	@head var/coverage/coverage.txt

########################################################################################################################

# https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:
	@echo "\nMakefile is used to run various utilities related to this project\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
