<?php

namespace Helper;

use Core\Database;

class Validator
{
    /**
     * Validates if the given string meets the specified length requirements.
     *
     * @param string $value The string value to be validated.
     * @param int $min Minimum length required (default is 1).
     * @param int $max Maximum length allowed (default is PHP_INT_MAX).
     * @return bool Returns true if the string meets the criteria, false otherwise.
     */
    public static function string(string $value, int $min = 1, int $max = INF): bool
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }
    /**
     * Validates if the given value is a valid email address.
     *
     * @param string $value The email value to be validated.
     * @return bool Returns true if the email is valid, false otherwise.
     */
    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    /**
     * Validates a CSRF token against the session-stored token.
     *
     * @param string $token The CSRF token to be validated.
     * @return bool Returns true if the token matches and is set, false otherwise.
     */
    public static function csrf(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    /**
     * Checking the email(FILTER_VALIDATE_EMAIL) and password(length) for registration.
     *
     * @param string $email The email address of the user.
     * @param string $password The password provided during registration.
     * @return array Returns an associative array of validation errors, empty if no errors.
     */
    public static function registration(string $username, string $email, string $password): array
    {
        $error = [];

        if (!self::string($username, 4, 12)) {
            $error['username'] = 'Username must be at least 4 characters long, 12 max.';
        }

        if (!self::usernameValid($username)) {
            $error['username'] = 'Username is not valid';
        }

        if (!self::email($email)) {
            $error['email'] = 'Email is not valid.';
        }

        if (!self::string($password, 6, 21)) {
            $error['password'] = 'Min 6 characters, max 21.';
        }

        return $error;
    }

    public static function correctPassword(array $account, string $password): bool
    {
        if ($account && password_verify($password, $account['password'])) {
            return true;
        }
        return false;
    }

    public static function pswInvalid(string $password): bool
    {
        if (!self::string($password, 6, 21)) {
            return true;
        }

        return false;
    }

    public static function usernameValid(string $username): bool
    {
        return preg_match('/^[a-zA-Z0-9]+(?:[_-][a-zA-Z0-9]+)*$/', $username) === 1;
    }
}
