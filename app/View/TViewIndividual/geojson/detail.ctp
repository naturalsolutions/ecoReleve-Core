{
"type": "FeatureCollection",
"features": [
	<?php 	
	for($i=0;$i<count($result);$i++):?>
		<?php	
			$count=1;
			$lat=floatval($result[$i]['TViewIndividual']['LAT']);
			$lon=floatval($result[$i]['TViewIndividual']['LON']);
			$date= substr($result[$i]['TViewIndividual']['DATE'],0,10);		
			list($year, $month, $day) = explode('-', $date);
			$date = mktime(0, 0, 0, $month, $day, $year);			
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"date":<?php echo $date;?>},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($result)-1)echo ",";?>
	<?php endfor?>
],
"bbox":{"maxlat":<?php echo $maxlat?>,"maxlon":<?php echo $maxlon?>,"minlat":<?php echo $minlat?>,"minlon":<?php echo $minlon?>}
}
