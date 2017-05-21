<?php

/*Zend prende questa sequenza di termini come se fossero dei path sostituendo _ con / */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
        protected $_logger;
	protected $_view;

        /*parte in automatico*/
    protected function _initLogging()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        Zend_Registry::set('log', $logger);

        $this->_logger = $logger;
    	$this->_logger->info('Bootstrap ' . __METHOD__);
    }

    /*parte in automatico*/
    protected function _initRequest()
	// Aggiunge un'istanza di Zend_Controller_Request_Http nel Front_Controller
	// che permette di utilizzare l'helper baseUrl() nel Bootstrap.php
	// Necessario solo se la Document-root di Apache non è la cartella public/
    {
        /*inizializzo il front controller*/
        $this->bootstrap('FrontController');
        /*lo memorizzo in $front*/
        $front = $this->getResource('FrontController');
        /*istanzio il request objecr*/
        $request = new Zend_Controller_Request_Http();
        /*lo passo al front controller
          Da qui baseurl prende il path          */
        $front->setRequest($request);
    }

    /*Metodo che parte in automatico poichè ha _init parte in automatico
     In questo metodo definisco tutti i placeholder che utilizzero nella mia vista
     Definisco alcune proprietà generiche della vista    */
    protected function _initViewSettings()
    {
        /*forzo la creazione della vista, poichè non è ancora istanziata la vista, siamo nel bostrap infatti*/
        $this->bootstrap('view');
        /*assegno all attributo _view la vista appena creata*/
        $this->_view = $this->getResource('view');
        /*headMeta(), headMeta(), headLink(), headTitle(), sono dei metodi presenti nell oggetto vista 
          e che permettono di creare le tag HTML, cosi facendo creo dei placeholder*/
        /*CREA LA TAG META*/
        $this->_view->headMeta()->setCharset('UTF-8');
        /*CREA LA TAG META*/
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        /*CREA LA TAG LINK*/
        /*Ricorda che zend prende tutte le cose relative al html,js,css in public
         * baseUrl()-> metodo delle vista, è un viewHelper; 
         *            Gli passo un path relativo 
         *            e lui genera il path assoluto fino ad arrivare a css/style.css 
                      Parte dalla htdocs e genera il path assoluto         */
	$this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/Logo.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/MenuAtendina.css'));
        
        
        /*CREA LA TAG TITLE*/
        $this->_view->headTitle('CouponLand - L offerta che vuoi quando vuoi');
    }
    
    
    protected function _initDefaultModuleAutoloader(){
        
    	$loader = Zend_Loader_Autoloader::getInstance();
		$loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');
    }

}

