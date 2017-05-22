<?php
/*tutti i metodi per estrarre i dati che mi servono per l interfaccia
 * Metodi richiamati nel controller Public */
class Application_Model_Modelbase extends App_Model_Abstract
{ 

    public function __construct(){
            
	$this->_logger = Zend_Registry::get('log');  
            
    }

    public function getCategorie()
    {
        //getResource 
        //-metodo ereditato  da App_Model_Abstract
        //-istanzia la classe Category e ne richiama il metodo getCategorie()
	return $this->getResource('Categoria')->getCategorie();
    }
    
    public function getPromozioneTOP(){
        
        return $this->getResource('Promozione')->getPromozioneTOP();
        
    }
    
    public function getlistAziende(){
        
        return $this->getResource('Aziende')->gelistAziende();
        
    }
    
    public function getAzienda($id_azienda){
        
        return $this->getResource('Aziende')->getAzienda($id_azienda);
        
    }
    
    
}