<?php

namespace db;

use PDO;

/**
 * Class MySqlDatabase
 * @package db
 */

class MySqlDatabase implements Database
{
    /** @var \PDO pdo */
    private static $pdo;

    public static function init()
    {
        $driver = new MySQLDriver();
        self::$pdo = $driver->connect();
    }

    public static function createTable()
    {
        $isOk = false;
        $msg = '';

        try {
            $sql = 'CREATE TABLE promotions (
              id INT(11) AUTO_INCREMENT PRIMARY KEY,
              name VARCHAR(255) NOT NULL,
              start_date INT(11) NOT NULL,
              end_date INT(11) NOT NULL,
              status TINYINT(1) NOT NULL
            );';
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $isOk = self::$pdo->prepare($sql)->execute();
        } catch (\PDOException $exception) {
            if ($exception->getCode() === '42S01') {
                $msg = 'Table already exists';
            } else {
                $msg = 'Some error had occurred';
            }
        }

        return [
            'success' => $isOk,
            'msg' => $msg
        ];
    }
}