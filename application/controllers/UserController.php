<?php

class UserController extends Zend_Controller_Action{
    
    protected $_Modelbase;
    protected $_cat;
    protected $_formricerca;
    
    public function init(){
        
        $this->_helper->layout->setLayout('main');
        //IN FASE DI INIT prendo l oggetto Application_Service_Auth()
        $this->_authService = new Application_Service_Auth();
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
        $this->view->ricercaForm = $this->getRicercaForm();

    }

    public function indexAction(){
        
        $PromozioniTOP = $this->_Modelbase->getPromozioneTOP();
        $this->view->assign(array('CatTOP' => $this->_cat,
                                  'PromozioniTOP' => $PromozioniTOP));
        
    } 
    
    private function getRicercaForm(){
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_formricerca = new Application_Form_Public_Ricerca_Ricerca();
    		$this->_formricerca->setAction($urlHelper->url(array(
			'controller' => 'public',
			'action' => 'accedi'),
			'default'
		));
		return $this->_formricerca;
    }   

    //
    public function logoutAction(){
        
        //utilizzo il metodo clear dell oggetto zend_auth
        $this->_authService->clear();
        //ridirigo la chiamata sull controllore public all azione index
        return $this->_helper->redirector('index','public');	
    }
    
    public function areariservataAction(){
        	
    }
    
    
    
}



