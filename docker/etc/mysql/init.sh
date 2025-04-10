echo "** Creating default DB and users"

mysql -u root -p$MYSQL_ROOT_PASSWORD --execute \
"
GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_USER'@'%';
GRANT SYSTEM_VARIABLES_ADMIN ON *.* TO '$MYSQL_USER'@'%';
FLUSH PRIVILEGES;
"

echo "** Finished creating default DB and users"
