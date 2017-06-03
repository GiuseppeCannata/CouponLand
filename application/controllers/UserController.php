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
       
        $auth = Zend_Auth::getInstance()->getIdentity();
        
        $User = $auth->User;
        $Id_prom = $this->_getParam('prom');
       
          
        //ritorna true se l utente ha gia prelevato il coupon
        $results = $this->_ModelUser->verificaemissioneCoupon($User , $Id_prom);
        
        if(!$results){
            
            $this->view->assign(array('response' => $results,
                                      'Titolo' => 'Spiacenti', 
                                      'msg' => 'Il coupon è gia stato prelevato per questo prodotto! '
                . 'Le ricordiamo che è possibile ritirare un solo coupon per prodotto!')) ;
        }else{
            
            $promozione = $this->_Modelbase->getPromozioneByID($Id_prom);
            
            //aggiorno i coupon emessi della promnozione
            $coupon_emessi =  (int) $promozione['Coupon_emessi'] ;
            $N_coupon = $coupon_emessi +1;
            $this->_ModelUser->updateCouponPromozione($Id_prom, $N_coupon );
            
            //aggiorno coupon_emessi dell utente
            $Utente = $this->_ModelUser->getCouponemessiUtente($User);
            $coupon_emessi = (int)$Utente['Coupon_emessi'];
            $N_coupon = $coupon_emessi +1;
            $this->_ModelUser->updateCouponUtente($User, $N_coupon);
           
            
            $data = array('User'=> $User, 
                'Id_promozione'=> $promozione['Id_promozione'], 
                'Nome_promozione'=> $promozione['Nome'],
                'Inizio_promozione'=> $promozione['Inizio_promozione'],
                'Fine_promozione'=> $promozione['Fine_promozione']);
            
            //inserisco l emissione del coupon
            $this->_ModelUser->insertCouponEmessi($data);
            
            $this->view->assign(array( 'response' => $results,
                                       'Titolo' => 'Coupon', 
                                       'msg' => 'Ecco a lei il suo coupon!',
                                       'prom'=> $promozione));
        }
        
        
    }
    
     public function cvAction(){
         $this->_helper->getHelper('layout')->disableLayout();
         
         $this->view->assign(array('Id_promozione' => $this->_getParam('Id_promozione'),
                                    'Nome_Promozione' => $this->_getParam('Nome_Promozione'),
                                    'Fine_promozione' => $this->_getParam('Fine_promozione'),
                                    'Azienda' =>$this->_getParam('Azienda') ));
        	
    }
    
}



