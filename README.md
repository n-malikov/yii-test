# yii-test

### Установка:

~~~
cp config/db.example.php config/db.php
~~~

редачим `config/db.php`

~~~
composer install
# composer install --no-dev
php yii migrate

sudo chown -R ${USER}:www-data runtime
sudo chown -R ${USER}:www-data web/assets
chmod -R 775 runtime
chmod -R 775 web/assets
~~~
