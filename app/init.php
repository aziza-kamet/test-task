<?php

session_start();
session_unset();
\db\QueryBuilder::init(new \db\MySQLDriver());

$result = \db\QueryBuilder::createTable();
if (!$result['success']) {
    $_SESSION['error'] = $result['msg'];
}
