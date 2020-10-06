default:
	@$(MAKE) -pRrq -f $(lastword $(MAKEFILE_LIST)) : 2>/dev/null | awk -v RS= -F: '/^# File/,/^# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | egrep -v -e '^[^[:alnum:]]' -e '^$@$$'
prepare:
	@uid=$$uid gid=$$gid docker-compose build
	@mkdir -p $$HOME/.composer-cache
	@docker run --rm --interactive --tty --volume $$PWD:/app --volume $${COMPOSER_HOME:-$$HOME/.composer-cache}:/tmp --user $$(id -u):$$(id -g) composer install
	@chmod -R 777 storage
	@chmod -R 777 bootstrap/cache
	@uid=$$uid gid=$$gid docker-compose up -d
	@touch .devops/psysh/config.php
	@docker exec -it voxus-php php artisan migrate:fresh --seed
build:
	@uid=$$uid gid=$$gid docker-compose build
up:
	@uid=$$uid gid=$$gid docker-compose up -d
stop:
	@uid=$$uid gid=$$gid docker-compose stop
down:
	@uid=$$uid gid=$$gid docker-compose down
console:
	@docker exec -it voxus-php bash
php:
	@docker exec -it voxus-php php $(filter-out $@,$(MAKECMDGOALS))
test:
	@docker exec -it voxus-php vendor/bin/phpunit  --verbose tests/
analyse:
	@docker exec -it voxus-php vendor/bin/phpstan analyse --memory-limit=2G
insights:
	@docker exec -it voxus-php php artisan insights
composer:
	@mkdir -p $$HOME/.composer-cache
	@docker run --rm --interactive --tty --volume $$PWD:/app --volume $${COMPOSER_HOME:-$$HOME/.composer-cache}:/tmp --user $$(id -u):$$(id -g) composer $(filter-out $@,$(MAKECMDGOALS))
composer-dev:
	@mkdir -p $$HOME/.composer-cache
	@docker run --rm --interactive --tty --volume $$PWD:/app --volume $${COMPOSER_HOME:-$$HOME/.composer-cache}:/tmp --user $$(id -u):$$(id -g) composer --dev $(filter-out $@,$(MAKECMDGOALS))
%:
	@:e
