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
        MySqlDatabase::insert(self::$table, $this->columnMap());
    }

    public function columnMap()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => strtotime($this->startDate),
            'end_date' => strtotime($this->endDate),
            'status' => $this->statusValue(),
        ];
    }

    public function statusValue()
    {
        if (!array_key_exists($this->status, self::STATUS_VALUES)) {
            return false;
        }

        return self::STATUS_VALUES[$this->status];
    }

    public static function truncate()
    {
        MySqlDatabase::truncateTable(self::$table);
    }
}