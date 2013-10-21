<?php echo $debug;?>
<?php if($find==1):?>
{
"type": "FeatureCollection",
"features": [
	<?php 
	for($i=0;$i<count($table);$i++):?>
		<?php if(isset($table[$i][1])):?>
			<?php				
				
				$lat=$table[$i][0][0]['rLat'];
				if(preg_match('/^-?\.(\d+)/', $lat)){
					$lat="0".$lat;
					if(stristr($lat, '-')){
						$lat="-".str_replace("-","",$lat);
					}
				}
				$lon=$table[$i][0][0]['rLon'];
				if(preg_match('/^-?\.(\d+)/', $lon)){
					$lon="0".$lon;
					if(stristr($lon, '-')){
						$lon="-".str_replace("-","",$lon);
					}
				}
				$c=0;
				for($j=0;$j<count($table[$i]);$j++){
					$c+=intval($table[$i][$j][0]['count']);
				}
				$count=$c;					
			?>
			{"type":"Feature","properties":{"count":"<?php echo $count;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
			<?php if($i<count($table)-1)echo ",";?>	
		<?php endif?>
		
		<?php if(!isset($table[$i][1]) && floatval($table[$i][0]['rLat'])!=0 && floatval($table[$i][0]['rLon'])!=0):?>
			<?php				
				$lat=$table[$i][0]['rLat'];
				if(preg_match('/^-?\.(\d+)/', $lat)){
					$lat="0".$lat;
					if(stristr($lat, '-')){
						$lat="-".str_replace("-","",$lat);
					}
				}	
				$lon=$table[$i][0]['rLon'];
				if(preg_match('/^-?\.(\d+)/', $lon)){
					$lon="0".$lon;
					if(stristr($lon, '-')){
						$lon="-".str_replace("-","",$lon);
					}
				}	
				
				$count=$table[$i][0]['count'];						
			?>
			{"type":"Feature","properties":{"count":"<?php echo $count;?>"},"geometry":{"type": "Point", "coordinates":[ <?php echo $lon;?>, <?php echo $lat;?>]}}
			<?php if($i<count($table)-1)echo ",";?>
		<?php endif?>
	<?php endfor?>
]
}
<?php endif?>
<?php if($find==2):?>
	<?php echo print_r($table[9],true); ?>
<?php endif?>