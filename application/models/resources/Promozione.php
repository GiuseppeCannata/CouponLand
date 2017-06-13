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
                       ->where('Fine_promozione >= CURDATE()')
                       ->where('Categoria !=?','Nessuna categoria')
                       ->where('Azienda !=?','Nessuna azienda');
        
        /*se eseguo questa istruzione significa che il risultato della query non lo voglio paginato
        e quidi ritorno i dati cosi come sono */
        return $this->fetchAll($select);

    }  
    
    public function getPromozioniByCat($NomeCat, $paged ,$order){
         
         /*Definisco l oggetto stringa che raffigura il comando sql*/
        $select = $this->select()
                       ->where('Categoria =?' ,$NomeCat)
                       ->where('Fine_promozione >= CURDATE()')
                       ->where('Categoria !=?','Nessuna categoria')
                       ->where('Azienda !=?','Nessuna azienda')
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
                       ->where('Categoria !=?','Nessuna categoria')
                       ->where('Azienda !=?','Nessuna azienda')
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
  
      
        if($textSearch != NULL){
            
            if($cat == 'Categoria'){

               $select = $this->select()
                           ->where('Fine_promozione >= CURDATE()')
                           ->where("Descrizione_estesa LIKE ?", "%".$textSearch."%")
                           ->order($order);
            }
            else{

                $select = $this->select()
                               ->where('Fine_promozione >= CURDATE()')
                               ->where("Categoria=?",$cat)
                               ->where("Descrizione_estesa LIKE ?", "%".$textSearch."%")
                               ->order($order);
            }
            
            
        }else{
            
            return false;
        }
            
       
                       
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
    
    public function promTutte(){
        
        $select = $this->select();
        
        return $this->fetchAll($select);
        
    }
    
    //metodo che, in seguito all eliminazione di una categoria, mette  tutte le promozioni con quella categoria a 
    //Categoria: Nessuna categoria
    public function aggiornaPromforCat($Categoria_selezionata){
        
        $data = array('Categoria' => 'Nessuna categoria');
        $where=$this->getAdapter()->quoteInto('Categoria=?', $Categoria_selezionata);
        
        $this->update($data, $where);
        
    }
    
    //metodo che, in seguito all eliminazione di una azienda, mette  tutte le promozioni con quella azienda a 
    //Azienda: Nessuna azienda
    public function aggiornaPromforAz($Nome_azienda){
        
        $data = array('Azienda' => 'Nessuna azienda');
        $where=$this->getAdapter()->quoteInto('Azienda=?', $Nome_azienda);
        
        $this->update($data, $where);
        
    }
    
    //metodo che, in seguito alla modifica di una categoria, mette  tutte le promozioni con quella categoria a 
    //Categoria: (nuova categoria selezionata dall admin)
    public function updatePromforCat($Nuovo_nome_cat,$Vecchio_nome_cat){
        
        $data = array('Categoria' => $Nuovo_nome_cat);
        $where=$this->getAdapter()->quoteInto('Categoria=?', $Vecchio_nome_cat);
        
        $this->update($data, $where);
        
    }  
    
    public function aggiornamentoPromforAz($Nome_vecchio, $Nome_Azienda){
        
        $data = array('Azienda' => $Nome_Azienda);
        $where=$this->getAdapter()->quoteInto('Azienda=?', $Nome_vecchio);
        
        $this->update($data, $where);
        
    } 
    
    
}

