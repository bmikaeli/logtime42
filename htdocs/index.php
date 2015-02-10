<html>
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="assets/js/picker.js"></script>
    <script type="text/javascript" src="assets/js/picker.date.js"></script>
    <script type="text/javascript" src="assets/js/fr_FR.js"></script>
    <script type="text/javascript" src="assets/js/semantic.min.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/default.date.css">
    <link rel="stylesheet" href="assets/css/semantic.min.css">
    <title>LogTime 42</title>
</head>
<body>
<br>
<br>
<?php

$uid = $_GET['uid'] ? $_GET['uid'] : '';
$uidcmp = $_GET['uidcmp'] ? $_GET['uidcmp'] : '';
$start = $_GET['start'] ? $_GET['start'] : date('Y-m-d', strtotime(date('Y-m-d') . " -2 WEEKS"));
$end = $_GET['end'] ? $_GET['end'] : date('Y-m-d', strtotime(date('Y-m-d') . "+1 DAY"));

$data_highchart = json_encode(array(
    'uid' => $uid,
    'uidcmp' => $uidcmp,
    'start' => $start,
    'end' => $end,
))
?>
<div class="main container all">
    <div class="ui centered grid">
        <div class="twelve wide column">
            <div class="four column centered row">

                <form class="ui form">
                    <div class="five fields">
                        <div class="field">
                            <label class="label required">uid</label>
                            <input name="uid" required="true" maxlength="8" type="text" value="<?= $uid ?>">
                        </div>
                        <div class="field">
                            <label class="label" for="uidcmp">uid a comparer (optionnel)</label>
                            <input name="uidcmp" type="text" value="<?= $uidcmp ?>">
                        </div>
                        <div class="field">
                            <label class="label">Date de debut</label>
                            <input name="start" class="datepicker" type="text" value="<?= $start ?>">
                        </div>
                        <div class="field">
                            <label class="label">Date de fin</label>
                            <input name="end" class="datepicker" type="text" value="<?= $end ?>">
                        </div>
                        <div class="field">
                            <label class="label">&nbsp;</label>
                            <input class="ui submit blue button" type="submit" value="Rechercher">
                        </div>
                    </div>

                </form>
            </div>
            <?php if ($uid): ?>

                <div id="highcharts-data" data-value='<?= $data_highchart ?>'></div>

                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                <table class="ui table">
                    <thead>
                    <tr>
                        <th>uid</th>
                        <th>Temps total de cette semaine</th>
                        <th>Temps aujourdhui</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $uid ?></td>
                        <td id="uid_week"></td>
                        <td id="uid_today"></td>
                    </tr>
                    <?php if ($uidcmp): ?>
                        <tr>
                            <td><?= $uidcmp ?></td>
                            <td id="uidcmp_week"></td>
                            <td id="uidcmp_today"></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>