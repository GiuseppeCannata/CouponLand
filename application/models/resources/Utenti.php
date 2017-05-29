<?php
class Application_Resource_Utenti extends Zend_Db_Table{
    
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'utenti';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_user';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Utenti_Item';
    
    
     public function init(){
        
    }
    
    
    public function getUtenteById($id)
    {
        //questa funziona ritorna un oggetto
        //find()-->metodo ereditato
        //         metodo che estrae dal DB, e ritorna sottoforma di oggetto, un insieme di tuple che hanno un certo 
        //         valore che gli passo come paramnetro
        //current--> dico che fra tutti queste tuple a me serve solo la prima
        return $this->find($id)->current();
    }
    
    public function insertUtente($info){
        
    	$this->insert($info);
        $this->update(array('Livello' => 'User'), '');
    }
    
    
    
    public function estraiUsersbyUsername($name){
         return $this->fetchRow($this->select()->where('User = ?', $name));
    }
                    
     public function estraiUsersbyEmail($email){
         return $this->fetchRow($this->select()->where('Email = ?', $email));
    }
    
    
    
    
    
    
    
    
    
    
}