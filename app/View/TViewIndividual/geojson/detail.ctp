{
"type": "FeatureCollection",
"features": [
	<?php 	
	for($i=0;$i<count($result);$i++):?>
		<?php	
			$count=1;
			$lat=$result[$i]['TViewIndividual']['LAT'];
			$lon=$result[$i]['TViewIndividual']['LON'];
			$date= substr($result[$i]['TViewIndividual']['DATE'],0,10);		
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"date":"<?php echo $date;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($result)-1)echo ",";?>
	<?php endfor?>
]
}
