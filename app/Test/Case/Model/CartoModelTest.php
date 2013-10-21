<?php 
App::uses('CartoModel', 'Model');
class CartoModelTest extends  CakeTestCase{
	
	public function setUp() {
        parent::setUp();
        $this->Carto = new CartoModel();
    }
	
	public function test_cluster() {
		$markers   = array();
		$markers[] = array('TStationsJoin' => array('id' => 'marker_1', 
						   'LAT' => 59.441193, 'LON' => 24.729494));
		$markers[] = array('TStationsJoin' => array('id' => 'marker_2', 
						   'LAT' => 59.432365, 'LON' => 24.742992));
		$markers[] = array('TStationsJoin' => array('id' => 'marker_3', 
						   'LAT' => 59.431602, 'LON' => 24.757563));
		$markers[] = array('TStationsJoin' => array('id' => 'marker_4', 
						   'LAT' => 59.437843, 'LON' => 24.765759));
		$markers[] = array('TStationsJoin' => array('id' => 'marker_5', 
						   'LAT' => 59.439644, 'LON' => 24.779041));
		$markers[] = array('TStationsJoin' => array('id' => 'marker_6', 
						   'LAT' => 59.434776, 'LON' => 24.756681));
		$Features = $this->Carto->cluster($markers,20,11);
		
		$this->assertEquals(4, count($Features));	
	}
	
}	
?>