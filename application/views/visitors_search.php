<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<title><?=$title?></title>
<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);

.table-title h3 {
   color: #fafafa;
   font-size: 18px;
   font-weight: 400;
   font-style:normal;
   font-family: "Roboto", helvetica, arial, sans-serif;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   text-transform:uppercase;
}


/*** Table Styles **/

.table-fill {
  background: white;
  border-radius:3px;
  border-collapse: collapse;
  height: 320px;
  margin: 0;
  float:left;
  max-width: 250px;
  width:20% !important;
  padding:5px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  animation: float 5s infinite;
}
 
th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:17px;
  font-weight: 100;
  padding:5px;
  text-align:left;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
}

th:first-child {
  border-top-left-radius:3px;
}
 
th:last-child {
  border-top-right-radius:3px;
  border-right:none;
}
  
tr {
  border-top: 1px solid #C1C3D1;
  border-bottom-: 1px solid #C1C3D1;
  color:#666B85;
  font-size:16px;
  font-weight:normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}
 
tr:hover td {
  background:#4E5066;
  color:#FFFFFF;
  border-top: 1px solid #22262e;
  border-bottom: 1px solid #22262e;
}
 
tr:first-child {
  border-top:none;
}

tr:last-child {
  border-bottom:none;
}
 
tr:nth-child(odd) td {
  background:#EBEBEB;
}
 
tr:nth-child(odd):hover td {
  background:#4E5066;
}

tr:last-child td:first-child {
  border-bottom-left-radius:3px;
}
 
tr:last-child td:last-child {
  border-bottom-right-radius:3px;
}
 
td {
  background:#FFFFFF;
  padding:2px;
  text-align:left;
  vertical-align:middle;
  font-weight:300;
  font-size:14px;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  border-right: 1px solid #C1C3D1;
}

td:last-child {
  border-right: 0px;
}

th.text-left {
  text-align: left;
}

th.text-center {
  text-align: center;
}

th.text-right {
  text-align: right;
}

td.text-left {
  text-align: left;
}

td.text-center {
  text-align: center;
}

td.text-right {
  text-align: right;
}

</style>
</head>
<body>
<table class="table-fill">
<thead>
<tr>
    <th class="text-left">Date</th>
    <th class="text-left">Number of Views</th>
</tr>
</thead>
<tbody class="table-hover">
<?php 
	foreach($search_visitors as $_visitors) {
		echo '<tr><td class="text-left" >'.date("D M j Y",strtotime($_visitors->day)).'</td><td class="text-left">'.$_visitors->Views.'</td></tr>';
 }?>
</tbody>
</table>
<div id="chart_div1" style="float:right; width:80% !important"></div>
<script type='text/javascript'>
 
    google.charts.load('current', {'packages': ['line', 'corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var button = document.getElementById('change-chart1');
        var chartDiv = document.getElementById('chart_div1');

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'day');
        data.addColumn('number', "Visitors");

        data.addRows([
<?php foreach($search_visitors as $_visitors) {?>
                ['<?=date("D M j Y",strtotime($_visitors->day))?>', <?=$_visitors->Views?>],
<?php }?>

        ]);

        var materialOptions = {
            chart: {
                title: 'Daily Visitors',
            },
			tooltip: { trigger: 'selection' }, 
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
<?php 
$row1='';
$row2='';
foreach($search_visitors as $_visitors) {
                $row1.='<td>'.date("D M j Y",strtotime($_visitors->day)).'</td>';
                $row2.='<td>'.$_visitors->Views.'</td>';
 }?>


</body>
</html>
