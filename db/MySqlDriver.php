<?php
namespace db;

use PDO;
use PDOException;

class MySQLDriver implements Driver
{
    private const HOST = '127.0.0.1';
    private const PORT = '3306';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const DATABASE = 'choco';

    public function connect()
    {
        try {
            return new PDO(
                'mysql:host=' . self::HOST . ':' . self::PORT
                    . ';dbname='.self::DATABASE,
                self::USERNAME,
                self::PASSWORD
            );
        } catch (PDOException $e) {
            var_dump($e->getMessage());die;
        }
    }
}