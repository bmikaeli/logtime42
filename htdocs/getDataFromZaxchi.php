<?php
$json = file_get_contents('http://timeat42.zaxchi.fr/api/get/history/tdemay');
$obj = json_decode($json);
//var_dump($obj);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=logtime', 'bmikaeli', 'besAJu5e');
    $pdo->beginTransaction();
    foreach ($obj as $key => $tmp) {
        if ($tmp->action == "login") {
            $login = date('Y-m-d H:i:s', strtotime(substr($tmp->timestamp, 0, 19)));
            $logout = date('Y-m-d H:i:s', strtotime(substr($obj[$key + 1]->timestamp, 0, 19)));
            if (strtotime(date('Y-m-d', strtotime($login))) == strtotime(date('Y-m-d', strtotime($logout)))) {
                $value = NULL;
                $value[] = array(
                    'nb' => (strtotime($logout) - strtotime($login)) / 3600,
                    'period' => date('Y-m-d', strtotime($logout)),
                    'login' => $tmp->login
                );
            } else {
                $value = NULL;
                $value[] = array(
                    'nb' => (strtotime($logout) - strtotime(date('Y-m-d', strtotime($logout)))) / 3600,
                    'period' => date('Y-m-d', strtotime($logout)),
                    'login' => $tmp->login
                );
                $value[] = array(
                    'nb' => (strtotime(date('Y-m-d', strtotime($logout))) - strtotime($login)) / 3600,
                    'period' => date('Y-m-d', strtotime($login)),
                    'login' => $tmp->login
                );
            }
            foreach ($value as $val) {

                var_dump($val);
                $alreadyId = -42;

                $select = "SELECT id, nb FROM history WHERE uid = '" . $val['login'] . "' AND period = '" . $val['period'] . "'";
                foreach ($pdo->query($select) as $row) {
                    $alreadyId = $row['id'];
                    $lastValue = $row['nb'];
                }
                if ($alreadyId != -42) {
                    $query = "UPDATE history SET nb = " . $lastValue + $val['nb'] . "WHERE id = " . $alreadyId;
                } else {
                    $query = "INSERT INTO history (uid, period, nb) VALUES ('" . $val['login'] . "', '" . $val['period'] . "', " . $val['nb'] . ")";
                }
                $pdo->query($query);
            }
        }
    }
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollback();
    die();
}
echo "done";

?>