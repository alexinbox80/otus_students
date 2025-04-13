COMPOSE := docker compose -f docker-compose.yml --env-file .env.local
DOCKER_EXEC := docker exec --env .env.local
DOCKER_EXEC_TEST := docker exec --env .env.test

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

codecept:
	${DOCKER_EXEC_TEST} students_php ./vendor/bin/codecept run tests/Unit --env test
	${DOCKER_EXEC_TEST} students_php ./vendor/bin/codecept run tests/Acceptance --env test

test:
	${DOCKER_EXEC_TEST} students_php ./vendor/bin/phpunit -c sharedKernel/tests/phpunit.xml --testsuite=unit --testdox
	${DOCKER_EXEC_TEST} students_php ./vendor/bin/phpunit -c studentsSalesBundle/tests/phpunit.xml --testsuite=unit --testdox

deptrac:
	${DOCKER_EXEC} students_php ./vendor/bin/deptrac analyze --config-file=studentsSalesBundle/deptrac-layers.yaml --fail-on-uncovered --report-uncovered
#	${DOCKER_EXEC} ./vendor/bin/deptrac analyze --config-file=sales/deptrac-layers.yaml --fail-on-uncovered --report-uncovered \
#		--cache-file=/tmp/.deptrac-sales-layers.cache
