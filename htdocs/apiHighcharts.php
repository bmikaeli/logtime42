<?php

$link = mysql_connect('localhost:3307', 'bmikaeli', 'besAJu5e');

if (!$link) {
    die('Connexion problemes : ' . mysql_error());
}
if (!mysql_select_db('logtime', $link)) {
    echo 'Sélection de base de données impossible';
    exit;
}

$return = array();
for ($i = strtotime($_GET['start']); $i < strtotime($_GET['end']); $i = strtotime(date('Y-m-d', $i) . " +1 DAY")) {
    $sql = "SELECT * FROM history WHERE period = '" . date('Y-m-d', $i) . "' AND uid = '" . $_GET['uid'] . "'";

    $result = mysql_query($sql, $link);
    if (!$result) {
        echo "request error";
    } else {
        while ($row = mysql_fetch_assoc($result)) {
            $dbresult[] = $row;
        }
        if (!empty($dbresult)) {
            $tmp = array($i * 1000, (int)$dbresult[0]['nb']);
        } else {
            $tmp = array($i * 1000, 0);
        }
        $dbresult = NULL;
    }
    $return[] = $tmp;
}

for ($i = strtotime($_GET['start']); $i < strtotime($_GET['end']); $i = strtotime(date('Y-m-d', $i) . " +1 DAY")) {
    $sql = "SELECT * FROM history WHERE period = '" . date('Y-m-d', $i) . "' AND uid = '" . $_GET['uidcmp'] . "'";

    $result = mysql_query($sql, $link);
    if (!$result) {
        echo "request error";
    } else {
        while ($row = mysql_fetch_assoc($result)) {
            $dbresult[] = $row;
        }
        if (!empty($dbresult)) {
            $tmp = array($i * 1000, (int)$dbresult[0]['nb']);
        } else {
            $tmp = array($i * 1000, 0);
        }
        $dbresult = NULL;
    }
    $returncmp[] = $tmp;
}
mysql_close($link);

$returnjson = array();
$returnjson[] =  array(
    'name' => $_GET['uid'],
    'data' => $return,
    'color' => '#9b59b6'
);
if($_GET['uidcmp'])
{
    $returnjson[] =  array(
        'name' => $_GET['uidcmp'],
        'data' => $returncmp,
        'color' => '#2ecc71'
    );
}

echo json_encode($returnjson);
?>