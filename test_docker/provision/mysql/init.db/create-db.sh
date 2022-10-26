#!/bin/bash

MYSQL_USER="root"
MYSQL_PASS="root"

echo "Creating MySQL DBs"

# Create databases
for DBNAME in face_app_db
do
    mysql -u$MYSQL_USER -p$MYSQL_PASS -e "DROP DATABASE IF EXISTS $DBNAME; CREATE DATABASE $DBNAME"
done

echo "Finished creating DB's!"