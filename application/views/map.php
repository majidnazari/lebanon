<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$query['name_ar']?></title>
<style type="text/css">
body {
    font-family: Tahoma, sans-serif;
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    font-size: 12px;
    color: #000000;
}

a{
    font-size:12px;
	font-weight:bold;
	color:#000000;
	text-decoration:none;
}

a:hover{
    font-size:12px;
	font-weight:bold;
	color:#000000;
	text-decoration:underline;
}
</style> 
 <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
</head>
<body>
   
  <div id="map" style="width: 100%; height: 100%; position:absolute"></div>

    <script type="text/javascript">
        var locations = [['<p><b><?=$query['name_ar']?></b></p>', <?=$query['x_decimal']?>, <?=$query['y_decimal']?>, 15]
    ];

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: new google.maps.LatLng(<?=$query['x_decimal']?>, <?=$query['y_decimal']?>),
            mapTypeId: google.maps.MapTypeId.HYBRID 
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
  </script>


</body>
</html>
