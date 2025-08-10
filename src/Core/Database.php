<?php

namespace Core;

use PDO;
use PDOStatement;

class Database
{
    private static \PDO $db;

    public function __construct(
        string $filename = 'database'
    ) {

        self::$db = new PDO(
            'sqlite:' . BASE_PATH . "{$filename}.db",
            options: [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );

        $this->initializeDatabase();
    }

    private function initializeDatabase()
    {
        // Create users table
        self::$db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                last_login DATETIME,
                confirmed TEXT DEFAULT NULL,
                verification_code TEXT DEFAULT NULL
            )
        ");

        // Create pg_databases table
        self::$db->exec("
            CREATE TABLE IF NOT EXISTS pg_databases (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                pg_username TEXT UNIQUE NOT NULL,
                pg_password TEXT NOT NULL,
                pg_database_name TEXT NOT NULL,
                pg_host TEXT DEFAULT '" . PG_HOST_PUBLIC . "',
                pg_port INTEGER DEFAULT " . PG_PORT . ",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users (id)
            )
        ");
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
    public static function query(string $query, array $params = [], bool $returnId = false): PDOStatement | int
    {
        try {
            $db = self::$db;
            $statement = $db->prepare($query);
            $statement->execute($params);
            $id = (int)$db->lastInsertId();
        } catch (\PDOException $e) {
            $error = [
                'title' => $e->getCode(),
                'error' => $e->getMessage()

            ];
            View::DBException($error);
        }

        if ($returnId && $id) return $id;

        return $statement;
    }

    public static function dropUser($id): void
    {
        self::query("DELETE FROM users WHERE id = ?", [$id]);
    }

    public static function getUserByUsername($username): array
    {
        return self::query("SELECT * FROM users WHERE username = ?", [$username])->fetch() ?? [];
    }

    public static function getUserByEmail($email): array
    {
        return self::query("SELECT * FROM users WHERE email = ?", [$email])->fetch() ?? [];
    }

    public static function getUserById($id): array
    {
        return self::query("SELECT * FROM users WHERE id = ?", [$id])->fetch() ?? [];
    }

    public static function updateLastLogin($id): array
    {
        return self::query("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?", [$id])->fetch() ?? [];
    }

    public static function getPgDatabaseByUserId($id): array
    {
        return self::query("SELECT * FROM pg_databases WHERE user_id = ?", [$id])->fetch() ?? [];
    }

    public static function insertLoginTimestamp($id): void
    {
        self::query("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?", [$id]);
    }
}
