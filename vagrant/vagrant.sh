#!/usr/bin/env bash
# Options
packages=$(echo "$1")
github_token=$(echo "$2")
swapsize=$(echo "$3")
timezone=$(echo "$4")
# Helpers
composer="php /usr/local/bin/composer"

# System configuration
if ! grep --quiet "swapfile" /etc/fstab; then
  fallocate -l ${swapsize}M /swapfile
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  echo '/swapfile none swap defaults 0 0' >> /etc/fstab
fi

# Configuring timezone
echo ${timezone} | sudo tee /etc/timezone
sudo dpkg-reconfigure --frontend noninteractive tzdata


sudo add-apt-repository -y ppa:ondrej/php

# Configuring server software
sudo update-locale LC_ALL="C"
sudo dpkg-reconfigure locales
echo "mysql-server-5.6 mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password_again password root" | debconf-set-selections

sudo apt-get update
sudo apt-get upgrade -y
sudo apt-get install -y ${packages}

sudo sed -i 's/bind-address.*/bind-address = 0.0.0.0/g' /etc/mysql/my.cnf;

sudo phpenmod mcrypt

# install composer
if [ ! -f /usr/local/bin/composer ]; then
	sudo curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
else
	${composer} self-update
	${composer} global update --no-progress --prefer-dist
fi
${composer} config --global github-oauth.github.com ${github_token}

# init application
if [ ! -d /var/www/vendor ]; then
    cd /var/www && ${composer} install --no-progress --prefer-dist --optimize-autoloader
else
    cd /var/www && ${composer} update --no-progress --prefer-dist --optimize-autoloader
fi


# copy only if not exists
if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.dist /var/www/.env
fi

# create nginx config
if [ ! -f /etc/nginx/sites-enabled/gitsender.local ]; then
    sudo ln -s /var/www/vagrant/vhost.conf /etc/nginx/sites-enabled/gitsender.local
fi

# Configuring application
echo "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root'" | mysql -uroot -proot
echo "FLUSH PRIVILEGES" | mysql -uroot -proot
echo "CREATE DATABASE IF NOT EXISTS \`gitsender\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" | mysql -uroot -proot

php /var/www/console/yii app/setup --interactive=0

sudo service mysql restart
sudo service php7.1-fpm restart
sudo service nginx restart
