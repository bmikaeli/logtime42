<?php

$start = $_GET['start'];
$end = $_GET['end'];
$uid = $_GET['uid'];
$uidcmp = $_GET['uidcmp'];
$returnjson = array();

$json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uid . '/' . $start . "/" . $end);

$obj = json_decode($json);

$time = $obj->time;
$return = array();

foreach ($time as $date => $nb) {
    $tmp = array();
    $tmp[] = strtotime($date) * 1000;
    $tmp[] = $nb;
    $return[] = $tmp;
}

sort($return);
$returnjson[] = array(
    'name' => $uid,
    'data' => $return,
    'color' => '#9b59b6',
);


if ($uidcmp) {
    $returncmp = array();

    $json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uidcmp . '/' . $start . "/" . $end);
    $obj = json_decode($json);
    $time = $obj->time;

    foreach ($time as $date => $nb) {
        $tmp = array();
        $tmp[] = strtotime($date) * 1000;
        $tmp[] = $nb;
        $returncmp[] = $tmp;
    }
    sort($returncmp);

    $returnjson[] = array(
        'name' => $uidcmp,
        'data' => $returncmp,
        'color' => '#2ecc71',
    );
}


echo json_encode($returnjson);
?>