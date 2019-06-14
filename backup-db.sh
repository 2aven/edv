#!/bin/bash
backups_dir="./db_backup/"
datetime=$(date +'%Y-%m-%dT%H:%M:%S')

docker exec edv-db /usr/bin/mysqldump -u root --password=contrasenya edv | gzip -9 > $backups_dir$db_name--$datetime.sql.gz
