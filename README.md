# PHP MVC-Framework

This is a simple PHP OOP/MVC framework I have made to further my understand of both OOP & MVC concepts. Hopefully to be utilised as a base to build upon and improve in future projects. 

This framework will include...

* A core library class to load controllers & methods from the URL (Also using .htaccess)
* A base controller class to load models and views
* A custom database library using PDO for all models to interact with the database using prepared statements

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.


### Installing

A step by step series of examples that tell you how to get a development env running

####Define all your constants in the config/config.php file:

```
define('DB_USER', '_YOUR_USER_');
define('DB_PASS', '_YOUR_PASS_');
define('DB_NAME', '_YOUR_DB_NAME_');
define('URL', '_YOUR_URL_') ;
define('SITENAME', '_YOUR_SITE_NAME_');
```

####Inside the public/.htaccess file be sure to point the RewriteBase to the location of your public folder
```
RewriteBase /public/folder/location
```
