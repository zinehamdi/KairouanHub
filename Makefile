setup:
	composer install
	npm install
	cp .env.example .env || true
	php artisan key:generate
	php artisan migrate --seed

fmt:
	composer pint

lint:
	vendor/bin/phpstan analyse

test:
	vendor/bin/pest --group=fast

build:
	npm run build
