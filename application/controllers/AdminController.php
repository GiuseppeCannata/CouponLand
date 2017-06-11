<?php

class AdminController extends Zend_Controller_Action{
    
    protected $_Modelbase;
    protected $_ModelAdmin;
    protected $_authService;
    protected $_cat;
    protected $_ricercaForm; 
    protected $_creaFaqForm; 
    protected $_modificaFaqForm; 
    protected $_creaAziendaForm;
    protected $_modificaAziendaForm;
    protected $_modificautenteForm;
    protected $_nuovoStaffForm;


    public function init(){
        
        $this->_helper->layout->setLayout('main');
        //IN FASE DI INIT prendo l oggetto Application_Service_Auth()
        $this->_authService = new Application_Service_Auth();
        
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_ModelUser = new Application_Model_User();
        $this->_ModelAdmin = new Application_Model_Admin();
        
        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
        
        $this->view->ricercaForm = $this->getRicercaForm();
        $this->view->creaFaqForm = $this->getCreafaqForm();
        $this->view->modificaFaqForm = $this->getModificafaqForm();
        $this->view->creaAziendaForm = $this->getCreaAziendaForm();
        $this->view->modificaAziendaForm = $this->getModificaAziendaForm();
        $this->view->modificautenteForm = $this->getModificaUtenteForm();
        
        $this->view->nuovoStaffForm = $this->getNuovoStaffForm();
    }

    public function indexAction(){
        
        
    } 
    
    public function logoutAction(){
        
        //utilizzo il metodo clear dell oggetto zend_auth
        $this->_authService->clear();
        //ridirigo la chiamata sull controllore public all azione index
        return $this->_helper->redirector('index','public');	
    }
    
    public function statisticheAction(){
        
       $N_couponEmessi = count($this->_ModelAdmin->numerocouponemessi());
       
       $promTUTTE = $this->_ModelAdmin->promTutte();
       
       
       
       $this->view->assign(array( 'N_couponEmessi' => $N_couponEmessi,
                                  'promTUTTE' => $promTUTTE));
       
    }
    
    //verifica se la faq è valida, fa  l inseriemnto , e mi da un messaggio
    public function verificanuovafaqAction(){
        
       if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_creaFaqForm;
        $post = $this->getRequest()->getPost();
         
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: compila tutti i campi');
            return $this->render('nuovafaq');
           
	}
      
        $values = $form->getValues();       
        $this->_ModelAdmin->saveFaq($values);
        $this->view->assign('msg', 'Inserimento avvenuto con successo');
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
    
