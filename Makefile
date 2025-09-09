
start: ## Start all docker-compose
	@./vendor/bin/sail up -d --remove-orphans

stop: ## Stop all docker-compose
	@./vendor/bin/sail stop

bash: ## Stop all docker-compose
	@./vendor/bin/sail exec crmservice.local.test bash

migrate: ## Run migrations
	@./vendor/bin/sail exec crmservice.local.test php artisan migrate

phpstan:
	@./vendor/bin/sail exec crmservice.local.test vendor/bin/phpstan analyse --memory-limit=4G -c phpstan.neon

composer:
	@./vendor/bin/sail composer install

pint:
	@./vendor/bin/pint src Apps App/console/Commands --config pint.json

style:
	@./vendor/bin/pint src Apps App/console/Commands --config pint.json
	@./vendor/bin/sail exec crmservice.local.test vendor/bin/phpstan analyse --memory-limit=4G -c phpstan.neon

