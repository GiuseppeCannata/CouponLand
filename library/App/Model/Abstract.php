<?php

/*è una classe astratta
 * No posso istanziarla, infatti non ho il costruttore
 * La utilizzo come base per catalog
 * No eredita da nessuna classe
 */
abstract class App_Model_Abstract
{	
        //dichiaro una variabile a cui assegno direttamnete un array
	protected $_resources = array();
	
        //Metodo che riceve come paramentro il nome della classe che io voglio istanziare
	public function getResource($name) 
	{
                /*Verifico se la classe che richiedo è stata gia istanziata
                  se lo è, l oggetto (relativo a quella classe) si trova nell array resorces   */
		if (!isset($this->_resources[$name])) {
                    //se non ho istanziato la classe
                    
                    //nella variabile $class, questo corpo dell if, costruisce 
                    //il percorso per arrivare alla classe che devo istanziare
                    
                    //implode()-->istruzione php, che prende un array ed un carattere
                    //e costruisce una stringa, che contiene tutti i valori 
                    //dell array separati dal carattere che gli passo come primo paramentro
                    //in questo caso(_)
                    
                    //fondamnetalmente cerco il nome della classe che voglio instanziare e lo salvo in $class
            $class = implode('_', array(
                    $this->_getNamespace(), //Metodo di servizio, prende la parola (in questo caso application) che noi abbiamo definito allinterno del application.ini
                    'Resource',  //nome della cartella
                    $name));   //classe che voglio istanziare (passata come parametro)
            //cosa che ottengo 
            
            //ora metto nell array (associativo) , l oggetto che istanzierò dalla classe che 
            $this->_resources[$name] = new $class();
                }
	    return $this->_resources[$name];
	}

	private function _getNamespace()
    {
        $ns = explode('_', get_class($this));
        return $ns[0];
    }

}