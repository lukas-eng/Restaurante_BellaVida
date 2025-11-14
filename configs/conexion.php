<?php

class Database {

    private static $host = "localhost";
    private static $dbname = "restaurante";
    private static $username = "admi";
    private static $password = "3456";
    
    private static $charset = "utf8mb4";
    private static $pdo = null;

    private function __construct() {}

    public static function connect() {
        if (self::$pdo === null) {
            try {
                $dn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
                self::$pdo = new PDO($dn, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
