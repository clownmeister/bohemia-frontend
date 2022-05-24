PHP = docker exec -it -w /var/www boh-php bash -c
NPM = docker exec -it -w /var/www boh-npm bash -c

default:
	@echo "\e[102;30m******************************         Izi Start          ******************************\e[0m\n"
	@make env up install

env:
	@echo "\n\e[92mChecking for existing env file\e[0m"
	@{ \
	if [ ! -f ./.env ]; then \
		echo "\e[91mEnv not found!\e[0m Creating...";\
		sed -e 's/{DEV_UID}/$(shell id -u)/g' -e 's/{DEV_GID}/$(shell id -g)/g' .env.local >> .env;\
		chmod 755 ./.env;\
		echo "\e[92mEnv file created.\e[0m\n";\
		echo "Don't forget to fill out all secrets.\n";\
	else \
		echo "Env file \e[92mOK\e[0m.\n";\
	fi \
	}

up:
	@docker-compose up -d --force-recreate

php:
	@echo "\e[103;30m******************************         sdk-php bash          ******************************\e[0m\n"
	docker exec -it -w /var/www boh-php bash

npm:
	@echo "\e[103;30m******************************         sdk-php bash          ******************************\e[0m\n"
	docker exec -it -w /var/www boh-npm bash


composer-install:
	@echo "\e[103;30m******************************         Composer Install          ******************************\e[0m\n"
	$(PHP) "composer install"

yarn-install:
	@echo "\e[103;30m******************************         Yarn Install          ******************************\e[0m\n"
	$(NPM) "yarn install"

install:
	@echo "\e[103;30m******************************         Install          ******************************\e[0m\n"
	make yarn-install
	make composer-install
	make build

update:
	@echo "\e[103;30m******************************         Update          ******************************\e[0m\n"
	make cache-clear
	@$(PHP) "composer update"

update-browserlist:
	@$(NPM) "npx browserslist@latest --update-db"

build:
	@echo "\e[103;30m******************************         BuildAll          ******************************\e[0m\n"
	@$(NPM) "yarn buildAll"

watch:
	@echo "\e[103;30m******************************         Watch          ******************************\e[0m\n"
	@$(NPM) "yarn watchAll"

vendor-clear:
	@echo "\e[103;30m******************************         Clearing vendor          ******************************\e[0m\n"
	@$(PHP) "rm -rf /vendor"

cache-clear:
	@echo "\e[103;30m******************************         Clearing cache          ******************************\e[0m\n"
	@$(PHP) "php bin/console cache:clear"

fix:
	@echo "\e[103;30m******************************         PHPCBF          ******************************\e[0m\n"
	@$(PHP) "./vendor/bin/phpcbf --standard=./phpcs-ruleset.xml -p src/ tests/"

phpcs:
	@echo "\e[103;30m******************************         PHPCS          ******************************\e[0m\n"
	@$(PHP) "./vendor/bin/phpcs --standard=./phpcs-ruleset.xml -p src/ tests/"

phpstan:
	@echo "\e[103;30m******************************         PHPStan          ******************************\e[0m\n"
	@$(PHP) "./vendor/bin/phpstan analyse -c phpstan.neon -l 8 src/ tests/"

test:
	@echo "\e[103;30m******************************         Test          ******************************\e[0m\n"
	make phpcs phpstan

send-mail:
	$(PHP) "php bin/console messenger:consume async -vv"
