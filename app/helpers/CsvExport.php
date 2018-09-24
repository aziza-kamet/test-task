<?php
namespace app\helpers;


use app\models\Promotion;

class CsvExport
{
    private const FILE_PATH = 'web/files/test.csv';
    private const COLUMN_NAME = 'ID акции';
    public const DELIMITER = ';';

    public static function export()
    {
        if (($handle = fopen(self::FILE_PATH, 'r')) !== false) {

            Promotion::truncate();
            while (($data = fgetcsv($handle, 1000, self::DELIMITER)) !== false) {
                if ($data[0] === self::COLUMN_NAME) {
                    continue;
                }

                $promotion = new Promotion();
                $promotion->id = $data[0];
                $promotion->name = $data[1];
                $promotion->startDate = strtotime($data[2]);
                $promotion->endDate = strtotime($data[3]);
                $promotion->status = $promotion->statusValue($data[4]);
                $promotion->save();
            }
            fclose($handle);
        }
    }
}