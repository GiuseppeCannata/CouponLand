<?php
/*Classe che rappresenta la tabella promozione*/
class Application_Resource_Promozione extends Zend_Db_Table_Abstract
{
    protected $_name    = 'promozione';
    protected $_primary  = 'Id_promozione';
    protected $_rowClass = 'Application_Resource_Promozione_Item';

    public function init(){
        
    }
    
    public function getPromozioneTOP(){
        /*Definisco l oggetto stringa che raffigura il comando sql*/
        
        $select = $this->select()
                       ->where('Fine_promozione >= CURDATE()');
        
        /*se eseguo questa istruzione significa che il risultato della query non lo voglio paginato
        e quidi ritorno i dati cosi come sono */
        return $this->fetchAll($select);

    }  
    
    public function getPromozioniByCat($NomeCat, $paged ,$order){
         
         /*Definisco l oggetto stringa che raffigura il comando sql*/
        $select = $this->select()
                       ->where('Categoria =?' ,$NomeCat)
                       ->where('Fine_promozione >= CURDATE()')
                       ->order($order);
        
        if (null !== $paged) {
            
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(5)
                      ->setCurrentPageNumber((int) $paged);
            
            return $paginator;
            
        } 
        
        return $this->fetchAll($select);
    }
    
    public function getPromozioniByAz($NomeAz, $paged ,$order){
         
         /*Definisco l oggetto stringa che raffigura il comando sql*/
        $select = $this->select()
                       ->where('Azienda =?' ,$NomeAz)
                       ->where('Fine_promozione >= CURDATE()')
                       ->order($order);
        
        if (null !== $paged) {
            
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(5)
                      ->setCurrentPageNumber((int) $paged);
            
            return $paginator;
            
        } 
        
        return $this->fetchAll($select);
        
    }
    
    
    public function getPromozioneByID($id_promozione){
        
       /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Id_promozione=?', $id_promozione);
        
        return $this->fetchRow($select);
        
    }
    
    public function search($cat , $textSearch, $paged , $order){
        
        $select = $this->select()
                       ->where('Fine_promozione >= CURDATE()')
                       ->where("Categoria=?",$cat)
                       ->where("Descrizione_estesa LIKE ?", "%".$textSearch."%")
                       ->order($order);
                       
        if (null !== $paged) {
            
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(5)
                      ->setCurrentPageNumber((int) $paged);
            
            return $paginator;
            
        } 
        
        return $this->fetchAll($select);
         
    }
    
    public function updateCouponPromozione($Id_prom, $N_coupon){
        
        $data = array('Coupon_emessi' => $N_coupon);
        $where=$this->getAdapter()->quoteInto('Id_promozione=?', $Id_prom);
        
    	$this->update($data, $where);
        
    }
}

