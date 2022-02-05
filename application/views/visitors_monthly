<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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


