<?php

class UserController extends Zend_Controller_Action{
    
    protected $_Modelbase;
    protected $_cat;
    protected $_formricerca;
    protected $_ModelUser; 
    protected $_authService;
    protected $_formarearis;


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
        $this->view->arearisForm = $this->getAreaRisForm();

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
    
    public function validatecouponAction(){
       
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
            
            $this->view->assign(array( 'response' => $results,
                                       'Titolo' => 'Coupon', 
                                       'msg' => 'Ecco a lei il suo coupon!',
                                       'Id_promozione' => $Id_prom));
        }
        
        
    }
    
    public function couponAction(){
        
        $auth = Zend_Auth::getInstance()->getIdentity();
        $Id_prom = $this->_getParam('Id_promozione');
        $User = $auth->User;
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
        $r = $this->_ModelUser->insertCouponEmessi($data);
        
        $this->_helper->getHelper('layout')->disableLayout();
         
        $this->view->assign(array('Nome_promozione' => $promozione['Nome'] ,
                                   'Categoria' => $promozione['Categoria'],
                                   'Offerta' => $promozione['Offerta'],
                                   'Fine_promozione' => $promozione['Fine_promozione'],
                                   'Azienda' => $promozione['Azienda'],
                                   'Id_coupon' => $r['Id_coupon']));
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
       if(($this->_ModelUser->estraiUsersbyUsernameandId($user_inserito, $iduser_attuale) != NULL) || ($this->_ModelUser->estraiUsersbyEmailandId($email_inserita,$iduser_attuale) != NULL)){
            
            $form->setDescription('Attenzione: User o email giÃ  presenti!');
            $this->render('areariservata');
            return  $this->_helper->layout->disableLayout();

        }
                
        
        //Vengono presi i valori dalla form e viene effetuato l'update        
        $values = $form->getValues();
        if($values["Pass"] == NULL){
            
            $values["Pass"] = $this->_authService->getIdentity()->Pass;
            
        }
        
        $this->_ModelUser->modificaUtente($values, $iduser_attuale);
        $this->_authService->authenticate($values);
        $this->_helper->redirector('index');
    }
    
    private function getAreaRisForm(){
        
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formarearis = new Application_Form_User_AreaRiser();
        $this->_formarearis->setAction($urlHelper->url(array('controller' => 'user',
                                                            'action' => 'modificautente'),
                                                            'default'));
        return $this->_formarearis;
    } 
    
    public function areariservataAction(){
        
        $this->_helper->layout->disableLayout();
        
    }
    
}



