<?php

class Application_Model_User extends App_Model_Abstract { 

    public function __construct(){
            
	$this->_logger = Zend_Registry::get('log');  
            
    }
    
    public function verificaemissioneCoupon($utente , $promozione){
        
    	return $this->getResource('Couponemessi')->verificaemissioneCoupon($utente , $promozione);
    }
    
    public function insertCouponEmessi($data){
        
    	return $this->getResource('Couponemessi')->insertCouponEmessi($data);
        
    }
    
    public function updateCouponUtente($User, $N_coupon){
        
    	return $this->getResource('Utenti')->updateCouponUtente($User, $N_coupon);
        
    }
    
    public function updateCouponPromozione($Id_prom, $N_coupon){
        
    	return $this->getResource('Promozione')->updateCouponPromozione($Id_prom, $N_coupon);
        
    }
    
    public function getCouponemessiUtente($User){
        
    	return $this->getResource('Utenti')->getCouponemessiUtente($User);
        
    }
}

