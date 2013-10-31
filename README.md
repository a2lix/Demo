A2LiX Demo
==========

- curl -sS https://getcomposer.org/installer | php
- php composer.phar install

- php app/console doctrine:database:create
- php app/console doctrine:schema:update --force
- php app/console assets:install --symlink
- php app/console assetic:dump
