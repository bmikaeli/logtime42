<?php

$uid = $_GET['uid'];

$returnjson = array();

$json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uid . '/' . date('Y-m-d', strtotime("-1 WEEK")) . "/" . date('Y-m-d'));
$obj = json_decode($json);
$total = 0;
foreach ($obj->time as $item) {
    $total += $item;
}

$hour = $total / 60;
$min = abs((round($hour) - $hour) * 60);

echo json_encode(array(
    'hour' => round($hour),
    'min' => round($min),
));
?>