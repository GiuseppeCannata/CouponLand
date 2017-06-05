<?php
/*tutti i metodi per estrarre i dati che mi servono per l interfaccia
 * Metodi richiamati nel controller Public */
class Application_Model_Modelbase extends App_Model_Abstract
{ 

    public function __construct(){
            
	$this->_logger = Zend_Registry::get('log');  
            
    }

    public function getCategorie(){
        //getResource 
        //-metodo ereditato  da App_Model_Abstract
        //-istanzia la classe Category e ne richiama il metodo getCategorie()
	return $this->getResource('Categoria')->getCategorie();
    }
    
    public function getPromozioneTOP(){
        
        return $this->getResource('Promozione')->getPromozioneTOP();
        
    }
    
    public function getAziende(){
        
        return $this->getResource('Azienda')->getAziende();
        
    }
    
    public function getAziendaByID($id_azienda){
        
        return $this->getResource('Azienda')->getAziendaByID($id_azienda);
        
    }
    
    public function getPromozioneByID($id_promozione){
        
        return $this->getResource('Promozione')->getPromozioneByID($id_promozione);
        
    }
    
    public function getfaq(){
        
        return $this->getResource('Faq')->getfaq();
        
    }
    
    public function getPromozioniByIBRIDO($chiamante , $IBRIDO , $paged , $order , $cat , $word){
        
        switch($chiamante){
           
            case 'search':{
            
                return $this->getResource('Promozione')->search($cat , $word, $paged, $order);
                break;
            }
            
            case 'promCat':{
                /*$IBRIDO== NomeCat*/
                return $this->getResource('Promozione')->getPromozioniByCat($IBRIDO , $paged ,$order);
                break;
            }
            
            case 'promAz':{
                
                /*$IBRIDO== NomeAz*/
                return $this->getResource('Promozione')->getPromozioniByAz($IBRIDO , $paged ,$order);
                break;
            }
        }
    }
    
    public function saveUtente($info){
    	return $this->getResource('Utenti')->insertUtente($info);
    }
    
    public function estraiUsersbyUsername($name){
    	return $this->getResource('Utenti')->estraiUsersbyUsername($name);
    }
    
    public function estraiUsersbyEmail($email){
    	return $this->getResource('Utenti')->estraiUsersbyEmail($email);
    }
}