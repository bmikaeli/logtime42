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

    $(function () {

        var json = "getAllUsers.php";
        $.getJSON(json, {
            'start': data_highchart.start,
            'end': data_highchart.end
        })
            .done(function (data) {
                $('#container').highcharts({
                    chart: {
                        type: 'areaspline',
                        zoomType: 'x'
                    },
                    title: {
                        text: 'Logtime for all users'
                    },
                    subtitle: {
                        text: data_highchart.start + " - " + data_highchart.end
                    },
                    tooltip: {
                        shared: true,
                        crosshairs: true,
                        formatter: function () {
                            var s = '<b>' + new Date(this.x).toDateString() + '</b>';

                            $.each(this.points, function () {
                                var hour = this.y / 60;
                                var min = Math.abs((Math.floor(hour) - hour) * 60);
                                s += '<br/>' + this.series.name + ': ' + Math.floor(hour) + " heures, " + Math.floor(min) + " minutes";
                            });
                            return s;
                        }
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    credits: {
                        enabled: false
                    },
                    yAxis: {
                        labels: {
                            formatter: function () {
                                return '';
                            }
                        },
                        title: {
                            text: ''
                        }
                    },
                    series: data
                });
            });
    });
});