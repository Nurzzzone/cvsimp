app-run:
	docker-compose up -d

app-bash:
	docker-compose exec app bash

app-install:
	docker-compose exec app composer install --no-interaction
	docker-compose exec app cp .env.example .env
	docker-compose exec app cp .env.example .env.testing
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate

app-test:
	docker-compose exec app php artisan test --env=testing --testdox -v --stop-on-failure