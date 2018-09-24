<?php


\db\MySqlDatabase::init();
$result = \db\MySqlDatabase::createTable();
if (!$result['success']) {
    echo sprintf('<p>%s</p>', $result['msg']);
}
