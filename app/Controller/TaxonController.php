<?php
App::uses('AppController', 'Controller');
App::uses('Taxon', 'Model');
/**
 * TApplications Controller
 *
 * @property TApplication $TApplication
 */
class TaxonController extends AppController {

	public $components = array('Paginator','Cookie','Session');
	public $notauth=false;	
	
	public function beforeFilter($id = null) {
		parent::beforeFilter();
		$this->Cookie->name = 'session';
		$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;
		if($this->params['action']=='column_list' 
		|| $this->params['action']=='taxon_get' || $this->params['action']=='taxon_count'){
			if((!$this->Cookie->read('connected')))
				$this->notauth=true;	
		}
		else if($this->Session->read('role')=='Administrateur' || $this->Cookie->read('connected')=='Administrateur'){
		}		
		else if($this->params['action']!='not_autorized'){
			$this->redirect(array('action' => 'not_autorized'));
		}
		
	}
	
	//
	public function not_autorized() {
		$this->render('not_autorized');		
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Taxon->recursive = 0;
		/*$this->Paginator->settings = array('Taxon',array(			
			//'conditions' => array('Recipe.title LIKE' => 'a%'),
			'limit' => 10
		);*/
		
		$search=null;
		if(isset($this->request->params['named']['search'])){
			$search=$this->request->params['named']['search'];
			$search=str_replace(" ","% %",$search);
			//$this->Session->setFlash(__(print_r($search,true)));
		}		
		$condi=array();
		if($search!=null)$condi=array("NAME_VALID_WITHOUT_AUTHORITY like '%$search%'");		
		$this->set('Taxon', $this->paginate($condi));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Taxon->exists($id)) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		$options = array('conditions' => array('Taxon.' . $this->Taxon->primaryKey => $id));
		$this->set('Taxon', $this->Taxon->find('all', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Taxon->create();
			print_r($this->request->data['Additional']);
			$finaladdi=array();
			$addi=$this->request->data['Additional'];
			//print_r(" val :".$this->request->data['Additional']);
			for($i=0;$i<count($this->request->data['Additional']);$i++){				
				if($this->request->data['Additional'][$i]['value']!=""){
				
					$finaladdi+=$this->request->data['Additional'][$i];
				}
			}
			print_r(" addi :".$finaladdi);
			//$this->request->data['Additional']=array();
			
			//print_r("SECOND : ".$this->request->data['Additional']);
			if ($this->Taxon->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('The Taxon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Taxon could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Taxon->exists($id)) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$d=new Taxon();
			if ($d->saveAssociated(array('Taxon'=>$this->request->data['Taxon'],'Additional'=>$this->request->data['Additional']))) {
				$this->Session->setFlash(__('The Taxon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Taxon could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Taxon.' . $this->Taxon->primaryKey => $id));
			$this->request->data = $this->Taxon->find('first', $options);
		}		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Taxon->id = $id;
		if (!$this->Taxon->exists()) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Taxon->delete()) {
			$this->Session->setFlash(__('Taxon deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Taxon was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function search($val = null) {
		$val=$this->request['data']['Taxon']['search'];
		//$this->Session->setFlash(__(print_r($this->request['data']['Taxon']['search'],true)));
		$this->redirect(array('action' => 'index/','search'=>$val));
	}
	
	//controller method for the getting taxon from protocole service 
	function proto_taxon_get(){
		$debug="";
		$find=1;
		$table_name="TProtocole";
		$base=base;
		$test=false;
		$taxons=array();
		$format="xml";
		$this->loadModel('Protocole');
		$this->loadModel('ProtocoleTaxon');
		//format from request
		if(stripos($this->request->header('Accept'),"application/xml")!==false){
			$format="xml"; 
			$tmp_format="xml";
		}
		else if(stripos($this->request->header('Accept'),"application/json")!==false){
			$tmp_format="json";
			$format="json";
		}				
		
		if(isset($this->params['url']['format']) && $this->params['url']['format']!="")
			$format=$this->params['url']['format'];			
		
		if(isset($this->params['url']['id_proto']) ){
			$id_proto = $this->params['url']['id_proto'];
			
			//get the name of table from the id				
			$pk_id_name="TTheEt_PK_ID";
			
			$table_name_array=$this->Protocole->find('first',array("conditions" => array($pk_id_name=>$id_proto)));
			if(isset($table_name_array['Protocole']['Relation'])){
				$table_name="TProtocol_".$table_name_array['Protocole']['Relation'];					
			}	
			else
				$find=-1;				
			
			//Get detail after finding the protocole name 	
			if($find!=-1){	
				$array_conditions=array();
				if(isset($this->params['url']['search']) && isset($this->params['url']['search'])!=""){
					$search=$this->params['url']['search'];
					$array_conditions+=array('Name_Taxon LIKE'=>'%'.$search.'%');	
				}				
				//finding taxon from table
				try{					
					//$model_proto = new ProtocoleTaxon($table_name,$table_name);	
					$this->ProtocoleTaxon->setSource($table_name);
					//check if the table have taxon field
					if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
						$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
						fwrite($fp, print_r($table_name ,true));	
					}
					$taxon_find=false;
					//foreach ($model_proto->schema() as $key=>$val){
					foreach ($this->ProtocoleTaxon->schema() as $key=>$val){
						if($key=="Name_Taxon")
							$taxon_find=true;							
					}
					
					if($taxon_find){
						//$taxons=$model_proto->find('all',array(
						$taxons=$this->ProtocoleTaxon->find('all',array(
							'fields'=>array('Name_Taxon'),
							'group'=>array('Name_Taxon'),
							'conditions'=>$array_conditions
						));	
					}	
					else
						$find=-2;//no taxon in table
				}						
				catch(Exception $e){
					$this->set('find',-1); //table not exist
				}	
			}					
		}			
		else
			$find=0;	
		$this->set("taxons",$taxons);		
		$this->set("table_name",$table_name);	
		$this->set("debug",$debug);
		$this->set("find",$find);
		// Set response as XML
		
		$this->RequestHandler->respondAs($format);		
		$this->viewPath .= '/'.$format;
		$this->layoutPath = $format;	
		$this->layout= $format;
	}
					
	//taxon get webservice
	function taxon_get(){
		$model_taxon = new AppModel("TTaxa","TTaxa","mycoflore");
		$condition_array=array();
		$KINGDOM="";
		$NAME_VALID="";
		$NAME_WITHOUT_AUTHORITY="";
		$NAME_WITH_AUTHORITY="";
		$id_taxon="";
		$ID_NAME="";
		$ID_HIGHER_TAXON="";
		$AUTHORITY="";
		$NOM_VERN_FR="";
		$NOM_VERN_ENG="";
		$PHYLUM="";
		$CLASS="";
		$ORDER="";
		$FAMILY="";
		$RANK="";
		$TAXREF_CD_NOM="";
		$TAXREF_CD_TAXSUP="";
		$TAXREF_CD_REF="";
		$join=array();
		$format="json";
		$this->loadModel('Taxon');
		$limit=0;
		$offset=0;
		
		//get id from param
		if(isset($this->params['url']['id_taxon'])){
			$id_taxon=$this->params['url']['id_taxon'];						
		}
		
		//format from request
			
		if(stripos($this->request->header('Accept'),"application/xml")!==false){
			$format="xml"; 
		}
		else if(stripos($this->request->header('Accept'),"application/json")!==false){
			$format="json";
		}
		
		if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
			if(stripos($this->params['url']['format'],"xml")!== false )
				$format="xml";
			else if(stripos($this->params['url']['format'],"json")!== false)	
				$format="json";
			else if(stripos($this->params['url']['format'],"test")!== false)	
				$format="test";	
		}
		
		if(isset($this->params['url']['limit'])){
			$limit=$this->params['url']['limit'];
		}
		
		if(isset($this->params['url']['offset'])){
			$offset=$this->params['url']['offset'];
		}
		
		//get id from request param (case with this kind of url : proto/get/"id")
		if(isset($this->request->params['id_taxon']) && $this->request->params['id_taxon']!="[0-9]+"){
			$id_taxon= $this->request->params['id_taxon'];
		}

		//get kingdom param
		if(isset($this->params['url']['KINGDOM'])){
			$KINGDOM= $this->params['url']['KINGDOM'];
		}	
		
		//get name_valid param
		if(isset($this->params['url']['NAME_VALID'])){
			$NAME_VALID= $this->params['url']['NAME_VALID'];
		}
		
		//get name_id param
		if(isset($this->params['url']['ID_NAME'])){
			$ID_NAME= $this->params['url']['ID_NAME'];
		}
		
		//get name_without_authority param
		if(isset($this->params['url']['NAME_WITHOUT_AUTHORITY'])){
			$NAME_WITHOUT_AUTHORITY= $this->params['url']['Name_without_Authority'];
		}
		
		//get ID_HIGHER_TAXON param
		if(isset($this->params['url']['ID_HIGHER_TAXON'])){
			$ID_HIGHER_TAXON= $this->params['url']['ID_HIGHER_TAXON'];
		}
		
		//get NOM_VERN_FR param
		if(isset($this->params['url']['NOM_VERN_FR'])){
			$NOM_VERN_FR= $this->params['url']['NOM_VERN_FR'];
		}
					
		//get AUTHORITY param
		if(isset($this->params['url']['AUTHORITY'])){
			$AUTHORITY= $this->params['url']['AUTHORITY'];
		}
		
		//get NOM_VERN_ENG param
		if(isset($this->params['url']['NOM_VERN_ENG'])){
			$NOM_VERN_ENG= $this->params['url']['NOM_VERN_ENG'];
		}
		
		//get PHYLUM param
		if(isset($this->params['url']['PHYLUM'])){
			$PHYLUM= $this->params['url']['PHYLUM'];
		}
		
		//get CLASS param
		if(isset($this->params['url']['CLASS'])){
			$CLASS= $this->params['url']['CLASS'];
		}
		
		//get ORDER param
		if(isset($this->params['url']['ORDER'])){
			$ORDER= $this->params['url']['ORDER'];
		}
		
		//get FAMILY param
		if(isset($this->params['url']['FAMILY'])){
			$FAMILY= $this->params['url']['FAMILY'];
		}
		
		//get RANK param
		if(isset($this->params['url']['RANK'])){
			$RANK= $this->params['url']['RANK'];
		}
		
		//get TAXREF_CD_NOM param
		if(isset($this->params['url']['TAXREF_CD_NOM'])){
			$TAXREF_CD_NOM= $this->params['url']['TAXREF_CD_NOM'];
		}
		
		//get TAXREF_CD_NOM param
		if(isset($this->params['url']['TAXREF_CD_TAXSUP'])){
			$TAXREF_CD_TAXSUP= $this->params['url']['TAXREF_CD_TAXSUP'];
		}
		
		//get TAXREF_CD_REF param
		if(isset($this->params['url']['TAXREF_CD_REF'])){
			$TAXREF_CD_REF= $this->params['url']['TAXREF_CD_REF'];
		}
		
		$array_conditions=$model_taxon->taxon_filter($condition_array,$id_taxon,$ID_HIGHER_TAXON,$ID_NAME
		,$NAME_WITH_AUTHORITY,$AUTHORITY,$NAME_WITHOUT_AUTHORITY,$NAME_VALID,$NOM_VERN_FR,$NOM_VERN_ENG,$NOM_VERN_FR
		,$KINGDOM,$PHYLUM,$CLASS,$ORDER,$FAMILY,$RANK,$TAXREF_CD_NOM,$TAXREF_CD_TAXSUP,$TAXREF_CD_REF
		,true);
		
		$hierarchie=$this->Taxon->query("EXECUTE sp_hierarchie $id_taxon");
		
		//$this->Taxon->hasMany['Synonymous']['conditions']['Synonymous.']=2;
		$taxons=$this->Taxon->find("all",array(
			/*'contain' => array(
				'Synonymous'=> array(
					'conditions'=> array('Synonymous.FK_Taxon'=>'17286')
				)
			),*/
			//'fields'=>array('ID_TAXON'),
			'conditions'=>$array_conditions,
			'order'=>array("NAME_VALID_WITHOUT_AUTHORITY asc"),
			'limit'=>$limit,
			'offset'=>intval($offset)
			
		));
		$taxons['hierarchie']=$hierarchie;
		
		$nb_taxons="";
		/*$nb_taxons=$this->Taxon->find("count",array(
			'conditions'=>$array_conditions,
			'limit'=>$limit,
			'offset'=>intval($offset)
		));*/
		
		
					
		if(!($taxons && (count($taxons)>0)))
			$taxons=array();
		/*
		if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
			$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
			fwrite($fp, print_r($taxons ,true));
		}
		*/
		$this->set("taxons",$taxons);
		$this->set("nb",$nb_taxons);
		
		if($format!="test"){
			//$this->RequestHandler->setContent('json', 'text/x-json');
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layoutPath = $format;
			$this->layout=$format;
		}	
		else{
			// Set response as XML
			$this->RequestHandler->respondAs("html");
			$this->viewPath .= "/"."json";
			//$this->layoutPath = $format;
			//$this->layout=$format;
		}
	}
	
	//
	function taxon_count(){
		$format='json';
		$this->loadModel('TaxonFamilyCount');
		$find_field=false;
		$field="";
		
		if(isset($this->params['url']['field']) && $this->params['url']['field']!=""){
			$field= $this->params['url']['field'];
		}
		if($field!="")
			foreach ($this->TaxonFamilyCount->schema() as $key=>$val){
				//check if the field exist with insensitive case
				if(stripos($key,$field)!==false){
					$field=$key;
					$find_field=true;
					break;
				}											
			}
		
		$options['joins'] = array(
			array('table' => 'TProtocol_Inventory',
				'alias' => 'TProtocol_Inventory',
				'type' => 'INNER',
				'conditions' => array(
					"TaxonFamilyCount.ID_TAXON = TProtocol_Inventory.Id_Taxon"
				)
			)
		);	
				
		if($find_field){
			$familycount=$this->TaxonFamilyCount->find('all',array(
				'fields'=>array("$field",'COUNT(*) as nb'),
				'group'=>"[$field]"
			)+$options);
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
				fwrite($fp, print_r($familycount ,true));
			}							
			$this->set('result',$familycount);			
		}
		else
			$this->set('result',"Nom de champs manquant ou mal ecrit. param: field='nom_champ'");
		$this->set('field',$field);	
		if($format!="test"){
			//$this->RequestHandler->setContent('json', 'text/x-json');
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layoutPath = $format;
			$this->layout=$format;
		}	
		else{
			// Set response as XML
			$this->RequestHandler->respondAs("html");
			$this->viewPath .= "/"."json";
			//$this->layoutPath = $format;
			//$this->layout=$format;
		}
	}
}	
