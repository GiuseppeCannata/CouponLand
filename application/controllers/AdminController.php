<?php

class AdminController extends Zend_Controller_Action{
    
    protected $_Modelbase;
    protected $_ModelAdmin;
    protected $_authService;
    protected $_cat;
    protected $_ricercaForm; 
    protected $_creaFaqForm; 
    protected $_modificaFaqForm; 
   
    public function init(){
        
        $this->_helper->layout->setLayout('main');
        //IN FASE DI INIT prendo l oggetto Application_Service_Auth()
        $this->_authService = new Application_Service_Auth();
        
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_ModelAdmin = new Application_Model_Admin();
        
        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
        
        $this->view->ricercaForm = $this->getRicercaForm();
        $this->view->creaFaqForm = $this->getCreafaqForm();
        $this->view->modificaFaqForm = $this->getModificafaqForm();

    }

    public function indexAction(){
        
        
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

    //
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
                                                                                       'action' => 'editfaq'),
                                                                                       'default'));
        return $this->_modificaFaqForm;
        
    } 
    
    public function editfaqAction(){
        
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
    
    
    
}

