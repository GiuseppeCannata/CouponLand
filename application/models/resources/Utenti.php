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
    
    public function allUsersfirstlevel(){
            $select = $this->select()
                     ->where('Livello =?', 'user')
                     ->order('User');
             return $this->fetchAll($select);

    }
    
    
    public function getUserByID($id){
        //questa funziona ritorna un oggetto
        //find()-->metodo ereditato
        //         metodo che estrae dal DB, e ritorna sottoforma di oggetto, un insieme di tuple che hanno un certo 
        //         valore che gli passo come paramnetro
        //current--> dico che fra tutti queste tuple a me serve solo la prima
        return $this->find($id)->current();
    }
    
    public function insertUtente($info){
        
    	$this->insert($info);
       
    }
    
    public function estraiUsersbyUsername($name){
        
        $select= $this->select()->where('User = ?', $name);
        return $this->fetchRow($select);
         
    }
    
    
                    
    public function estraiUsersbyEmail($email){
         
         return $this->fetchRow($this->select()->where('Email = ?', $email));
         
    }
    
    public function updateCouponUtente($User, $N_coupon){
        
        $data = array('Coupon_emessi' => $N_coupon);
        $where=$this->getAdapter()->quoteInto('User=?', $User);
        
        $this->update($data, $where );
    }
    
    public function getCouponemessiUtente($User){
        
    	$select = $this->select()
                        ->where('User=?',$User) ;
        
        
        return $this->fetchRow($select);
    }
    
    
    public function modificaUtente($info, $id){
        
        $table = new Application_Resource_Utenti();
        $where = $table->getAdapter()->quoteInto('Id_user = ?', $id);
        $this->update($info, $where);
    }
    
    public function estraiUsersbyUsernameandId($name,$id){
        
        $select= $this->select()->where('Id_user != ?',$id)
                                ->where('User = ?', $name);
        
        return $this->fetchRow($select);
        
    }   
    
    
    public function estraiUsersbyEmailandId($email,$id){
        
        $select= $this->select()->where('Id_user != ?',$id)
                                ->where('Email = ?', $email);
        
                                
        return $this->fetchRow($select);
         
    } 
    
    public function getUtenti(){
        
        $select = $this->select()
                       ->where('User != ?','admin')
                       ->order('Nome');
        
        return $this->fetchAll($select);
         
    }
    
    public function getUtenteByID($id){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Id_user=?',$id);
        
        return $this->fetchRow($select);
        
    }
    
    public function getPassByID($id){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Id_user=?',$id);
        
        return $this->fetchRow($select);
        
    }
    
    public function deleteutente($Id){
        
      $this->find($Id)->current()->delete();
        
    }
    
   
    
    
    
}