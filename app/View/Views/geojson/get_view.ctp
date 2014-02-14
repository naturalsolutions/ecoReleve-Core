<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php 
	$ModelName="MapSelectionManager";
	if(isset($result[0][0]['AppModel']) || isset($result[0]['AppModel']['TSta_PK_ID'])){
		$ModelName="AppModel";	
	}
	for($i=0;$i<count($result)-1;$i++):?>
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
				if(isset($result[$i][$ModelName]['TSta_PK_ID']))
					$id=$result[$i][$ModelName]['TSta_PK_ID'];
				$attrs=$model->create_geojson_attribut($result[$i][$ModelName]);
			}
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');
				fwrite($fp,print_r($model->create_geojson_attribut($result[$i][$ModelName]),true));
			}
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,<?php echo $attrs;?>},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($result)-2)echo ",";?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($result[9],true); ?>
<?php endif?>