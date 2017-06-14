<?php
/*Mappa la tabella aziende, per questo estende Zend_Db_Table_Abstract
  Attenzione ai nomi( maiuscole e minuscole, e path in modo tale che l autoloder funzioni)
*/
class Application_Resource_Azienda extends Zend_Db_Table_Abstract
{
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'aziende';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_azienda';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Azienda_Item';
    
    public function init(){
        
    }

    public function getAziende(){
        
        /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->order('Nome');
        
        return $this->fetchAll($select);
        
        
    }
    
    public function getAziendaByID($id_azienda, $chiamante = null){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Id_azienda=?',$id_azienda);
        if($chiamante == 'modifica'){
            return $this->fetchRow($select);
        }
        return $this->fetchAll($select);
        
    }
    
    public function getAziendaByName($Nome){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Nome=?',$Nome);
        
        $result = $this->fetchRow($select);
        
         if($result == NULL){
             
             return false;
           
        }else{
            
           return true;
           
       }
        
    }
    
    public function saveAzienda($data){
        
      $this->insert($data);
        
    }
    
    
    public function deleteAzienda($Id){
        
      $this->find($Id)->current()->delete();
        
    }
    
    
    public function updateAzienda($values){
        
        $Id_azienda = $values['Id_azienda'];
        
	$data = array('Nome' =>  $values['Nome'],
                      'Ragione_sociale' => $values['Ragione_sociale'],
                      'Logo_aziendale' => $values['Logo_aziendale'],
                      'Localizzazione' => $values['Localizzazione'],
                      'Descrizione' => $values['Descrizione'],
                      'Tipologia' => $values['Tipologia']);
        
        $where=$this->getAdapter()->quoteInto('Id_azienda=?',$Id_azienda  );
        
        $this->update($data, $where );
        
    }
    
    public function getAziendaByNameandID($Nome_Azienda, $id){
        
        /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Nome=?',$Nome_Azienda)
                       ->where('Id_azienda !=?',$id);
        
        $result = $this->fetchRow($select);
        
         if($result == NULL){
             
             return false;
           
        }else{
            
           return true;
           
       }
        
    }
    
     public function getAziendaByNOME($Nome){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Nome=?',$Nome);
        
         return $this->fetchRow($select);
        
    }
    
    
       
}

