<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<title><?=$title?></title>
</head>
<body>
<div id="chart_div"></div>
<script type='text/javascript'>
    google.charts.load('current', {'packages': ['line', 'corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'day');
        data.addColumn('number', "Visitors");

        data.addRows([
<?php foreach($days_visitors as $day_visitors) {?>
                ['<?=$day_visitors->day." ".$day_visitors->Month?>', <?=$day_visitors->Views?>],
<?php }?>

        ]);

        var materialOptions = {
            chart: {
                title: 'Daily Visitors'
            },
            height: 500,
            series: {
// Gives each series an axis name that matches the Y-axis below.
                0: {axis: 'Visitors'},
            },
            axes: {
// Adds labels to each axis; they don't have to match the axis names.
                y: {
                    Temps: {label: 'Visitors'},
                }
            }
        };


        function drawMaterialChart() {
            var materialChart = new google.charts.Line(chartDiv);
            materialChart.draw(data, materialOptions);

        }



        drawMaterialChart();

    }
</script>

</body>
</html>
