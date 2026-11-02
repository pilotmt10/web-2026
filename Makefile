.PHONY: up down build restart logs shell artisan composer migrate migrate-fresh test

up:            ## Запуск окружения
	docker compose up -d

down:          ## Остановка окружения
	docker compose down

build:         ## Пересборка образов
	docker compose build

restart:       ## Перезапуск окружения
	docker compose restart

logs:          ## Логи всех сервисов
	docker compose logs -f

shell:         ## Shell внутри PHP-контейнера
	docker compose exec app sh

artisan:       ## make artisan ARGS="migrate"
	docker compose exec app php artisan $(ARGS)

composer:      ## make composer ARGS="require vendor/package"
	docker compose exec app composer $(ARGS)

migrate:       ## Миграции
	docker compose exec app php artisan migrate

migrate-fresh: ## Пересоздание БД с миграциями
	docker compose exec app php artisan migrate:fresh --seed

test:          ## Тесты
	docker compose exec app php artisan test
