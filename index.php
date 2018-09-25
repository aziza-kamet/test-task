<?php

require 'vendor/autoload.php';
require 'app/init.php';

use app\controllers\PromotionController;

$controller = new PromotionController;
$controller->index();