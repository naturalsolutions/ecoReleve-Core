<?php
	App::uses('Model', 'Model');
		
	class TViewTrxRadio extends AppModel {	
		//public $useDbConfig = 'narc_ereleve';
		public $useTable = 'TViewTrx_Radio';
		public $primaryKey = 'Trx_Radio_Obj_PK';
		public $hasMany = array(
			'Status' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Status.Fk_carac'=>1)
			),'Age' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Age.Fk_carac'=>2)
			),
			'Tansmitter_shape' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Tansmitter_shape.Fk_carac'=>3)
			),
			'Tansmitter_model' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Tansmitter_model.Fk_carac'=>4)
			),
			'Frequency' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Frequency.Fk_carac'=>5)
			),
			'Serial_number' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Serial_number.Fk_carac'=>6)
			),
			'Release_ring_position' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Release_ring_position.Fk_carac'=>7)
			),
			'Release_ring_color' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Release_ring_color.Fk_carac'=>8)
			),
			'Release_ring_code' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Release_ring_code.Fk_carac'=>9)
			),
			'Breeding_ring_position' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Breeding_ring_position.Fk_carac'=>10)
			),
			'Breeding_ring_color' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Breeding_ring_color.Fk_carac'=>11)
			),
			'Breeding_ring_code' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Breeding_ring_code.Fk_carac'=>12)
			),
			'Chip_code' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Chip_code.Fk_carac'=>14)
			),
			'Mark_color_1' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_color_1.Fk_carac'=>4)
			),
			'Mark_position_1' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_position_1.Fk_carac'=>15)
			),
			'Mark_color_2' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_color_2.Fk_carac'=>16)
			),
			'Mark_position_2' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_position_2.Fk_carac'=>17)
			),
			'PTT' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('PTT.Fk_carac'=>19)
			),
			'Sex' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Sex.Fk_carac'=>30)
			),
			'Origin' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Origin.Fk_carac'=>33)
			),
			'Species' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Species.Fk_carac'=>34)
			),
			'Birth_date' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Birth_date.Fk_carac'=>35)
			),
			'Death_date' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Death_date.Fk_carac'=>36)
			),
			'Comments' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Comments.Fk_carac'=>37)
			),
			'PTT_manufacturer' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('PTT_manufacturer.Fk_carac'=>20)
			),
			'PTT_model' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('PTT_model.Fk_carac'=>22)
			),
			'Object_type' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Object_type.Fk_carac'=>54)
			),
			'Harness' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Harness.Fk_carac'=>24)
			),
			'Argos_Duty_cycle' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Argos_Duty_cycle.Fk_carac'=>25)
			),
			'Mark_code_1' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_code_1.Fk_carac'=>55)
			),
			'Mark_code_2' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Mark_code_2.Fk_carac'=>56)
			),
			'Updated_LifeSpan' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Updated_LifeSpan.Fk_carac'=>57)
			),
			'Date_Updated_LifeSpan' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Date_Updated_LifeSpan.Fk_carac'=>58)
			),
			'Individual_status' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Individual_status.Fk_carac'=>59)
			),
			'Monitoring_status' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Monitoring_status.Fk_carac'=>60)
			),
			'Survey_type' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Survey_type.Fk_carac'=>61)
			),
			'Argos_transmission_frequency' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Argos_transmission_frequency.Fk_carac'=>26)
			),
			'GPS_acquisition_shedule' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('GPS_acquisition_shedule.Fk_carac'=>27)
			),
			'Shape' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Shape.Fk_carac'=>40)
			),
			'Bird_Name' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Bird_Name.Fk_carac'=>38)
			),
			'Model' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Model.Fk_carac'=>41)
			),
			'Company' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Company.Fk_carac'=>42)
			),
			'Weight' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Weight.Fk_carac'=>43)
			),
			'Initial_livespan' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Initial_livespan.Fk_carac'=>44)
			),
			'Battery_type' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('Battery_type.Fk_carac'=>46)
			),
			'PTT_assignment_date' => array(
				'className' => 'TObjectCaracValue',
				'foreignKey' => 'fk_object',
				'fields' => array('Carac_value_Pk','value','value_precision','begin_date','end_date','creation_date','comments'),
				'conditions'=>array('PTT_assignment_date.Fk_carac'=>49)
			)
		);
	}
?>