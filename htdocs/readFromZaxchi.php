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

for ($i = strtotime($start); $i < strtotime($end . "+1 DAY"); $i = strtotime(date('Y-m-d', $i) . " +1 DAY")) {
    $tmp = NULL;
    $key = date('Y-m-d', $i);
    $tmp[] = $i * 1000;
    $tmp[] = round($time->$key, 2);
    $return[] = $tmp;
}

$returnjson[] = array(
    'name' => $uid,
    'data' => $return,
    'color' => '#9b59b6',
);


if ($uidcmp) {
    $json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $uidcmp . '/' . $start . "/" . $end);
    $obj = json_decode($json);
    $time = $obj->time;
    $returncmp = array();

    for ($i = strtotime($start); $i < strtotime($end . "+1 DAY"); $i = strtotime(date('Y-m-d', $i) . " +1 DAY")) {
        $tmp = NULL;
        $key = date('Y-m-d', $i);
        $tmp[] = $i * 1000;
        $tmp[] = round($time->$key, 2);
        $returncmp[] = $tmp;
    }

    $returnjson[] = array(
        'name' => $uidcmp,
        'data' => $returncmp,
        'color' => '#2ecc71',
    );

}


echo json_encode($returnjson);
?>