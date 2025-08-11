<?php

namespace Controller;

use Core\Database;
use Core\Postgres;
use Core\View;
use Helper\Validator;

class Admin
{

    public function test()
    {

        function formatSize($bytes)
        {
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }
            return round($bytes, 2) . ' ' . $units[$i];
        }

        $users = Database::query("
            SELECT u.id, u.username, u.email, u.last_login, u.created_at, 
                p.pg_database_name, p.pg_username
            FROM users u
            LEFT JOIN pg_databases p ON u.id = p.user_id")->fetchAll();

        // Process each user
        foreach ($users as &$user) {
            // Get PostgreSQL DB size
            if (!empty($user['pg_database_name'])) {
                // Use parameterized query to prevent SQL injection
                $sizeQuery = "SELECT pg_database_size(?)";
                $result = Postgres::query($sizeQuery, [$user['pg_database_name']])->fetch();
                $user['db_size'] = $result['pg_database_size'] ? formatSize($result['pg_database_size']) : 'N/A';
            } else {
                $user['db_size'] = 'N/A';
            }
            $user['privileges_blocked'] = false;
        }
        View::show('home/test', ['title' => 'test', 'users' => $users]);
    }

    public function test2()
    {
        $user = request()->get('user_id');
        $action = request()->get('action');

        $userData = Database::query("
        SELECT p.pg_username, p.pg_database_name 
        FROM pg_databases p
        WHERE p.user_id = ?
        ", [$user])->fetch();

        $username = $userData['pg_username'];
        $database = $userData['pg_database_name'];

        try {
            if ($action === 'block') {
                Postgres::query("REVOKE INSERT ON ALL TABLES IN SCHEMA public FROM $username");
                Postgres::query("REVOKE CREATE ON DATABASE $database FROM $username");
            }
            if ($action === 'unblock') {
                Postgres::query("GRANT INSERT ON ALL TABLES IN SCHEMA public TO $username");
                Postgres::query("GRANT CREATE ON DATABASE $database TO $username");
            }
            if ($action === 'delete') {
                Postgres::dropUser($username, $database);
                Database::dropUser($user);
            }

            // Update privileges status in SQLite
            // Database::query(
            //     "UPDATE pg_databases SET privileges_blocked = ? WHERE user_id = ?",
            //     [$action === 'block' ? 1 : 0, $user]
            // );

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
