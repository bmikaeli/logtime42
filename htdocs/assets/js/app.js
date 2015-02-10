$(document).ready(function () {

    var data_highchart = eval("(" + $("#highcharts-data").attr("data-value") + ")");

    $(function () {
        $('.datepicker').pickadate({
            formatSubmit: 'yyyy-mm-d',
            format: 'yyyy-mm-d',
            hiddenSuffix: undefined,
            hiddenPrefix: undefined,
            hiddenName: undefined
        });

    });

    $('select.dropdown')
        .dropdown();

    $(function () {
        var json = "getTotalForToday.php";
        $.getJSON(json, {
            'uid': data_highchart.uid
        })
            .done(function (data) {
                $("#uid_today").html(data.hour + " heures, " + data.min + " minutes");
            })
    });

    $(function () {
        var json = "getTotalForWeek.php";
        $.getJSON(json, {
            'uid': data_highchart.uidcmp
        })
            .done(function (data) {
                $("#uidcmp_week").html(data.hour + " heures, " + data.min + " minutes");
            })
    });
    $(function () {
        var json = "getTotalForToday.php";
        $.getJSON(json, {
            'uid': data_highchart.uidcmp
        })
            .done(function (data) {
                $("#uidcmp_today").html(data.hour + " heures, " + data.min + " minutes");
            })
    });
    $(function () {
        var json = "getTotalForWeek.php";
        $.getJSON(json, {
            'uid': data_highchart.uid
        })
            .done(function (data) {
                $("#uid_week").html(data.hour + " heures, " + data.min + " minutes");
            })
    });


    $(function () {

        var json = "readFromZaxchi.php";
        $.getJSON(json, {
            'uid': data_highchart.uid,
            'uidcmp': data_highchart.uidcmp,
            'start': data_highchart.start,
            'end': data_highchart.end
        })
            .done(function (data) {
                $('#container').highcharts({
                    chart: {
                        type: 'areaspline'
                    },
                    title: {
                        text: 'Logtime for user ' + data_highchart.uid
                    },
                    subtitle: {
                        text: data_highchart.start + " - " + data_highchart.end
                    },
                    tooltip: {
                        formatter: function () {
                            var hour = this.y / 60;
                            var min = Math.abs((Math.floor(hour) - hour) * 60);
                            return Math.floor(hour) + " heures, " + Math.floor(min) + " minutes";
                        }
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
});