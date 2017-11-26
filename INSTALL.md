Installation guide
==================

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following commands:

~~~
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
~~~

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=databasename',
    'username' => 'usernameroot',
    'password' => 'passwordroot',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.

Migration
-------------
### Yii2-user module Migration

You can install this migration using the following command:

~~~
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations // yii2-user vendor migration
~~~

### Yii2 custom Migrations

You can install this migrations using the following command:

~~~
php yii migrate
~~~

Import products from [CookDrive](http://cookdrive.com.ua)
---------------------------------------------------------
### Parser

Run parser [CookDrive.com.ua](http://cookdrive.com.ua) using the following command:

~~~
php yii import
~~~
or
~~~
php yii import/index
~~~

Google Auth
-----------
### Google Auth configuration

If you need using own google oauth application and edit the file `config/hello.ini` with real data, for example:

~~~
oauth_google_clientId="901813169709-1741jubl302jn9mgt2o5f3mq8e5hlsct.apps.googleusercontent.com" // google client ID
oauth_google_clientSecret="EEecPlY5kUmszUet2OL27-kZ" // client secret
...some code...
~~~

Yii Server
----------
### Running server command
~~~
php yii serve
~~~

### Profit!