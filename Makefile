install:
    cp .env.example .env
    composer install
    npm install
    npx mix
    php artisan key:generate
docker:
	docker compose up --build -d php
mysql-cli:
	docker exec -it user_manager_mysql mysql -u root -p
php:
	docker exec -it user_manager_php /bin/sh
