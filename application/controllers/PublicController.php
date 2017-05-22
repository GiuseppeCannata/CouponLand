<!--Questo controllore è chiamato public poichè si riferisce alla parte publbica del sito (Livello 0)  -->
<?php

class PublicController extends Zend_Controller_Action {
       
    protected $_Modelbase;
	
    /*costruttore*/    
    public function init() {
        
        $this->_helper->layout->setLayout('main'); 
        $this->_Modelbase = new Application_Model_Modelbase();
    }

    /*Deve generare i contenuti della mia pagina, in base a come la chiamo
      si riferisce al index.phtml (ad ogni azione corrisponde una viewscriptv ) */
    public function indexAction() {   
        
        //  Estrae le Categorie dal model   	    	
    	$CategorieTendina = $this->_Modelbase->getCategorie();
        $PromozioniTOP    = $this->_Modelbase->getPromozioneTOP();
        
         // Definisce le variabili per il viewer
        //passo alla view index l array contenete le variabili
    	$this->view->assign(array('CategorieTendina' => $CategorieTendina,
                                  'PromozioniTOP' => $PromozioniTOP));
    
    }

    /*azione che permette di far vedere le pagine statiche
      Per questo nel corpo di questo metodo no ho nessuna sezione dinamica php     */
    public function viewstaticAction () {
        
       $page = $this->_getParam('staticPage');
       $this->render($page);
        
    }
    
    public function listaziendeAction () {
        
      $listaziende = $this->_Modelbase->getlistAziende();
      
      $this->view->assign(array('listaziende' => $listaziende));
        
    }
    
    public function aziendaAction() {
        
      $id_azienda = $this->_getParam('id');
      $azienda = $this->_Modelbase->getAzienda($id_azienda);
      
      $this->view->assign(array('azienda' => $azienda));
        
    }
    
    
    
    public function accediAction (){
        
        $this->_helper->layout->disableLayout();
        $page= $this->_getParam('pagina');
        $this->view->paginaScelta = $page;
        
    }
}