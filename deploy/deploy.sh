sudo cp deploy/nginx.conf /etc/nginx/conf.d/students.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/students.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/students.conf
sudo service nginx restart
sudo -u www-data composer install -q
sudo service php8.3-fpm restart
sudo -u www-data sed -i -- "s|%JWT_PASSPHRASE%|$2|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$3|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_USER%|$4|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$5|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$6|g" .env
sudo -u www-data php bin/console doctrine:migrations:migrate --no-interaction
sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$7|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$8|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$9|g" .env
sudo service supervisor restart
