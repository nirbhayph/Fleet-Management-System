<?php
include "config.php";
$sql = "SELECT zone_id FROM `pickups_aggregated_manhattan` GROUP BY zone_id ORDER BY zone_id";
$result = mysql_query($sql, $link);
if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

if (isset($_POST['zoneid'])){
$zone_id = $_POST['zoneid'];
$day="";
if($_POST['day']=="Sunday")
   $day="0";
else if($_POST['day']=="Monday")
   $day="1";
else if($_POST['day']=="Tuesday")
   $day="2";
else if($_POST['day']=="Wednesday")
   $day="3";
else if($_POST['day']=="Thursday")
   $day="4";
else if($_POST['day']=="Friday")
   $day="5";
else if($_POST['day']=="Saturday")
   $day="6";
$hour = $_POST['hour'];
$latx = intval($zone_id) / 200 + 40 * 100;
$latx = $latx/100.0;
$lngx = intval($zone_id) % 200 - 75 * 100;
$lngx = $lngx/100.0;

$lat1 = $latx + 0.00;
$lat1 = number_format($lat1, 2, '.', '');
$lng1 = $lngx + 0.00;
$lng1 = number_format($lng1, 2, '.', '');
$lat2 = $latx + 0.01;
$lat2 = number_format($lat2, 2, '.', '');
$lng2 = $lngx + 0.00;
$lng2 = number_format($lng2, 2, '.', '');
$lat3 = $latx + 0.00;
$lat3 = number_format($lat3, 2, '.', '');
$lng3 = $lngx + 0.01;
$lng3 = number_format($lng3, 2, '.', '');
$lat4 = $latx + 0.01;
$lat4 = number_format($lat4, 2, '.', '');
$lng4 = $lngx + 0.01;
$lng4 = number_format($lng4, 2, '.', '');


exec('sudo python pickups-test.py '.$zone_id.' '.$day.' '.$hour.' 2>&1',$retArr);

$val = round($retArr[0]);


if($day=="0")
   $day="Sunday";
else if($day=="1")
   $day="Monday";
else if($day=="2")
   $day="Tuesday";
else if($day=="3")
   $day="Wednesday";
else if($day=="4")
   $day="Thursday";
else if($day=="5")
   $day="Friday";
else if($day=="6")
   $day="Saturday";
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/i18n/defaults-*.min.js"></script>
    <title>NYC Taxi</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      label{
        color:#FFF;
      }
      #map {
        height: 65%;
        margin-right:5%;
        margin-left:5%;
        border:4px SOLID #C32026;
      }
      .Footer-elements{
          height: 10%;
          background-color:#111;
          color:rgb(14,14,12);
          font-weight:bold;

      }

      html, body {
        height: 100%;
        background-color:#111111;
        margin: 0;
        padding: 0;
      }
    </style>
    
    <script>

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: <?php echo $lat1; ?>, lng: <?php echo $lng1; ?>},
          mapTypeId: 'terrain'
        });

       

        var rectangle = new google.maps.Rectangle({
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35,
          map: map,
          bounds: new google.maps.LatLngBounds(
            new google.maps.LatLng(<?php echo $lat1; ?>,<?php echo $lng1; ?>),
            new google.maps.LatLng(<?php echo $lat4; ?>,<?php echo $lng4; ?>)
          )
        });
        var contentString = 'The number of pickups expected for Zone Id <b> <?php echo $zone_id;?> </b> on Day <b><?php echo $day;?></b> and hour <b><?php echo $hour;?> </b> are <b><?php echo $val; ?></b>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

    rectangle.addListener('mouseover', function() {
    infowindow.setPosition(rectangle.getBounds().getCenter());
    infowindow.open(map, rectangle);
  });

        }
    </script>
  </head>
  <body style="overflow:hidden">
    <div class="container">
      <br>
      <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-10">
         <form class="form" method="post" action="index.php">
            <!-- FOR ZONE -->
           <div class="row">
            <div class="col-sm-4">
            <label>Zone</label><br>
  	    <select name="zoneid" class="selectpicker" data-live-search="true" data-style="btn-danger" data-header="Zone">
            <?php
            while ($row = mysql_fetch_assoc($result)) { ?>
  	    <option data-tokens="<?php echo $row['zone_id']; ?>"><?php echo $row['zone_id']; ?></option>
            <?php } ?>
            </select>
            </div>
            
            <!-- FOR DAY --> 
            <div class="col-sm-4">
            <label>Day</label>    <br>      
            <select name="day" class="selectpicker" data-live-search="true" data-style="btn-danger" data-header="Day" value="<?php echo $day; ?>">
            <?php $day_array=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")?>
            <?php for($i=0;$i<7;$i++){
            ?>
  	    <option data-tokens="<?php echo $day_array[$i]; ?>"><?php echo $day_array[$i]; ?></option>
            <?php } ?>
            </select>
            </div>

            <div class="col-sm-4">
            <!-- FOR HOUR -->
            <label>Hour</label><br>
            <select name="hour" class="selectpicker" data-live-search="true" data-style="btn-danger" data-header="Hour">
            <?php for($i=0;$i<24;$i++){
            ?>
  	    <option data-tokens="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
            </select>
            </div>
            <div class="row">
            <div class="col-sm-12">
            <br>
            <button type="submit" class="btn btn-warning form-control">Go</button>
            <br>
            </div>
            </div>
          </div>  
          </form>
      </div>
      <div class="col-sm-1"></div>
     
      </div>
    </div>
    <br>
    <div id="map"></div>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBexV8QYr0mcL_kcANJYwqzf5KEY-mmOcg&callback=initMap">
    </script>
    <div class="Footer-elements">
      <div class="row">
       
       <div class="col-sm-12"><marquee> <img src="taxiclip.png" height=70 width=120> <img src="taxiclip.png" height=70 width=120> <img src="taxiclip.png" height=70 width=120></marquee></div>
       
      </div>
    </div>
  </body>
</html>

