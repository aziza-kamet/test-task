<?php
namespace app\config;


class Config
{
    private const PATH = 'app/config/constants.php';
    public static function get($key)
    {
        if (!file_exists(self::PATH)) {
            die('You must create file app/config/constants.php');
        }
        $constants = require self::PATH;
        if (!array_key_exists($key, $constants)) {
            return null;
        }
        return $constants[$key];
    }
}