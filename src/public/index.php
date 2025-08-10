<?php
require '../vendor/autoload.php';

use Core\App;

ini_set('display_errors', '1');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

const SERVICE_NAME = 'MouseSQL';
const SERVICE_URL = 'http://localhost:8080';
const SERVICE_LOGO = SERVICE_URL . '/img/logo.webp';

const PG_HOST = 'mousesql_postgres';
const PG_HOST_PUBLIC = 'mousesql_postgres';
const PG_PORT = 5432;
const PG_ADMIN_USER = 'docker';
const PG_ADMIN_PASSWORD = 'docker';

const SMTP = '';
const SMTP_username = '';
const SMTP_password = '';
const SMTP_email_from = '';

const BASE_PATH = __DIR__ . "/../";
const VIEWS_PATH = BASE_PATH . "views/";

session_start();

new App();
App::resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
