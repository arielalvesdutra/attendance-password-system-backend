#!/bin/bash

cd env/
sudo docker-compose up -d
cd ../public
php -S 192.168.11.102:8030
