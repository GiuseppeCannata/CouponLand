<!--Questo controllore è chiamato public poichè si riferisce alla parte publbica del sito (Livello 0)  -->
<?php

class PublicController extends Zend_Controller_Action {
       
    protected $_logger;
	
    /*costruttore*/    
    public function init() {
        
        $this->_helper->layout->setLayout('main');
        $this->_logger = Zend_Registry::get('log');  
        
    }

    /*Deve generare i contenuti della mia pagina, in base a come la chiamo
      si riferisce al index.phtml (ad ogni azione corrisponde una viewscriptv )      */
    public function indexAction() {    
        
        
    
    }

    /*azione che permette di far vedere le pagine statiche
      Per questo nel corpo di questo metodo no ho nessuna sezione dinamica php     */
    public function viewstaticAction () {
       $page = $this->_getParam('staticPage');
       $this->render($page);
        
    }
    
    public function accediAction (){
        
        $this->_helper->layout->disableLayout();
        $page= $this->_getParam('pagina');
        $this->view->paginaScelta = $page;
        
    }
}