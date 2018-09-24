<?php
namespace app\controllers;


use app\helpers\CsvExport;
use app\helpers\UrlGenerator;
use app\models\Promotion;

class PromotionController
{
    public function index()
    {
        CsvExport::export();

        $promotion = Promotion::selectRandom();
        $promotion->status = intval(!$promotion->status);
        $promotion->save();
        echo sprintf('<p><b>%s</b></p>', implode(CsvExport::DELIMITER . ' ', $promotion->columnMap()));

        $promotions = Promotion::list();
        foreach ($promotions as $promotion) {
            echo sprintf('<p>%s</p>', UrlGenerator::generate($promotion->id, $promotion->name));
        }
    }
}