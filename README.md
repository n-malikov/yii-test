# yii-test

живой пример: [yii-test.artello.ru](https://yii-test.artello.ru/)

### Установка:

~~~
cp config/db.example.php config/db.php
~~~

редачим `config/db.php`

~~~
composer install
# composer install --no-dev
php yii migrate

sudo chown -R www-data:www-data runtime
sudo chown -R www-data:www-data web/assets
~~~
