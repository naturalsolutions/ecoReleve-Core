<?php session_start();
$_SESSION['lasturl'] = $debug;
?>
<?php echo $debug;?>{
"type": "FeatureCollection",
"features": [
	<?php for($i=0;$i<count($table);$i++):?>
		<?php
			$count=1;
			$id="";
			if(!is_string(array_keys($table[$i])[0])){
				$lat=$table[$i][0]['LAT'];
				$lon=$table[$i][0]['LON'];
				$count=count($table[$i]);	
			}
			else{
				$lat=$table[$i]['LAT'];
				$lon=$table[$i]['LON'];
				$id=$table[$i]['TSta_PK_ID'];
			}	
		?>
		{"type":"Feature","properties":{"count":<?php echo $count;?>,"id":"<?php echo $id;?>","index":"<?php echo $i;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
		<?php if($i<count($table)-1)echo ",";?>
	<?php endfor?>
]
}