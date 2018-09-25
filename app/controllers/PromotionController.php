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
        $modifiedPromotion = implode(CsvExport::DELIMITER . ' ', $promotion->columnMap());
        $promotions = Promotion::list();

        return require('app/views/promotions.php');
    }
}