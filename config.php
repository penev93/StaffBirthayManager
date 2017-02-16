<?php
define("HOME_URL", "http://localhost/birthday/");
define("CRON_EMAIL",'valeripenew93@gmail.com');
define("HOME_DIRECTORY", "E:/www/birthday/");
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '1234');
define('DATABASE_NAME', 'birthday');
error_reporting(E_ALL & ~E_NOTICE);
session_start([
    'cookie_lifetime' => 12,
    'read_and_close' => true,
]);
$CURRENT_TEMPLATE = "";
function __autoload($class_name)
{
    if (file_exists(HOME_DIRECTORY . "Classes/" . $class_name . '.php')) {
        require_once HOME_DIRECTORY . "Classes/" . $class_name . '.php';
    } else if (file_exists(HOME_DIRECTORY . "Controllers/" . $class_name . '.php')) {
        require_once HOME_DIRECTORY . "Controllers/" . $class_name . '.php';
    }
}
Connection::init();
