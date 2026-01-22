<?php
require '../vendor/autoload.php';

use Core\App;

if ((bool) getenv('DEBUG') == true) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

const SERVICE_NAME = getenv('SERVICE_NAME');
const SERVICE_URL = getenv('SERVICE_URL');
const SERVICE_LOGO = SERVICE_URL . '/img/logo.webp';

const PG_HOST = getenv('PG_HOST');
const PG_HOST_PUBLIC = getenv('PG_HOST_PUBLIC');
const PG_PORT = getenv('PG_PORT');
const PG_ADMIN_USER = getenv('PG_USR');
const PG_ADMIN_PASSWORD = getenv('PG_PSW');

const SMTP = getenv('STMP');
const SMTP_username = getenv('SMTP_USR');
const SMTP_password = getenv('STMP_PSW');
const SMTP_email_from = getenv('STMP_MAILFROM');

const BASE_PATH = __DIR__ . "/../";
const VIEWS_PATH = BASE_PATH . "views/";

session_start();

new App();
App::resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
