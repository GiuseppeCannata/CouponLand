<?php

class StaffController extends Zend_Controller_Action{
     
    protected $_Modelbase;
    protected $_cat;
    protected $_ricercaForm; 
    protected $_ModelStaff; 
    protected $_authService;
    protected $_insertProm;
    protected $_selezProm;
    protected $_modificaProm;
    protected $_formarearis;
   


    public function init(){
         
        $this->_helper->layout->setLayout('main');
           
        //IN FASE DI INIT prendo l oggetto Application_Service_Auth()
        $this->_authService = new Application_Service_Auth();
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_ModelStaff = new Application_Model_Staff();
        
        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
        
        $this->view->ricercaForm = $this->getRicercaForm();
        $this->view->inserisciProm = $this->getinsertpromForm();
        $this->view->selezionaProm = $this->getselezProm();
        $this->view->modificaProm = $this->getmodificaProm();
        $this->view->arearisForm = $this->getAreaRisForm();
      
     }
    
    
     
     
    public function indexAction(){
        
        $PromozioniTOP = $this->_Modelbase->getPromozioneTOP();
        $this->view->assign(array('CatTOP' => $this->_cat,
                                  'PromozioniTOP' => $PromozioniTOP));
    }
    
    private function getRicercaForm(){

        $this->_ricercaForm = new Application_Form_Public_Ricerca_Ricerca();
        $this->_ricercaForm->setAction($this->_helper->getHelper('url')->url(array( 'controller' => 'public',
                                                                                    'action' => 'listpromozioni',
                                                                                    'chiamante' => 'search',
                                                                                    'IBRIDO'=> 'Elenco risultati:'),
                                                                                    'default'));
        
        return $this->_ricercaForm;
        
    } 
    
    
    public function insertpromAction(){
        
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form=$this->_insertProm;
        $post = $this->getRequest()->getPost();
        
        
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
          return  $this->render('inserisciprom');
           
           
	}
        
       $todays_date = date("Y-m-d");
       $inizioProm = $form->getValue('Inizio_promozione');
       $fineProm = $form->getValue('Fine_promozione');
       
       $todays_date_converted = strtotime($todays_date);
       $inizioProm_converted = strtotime($inizioProm);
       $fineProm_converted = strtotime($fineProm);
       $promozioneinserita = $form->getValue('Nome');
       $aziendascelta = $form->getValue('Azienda');
       
       if($this->_ModelStaff->getPromByNomeAz($promozioneinserita, $aziendascelta) != NULL){
            $form->setDescription('Attenzione: Promozione relativa a questa azienda gi&agrave esistente!');
           return $this->render('inserisciprom');
           
       }
       
       
       
