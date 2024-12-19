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

#drop all tables in database \
php bin/console doctrine:schema:drop --full-database --force

#migrtion status \
php bin/console doctrine:migrations:status

#generate migration \
php bin/console doctrine:migrations:generate 

#Validate the mapping files \
php bin/console doctrine:schema:validate

#Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata \
php bin/console doctrine:schema:update --dump-sql
