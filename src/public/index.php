<?php
require '../vendor/autoload.php';

use Core\App;

define('SERVICE_NAME', getenv('SERVICE_NAME'));
define('SERVICE_URL', getenv('SERVICE_URL'));
define('SERVICE_LOGO', SERVICE_URL . '/img/logo.webp');

define('PG_HOST', getenv('PG_HOST'));
define('PG_HOST_PUBLIC', getenv('PG_HOST_PUBLIC'));
define('PG_PORT', getenv('PG_PORT'));
define('PG_ADMIN_USER', getenv('PG_USR'));
define('PG_ADMIN_PASSWORD', getenv('PG_PSW'));

define('SMTP', getenv('STMP'));
define('SMTP_username', getenv('SMTP_USR'));
define('SMTP_password', getenv('STMP_PSW'));
define('SMTP_email_from', getenv('STMP_MAILFROM'));

if (filter_var(getenv('DEBUG'), FILTER_VALIDATE_BOOLEAN)) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

const BASE_PATH = __DIR__ . "/../";
const VIEWS_PATH = BASE_PATH . "views/";

session_start();

new App();
App::resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
