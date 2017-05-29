<!--Questo controllore è chiamato public poichè si riferisce alla parte publbica del sito (Livello 0)  -->
<?php

class PublicController extends Zend_Controller_Action {
     
    /*attributi*/
    protected $_Modelbase; //salvo il modelPubblico
    protected $_cat;  //salvo le categorie 
    protected $_authService;
    protected $_form;
    protected $_form2;

	
    /*costruttore*/    
    public function init() {
        
        $this->_helper->layout->setLayout('main'); 
        $this->_Modelbase = new Application_Model_Modelbase();
        
        $this->_authService = new Application_Service_Auth();

        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
        $this->view->registraForm = $this->getRegistraForm();
        $this->view->loginForm = $this->getloginForm();

    }
    
    
    public function indexAction() {   
               
       $PromozioniTOP = $this->_Modelbase->getPromozioneTOP();
       $this->view->assign(array('CatTOP' => $this->_cat,
                                  'PromozioniTOP' => $PromozioniTOP));
       

    
    }

    /*azione che permette di far vedere le pagine statiche
      Per questo nel corpo di questo metodo no ho nessuna sezione dinamica php     */
    public function viewstaticAction () {
        
       $page = $this->_getParam('staticPage');
       $this->render($page);
        
    }
    
    public function listaziendeAction () {
        
      $listaziende = $this->_Modelbase->getAziende();
      $chiamante = $this->_getParam('chiamante');
      $this->view->assign(array('listaziende' => $listaziende,
                                'chiamante' => $chiamante));
        
    }
    
    public function aziendaAction() {
        
      $id_azienda = $this->_getParam('id');
      $azienda = $this->_Modelbase->getAziendaByID($id_azienda);
      $this->view->assign(array('azienda' => $azienda));
        
    }
    
    public function faqAction() {
      
      $Faq = $this->_Modelbase->getfaq();
      $this->view->assign(array('faq' => $Faq));
        
    }
    
    
    public function getpromozioniAction() {
        
        $chiamante = $this->_getParam('chiamante');
        $IBRIDO = $this->_getparam('IBRIDO');
        $paged = $this->_getParam('page',1);
        $promozioni = $this->_Modelbase->getPromozioniByIBRIDO($chiamante,$IBRIDO, $paged ,$order=array('Fine_promozione'));
                
        $this->view->assign(array('prom' => $promozioni,
                                  'chiamante' => $chiamante,
                                  'IBRIDO' => $this->_getParam('IBRIDO')));
        
        
    }
    
    public function promozioneAction() {
      
      $Id= $this->_getParam('Id_prom');
      
      $PromScelta = $this->_Modelbase->getPromozioneByID($Id);
      
      $this->view->assign(array('prom' => $PromScelta));
      
        
    }
    
    public function registraAction(){
        
        if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
		$form=$this->_form;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
			 $this->render('registrati');
                       return  $this->_helper->layout->disableLayout();
		}
                $user_inserito = $form->getValue('User');
                $email_inserita = $form->getValue('Email');
               // $all_users =$this->_Modelbase->estraiAllUsers();                
                
                if(($this->_Modelbase->estraiUsersbyUsername($user_inserito) != NULL) || ($this->_Modelbase->estraiUsersbyEmail($email_inserita) != NULL)){
                    $form->setDescription('Attenzione: Utente giÃƒÂ  registrato!');
			 $this->render('registrati');
                       return  $this->_helper->layout->disableLayout();
                    
                }
                
                
		$values = $form->getValues();
		$this->_Modelbase->saveUtente($values);
		$this->_helper->redirector('index');
        
        
    }

    
    private function getregistraForm()
	{
		$urlHelper = $this->_helper->getHelper('url');
		$this->_form = new Application_Form_Public_Utenti_Registra();
		$this->_form->setAction($urlHelper->url(array(
				'controller' => 'public',
				'action' => 'registra'),
				'default'
				));
		return $this->_form;
	}
        
        
        
        
        
        
        
         public function authenticateAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('accedi');
        }
        $form = $this->_form2;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati!');
            $this->render('accedi');
            return  $this->_helper->layout->disableLayout();
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita, utente non trovato. Riprova!');
            $this->render('accedi');
            return $this->_helper->layout->disableLayout();
        }
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->role);
	}
	
        
        
	private function getLoginForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_form2 = new Application_Form_Public_Utenti_Login();
    		$this->_form2->setAction($urlHelper->url(array(
			'controller' => 'public',
			'action' => 'authenticate'),
			'default'
		));
		return $this->_form2;
    }   	
        
        
        
        public function registratiAction (){
        
        $this->_helper->layout->disableLayout();
       
        
    }
    
    
    
    
        public function accediAction (){
        
        $this->_helper->layout->disableLayout();
        
        
    }

    
}