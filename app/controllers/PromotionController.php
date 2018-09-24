<?php
namespace app\controllers;


use app\helpers\CsvExport;
use app\models\Promotion;

class PromotionController
{
    public function index()
    {
        CsvExport::export();

        $promotion = Promotion::selectRandom();
        $promotion->status = intval(!$promotion->status);
        $promotion->save();
        var_dump(implode(CsvExport::DELIMITER . ' ', $promotion->columnMap()));
    }
}