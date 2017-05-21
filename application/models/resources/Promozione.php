<?php
/*Classe che rappresenta la tabella prodotti*/
class Application_Resource_Product extends Zend_Db_Table_Abstract
{
    protected $_name    = 'product';
    protected $_primary  = 'prodId';
    protected $_rowClass = 'Application_Resource_Product_Item';

	public function init()
    {
    }

    // Estrae i prodotti della categoria $categoryId, eventualmente paginati ed ordinati
    //voglio wrappare i dati in una pagina in un determinato modo--> utilizzo Zend-Paginator
    //Come parametri formali ho: la categoria, 
    //                           paged--> se definito dice la pagina che voglio estrarre, (voglio ad esempiuo vedere solo i prodotti presenti nella pagina 2 o 3
    //                           order--> vuoi i prodotti cosi come sono? oppure ordinati magari per sconto? 
    //                                      se li voglio ordinare, devo specificare per cosa per cui $order diventa un array associativo
    
    public function getProdsByCat($categoryId, $paged=null, $order=null)
    {
        /*Definisco l oggetto stringa che raffigura il comando sql*/
        $select = $this->select()
                /*grazie a questa sintassi sono in grado di estrarre i prodotti non solo di una sola categoria, ma di piu categorie
                  che passo al metodo where come un array    $categoryId
                  IL where è in grado di saperlo grazie al comando (?)         */
                        ->where('catId IN(?)', $categoryId);
        
        //LA SELECT CONTINUA
        
        /*$oreder è un array associativo poiche io devo specificare, se voglio, come ordinare i prodotti */
        //quindi in questo caso controllo se $order è un array
        if (true === is_array($order)) {
            $select->order($order);
        }
                //se paged è settato significa che io programmatore voglio far visualixzzare il dato in maniera paginata
                //per questo effettuo il controllo
		if (null !== $paged) {
                    //entro nel corpo dell if , quidni voglio un dato paginato
                        //defiisco a quale sorgente bisogna applicare la paginazione, per questo richiede la $select
                       // o meglio la query che faccio al DB
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
                        //cREO UN ISTANZA DI Zend_Paginator che raffigura il dato paginato
                        //a cui passo il risultato della query per poterlo paginare
			$paginator = new Zend_Paginator($adapter);
                        //Quate tuple vuoi in ogni pagina?
			$paginator->setItemCountPerPage(1)
                                //notare l operatore di cast, questo perche setCurrentPageNumber vuole un intero
		          	  ->setCurrentPageNumber((int) $paged);
                        
                        /*cosi facendo arresto il metodo e ritorno l oggetto paginato*/
			return $paginator;
		}
                
            /*se eseguo questa istruzione significa che il risultato della query non lo voglio paginato
              e quidi ritorno i dati cosi come sono              */
        return $this->fetchAll($select);
    } 

	// Estrae i prodotti IN SCONTO della categoria $categoryId, eventualmente paginati ed ordinati
    public function getDiscProds($categoryId, $paged=null, $order=null)
    {
        $select = $this->select()
        	       ->where('catId IN(?)', $categoryId)
        	       ->where('discounted = 1');
        
        if (true === is_array($order)) {
            $select->order($order);
        }
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    } 
}

