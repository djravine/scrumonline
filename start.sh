#!/bin/bash
current_dir=$(pwd)

# Stop any running containers
./docker.sh stop
./docker.sh myadmin stop
docker rm scrumonline myadmin

# Remove existing database
sudo rm -rf mysql_db

# Prepare the ENV
./docker.sh prepare

# Start with inbuilt mysql
./docker.sh start mysql_db

# Start adminer
./docker.sh myadmin

# Run DB migrations after mysql is running
sleep 10
docker exec -it -w /var/www/scrumonline scrumonline php bin/composer install
docker exec -it -w /var/www/scrumonline scrumonline ./vendor/bin/doctrine orm:generate-proxies
docker exec -it -w /var/www/scrumonline scrumonline ./vendor/bin/doctrine orm:schema-tool:drop --force
docker exec -it -w /var/www/scrumonline scrumonline ./vendor/bin/doctrine orm:schema-tool:create