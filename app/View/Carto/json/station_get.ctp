<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php for($i=0;$i<count($table);$i++):?>
		<?php
			$count=1;
			$id="";
			if(!is_string(array_keys($table[$i])[0])){
				$lat=$table[$i][0]['TStationsJoin']['LAT'];
				$lon=$table[$i][0]['TStationsJoin']['LON'];
				$count=count($table[$i]);	
			}
			else{
				$lat=$table[$i]['TStationsJoin']['LAT'];
				$lon=$table[$i]['TStationsJoin']['LON'];
				$id=$table[$i]['TStationsJoin']['TSta_PK_ID'];
			}	
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"id":"<?php echo $id;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($table)-1)echo ",";?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($table[9],true); ?>
<?php endif?>