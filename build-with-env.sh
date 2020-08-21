#!/bin/bash
cd /var/www/scrumonline
/usr/bin/php ./bin/composer install
cp src/sample-config.env.php src/config.php
