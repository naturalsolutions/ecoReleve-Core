<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php 
	
	for($i=0;$i<count($result);$i++):?>
		<?php
			$count=1;
			$id="";
			$sta_keys=array_keys($result[$i]);
			
			
			$lat=$result[$i][0]['LAT'];
			$lon=$result[$i][0]['LON'];
			if(isset($result[$i][0]['TSta_PK_ID']))
				$id=$result[$i][0]['TSta_PK_ID'];
			$attrs=$model->create_geojson_attribut($result[$i][0]);
			
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,<?php echo $attrs;?>},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($result)-1)echo ",";?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($result[9],true); ?>
<?php endif?>