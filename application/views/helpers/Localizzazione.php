<?php

class Zend_View_Helper_Localizzazione extends Zend_View_Helper_HtmlElement {
	
    
        /*Data una promozione questo view helper è in grado di estrarre la localizzazione della 
         relativa azienda*/
	
	public function Localizzazione($azienda_prom, $aziende){
            
            foreach($aziende as $azienda) {

                if($azienda_prom == $azienda->Nome){

                    $Localizzazione = $azienda->Localizzazione;
                    return $Localizzazione ;

                }
            }
        }
}