    private function getCreafaqForm(){

        $this->_creaFaqForm = new Application_Form_Admin_Faq();
        $this->_creaFaqForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                               'action' => 'verificanuovafaq'),
                                                                               'default'));
        return $this->_creaFaqForm;
        
    } 
    
    private function getModificafaqForm(){

        $domanda=$this->getParam("domanda");
        $risposta=$this->getParam("risposta");
        $id=$this->getParam("id");
        
        $this->_modificaFaqForm = new Application_Form_Admin_Faq($domanda,$risposta,$id);
        $this->_modificaFaqForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                                       'action' => 'verificamodificafaq'),
                                                                                       'default'));
        return $this->_modificaFaqForm;
        
    } 
    
    public function verificamodificafaqAction(){
        
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_modificaFaqForm;
        $post = $this->getRequest()->getPost();
         
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: compila tutti i campi');
            return $this->render('modificafaq');
           
	}
      
        $values = $form->getValues();       
        $this->_ModelAdmin->updateFaq($values);
        $this->view->assign('msg', 'Modifica avvenuto con successo');
        
       
    }
    
    //mi da la lista delle faq e le relative ancore per le azioni
    public function faqAction(){
        
        $Modelbase = new Application_Model_Modelbase();
        
        $listfaq = $Modelbase->getfaq();
        
        
        $this->view->assign(array( 'listFAQ' => $listfaq ));
        
    }
    
    public function nuovafaqAction(){
        
         //azione per la view
        
    }
    
    public function modificafaqAction(){
        
        //azione per la view
        
    }
    
    public function messaggioAction(){
        
        $this->view->assign(array('actionSI' => 'cancellafaq',
                                  'indietro' => 'faq',
                                  'msg' => 'Sei sicuro di voler cancellare la faq: " '. $this->_getParam('domanda'). ' " ?',
                                  'id_faq' => $this->_getParam('id')));
        
    }
    
    public function cancellafaqAction(){
        
        $Id_faq = $this->_getParam('Id_faq');
        
        $this->_ModelAdmin->deletefaq($Id_faq);
        
        $this->_helper->redirector('faq');
        
    }
    
    
    
    
    
    
    
    public function listaziendeAction () {
        
      $listaziende = $this->_Modelbase->getAziende();
      $this->view->assign(array('listaziende' => $listaziende));
        
    }
    
    /*Metodo che si riferisce alla corrispettiva view azienda.
      Questo metodo consente di caricare (servendosi del model) l azienda specificata per Id, e passare 
      alla corrispettiva view le info rispetto ad essa*/
    public function aziendaAction() {
        
      $id_azienda = $this->_getParam('id');
      $azienda = $this->_ModelAdmin->getAziendaByID($id_azienda);
      $this->view->assign(array('azienda' => $azienda));
      
    }
    
    
    private function getCreaAziendaForm(){

        $this->_creaAziendaForm = new Application_Form_Admin_Azienda();
        $this->_creaAziendaForm ->AddCategorieToSelect($this->_cat->toArray());
        $this->_creaAziendaForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                                       'action' => 'verificanuovaazienda'),
                                                                                       'default'));
        return $this->_creaAziendaForm;
        
    }
    
    private function getModificaAziendaForm(){

        $Id = $this->getParam("Id_azienda");
        
        $this->_modificaAziendaForm = new Application_Form_Admin_Azienda(/*$result*/);
        $this->_modificaAziendaForm ->AddCategorieToSelect($this->_cat->toArray());
        
       if($Id != null){
            
            $result = $this->_ModelAdmin->getAziendaByID($Id, 'modifica')->toArray();
            $this->_modificaAziendaForm ->setDefaults($result);
            
        }
        
        $this->_modificaAziendaForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                                       'action' => 'verificamodificaazienda'),
                                                                                       'default'));
        return $this->_modificaAziendaForm;
        
    }
    
    
    //verifica se la faq è valida, fa  l inseriemnto , e mi da un messaggio
    public function verificanuovaaziendaAction(){
        
       if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_creaAziendaForm;
        $post = $this->getRequest()->getPost();
         
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: compila tutti i campi');
            //nome pagina
            return $this->render('nuovaazienda');
           
	}
        
        $values= $form->getValues();
        $Nome_Azienda = $values["Nome"]; 
        $result = $this->_ModelAdmin->getAziendaByName($Nome_Azienda);
        
        
        //se result == true significa che l azienda gia c e nel db
        if($result){
            
            $form->setDescription('Attenzione: Azienda già essistente');
            //nome pagina
            return $this->render('nuovaazienda');
            
        }
        
        if($values['Logo_aziendale'] == null){
            
            $values['Logo_aziendale'] = "default.jpg";
        }
        
        $this->_ModelAdmin->saveAzienda($values);
        $this->view->assign('msg', 'Inserimento avvenuto con successo');
    }
    
    public function verificamodificaaziendaAction(){
        
       if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_modificaAziendaForm;
        $post = $this->getRequest()->getPost();
         
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: compila tutti i campi');
            //nome pagina
            return $this->render('updateazienda');
           
	}
        
        $values= $form->getValues();
        $Nome_Azienda = $values["Nome"];
        $result = $this->_ModelAdmin->getAziendaByName($Nome_Azienda);
        
        
        //se result == true significa che l azienda gia c e nel db
        if($result){
            
            $form->setDescription('Attenzione: Azienda già essistente');
            //nome pagina
            return $this->render('updateazienda');
            
        }
        
        $values= $form->getValues();
        
       if($values['Logo_aziendale'] == null){
            
            $azienda = $this->_ModelAdmin->getAziendaByID($values['Id_azienda'], 'modifica');
            $logo = $azienda['Logo_aziendale'];
            $values['Logo_aziendale'] =  $logo ;
                    
        }
        
        $this->_ModelAdmin->updateAzienda($values);
        $this->view->assign('msg', 'Aggiornamento avvenuto con successo');
    }
    
    
    
    public function nuovaaziendaAction(){
        
         //azione per la view
        
    }
    
    
    public function deleteaziendaAction(){
        
       
        $this->view->assign(array('actionSI' => 'cancellaazienda',
                                  'indietro' => 'azienda',
                                  'msg' => 'Sei sicuro di voler cancellare l azienda: " '. $this->_getParam('Nome_azienda'). ' " ?',
                                  'Id_azienda' => $this->_getParam('Id_azienda')));
    }
    
    
    public function cancellaaziendaAction(){
        
       
        $Id_azienda = $this->_getParam('Id_azienda');
        
        $this->_ModelAdmin->cancellaAzienda($Id_azienda);
        
        $this->_helper->redirector('listaziende');
        
        
    }
    
    
    public function updateaziendaAction(){
        
       //serve per la view
       
    }
    
    
    public function listutentiAction () {
        
      $listutenti = $this->_ModelAdmin->getUtenti();
      
      $this->view->assign(array('listutenti' => $listutenti ));
        
    }
    
    
    public function schedautenteAction(){
        
       $Id = $this->_getParam("Id_user");
        
       $utente = $this->_ModelAdmin->getUtenteByID($Id);
       $this->view->assign(array('utente' => $utente));
       
    }
    
    
    
    
    public function updateutenteAction () {
        
     //serve per iniettare la form
        
    }
    
    private function getModificaUtenteForm(){

       $Id = $this->getParam("Id_user");
        
        $this->_modificautenteForm = new Application_Form_Admin_ModificaUtente;
        
        if($Id != null){
            
            $result = $this->_ModelAdmin->getUtenteByID($Id)->toArray();
            $this->_modificautenteForm->setDefaults($result);
            
        }
        
        $this->_modificautenteForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                                       'action' => 'verificamodificautente'),
                                                                                       'default'));
        return $this->_modificautenteForm;
        
    } 
    
    
    
    public function verificamodificautenteAction(){
        
       if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_modificautenteForm;
        $post = $this->getRequest()->getPost();
        
        
        if (!$form->isValid($post)) {
            
            $form->setDescription('Attenzione: completa tutti i campi.');
            return $this->render('updateutente');
           
	}
        
        if(empty($post['Pass'])){
            
            $form->getElement('Pass')->setRequired(false);
            
        }
       

        //Username e Email inserite nella form
       $user_inserito = $form->getValue('User');
        $email_inserita = $form->getValue('Email');
        $iduser = $form->getValue('Id_user');
        
        //effettuo la verifica per controllare se email o user sono gia presenti (utilizzati)
        
       if(($this->_ModelUser->estraiUsersbyUsernameandId($user_inserito, $iduser) != NULL) || ($this->_ModelUser->estraiUsersbyEmailandId($email_inserita,$iduser) != NULL)){
            
            $form->setDescription('Attenzione: User o email giÃ  presenti!');
            return $this->render('updateutente');
            

        }   
        
        //Vengono presi i valori dalla form e viene effetuato l'update        
        $values = $form->getValues();
        
        if($values["Pass"] == NULL){
            
            $values["Pass"] = $this->_ModelAdmin->getPassByID($iduser)->Pass;
            
        }
        
        $this->_ModelUser->modificaUtente($values, $iduser);
        $this->_helper->redirector('listutenti');
        
    }
    
    
    public function messaggioeliminautenteAction() {
        
      $this->view->assign(array( 'Nome' => $this->_getParam('Nome'),
                                  'Id_user' => $this->_getParam('Id_user')));
        
    }
    
    
    public function deleteutenteAction() {
        
      $id = $this->_getParam('Id_user');
      
      $this->_ModelAdmin->deleteutente($id);
      $this->_helper->redirector('listutenti');
        
    }
    
    
    
    private function getNuovoStaffForm() {

        $this->_nuovoStaffForm = new Application_Form_Admin_Staff();
        $this->_nuovoStaffForm->setAction($this->_helper->getHelper('url')->url(array('controller' => 'admin',
                                                                                       'action' => 'verificanuovostaff'),
                                                                                       'default'));
        return $this->_nuovoStaffForm;
        
    }
    
    
    public function nuovostaffAction() {
        
      //serve per la view
        
    }
    
    
    public function verificanuovostaffAction(){
        
        if (!$this->getRequest()->isPost()) {
            
	    $this->_helper->redirector('index');
            
        }
	
        $form = $this->_FormRegistra;
        
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
        $values["Livello"] = 'user';        
        $this->_Modelbase->saveUtente($values);
        $this->_helper->redirector('index');
        
    }
    
}

