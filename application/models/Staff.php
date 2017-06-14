<?php

class Application_Model_Staff extends App_Model_Abstract { 

    public function __construct(){
            
	$this->_logger = Zend_Registry::get('log');  
            
    }
    
    
    public function inserisciPromozione($data){
    	return $this->getResource('Promozione')->insertPromozione($data);
    }
    
    
    public function modificaPromozione($data, $id){
    	return $this->getResource('Promozione')->editPromozione($data, $id);
    }
    
    public function cancellaPromozione($id){
    	return $this->getResource('Promozione')->deletePromozione($id);
    }
    
     public function getCategorie(){
        //getResource 
        //-metodo ereditato  da App_Model_Abstract
        //-istanzia la classe Category e ne richiama il metodo getCategorie()
	return $this->getResource('Categoria')->getCategorie();
    }
    
    
     public function getAziende(){
        
        return $this->getResource('Azienda')->getAziende();
        
    }
    
    
    public function getPromByCat($cat){
        
        return $this->getResource('Promozione')->getPromByCat($cat);
        
    }
    
     public function getAziendaByNomeProm($nomeProm){
        
        return $this->getResource('Promozione')->getAziendaByNomeProm($nomeProm);
        
    }
    
    
     public function getPromByCatNomeAz($cat, $nome, $azienda){
        
        return $this->getResource('Promozione')->getPromByCatNomeAz($cat, $nome, $azienda);
        
    }
    
    
     public function getPromByNomeAz($nome, $azienda){
        
        return $this->getResource('Promozione')->getPromByNomeAz($nome, $azienda);
        
    }
    
    
    public function estraiPrombyNameandIdandAz($id,$name,$az){
        
        return $this->getResource('Promozione')->estraiPrombyNameandIdandAz($id,$name,$az);
    }

    
     public function estraiUsersbyUsernameandId($name,$id)
    {
    	return $this->getResource('Utenti')->estraiUsersbyUsernameandId($name,$id);
       
    }
    
     public function estraiUsersbyEmailandId($email,$id)
    {
    	return $this->getResource('Utenti')->estraiUsersbyEmailandId($email,$id);
    }
    
    
    public function modificaUtente($info, $id)
    {
    	return $this->getResource('Utenti')->modificaUtente($info,$id);
    }
    
    public function getPromozioneByID($id_promozione){
         return $this->getResource('Promozione')->getPromozioneByID($id_promozione);
    }
    
    public function getCatsfromPromozioni(){
        return $this->getResource('Promozione')->getCatsfromPromozioni();
    }
    
    
}