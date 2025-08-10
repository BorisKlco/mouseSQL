<?php

namespace Controller;

use Core\Database;
use Core\Postgres;
use Core\View;
use Helper\Validator;

class Dashboard
{
    protected Database $db;
    protected Postgres $pg;
    public function __construct()
    {
        $this->db = new Database();
        $this->pg = new Postgres();
    }

    public function index()
    {
        $pgDatabase = Database::getPgDatabaseByUserId(user('id'));
        $pgStats = Postgres::getPgDatabaseStats($pgDatabase);
        $quotaBytes = 50 * 1024 * 1024;
        $usage = round(($pgStats['size_bytes'] / $quotaBytes) * 100, 2);
        View::show('home/dashboard', ['title' => 'Dashboard', 'pgDatabase' => $pgDatabase, 'pgStats' => $pgStats, 'usage' => $usage]);
    }

    public function info()
    {
        $pgDatabase = Database::getPgDatabaseByUserId(user('id'));
        $pgStats = Postgres::getPgDatabaseStats($pgDatabase);
        View::show('home/info', ['title' => 'Database Information', 'pgDatabase' => $pgDatabase, 'pgStats' => $pgStats]);
    }

    public function profileShow()
    {
        View::show('home/profile', ['title' => 'Profile']);
    }

    public function profileChange()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/');
        $current_password = request()->get('current_password');
        $new_password = request()->get('new_password');
        $confirm_password = request()->get('confirm_password');

        if ($new_password != $confirm_password) {
            $error = 'New passwords do not match';
            View::show('home/profile', ['title' => 'Profile', 'error' => $error]);
        }

        if (Validator::pswInvalid($new_password)) {
            $error = 'New passwords need to be min. 6, max. 21 characters';
            View::show('home/profile', ['title' => 'Profile', 'error' => $error]);
        }

        $account = Database::query('SELECT * FROM users WHERE username = ?', [user('username')])->fetch();
        if (Validator::correctPassword($account, $current_password)) {
            Database::query(
                "UPDATE users SET password = :password WHERE username = :username",
                [
                    'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    'username' => user('username')
                ]
            );
            $success = 'Password changed successfully!';
            View::show('home/profile', ['title' => 'Profile', 'success' => $success]);
        } else {
            $error = 'Account password is incorrect.';
            View::show('home/profile', ['title' => 'Profile', 'error' => $error]);
        }
        redirect('/');
    }

    public function DbPasswordChangeShow()
    {
        View::show('home/db_password', ['title' => 'Change database password']);
    }

    public function DbPasswordChange()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/');
        $current_password = request()->get('current_password');
        $new_password = request()->get('new_password');
        $confirm_password = request()->get('confirm_password');

        if ($new_password != $confirm_password) {
            $error = 'New passwords do not match';
            View::show('home/db_password', ['title' => 'Change database password', 'error' => $error]);
        }

        if (Validator::pswInvalid($new_password)) {
            $error = 'New passwords need to be min. 6, max. 21 characters';
            View::show('home/db_password', ['title' => 'Change database password', 'error' => $error]);
        }

        $account = Database::query('SELECT * FROM users WHERE username = ?', [user('username')])->fetch();
        if (Validator::correctPassword($account, $current_password)) {
            $db_username = Database::query('SELECT pg_username FROM pg_databases WHERE user_id = ?', [$account['id']])->fetch();

            Postgres::query("ALTER USER " . $db_username['pg_username'] . " WITH PASSWORD '$new_password'");
            Database::query('UPDATE pg_databases SET pg_password = :password', ['password' => $new_password]);

            $success = 'Password changed successfully!';
            View::show('home/db_password', ['title' => 'Change database password', 'success' => $success]);
        } else {
            $error = 'Account password is incorrect.';
            View::show('home/db_password', ['title' => 'Change database password', 'error' => $error]);
        }

        redirect('/');
    }

    public function deleteAcc()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/');
        $user = Database::query("SELECT pg_username, pg_database_name FROM pg_databases WHERE user_id = ?", [user('id')])->fetch();

        Postgres::dropUser($user['pg_username'], $user['pg_database_name']);
        Database::dropUser(user('id'));

        session_destroy();
        $cookie = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $cookie['path'], $cookie['domain']);
        redirect('/');
    }
}
