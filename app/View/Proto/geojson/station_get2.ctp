<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php 
	$ModelName="Station";
	if(isset($result[0][0]['AppModel']) || isset($result[0]['AppModel']['TSta_PK_ID'])){
		$ModelName="AppModel";	
	}
	for($i=0;$i<count($result);$i++):?>
		<?php
			$count=1;
			$id="";
			$sta_keys=array_keys($result[$i]);
			if(!is_string($sta_keys[0])){
				$lat=$result[$i][0][$ModelName]['LAT'];
				$lon=$result[$i][0][$ModelName]['LON'];
				$count=count($result[$i]);	
			}
			else{
				$lat=$result[$i][$ModelName]['LAT'];
				$lon=$result[$i][$ModelName]['LON'];
				$id=$result[$i][$ModelName]['TSta_PK_ID'];
				$date=$result[$i][$ModelName]['DATE'];
				$formatdate=new DateTime($date);
				$year=date_format($formatdate, 'Y');
				
			}	
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"id":"<?php echo $id;?>","year":"<?php echo $year;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($result)-1)echo ",";?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($result[9],true); ?>
<?php endif?>