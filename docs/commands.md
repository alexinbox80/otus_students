docker-compose up -d \
docker exec -it php sh

#make new entity \
php bin/console make:entity

#create migrations \
php bin/console doctrine:migrations:diff

#migrate migrations \
php bin/console doctrine:migrations:migrate

#clear cache \
php bin/console cache:clear

#show route lists \
php bin/console debug:router
