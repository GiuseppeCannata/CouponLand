<!--Questo controllore è chiamato public poichè si riferisce alla parte publbica del sito (Livello 0)  -->
<?php

class PublicController extends Zend_Controller_Action {
     
    /*attributi*/
    protected $_Modelbase; //salvo il modelPubblico
    protected $_cat;  //salvo le categorie 
	
    /*costruttore*/    
    public function init() {
        
        $this->_helper->layout->setLayout('main'); 
        $this->_Modelbase = new Application_Model_Modelbase();
        $this->_cat = $this->_Modelbase->getCategorie();
        //la passo alla view
        $this->view->assign(array('CategorieTendina' => $this->_cat ));
    }
    
    
    public function indexAction() {   
               
        $PromozioniTOP = $this->_Modelbase->getPromozioneTOP();
        //Definisce le variabili per il viewer
        //passo alla view index l array contenete le variabili
    	$this->view->assign(array('PromozioniTOP' => $PromozioniTOP));
    
    }

    /*azione che permette di far vedere le pagine statiche
      Per questo nel corpo di questo metodo no ho nessuna sezione dinamica php     */
    public function viewstaticAction () {
        
       $page = $this->_getParam('staticPage');
       $this->render($page);
        
    }
    
    public function listaziendeAction () {
        
      $listaziende = $this->_Modelbase->getAziende();
      $this->view->assign(array('listaziende' => $listaziende));
        
    }
    
    public function aziendaAction() {
        
      $id_azienda = $this->_getParam('id');
      $azienda = $this->_Modelbase->getAziendaByID($id_azienda);
      $this->view->assign(array('azienda' => $azienda));
        
    }
    
    public function faqAction() {
      
      $Faq = $this->_Modelbase->getfaq();
      $this->view->assign(array('faq' => $Faq));
        
    }
    
    
    
    public function accediAction (){
        
        $this->_helper->layout->disableLayout();
        $page= $this->_getParam('pagina');
        $this->view->paginaScelta = $page;
        
    }
}