<?php
namespace app\controllers;


use app\helpers\CSVExport;
use app\models\Promotion;

class PromotionController
{
    public function index()
    {
        CSVExport::export();

        $promotion = Promotion::selectRandom();
        $promotion->status = intval(!$promotion->status);
        $promotion->save();
        var_dump(implode(CSVExport::DELIMITER . ' ', $promotion->columnMap()));
    }
}