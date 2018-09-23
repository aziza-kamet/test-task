<?php


\db\MySqlDatabase::init();
$result = \db\MySqlDatabase::createTable();
if (!$result['success']) {
    var_dump($result['msg']);
}
