<html>
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="assets/js/picker.js"></script>
    <script type="text/javascript" src="assets/js/picker.date.js"></script>
    <script type="text/javascript" src="assets/js/fr_FR.js"></script>
    <script type="text/javascript" src="assets/js/semantic.min.js"></script>
    <script type="text/javascript" src="assets/js/appAll.js"></script>
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/default.date.css">
    <link rel="stylesheet" href="assets/css/semantic.min.css">
    <title>LogTime 42</title>
</head>
<body>
<br>
<?php
$start = $_GET['start'] ? $_GET['start'] : date('Y-m-d', strtotime(date('Y-m-d') . " -2 WEEKS"));
$end = $_GET['end'] ? $_GET['end'] : date('Y-m-d', strtotime(date('Y-m-d') . "+1 DAY"));

$data_highchart = json_encode(array(
    'start' => $start,
    'end' => $end,
))
?>
<div class="main container all" style="overflow: hidden">
    <div class="ui centered grid">
        <div class="twelve wide column">
            <div class="ui blue menu">
                <a class=" item" href="index.php">
                    Home
                </a>
                <a class="active item">
                    All
                </a>
            </div>
            <div class="four column centered row">
                <form class="ui form">
                    <div class="five fields">
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
                <?php $users = json_decode(file_get_contents('http://timeat42.zaxchi.fr/api/get/user/'));
                $i = 0; ?>
                <?php foreach ($users as $user): $i++; ?>
                    <tr>
                        <td><?= $user ?></td>
                        <td id="<?= $i ?>_week"></td>
                        <td id="<?= $i ?>_day"></td>
                    </tr>
                    <script>
                        $(function () {
                            var json = "getTotalForToday.php";
                            $.getJSON(json, {
                                'uid': '<?= $user ?>'
                            })
                                .done(function (data) {
                                    $("#<?= $i ?>_day").html(data.hour + " heures, " + data.min + " minutes");
                                })
                        });
                        $(function () {
                            var json = "getTotalForWeek.php";
                            $.getJSON(json, {
                                'uid': '<?= $user ?>'
                            })
                                .done(function (data) {
                                    $("#<?= $i ?>_week").html(data.hour + " heures, " + data.min + " minutes");
                                })
                        });
                    </script>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>