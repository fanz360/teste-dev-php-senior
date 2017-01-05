<?php

namespace Acme\Util;

use PDO;

class Database
{
    private static $conn;

    private function __construct()
    {
    }

    public static function getConnection()
    {
        if (self::$conn === NULL) {
            // Não estava encontrando a pasta com valor absoluto por conta do ambiente
            //$dsn = 'sqlite:/var/www/app/db/task.sqlite';
            $dsn = 'sqlite:'.__DIR__.'/../../db/task.sqlite';
            
            self::$conn = new PDO($dsn);

            if(!self::$conn) {
                throw new \RuntimeException(self::$conn->lastErrorMsg());
            }

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("CREATE TABLE IF NOT EXISTS tasks (id INTEGER PRIMARY KEY AUTOINCREMENT, description TEXT, message TEXT)");
        }
        return self::$conn;
    }
}