       if($todays_date_converted > $inizioProm_converted){
           
             $form->setDescription('Attenzione: La data di inizio promozione &egrave già passata!');
           return $this->render('inserisciprom');
       }
       
         
      if($inizioProm_converted > $fineProm_converted){
           
             $form->setDescription('Attenzione: La data di inizio promozione &egrave più grande di quella finale!');
          return  $this->render('inserisciprom');
       }
       
        
        $values = $form->getValues();
        $this->_ModelStaff->inserisciPromozione($values);
        
    }
    
    private function getinsertpromForm(){
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_insertProm = new Application_Form_Staff_Nuovoprodotto();
    		$this->_insertProm->setAction($urlHelper->url(array(
			'controller' => 'staff',
			'action' => 'insertprom'),
			'default'
		));
		return $this->_insertProm;
    } 
    
    public function selezionapromformAction(){
        
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form=$this->_selezProm;
        
     //   $request = $this->getRequest();
        $post = $this->getRequest()->getPost();
        if(sizeof($post) < 4){
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
          return  $this->render('selezionaprom');
            
        }
        else if($post['Nome'] == '-- Seleziona --' || $post['Azienda']=='-- Seleziona --')
        {
             $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
          return  $this->render('selezionaprom');
        }
        
      /*  if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            $this->render('selezionaprom');
           
           
	}*/
        
        
        if (array_key_exists('modifica', $post))
        {   
         //   $prom_da_modif = $this->_ModelStaff->getPromByCatNomeAz($post['Categoria'], $post['Nome'], $post['Azienda'])->toArray();
           // $this->redirect($url, $options)->assign(array('elementipromForm' => $prom_da_modif ));
           // $elemforform = array('elementipromForm' => $prom_da_modif );
         $this->forward('modificaprom'); //metodo di Zend che salva la vita
           // $this->_helper->redirector('modificaprom','staff',null,$prom_da_modif);
           /*$url=$this->url(array('controller' => 'staff',
                                    'action' => 'modificaprom', 
                                    'elementipromForm' => $prom_da_modif),
                                    'default',true );*/
           // $this->redirect($url);
            
        }
        elseif(array_key_exists('cancella', $post)){
             
       $prom_da_elim = $this->_ModelStaff->getPromByCatNomeAz($post['Categoria'], $post['Nome'], $post['Azienda'])->toArray(); 
       $id_prom_da_elim = $prom_da_elim['Id_promozione'];
       $this->_ModelStaff->cancellaPromozione($id_prom_da_elim);
    
       
        }
        
    }
    
    
    
    
     public function modificapromformAction(){
         
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
        
        
       $form = $this->_modificaProm;
       $post = $this->getRequest()->getPost();
        
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        return  $this->render('modificaprom');
        
        }
     
      $todays_date = date("Y-m-d");
       $inizioProm = $form->getValue('Inizio_promozione');
       $fineProm = $form->getValue('Fine_promozione');
       
       $todays_date_converted = strtotime($todays_date);
       $inizioProm_converted = strtotime($inizioProm);
       $fineProm_converted = strtotime($fineProm);
    
        
        if($this->_ModelStaff->estraiPrombyNameandIdandAz($post['Id_promozione'], $post['Nome'], $post['Azienda']) != NULL){
        
            
          $form->setDescription('Attenzione: Promozione relativa a questa azienda già esistente!');
         return $this->render('modificaprom');
            
            
          }
          
       
         
      if($inizioProm_converted > $fineProm_converted){
           
             $form->setDescription('Attenzione: La data di inizio promozione è più grande di quella finale!');
          return  $this->render('modificaprom');
       }
          
          
        $values = $form->getValues();
         if($values['Immagine'] == null){
            
            $promozione = $this->_ModelStaff->getPromozioneByID($values['Id_promozione']);
            $img = $promozione['Immagine'];
            $values['Immagine'] =  $img ;
                    
        }
          $this->_ModelStaff->modificaPromozione($values, $values['Id_promozione']);
          
          
          
        }
     
      // Validazione AJAX
	public function segnalapromAction() 
    {   
            
        
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

                $param = $this->getRequest()->getPost('Categoria');
                $promozioni = $this->_ModelStaff->getPromByCat($param);
             $data = array();
                
             foreach ($promozioni as $promozione) {
                    $data[$promozione->Id_promozione] = $promozione->Nome;
             }  
             $results = array_unique($data);
             $json = Zend_Json::encode($results);
            echo $json;
            // a die here helps ensure a clean ajax call
            die();
        }

    
    // Validazione AJAX
    public function segnalazAction(){   
            
        
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

                $param = $this->getRequest()->getPost('Nome');
                $aziende = $this->_ModelStaff->getAziendaByNomeProm($param);
              
                
               $data = array();
                
             foreach ($aziende as $azienda) {
                    $data[$azienda->Azienda] = $azienda->Azienda;
             }  

             $json = Zend_Json::encode($data);
            echo $json;
            // a die here helps ensure a clean ajax call
            die();
    }




    private function getselezProm(){
        
        $urlHelper = $this->_helper->getHelper('url');
		$this->_selezProm = new Application_Form_Staff_Selezionaprodotto();
    		$this->_selezProm->setAction($urlHelper->url(array(
			'controller' => 'staff',
			'action' => 'selezionapromform'),
			'default'
		));
		return $this->_selezProm;
        
    }
    
    
     private function getmodificaProm(){
        
        $urlHelper = $this->_helper->getHelper('url');
		$this->_modificaProm = new Application_Form_Staff_modificaprodotto();
    		$this->_modificaProm->setAction($urlHelper->url(array(
			'controller' => 'staff',
			'action' => 'modificapromform'),
			'default'
		));
		return $this->_modificaProm;
        
    }
    
    
    
    
    public function logoutAction(){
        
        //utilizzo il metodo clear dell oggetto zend_auth
        $this->_authService->clear();
        //ridirigo la chiamata sull controllore public all azione index
        return $this->_helper->redirector('index','public');	
     }
     
     
     
     
      public function modificautenteAction(){
        
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_formarearis;
        $post = $this->getRequest()->getPost();
        
        
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            $this->render('areariservata');
            return  $this->_helper->layout->disableLayout();
           
	}
        
        if(empty($post['Pass']))
        {
            $form->getElement('Pass')->setRequired(false);
            
        }
       
        //Id, Username e Email nell'utente autenticato
        $iduser_attuale = $this->_authService->getIdentity()->Id_user;
        $user_attuale = $this->_authService->getIdentity()->User; 
        $email_attuale = $this->_authService->getIdentity()->Email; 

        //Username e Email inserite nella form
        $user_inserito = $form->getValue('User');
        $email_inserita = $form->getValue('Email');
        
        
       
        
        
        //controllo se l'utente inserisce un username o un email che gia' son state utilizzate
       if(($this->_ModelStaff->estraiUsersbyUsernameandId($user_inserito, $iduser_attuale) != NULL) || ($this->_ModelStaff->estraiUsersbyEmailandId($email_inserita,$iduser_attuale) != NULL)){
            
            $form->setDescription('Attenzione: User o email già  presenti!');
            $this->render('areariservata');
            return  $this->_helper->layout->disableLayout();

        }
                
        
        //Vengono presi i valori dalla form e viene effetuato l'update        
        $values = $form->getValues();
        if($values["Pass"] == NULL){
            
            $values["Pass"] = $this->_authService->getIdentity()->Pass;
            
        }
        
        $this->_ModelStaff->modificaUtente($values, $iduser_attuale);
        $this->_authService->authenticate($values);
    }
    
    private function getAreaRisForm(){
        
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formarearis = new Application_Form_Staff_AreaRiser();
        $this->_formarearis->setAction($urlHelper->url(array('controller' => 'staff',
                                                            'action' => 'modificautente'),
                                                            'default'));
        return $this->_formarearis;
    } 
     
    public function areariservataAction(){
        $this->_helper->layout->disableLayout();
    }
    
    public function selezionapromAction(){}
    
    
     public function inseriscipromAction(){}
     
    public function cancellapromAction(){}
     
      public function modificapromAction(){
          $post= $this->getRequest()->getPost();
          $prom_da_modif = $this->_ModelStaff->getPromByCatNomeAz($post['Categoria'], $post['Nome'], $post['Azienda'])->toArray();
          $this->view->assign((array('elementipromForm' => $prom_da_modif)));
      }
    
    
}

