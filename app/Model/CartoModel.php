<?php
	App::uses('Model', 'Model');
	define('OFFSET', 268435456); //half of the earth circumference in pixels at zoom level 21
	define('RADIUS', 85445659.4471); /* $offset / pi() */
	
	class CartoModel extends AppModel {		
		
		public function __construct($id = false, $table = null, $ds = null) { 
			parent::__construct($id, $table, $ds); 
			$this->dom = new DOMDocument; 
			if (isset($this->data[get_class($this)]["xml"])) { 
				$this->dom->LoadXML($this->data[get_class($this)]["xml"]); 
			} 
		} 	
		
		function haversineDistance($lat1, $lon1, $lat2, $lon2) {
			$latd = deg2rad($lat2 - $lat1);
			$lond = deg2rad($lon2 - $lon1);
			$a = sin($latd / 2) * sin($latd / 2) +
				 cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
				 sin($lond / 2) * sin($lond / 2);
				 $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
			return 6371.0 * $c;
		}
		
		
		function lonToX($lon) {
			return round(OFFSET + RADIUS * $lon * pi() / 180);        
		}

		function latToY($lat) {
			return round(OFFSET - RADIUS * 
						log((1 + sin($lat * pi() / 180)) / 
						(1 - sin($lat * pi() / 180))) / 2);
		}

		function pixelDistance($lat1, $lon1, $lat2, $lon2, $zoom) {
			$x1 = $this->lonToX($lon1);
			$y1 = $this->latToY($lat1);

			$x2 = $this->lonToX($lon2);
			$y2 = $this->latToY($lat2);
				
			return sqrt(pow(($x1-$x2),2) + pow(($y1-$y2),2)) >> (21 - $zoom);
		}
		
		//cluster method for a table return by the method find from cake model
		function cluster($markers, $distance, $zoom) {
			$clustered = array();
			$name_key='TStationsJoin';
			if(isset($markers[0]['AppModel'])){
				$name_key='AppModel';
			}
			/* Loop until all markers have been compared. */
			while (count($markers)) {
				$marker  = array_pop($markers);				
				if(isset($marker[$name_key]['LAT'])){
					$cluster = array();
					/* Compare against all markers which are left. */
					foreach ($markers as $key => $target) {				
						$pixels = $this->pixelDistance($marker[$name_key]['LAT'], $marker[$name_key]['LON'],
												$target[$name_key]['LAT'], $target[$name_key]['LON'],
												$zoom);
						/* If two markers are closer than given distance remove */
						/* target marker from array and add it to cluster.      */
						if ($distance > $pixels){
							/*printf("Distance between %s,%s and %s,%s is %d pixels.\n", 
								$marker['lat'], $marker['lon'],
								$target['lat'], $target['lon'],
								$pixels);*/
							unset($markers[$key]);
							$cluster[] = $target;
						}
							
					}

					/* If a marker has been added to cluster, add also the one  */
					/* we were comparing to and remove the original from array. */
					if (count($cluster) > 0) {
						$cluster[] = $marker;
						$clustered[] = $cluster;
					} else {
						$clustered[] = $marker;
					}
				}	
			}
			return $clustered;
		}
		
		//cluster method for a table return by the method query from cake model
		function cluster2($markers, $distance, $zoom) {
			$clustered = array();
			/* Loop until all markers have been compared. */
			while (count($markers)) {
				$marker  = array_pop($markers);				
				if(isset($marker[0]['rLat'])){
					$cluster = array();
					/* Compare against all markers which are left. */
					foreach ($markers as $key => $target) {				
						$pixels = $this->pixelDistance($marker[0]['rLat'], $marker[0]['rLon'],
												$target[0]['rLat'], $target[0]['rLon'],
												$zoom);
						/* If two markers are closer than given distance remove */
						/* target marker from array and add it to cluster.      */
						if ($distance > $pixels){
							/*printf("Distance between %s,%s and %s,%s is %d pixels.\n", 
								$marker['lat'], $marker['lon'],
								$target['lat'], $target['lon'],
								$pixels);*/
							unset($markers[$key]);
							$cluster[] = $target;
						}
							
					}

					/* If a marker has been added to cluster, add also the one  */
					/* we were comparing to and remove the original from array. */
					if (count($cluster) > 0) {
						$cluster[] = $marker;
						$clustered[] = $cluster;
					} else {
						$clustered[] = $marker;
					}
				}	
			}
			return $clustered;
		}
	}
?>