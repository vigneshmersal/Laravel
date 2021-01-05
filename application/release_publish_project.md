# Publish
https://laraveldaily.com/how-to-deploy-laravel-projects-to-live-server-the-ultimate-guide/
https://laravel.com/docs/7.x/deployment

https://www.digitalocean.com/community/tutorials/how-to-set-up-nginx-server-blocks-virtual-hosts-on-ubuntu-16-04

## connect
> ssh -i file.pem user@ip

## nginx
https://serversforhackers.com/c/lemp-nginx-php-laravel

cd /etc/nginx/sites-enabled/
cd /etc/nginx/sites-available/

> vim /etc/nginx# vim nginx.conf
> vim /etc/nginx/sites-available/default

pointing server
> vim /etc/nginx/sites-enabled/myapp

listen 80 default_server;
listen 443 ssl default_server;
server_name example.com;
root /srv/example.com/public;
index index.php;

test:
> sudo nginx -t
- sudo service nginx configtest

log:
> /var/log/nginx/error.log

reload:
> sudo service nginx reload
> sudo service nginx restart

Check what user PHP-FPM is running as (it's www-data)
> ps aux | grep php

# Change owner of storage and bootstrap laravel directories
from:  drwxr_xr_x root root 4096 storage
to:    drwxr_xr_x www-data www-data 4096 storage
> sudo chown -R www-data: storage bootstrap

## Release Project
> git clone <repo>

> .env file

> database connection

> composer install

> php artisan storage:link
- check image paths

> chmod -R o+w storage/ bootstrap/

> php artisan config:clear

> php artisan key:generate

> composer dump-autoload

> php artisan migrate , php artisan db:seed , php artisan migrate --seed

> php artisan passport:install
- files created at -> storage/ oauth-private.key , oauth-public.key

## New changes
```sh
cd /var/www/project/htdocs/
php artisan down
git pull origin master
composer install
php artisan migrate
php artisan cache:clear
php artisan queue:restart
php artisan up
```

## zero-time deployment

## staging
```php
APP_ENV=staging
APP_DEBUG=true
APP_URL=http://test-something.yourdomain.com
```

## Clear
```php
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache
```

