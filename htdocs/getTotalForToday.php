<?php

$uid = $_GET['uid'];

$returnjson = array();

$json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uid . '/' . date('Y-m-d'));
$obj = json_decode($json);
$today = date('Y-m-d');

$hour = $obj->time->$today / 60;
$min = abs((round($hour) - $hour) * 60);

echo json_encode(array(
    'hour' => floor($hour),
    'min' => round($min),
));
?>