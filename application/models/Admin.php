<?php

class Application_Model_Admin extends App_Model_Abstract {
    

    public function __construct(){
        
    }

        
    public function getUserByName($info){
        
    	return $this->getResource('Utenti')->estraiUsersbyUsername($info);
    }
    
   
    
    public function  numerocouponemessi(){
        
    	return $this->getResource('Couponemessi')->numerocouponemessi();
    }
    
    public function promTutte(){
        
    	return $this->getResource('Promozione')->promTutte();
        
    }
    
    
    public function saveFaq($values){
        
    	return $this->getResource('Faq')->saveFaq($values);
        
    }
    
    public function updateFaq($values){
        
    	return $this->getResource('Faq')->updateFaq($values);
        
    }
    
    
    public function deletefaq($Id_faq){
        
    	return $this->getResource('Faq')->deletefaq($Id_faq);
        
    }
   

    
}