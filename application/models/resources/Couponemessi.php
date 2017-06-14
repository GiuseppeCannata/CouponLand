<?php
/*Mappa la tabella faq*/

class Application_Resource_Couponemessi extends Zend_Db_Table_Abstract {
    
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'coupon_emessi';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_coupon';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Couponemessi_Item';
    
    public function init(){
        
    }
    
   public function verificaemissioneCoupon($User , $Id_promozione){
       
        $select = $this->select()
                        ->where('User=?' , $User)
                        ->where('Id_promozione=?' , $Id_promozione);
                        
       $result = $this->fetchRow($select);
       
       if($result == NULL){
           
          return true;
           
       }else{
           
           return false;
           //il coupon per quel user è stato emesso
           
       }
   }
   
    public function insertCouponEmessi($data){
      
       $this->insert($data);
       
       //mi faccio ridare l id del coupon
       $select = $this->select()
                      ->where('Id_promozione=?',$data['Id_promozione']);
        
        return $this->fetchRow($select);
        
    }
    
    public function numerocouponemessi() {
        
        $select = $this->select();
        
        return $this->fetchAll($select);
        
    }   
}

