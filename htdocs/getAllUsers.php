<?php
$start = $_GET['start'];
$end = $_GET['end'];
$allusers = json_decode(file_get_contents('http://timeat42.zaxchi.fr/api/get/user/'));
$returnjson = array();

foreach ($allusers as $user) {

    $json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/' . $user . '/' . $start . "/" . $end);

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
        'name' => $user,
        'data' => $return,
        'color' => "#".substr(hash('tiger192,4', $user), 3, 6),
    );

}
echo json_encode($returnjson);
?>