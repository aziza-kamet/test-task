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
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

//    TODO have no idea how to refactor
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
            $isOk = self::$pdo->prepare($sql)->execute();
        } catch (\PDOException $e) {
            if ($e->getCode() === '42S01') {
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

    public static function insertOrUpdate($table, $map)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', array_keys($map)),
            ':' . implode(', :', array_keys($map))
        );

        $updateMap = array_reduce(
            array_keys($map),
            function ($array, $key) use ($map) {
                $array[sprintf('update_%s', $key)] = $map[$key];
                return $array;
            }, []
        );
        $valuesMap = array_map(function ($key, $updateKey) {
            return sprintf('%s = :%s', $key, $updateKey);
        }, array_keys($map), array_keys($updateMap));

        $valuesString = implode(', ', $valuesMap);
        $sql = sprintf('%s ON DUPLICATE KEY UPDATE %s', $sql, $valuesString);
        $map = array_merge($map, $updateMap);

        self::executeStatement($sql, $map);
    }

    public static function update($table, $id, $map)
    {
        self::executeStatement(sprintf(
            'UPDATE %s (%s) VALUES (%s) WHERE id = :id',
            $table,
            implode(', ', array_keys($map)),
            ':' . implode(', :', array_keys($map))
        ), array_merge($map, ['id' => $id]));
    }

    public static function truncateTable($table)
    {
        self::executeStatement(sprintf('TRUNCATE TABLE %s', $table));
    }

    public static function selectRandom($table, $className)
    {
        $statement = self::executeStatement(sprintf(
            'SELECT * FROM %s ORDER BY RAND() LIMIT 1',
            $table
        ));

        return $statement->fetchObject($className);
    }

    private static function executeStatement($sql, $params = null)
    {
        try {
            $statement = self::$pdo->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}