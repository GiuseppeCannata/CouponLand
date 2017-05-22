<?php
/*Mappa la tabella aziende, per questo estende Zend_Db_Table_Abstract
  Attenzione ai nomi( maiuscole e minuscole, e path in modo tale che l autoloder funzioni)
*/
class Application_Resource_Aziende extends Zend_Db_Table_Abstract
{
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'aziende';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_azienda';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Aziende_Item';
    
    public function init(){
        
    }

    public function gelistAziende(){
        
        /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->order('Nome');
        
        return $this->fetchAll($select);
        
        
    }
    
    public function getAzienda($id_azienda){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('id_azienda='.$id_azienda);
        
        return $this->fetchAll($select);
        
    }
    
       
}

