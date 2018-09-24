<?php
namespace app\controllers;


use app\models\Promotion;

class PromotionController
{
    public function index()
    {
        if (($handle = fopen("web/files/test.csv", "r")) !== false) {

            Promotion::truncate();
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                if ($data[0] === 'ID акции') {
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

        $promotion = Promotion::selectRandom();
        $promotion->status = intval(!$promotion->status);
        $promotion->save();
        var_dump(implode('; ', $promotion->columnMap()));
    }
}