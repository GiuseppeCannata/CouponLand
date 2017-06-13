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
    
    public function saveCategoria($values){
       
    	return $this->getResource('Categoria')->saveCategoria($values);
    }
    
    public function verificaCategoria($Categoria_inserita){
       
    	return $this->getResource('Categoria')->verificaCategoria($Categoria_inserita);
        
    }
    
    public function deleteCat($Categoria_selezionata){
       
    	return $this->getResource('Categoria')->deleteCat($Categoria_selezionata);
        
    }
    
    public function aggiornaPromforCat($Categoria_selezionata){
       
    	return $this->getResource('Promozione')->aggiornaPromforCat($Categoria_selezionata);
        
    }
    
    public function updateCat($Nuovo_nome_cat,$Vecchio_nome_cat){
       
    	return $this->getResource('Categoria')->updateCat($Nuovo_nome_cat,$Vecchio_nome_cat);
        
    }
    
    public function updatePromforCat($Nuovo_nome_cat,$Vecchio_nome_cat){
       
    	return $this->getResource('Promozione')->updatePromforCat($Nuovo_nome_cat,$Vecchio_nome_cat);
        
    }
    
    public function aggiornaPromforAz($Nome_azienda){
       
    	return $this->getResource('Promozione')->aggiornaPromforAz($Nome_azienda);
        
    }
    
    public function getAziendaByNameandID($Nome_Azienda, $id){
       
    	return $this->getResource('Azienda')->getAziendaByNameandID($Nome_Azienda, $id);
        
    }
    
    public function aggiornamentoPromforAz($Nome_vecchio, $Nome_Azienda){
       
    	return $this->getResource('Promozione')->aggiornamentoPromforAz($Nome_vecchio, $Nome_Azienda);
        
    }
    
    public function getPromozioneByID($id_promozione){
        
         return $this->getResource('Promozione')->getPromozioneByID($id_promozione);
    }

    public function allUsersfirstlevel(){
        
        
        return $this->getResource('Utenti')->allUsersfirstlevel();
    }
    
    
    
    
}