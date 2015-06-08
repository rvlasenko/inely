#! /usr/bin/env bash
# Vagrant provision script for PHP development. This script based on @rrosiek gist: https://gist.github.com/rrosiek/8190550
DBHOST=localhost
DBNAME=madeasy
DBUSER=root
DBPASSWD=qwerty
XDEBUGIDEKEY=PHPSTORM

echo -e "\n-- Start installing now... ---\n"

echo -e "\n--- Updating packages list ---\n"
apt-get -qq update

echo -e "\n--- Install base packages ---\n"
apt-get -y install vim curl build-essential python-software-properties git > /dev/null 2>&1

echo -e "\n--- Install MySQL specific packages and settings ---\n"
echo "mysql-server mysql-server/root_password password $DBPASSWD" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none" | debconf-set-selections
apt-get -y install mysql-server-5.5 phpmyadmin > /dev/null 2>&1

# Changing the bind-address to 0.0.0.0 makes it so your vagrant MySQL server will accept connections from any IP, not just localhost.
sed -i "s/bind-address.*/bind-address\t= 0.0.0.0/g" /etc/mysql/my.cnf

echo -e "\n--- Setting up our MySQL user and db ---\n"
mysql -uroot -p$DBPASSWD -e "CREATE DATABASE $DBNAME"
mysql -uroot -p$DBPASSWD -e "grant all privileges on $DBNAME.* to '$DBUSER'@'%' identified by '$DBPASSWD'"

echo -e "\n--- Restarting MySQL ---\n"
/etc/init.d/mysql restart > /dev/null 2>&1

echo -e "\n--- Installing PHP-specific packages ---\n"
apt-get -y install php5 apache2 libapache2-mod-php5 php5-curl php5-gd php5-mcrypt php5-mysql php-apc php5-xdebug > /dev/null 2>&1

echo -e "\n--- Enabling PHP mcrypt module ---\n"
php5enmod mcrypt

echo -e "\n--- Configure php.ini... ---\n"
sed -i "$ a \ \n[xdebug]\nxdebug.remote_enable = On\nxdebug.remote_connect_back = On\nxdebug.max_nesting_level = 400\nhtml_errors = 1\nxdebug.extended_info = 1\nxdebug.profiler_output_dir=\"/vagrant/logs/xdebug\"\nxdebug.profiler_output_name = \"cachegrind.out.%H%R\"\nxdebug.trace_output_dir = \"/vagrant/logs/xdebug/\"\nxdebug.remote_log = \"/vagrant/logs/xdebug-access.log\"\nxdebug.idekey = \"$XDEBUGIDEKEY\"" /etc/php5/apache2/php.ini
sed -i "s/display_errors = Off/display_errors = On/g" /etc/php5/apache2/php.ini

echo -e "\n--- Enabling mod-rewrite ---\n"
a2enmod rewrite > /dev/null 2>&1

echo -e "\n--- Setting document root to public directory ---\n"
rm -rf /var/www
mkdir /vagrant/public
mkdir /vagrant/logs
ln -fs /vagrant/public /var/www

echo -e "\n--- Include phpmyadmin config to apache2.conf  ---\n"
sudo sed -i '$ a \\nInclude /etc/phpmyadmin/apache.conf' /etc/apache2/apache2.conf

echo -e "\n--- Configure Apache virtual host ---\n"
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www
	<Directory /var/www>
        AllowOverride All
        Options FollowSymLinks
    </Directory>
	ErrorLog /vagrant/logs/apache-error.log
	CustomLog /vagrant/logs/apache-access.log combined
</VirtualHost>
# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
EOF

cat > /vagrant/public/index.php <<EOF
<?php phpinfo();
EOF

echo -e "\n--- Restarting Apache ---\n"
service apache2 restart > /dev/null 2>&1

echo -e "\n--- Installing Composer for PHP package management ---\n"
curl --silent https://getcomposer.org/installer | php > /dev/null 2>&1
mv composer.phar /usr/local/bin/composer