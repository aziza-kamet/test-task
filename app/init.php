<?php

session_start();
session_unset();
\db\MySqlDatabase::init();

$result = \db\MySqlDatabase::createTable();
if (!$result['success']) {
    $_SESSION['error'] = $result['msg'];
}
