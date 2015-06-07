#!/bin/bash

VAGRANT_CORE_FOLDER=$(cat '/.puphpet-stuff/vagrant-core-folder.txt')

if [[ -f '/.puphpet-stuff/displayed-important-notices' ]]; then
    exit 0
fi

#!/usr/bin/env bash
composer="hhvm /usr/local/bin/composer"

# Install composer
if [ ! -f /usr/local/bin/composer ]; then
	sudo curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    ${composer} global require fxp/composer-asset-plugin --prefer-dist
else
	${composer} self-update
	${composer} global update --prefer-dist
fi
${composer} config --global github-oauth.github.com ${github_token}

# Configuring application
echo "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root'" | mysql -uroot -proot
echo "FLUSH PRIVILEGES'" | mysql -uroot -proot
echo "CREATE DATABASE IF NOT EXISTS \`madeasy\` CHARACTER SET utf8 COLLATE utf8_unicode_ci" | mysql -uroot -proot

php /var/www/console/yii migrate up --interactive=0
php /var/www/console/yii rbac/init

sudo service mysql restart
sudo service php5-fpm restart
sudo service apache2 restart

cat "${VAGRANT_CORE_FOLDER}/shell/ascii-art/important-notices.txt"

touch '/.puphpet-stuff/displayed-important-notices'
