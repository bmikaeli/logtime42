<html>
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="assets/js/picker.js"></script>
    <script type="text/javascript" src="assets/js/picker.date.js"></script>
    <script type="text/javascript" src="assets/js/fr_FR.js"></script>
    <script type="text/javascript" src="assets/js/semantic.min.js"></script>
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/default.date.css">
    <link rel="stylesheet" href="assets/css/semantic.min.css">
</head>
<body>
<br>
<br>
<?php

$uid = $_GET['uid'] ? $_GET['uid'] : 'tdemay';
$uidcmp = $_GET['uidcmp'] ? $_GET['uidcmp'] : '';
$start = $_GET['start'] ? $_GET['start'] : date('Y-m-d', strtotime(date('Y-m-d') . " -2 WEEKS"));
$end = $_GET['end'] ? $_GET['end'] : date('Y-m-d');

?>
<div class="main container all">
    <div class="ui centered grid">
        <div class="twelve wide column">
            <div class="four column centered row">
                <form class="ui form">
                    <div class="four fields">
                        <div class="field">
                            <label class="label required">uid</label>
                            <input name="uid" required="true"  maxlength="8" type="text" value="<?= $uid ?>">
                        </div>
                        <div class="field">
                            <label class="label">uid a comparer</label>
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
                        <input class="ui submit blue button" type="submit" value="Rechercher">
                </form>
            </div>
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var json = "apiHighcharts.php";
        $.getJSON(json, {
            'uid': '<?= $uid ?>',
            'uidcmp' : '<?= $uidcmp ?>',
            'start' : '<?= $start ?>',
            'end' : '<?= $end ?>',
        })
            .done(function (data) {
                $('#container').highcharts({
                    chart: {
                        type: 'areaspline'
                    },
                    title: {
                        text: 'Logtime for user ' + '<?= $uid ?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x:%e %b %Y}: {point.y}'
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: 'Nombre d\'heures'
                        }
                    },
                    series: data
                });
            });
    });
    $(function () {
        $('.datepicker').pickadate({
            formatSubmit: 'yyyy-mm-d',
            format: 'yyyy-mm-d',
            hiddenSuffix : undefined,
            hiddenPrefix: undefined,
            hiddenName: undefined
        })

    });
</script>

</body>
</html>