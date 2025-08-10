<?php

namespace Controller;

use Core\Database;
use Core\Postgres;
use Core\View;
use Core\Mail;
use Helper\Validator;

class User
{
    protected Database $db;
    protected Postgres $pg;
    public function __construct()
    {
        $this->db = new Database();
        $this->pg = new Postgres();
    }

    public function login()
    {
        View::show('user/login', ['title' => 'Login Page']);
    }

    public function register()
    {
        View::show('user/register', ['title' => 'Register']);
    }

    public function verification()
    {
        $token = request()->get('token');
        if ($token){
            $account = Database::query('SELECT * FROM users WHERE verification_code = ?', [$token])->fetch();
            if ($account && $account['confirmed'] != 'true'){
                Database::query("UPDATE users SET confirmed = 'true' WHERE id = ?", [$account['id']]);
                redirect('/', $account);
            }
        }

        redirect('/');
    }

    public function auth()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/login');
        $userLogin = request()->get('username');
        $password = request()->get('password');
        $error = '';

        if (Validator::email($userLogin)) {
            $account = Database::query('SELECT * FROM users WHERE email = ?', [$userLogin])->fetch();
            if (Validator::correctPassword($account, $password)) {
                if ($account['confirmed'] == 'true') {
                    Database::insertLoginTimestamp($account['id']);
                    redirect('/', $account);
                } else {
                    $error = 'Please check your email for the verification link.';
                    View::show('user/login', ['title' => 'Login Page', 'error' => $error]);
                }
            }
        } else {
            $account = Database::query('SELECT * FROM users WHERE username = ?', [$userLogin])->fetch();
            if (Validator::correctPassword($account, $password)) {
                if ($account['confirmed'] == 'true') {
                    Database::insertLoginTimestamp($account['id']);
                    redirect('/', $account);
                } else {
                    $error = 'Please check your email for the verification link.';
                    View::show('user/login', ['title' => 'Login Page', 'error' => $error]);
                }
            }
        }
        $_SESSION['old']['username'] = $userLogin;
        $error = "Invalid username or password";
        View::show('user/login', ['title' => 'Login Page', 'error' => $error]);
    }

    public function create()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/register');
        $username = request()->get('username');
        $email = request()->get('email');
        $password = request()->get('password');
        $error = Validator::registration($username, $email, $password);

        if ($error) {
            $_SESSION['old']['username'] = $username;
            $_SESSION['old']['email'] = $email;
            View::show('user/register', ['title' => 'Registration', 'error' => $error]);
        }

        $userExist = Database::query('SELECT id FROM users WHERE username = ?', [$username])->fetch();
        $emailExist = Database::query('SELECT id FROM users WHERE email = ?', [$email])->fetch();
        if ($userExist) $error['username'] = 'Username already exists';
        if ($emailExist) $error['email'] = 'Email address is already in use';
        if ($error) {
            $_SESSION['old']['username'] = $username;
            $_SESSION['old']['email'] = $email;
            View::show('user/register', ['title' => 'Registration', 'error' => $error]);
        }

        $verification_code = generateVerificationToken();

        $createAccGetId = Database::query("
            INSERT INTO users (username, email, password, verification_code)
            VALUES (:username, :email, :password, :verification_code);
            ", [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'verification_code' => $verification_code
        ], true);

        list($postgres_user, $postgres_psw, $postgres_db) = $this->pg->createPgUser($username);
        Database::query("
            INSERT INTO pg_databases (user_id, pg_username, pg_password, pg_database_name)
            VALUES (:user_id, :pg_username, :pg_password, :pg_database_name);
            ", [
            'user_id' => $createAccGetId,
            'pg_username' => $postgres_user,
            'pg_password' => $postgres_psw,
            'pg_database_name' => $postgres_db
        ]);

        $subject = "Verify your " . SERVICE_NAME . " account";
        $verification_link = SERVICE_URL . '/verification?token=' . $verification_code;
        $emailContent = View::renderEmail('email/verification', ['username' => $username, 'verification_link' => $verification_link]);

        Mail::send($email, $subject, $emailContent);

        $_SESSION['success'] = true;
        redirect('/login');
    }

    public function destroy()
    {
        if (!verifyCsrf(request()->get('_csrf'))) redirect('/');
        session_destroy();
        $cookie = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $cookie['path'], $cookie['domain']);
        redirect('/');
    }
}
