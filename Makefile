COMPOSE := docker compose -f docker-compose.yml --env-file .env.local
DOCKER_EXEC := docker exec --env-file .env.local

php:
	${DOCKER_EXEC} -it --user=www-data students_php bash

nginx:
	${DOCKER_EXEC} -it --user=root students_nginx bash

supervisor:
	${DOCKER_EXEC} -it --user=root students_supervisor bash

build:
	${COMPOSE} build

running:
	${COMPOSE} ps

start:
	${COMPOSE} up -d

stop:
	${COMPOSE} stop

rsupervisor:
	${COMPOSE} restart students_supervisor

test:
	${DOCKER_EXEC} ./vendor/bin/phpunit -c sharedKernel/tests/phpunit.xml --testsuite=unit --testdox
	${DOCKER_EXEC} ./vendor/bin/phpunit -c sales/tests/phpunit.xml --testsuite=unit --testdox