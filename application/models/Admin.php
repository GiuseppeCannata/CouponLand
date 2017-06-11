<?php

class Application_Model_Admin extends App_Model_Abstract {
    

    public function __construct(){
        
    }

        
    public function getUserByID($info){
       
    	return $this->getResource('Utenti')->getUserByID($info);
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
    
    
    public function getAziendaByID($id_azienda , $chiamante = null){
        
        return $this->getResource('Azienda')->getAziendaByID($id_azienda, $chiamante);
        
    }
    
            
    public function getAziendaByName($Nome_Azienda){
        
        return $this->getResource('Azienda')->getAziendaByName($Nome_Azienda);
        
    }
    
    public function saveAzienda($values){
        
        return $this->getResource('Azienda')->saveAzienda($values);
        
    }
    
    public function getCategoriaById($Id_categoria){
        
        return $this->getResource('Categoria')->getCatByID($Id_categoria);
        
    }
    
    
    public function cancellaAzienda($Id_azienda){
        
         return $this->getResource('Azienda')->deleteAzienda($Id_azienda);
        
    }
    
    public function updateAzienda($azienda){
        
         return $this->getResource('Azienda')->updateAzienda($azienda);
        
    }
    
    public function getUtenti(){
        
         return $this->getResource('Utenti')->getUtenti();
        
    }
    
    public function getUtenteByID($info){
       
    	return $this->getResource('Utenti')->getUtenteByID($info);
    }
    
    public function getPassByID($info){
       
    	return $this->getResource('Utenti')->getPassByID($info);
    }
    public function deleteutente($id){
       
    	return $this->getResource('Utenti')->deleteutente($id);
    }
    
    

    
}