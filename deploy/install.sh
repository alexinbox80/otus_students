sudo apt update
sudo apt install curl git unzip nginx redis-server postgresql \
postgresql-contrib rabbitmq-server supervisor php-cli php-fpm php-json \
php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-pgsql

curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

sudo -u postgres bash -c "psql -c \"CREATE DATABASE students ENCODING 'UTF8' TEMPLATE = template0\""
sudo -u postgres bash -c "psql -c \"CREATE USER dbuser WITH PASSWORD 'password'\""
sudo -u postgres bash -c "psql -c \"GRANT ALL PRIVILEGES ON DATABASE students TO dbuser\""

sudo rabbitmq-plugins enable rabbitmq_management
sudo rabbitmq-plugins enable rabbitmq_consistent_hash_exchange
sudo rabbitmqctl add_user user password
sudo rabbitmqctl set_user_tags user administrator
sudo rabbitmqctl set_permissions -p / user ".*" ".*" ".*"

#sudo echo "ubuntu ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

#sudo -u $USER bash -c "ssh-keygen -f ~/.ssh/id_rsa -N ''"
#cat ~/.ssh/id_rsa.pub | cat >> ~/.ssh/authorized_keys
#cat ~/.ssh/id_rsa | base64 -w0

sudo service redis-server restart
sudo service php8.3-fpm restart
sudo service supervisor restart
