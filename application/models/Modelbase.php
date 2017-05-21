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
    //estrarre specifica categoria
    public function getCatById($id)
    {
        return $this->getResource('Category')->getCatById($id);
    }
}