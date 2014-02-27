<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php 	
	$ModelName="Station";
	if(isset($table[0][0]['AppModel']) || isset($table[0]['AppModel']['TSta_PK_ID'])){
		$ModelName="AppModel";	
	}
	else if(isset($table[0][0]['TStationsJoin']) || isset($table[0]['TStationsJoin']['TSta_PK_ID'])){
		$ModelName="TStationsJoin";	
	} 
	for($i=0;$i<count($table);$i++):?>
		<?php
			$count=1;
			$id="";
			$sta_keys=array_keys($table[$i]);
			$date="";
			if(!is_string($sta_keys[0])){
				$lat=$table[$i][0][$ModelName]['LAT'];
				$lon=$table[$i][0][$ModelName]['LON'];
				$count=count($table[$i]);	
			}
			else{
				$lat=$table[$i][$ModelName]['LAT'];
				$lon=$table[$i][$ModelName]['LON'];
				$id=$table[$i][$ModelName]['TSta_PK_ID'];
				$date=$table[$i][$ModelName]['DATE'];
			}	
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"id":"<?php echo $id;?>","year":"<?php echo date("Y", strtotime($date));?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($table)-1)echo ",";?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($table[9],true); ?>
<?php endif?>