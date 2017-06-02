<?php

class UserController extends Zend_Controller_Action{
    
    protected $_Modelbase;
    protected $_cat;
    protected $_formricerca;
    protected $_ModelUser; 
    
    public function init(){
        
        $this->_helper->layout->setLayout('main');
        //IN FASE DI INIT prendo l oggetto Application_Service_Auth()
        $this->_authService = new Application_Service_Auth();
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_ModelUser = new Application_Model_User();
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

        $this->_formricerca = new Application_Form_Public_Ricerca_Ricerca();
        $this->_formricerca->setAction($this->_helper->getHelper('url')->url(array( 'controller' => 'public',
                                                                                    'action' => 'listpromozioni',
                                                                                    'chiamante' => 'search',
                                                                                     'IBRIDO'=> 'Elenco risultati:'),
                                                                                    'default'));
        
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
    
    public function couponAction(){
       
        $auth = Zend_Auth::getInstance();
        $User = $auth->getIdentity()->User;
          
        $Id_prom = $this->_getParam('prom');
          
        //ritorna true se l utente ha gia prelevato il coupon
        $results = $this->_ModelUser->verificaemissioneCoupon($User , $Id_prom);
        
        if(!$results){
            
            $this->view->assign(array('Titolo' => 'Spiacenti', 
                                      'msg' => 'Il coupon è gia stato prelevato per questpo prodotto')) ;
        }else{
            
            $promozione = $this->_Modelbase->getPromozioneByID($Id_prom);
            
            $data = array('User'=> $User, 
                'Id_promozione'=> $promozione['Id_promozione'], 
                'Nome_promozione'=> $promozione['Nome'],
                'Inizio_promozione'=> $promozione['Inizio_promozione'],
                'Fine_promozione'=> $promozione['Fine_promozione']);
            
            //inserisco
            $this->_ModelUser->insertCouponEmessi($data);
            
            $N_coupon = $auth->getIdentity()->Coupon_emessi + 1;
            $this->_ModelUser->updateCouponUtente($User, $N_coupon);
            
            //$N_coupon =  $promozione['Coupon_emessi'] ;
            $this->_ModelUser->updateCouponPromozione($Id_prom, $N_coupon );
            
            $this->view->assign(array('Titolo' => 'Coupon', 
                                      'msg' => 'Ecco a lei il suo coupon!',
                                      ));
        }
            
    }
    
    
    
}



