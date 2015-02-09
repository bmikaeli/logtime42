<?php

$uid = $_GET['uid'];

$returnjson = array();

$json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uid . '/' . date('Y-m-d'));
$obj = json_decode($json);
$today = date('Y-m-d');

echo json_encode(array('nb' => round($obj->time->$today, 2)));
?>