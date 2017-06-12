<?php
/*Mappa la tabella categoria, per questo estende Zend_Db_Table_Abstract
  Attenzione ai nomi( maiuscole e minuscole, e path in modo tale che l autoloder funzioni)
 * MODIFICARE NOME DELLA TABELLA IN DBMS */
class Application_Resource_Categoria extends Zend_Db_Table_Abstract
{
    /*nome della tabella (la devo scrivere come scritta nel DB*/
    protected $_name    = 'categoria';
    /*CHIAVE DI ACCESSO PRIMARIA*/
    protected $_primary  = 'Id_categoria';
    /*specifico la classe che rappresenta le tuble di questa tabella (il nome è il path della classe)*/
    protected $_rowClass = 'Application_Resource_Categoria_Item';
    
    public function init(){
        
    }

    // Estrae i dati della categoria $id (cioè la categoria che gli passo come parametro attuale)
    public function getCatById($id)
    {
        //questa funziona ritorna un oggetto
        //find()-->metodo ereditato
        //         metodo che estrae dal DB, e ritorna sottoforma di oggetto, un insieme di tuple che hanno un certo 
        //         valore che gli passo come paramnetro
        //current--> dico che fra tutti queste tuple a me serve solo la prima
        return $this->find($id)->current();
    }
    
   // Estrae tutte le categorie presenti nella tabella categoria
    public function getCategorie(){
        /*Scrivo la stringa per fare la select
         * fa la select --> select * from categoria (perche sto nella classe che raffigura la tabella categoria) order by name*/
	$select = $this->select()
                       ->order('Nome');
        //fetchAll --> metodo ereditato
        //               fa una query al DB estraendo tutti i dati che sono compatibili con l oggetto select
        return $this->fetchAll($select);
    }
    
    
    public function saveCategoria($values){
       
       $this->insert($values);
     
    }
    
    public function verificaCategoria($Categoria_inserita){
       
    	
        /*Scrivo la stringa per fare la select*/
	$select = $this->select()
                       ->where('Nome=?',$Categoria_inserita);
        
        $result = $this->fetchRow($select);
        
         if($result != NULL){
             
             return true;
           
        }else{
            
           return false;
           
       }
    }
    
    public function deleteCat($Categoria_selezionata){
       
    	$this->find($Categoria_selezionata)->current()->delete();
        
    }
           
    public function updateCat($Nuovo_nome_cat,$Vecchio_nome_cat){
       
        $data = array('Nome' => $Nuovo_nome_cat);
        $where=$this->getAdapter()->quoteInto('Nome=?', $Vecchio_nome_cat);
        
        $this->update($data, $where);
        
    }
      
}

