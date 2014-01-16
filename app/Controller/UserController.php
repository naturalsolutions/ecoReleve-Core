<?php
	include_once 'AppController.php';
	App::uses('AppModel', 'Model');
	App::uses('User', 'Model');
	define("base", "user");
	define("limit",0);
	define("offset",0);
	define("cache_time",3600);
	//require '../Lib/PHPMailer/PHPMailerAutoload.php';
	App::import('Lib', 'PHPMailer/PHPMailerAutoload');
	
	class UserController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache');
		public $components = array('RequestHandler','Cookie','Session'
		);
		public $cacheAction = array(
			//'listv'  => cache_time			
		);
		public $admin=false;
		private $ssl=true;
		
		public function beforeFilter() {
			parent::beforeFilter();
			
			$this->Cookie->name = 'session';
			$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
			$this->Cookie->httpOnly = true;
			//$this->Cookie->time = 3600;  // ou '1 hour'
			//$this->Cookie->path = '/bakers/preferences/';
			//$this->Cookie->domain = 'example.com';
			//$this->Cookie->secure = true;  // ex. seulement envoyé si on utilise un HTTPS sécurisé
			
			//$this->Cookie->write('nom', 'Ré');
			
			//$this->Cookie->httpOnly = false;
			//$this->Cookie->read('connected')
			//print_r($this->Cookie->read('connected'));
			if($this->Cookie->read('connected')=='Administrateur'){
				$this->admin=true;
				//$this->redirect(array('action' => 'not_autorized'));
			}
			
			//print_r($this->params['action']);
			/*if ($this->params['action']=='login') {
				$this->Security->blackHoleCallback = 'forceSSL';
				$this->Security->requireSecure();
			}*/
			if(isset($_SERVER["HTTP_ORIGIN"])){
				//$_SERVER["HTTP_ORIGIN"];
				$origin=$_SERVER["HTTP_ORIGIN"];
				$this->set('origin',$origin);
			}
			
		}
		
		public function inscrip_set(){
			if(true){
				$format='json';
				//$fp=fopen("app/webroot/config/adminmail","r");
				$smtpxmlstr=file_get_contents("app/webroot/config/smtpconf.xml");
				$smtpArray = Xml::toArray(Xml::build($smtpxmlstr));
				//ini_set("upload_tmp_dir","C:\Inetpub\vhosts\fmbds.org\httpdocs\mycoflore\tmp");
				//print_r(ini_get("upload_tmp_dir"));
				
				//$ademail=fgets($fp);
				$ademail=$smtpArray['smtp']['mailadmin'];
				$firstName="";
				$email="";
				$password="";
				$association="";
				$name="";
				
				$mail = new PHPMailer();
				//$mail->ClearAddresses();
				$mail->IsSMTP();
				$mail->CharSet = 'UTF-8';

				$mail->Host       = $smtpArray['smtp']['host']; // SMTP server example
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $smtpArray['smtp']['login']; // SMTP account username example
				$mail->Password   = $smtpArray['smtp']['password']; 
				//$mail->SMTPSecure = 'tls'; 
				
				$mail->addAddress($ademail); 
				
				//print_r($ademail);
				
				if(isset($this->params['url']['firstName']))
					$firstName=$this->params['url']['firstName'];						
				else if(isset($this->request->params['firstName']))
					$firstName=$this->request->params['firstName'];
				else if(isset($this->request['data']['firstName']))
					$firstName=$this->request['data']['firstName'];
					
				if(isset($this->params['url']['name']))
					$name=$this->params['url']['name'];						
				else if(isset($this->request->params['name']))
					$name=$this->request->params['name'];
				else if(isset($this->request['data']['name']))
					$name=$this->request['data']['name'];	
				
				if(isset($this->params['url']['email']))
					$email=$this->params['url']['email'];						
				else if(isset($this->request->params['email']))
					$email=$this->request->params['email'];
				else if(isset($this->request['data']['email']))
					$email=$this->request['data']['email'];
				
				if(isset($this->params['url']['password']))
					$password=$this->params['url']['password'];						
				else if(isset($this->request->params['password']))
					$password=$this->request->params['password'];
				else if(isset($this->request['data']['password']))
					$password=$this->request['data']['password'];
					
				if(isset($this->params['url']['association']))
					$association=$this->params['url']['association'];						
				else if(isset($this->request->params['association']))
					$association=$this->request->params['association'];
				else if(isset($this->request['data']['association']))
					$association=$this->request['data']['association'];	
				/*$headers = 'From: webmaster@example.com' . "\r\n" .
		 'Reply-To: webmaster@example.com' . "\r\n" .
		 'X-Mailer: PHP/' . phpversion();*/
				
				//$mail->From = "from@example.com"; 
				//$mail->FromName = "noreplyadminmyco"; 
				$mail->setFrom($smtpArray['smtp']['mailfrom'],$smtpArray['smtp']['mailfrom']);	
				$mail->Subject = $smtpArray['smtp']['mailsubject'];
				$orig=array('\n','\t','$email','$name','$firstName','$password','$association');
				$replace=array("\n","\t",$email,$name,$firstName,$password,$association);
				$mail->Body = str_replace($orig,$replace,$smtpArray['smtp']['mailbody']);
				
				$this->set("result","unknown");
				$this->set("message","unknown");
				if(!$mail->send()) {
					$this->set("result","error");
					$this->set("message","mail send error");
				}
				else{
					$this->set("result","success");
					$this->set("message","success");
				}
				/*if(mail($ademail, 'Inscription Myco Portail', "Bonjour,\nNouvelle inscription:\n\tEmail : $email\n\tNom : $name\n\tPrenom : $firstName\n\tMot de passe : $password\n\tAssociation : $association")){
					$this->set("result","success");
					$this->set("message","success");	
				}	
				else{
					$this->set("result","error");
					$this->set("message","mail send error");
				}*/
				
				//print_r($mail);
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/$format";
				$this->layout =$format;
				$this->layoutPath =$format;
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');
			}	
		}
		
		public function mail_get(){
			if($this->admin){
				$format='json';
				//$fp=fopen("app/webroot/config/adminmail","r");
				$smtpxmlstr = file_get_contents("app/webroot/config/smtpconf.xml");				
				$smtpArray = Xml::toArray(Xml::build($smtpxmlstr));				
				$email=$smtpArray['smtp']['mailadmin'];
				$this->set("email",$email);
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/$format";
				$this->layout =$format;
				$this->layoutPath =$format;
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');
			}	
		}
		
		public function mail_set(){
			if($this->admin){
				$format='json';
				$email="";
				if(isset($this->params['url']['email']))
					$email=$this->params['url']['email'];						
				else if(isset($this->request->params['email']))
					$email=$this->request->params['email'];
				else if(isset($this->request['data']['email']))
					$email=$this->request['data']['email'];
					
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 	
				if(preg_match($regex, $email)){
					//$fp=fopen("app/webroot/config/adminmail","w");
					$smtpxmlstr = file_get_contents("app/webroot/config/smtpconf.xml");					
					$smtpArray = Xml::toArray(Xml::build($smtpxmlstr));
					$smtpArray['smtp']['mailadmin']=$email;
					$smtpxml=Xml::build($smtpArray);
					//print_r($smtpxml->asXMl());
					$fp=fopen("app/webroot/config/smtpconf.xml","w");
					fwrite($fp,$smtpxml->asXMl());
					$this->set("result","success");
					$this->set("message","success");	
				}
				else{
					$this->set("result","error");
					$this->set("message","email missing or malformed");
				}
					
					
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/$format";
				$this->layout =$format;
				$this->layoutPath =$format;
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');
			}	
		}
		
		public function forceSSL() {
			//$this->redirect('https://' . env('SERVER_NAME') . $this->here);
			$this->set('message','Required a SSL connection');
			$this->set('result','Error');
			$this->layout ="json/json";
			$this->ssl=false;
			$this->render('json/login');
		}
		
		function logout(){
			$format='json';
			
			$this->set("result","logout");
			
			$this->Session->delete('login');
			$this->Session->delete('role');			
			
						
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/$format";
			$this->layout =$format;
			$this->layoutPath =$format;	
			$this->Cookie->delete('connected');
		}
		
		function login(){
			$this->loadModel('User');
			$format='json';
			$id_app=1;
			$role="";
			$login="";
			if($this->ssl){
				$options['joins'] = array(
					array(
						'table' => 'TAutorisations',	
						'alias' => 'Autorisations',	
						'type' => 'INNER',
						'conditions' => array(
							'TUse_Pk_ID = Autorisations.TAut_FK_TUse_PK_ID'
						)
					),
					 array(
						'table' => 'TApplications',
						'alias' => 'Applications',
						'type' => 'INNER',
						'conditions' => array(
							"Autorisations.TAut_FK_TApp_PK_ID = Applications.TApp_PK_ID and TApp_PK_ID = $id_app"
						)
					 ),
					  array(
						'table' => 'TRoles',
						'alias' => 'Roles',
						'type' => 'INNER',
						'conditions' => array(
							'Autorisations.TAut_FK_TRol_PK_ID = Roles.TRol_PK_ID'
						)
					 )
				);	
				
				//print_r($this->request);
				if((isset($this->params['url']['login']) && isset($this->params['url']['password'])
					&& $this->params['url']['login']!="") || (isset($this->request->params['login']) && isset($this->request->params['password'])
					&& $this->request->params['login']!="") || (isset($this->request['data']['login']) && isset($this->request['data']['password'])
					&& $this->request['data']['login']!="")){
					if(isset($this->request->params['login']))
						$login=$this->request->params['login'];
					else if(isset($this->request['data']['login']))
						$login=$this->request['data']['login'];
					else
						$login=$this->params['url']['login'];
					if(isset($this->request->params['password']))
						$password=$this->request->params['password'];
					else if(isset($this->request['data']['password']))
						$password=$this->request['data']['password'];
					else
						$password=$this->params['url']['password'];
					$result=$this->User->find('first',array(
							'fields'=>array('*','Roles.TRol_Type','Applications.TApp_Nom'),
							'conditions'=> array("TUse_Login  COLLATE Latin1_General_CS_AS = '$login'","TUse_Password COLLATE Latin1_General_CS_AS = '$password'","TUse_Actif"=>"true")
						)+$options			
					);
					if(count($result)>0){
						$role=$result['Roles']['TRol_Type'];						
						$this->set("result","Success");
						
						$this->set("message","Success");
						//session_start (); 
						//$_SESSION['login'] = $login; 
						//$_SESSION['role'] = $role; 
						$this->Cookie->write('connected',$role);
						$this->Session->write('login',$login);
						$this->Session->write('role',$role);
						$this->Session->write('user',$result);
						
						//print_r($result);	
					}	
					else{
						$this->set("message","Fail. Bad login,password");
						$this->set("result","Error");
					}	
				}
				else{
					$this->set("message","Fail. Missing parameters 'login','password'");
					$this->set("result","Error");
				}
				$this->set('role',$role);
				$this->set("login",$login);
			}
			
			
			if(isset($this->params['url']['session'])){
				//$this->Cookie->name = 'blabla';
				//$this->Cookie->write('nom', 'Ré');
				//setcookie("TestCookie", "val");
				
			}	
			
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/$format";
			$this->layout =$format;
			$this->layoutPath =$format;			
		}
		
		function listv(){
			$this->loadModel('User');
			$format="json";
			if(isset($this->params['url']['format']))
				$format = $this->params['url']['format'];
			$model_view = new AppModel("TUsers","TUsers",base);
			$model_view->name='User';
			$this->set('model',$model_view);	
			$views = $this->User->find('all',array(			
				'fields' => array('TUse_Pk_ID','TUse_Nom','TUse_Prenom','Roles.TRol_Type'),
				'joins' => array(
					array(
						'table' => 'TAutorisations',	
						'alias' => 'Autorisations',	
						'type' => 'INNER',
						'conditions' => array(
							'TUse_Pk_ID = Autorisations.TAut_FK_TUse_PK_ID'
						)
					),
					 array(
						'table' => 'TApplications',
						'alias' => 'Applications',
						'type' => 'INNER',
						'conditions' => array(
							'Autorisations.TAut_FK_TApp_PK_ID = Applications.TApp_PK_ID'
						)
					 ),
					  array(
						'table' => 'TRoles',
						'alias' => 'Roles',
						'type' => 'INNER',
						'conditions' => array(
							'Autorisations.TAut_FK_TRol_PK_ID = Roles.TRol_PK_ID'
						)
					 )
				),
				'recursive' => 0,
				'conditions' => array(
					'Applications.TApp_Nom' => 'eReleve',
					'NOT' => array('Roles.TRol_Type' => "Interdit")
				),
				'fields' => array('TUse_Pk_ID','TUse_Nom','TUse_Prenom','Roles.TRol_Type'),
				'order' => array('TUse_Nom', 'TUse_Prenom DESC')
			));
			$this->set('v',$views);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/$format";
			$this->layout =$format;
			$this->layoutPath =$format;
		}
		
		function index(){			
			//$this->set('result',"result:'".$this->Session->read('login')."'\ndebug:".print_r($_SESSION,true)."\nLevel:'".$this->Session->read('Security.level')."'\n");
			//print_r($this->Session->read('login'));
			$this->RequestHandler->respondAs('json');
			$this->viewPath .= "/json";
			$this->layout ='json';
			$this->layoutPath ='json';	
			
			
		}		
	}
?>	