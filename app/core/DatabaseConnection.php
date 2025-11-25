<?php

class DatabaseConnection {

    private static PDO $instance;
    private const HOST = "postgres";
    private const PORT = "5432";

    protected function __construct()
    {
    }

    /**
     * Singletons should not be cloneable.
     */
    protected function __clone()
    {
    }

    /**
     * Singletons should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): PDO
    {
        if (!isset(self::$instance)) {
            $user = getenv("POSTGRES_USER");
            $password = getenv("POSTGRES_PASSWORD");
            $db = getenv("POSTGRES_DB");
            try {
                $dsn = "pgsql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . $db;
                self::$instance = new PDO($dsn, $user, $password);
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new PDOException('Database connection failed.');
            }
        }
        return self::$instance;
    }
}