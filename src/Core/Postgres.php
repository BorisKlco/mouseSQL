<?php

namespace Core;

use PDO;
use PDOStatement;

class Postgres
{
    private static \PDO $db;

    public function __construct()
    {

        self::$db = new PDO(
            dsn: "pgsql:host=" . PG_HOST . ";port=5432;dbname=postgres",
            username: PG_ADMIN_USER,
            password: PG_ADMIN_PASSWORD,
            options: [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public static function instance(): \PDO
    {
        return self::$db;
    }
    /**
     * Executes a SQL query with optional parameters and returns the prepared statement.
     *
     * @param string $query The SQL query to be executed.
     * @param array $params An associative array of parameters to bind to the query (default is an empty array).
     * @return PDOStatement Returns the prepared statement object.
     */
    public static function query(string $query, array $params = []): PDOStatement
    {
        try {
            $db = self::$db;
            $statement = $db->prepare($query);
            $statement->execute($params);
        } catch (\PDOException $e) {
            $error = [
                'title' => $e->getCode(),
                'error' => $e->getMessage()

            ];
            View::DBException($error);
        }

        return $statement;
    }

    public static function dropUser($user, $database): void
    {
        self::query("SELECT pg_terminate_backend(pg_stat_activity.pid)
                    FROM pg_stat_activity
                    WHERE pg_stat_activity.datname = '$database'");
        self::query("DROP DATABASE IF EXISTS $database");
        self::query("DROP ROLE IF EXISTS $user");
    }

    public static function getPgDatabaseStats($pgDatabase)
    {
        $stats = [
            'size_pretty' => 'N/A',
            'size_bytes' => 0,
            'connections' => 'N/A'
        ];
        // Get database size
        $data = self::query("SELECT pg_database_size(:db) as size_bytes, pg_size_pretty(pg_database_size(:db)) AS size_pretty", ['db' => $pgDatabase['pg_database_name']])->fetch();
        if ($data) {
            $stats['size_pretty'] = $data['size_pretty'];
            $stats['size_bytes'] = (int)$data['size_bytes'];
        }
        // Get active connections
        $data = self::query("SELECT COUNT(*) AS connections FROM pg_stat_activity WHERE datname = ?", [$pgDatabase['pg_database_name']])->fetch();
        $stats['connections'] = $data ? $data['connections'] : 'N/A';

        return $stats;
    }

    /**
     * Create a new PostgreSQL user with restricted privileges
     */
    public function createPgUser($user): array
    {
        // Create user
        $username = $this->generatePgUsername($user);
        $password = $this->generateSecurePassword();
        $database = $this->generateDatabaseName($user);
        self::query("CREATE USER $username WITH PASSWORD '$password'");
        self::query("CREATE DATABASE $database OWNER $username");
        self::query("REVOKE CONNECT ON DATABASE $database FROM PUBLIC");

        return [$username, $password, $database];
    }

    public function generatePgUsername($baseUsername)
    {
        return substr($baseUsername, 0, 20) . '_' . time();
    }

    public function generateDatabaseName($baseName)
    {
        return substr($baseName, 0, 20) . '_db_' . time();
    }

    public function generateSecurePassword($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }
}
