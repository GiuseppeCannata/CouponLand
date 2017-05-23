<?php
/*Mappa la tabella faq*/

class Application_Resource_Faq extends Zend_Db_Table_Abstract {
    
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'faq';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_faq';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Faq_Item';
    
    public function init(){
        
    }
    
   // Estrae tutte le faq presenti nella tabella faq
    public function getFaq(){
       
	$select = $this->select();
                    
        return $this->fetchAll($select);
    }
       
}


