<?php
namespace db;

use app\config\Config;
use PDO;
use PDOException;

class MySQLDriver implements Driver
{
    public function connect()
    {
        $db = Config::get('db');
        try {
            return new PDO(
                sprintf(
                    'mysql:host=%s:%s;dbname=%s',
                    $db['host'],
                    $db['port'],
                    $db['dbname']
                ),
                $db['username'],
                $db['password']
            );
        } catch (PDOException $e) {
            var_dump($e->getMessage());die;
        }
    }
}