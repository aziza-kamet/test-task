<?php
namespace app\models;


use db\MySqlDatabase;

class Promotion
{
    public static $table = 'promotions';

    public $id;
    public $name;
    public $startDate;
    public $endDate;
    public $status;

    public const STATUS_ON = 'On';
    public const STATUS_OFF = 'Off';
    public const STATUS_VALUES = [
        self::STATUS_ON => 1,
        self::STATUS_OFF => 0
    ];

    public function save()
    {
        MySqlDatabase::insertOrUpdate(self::$table, $this->columnMap());
    }

    public function columnMap()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'status' => $this->status,
        ];
    }

    public function statusValue($status)
    {
        if (!array_key_exists($status, self::STATUS_VALUES)) {
            return false;
        }

        return self::STATUS_VALUES[$status];
    }

    public static function selectRandom()
    {
        return MySqlDatabase::selectRandom(self::$table, self::class);
    }

    public static function truncate()
    {
        MySqlDatabase::truncateTable(self::$table);
    }

    public function __set($name, $value)
    {
        $propertyName = lcfirst(str_replace('_', '', ucwords($name, '_')));
        $this->$propertyName = $value;
    }
}