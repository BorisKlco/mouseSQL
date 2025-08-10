<?php

use Core\App;
use Core\View;
use Helper\Request;

function request()
{
    return new Request($_REQUEST);
}

/**
 * Sanitize user input
 */
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Log activity
 */
function logActivity($userId, $activity)
{
    $logFile = __DIR__ . '/../logs/activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] User ID: $userId - $activity\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Generates a hidden input element with a CSRF token.
 *
 * This function checks if a CSRF token exists in the session.
 * If not, it generates a new token and stores it in the session.
 * The token is then included as the value of a hidden input element,
 * with the name '_csrf'.
 *
 * @return string The HTML input element containing the CSRF token.
 */
function csrf(): string
{
    $csrf = generateCsrf();
    $inputElement = "<input type='hidden' name='_csrf' value='{$csrf}'>";

    return $inputElement;
}

/**
 * Generates and retrieves the CSRF token for the session.
 *
 * If no CSRF token exists in the session, a new one is generated
 * and stored in the session. The token is then returned.
 *
 * @return string The CSRF token stored in the session.
 */
function generateCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function generateVerificationToken($length = 32): string
{
    return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
}

/**
 * Verifies the CSRF token. True or render Forbidden.
 *
 * This function checks if the provided token matches the CSRF token
 * stored in the session. If the tokens do not match, it renders
 * a "Forbidden" view and halts execution.
 *
 * @param string $token The CSRF token to verify.
 */

function verifyCsrf($token): bool
{
    $verify = isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    unset($_SESSION['csrf_token']);
    return $verify;
}

/**
 * Formats a given datetime string into the format "DD, Nov., YYYY, HH:MM:SS".
 *
 * @param string $datetime The datetime string to format (e.g., "2024-11-21 08:44:58").
 * @return string The formatted datetime string.
 */
function formatDate(string $datetime): string
{
    $date = new DateTime($datetime);
    return $date->format('d. M. Y, H:i:s');
}

function currentRoute(string $name): bool
{
    return $_SERVER['REQUEST_URI'] == getRoute($name);
}

/**
 * Return string value of path for named route.
 */
function getRoute(string $name): string
{
    return App::getRoute($name);
}

/**
 * Return session['user'] or false
 */
function logged()
{
    return isset($_SESSION['user']);
}

function user(string $data): string
{
    return $_SESSION['user'][$data] ?? '';
}


function prevUrl()
{

    return $_SERVER['HTTP_REFERER'] ?? '';
}

/**
 * Redirects to the specified path, optionally setting a session user value.
 *
 * This function sets the session `user` value if provided, then performs
 * an HTTP redirect to the specified path and terminates execution.
 *
 * @param string $path The URL or path to redirect to.
 * @param array user account
 * @return void
 */
function redirect(string $path, array $setUserSession = [])
{
    if (!empty($setUserSession)) {
        $_SESSION['user'] = $setUserSession;

        session_regenerate_id(true);
    }
    header("Location: {$path}");
    exit();
}
/**
 * Dump and die, var_dump for every arg.
 */
function dd(...$args)
{
    echo '<pre>';
    foreach ($args as $arg) {
        var_dump($arg);
        echo '<br>';
    }
    exit();
}
