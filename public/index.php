<?php

/*OGNI VOLTA CHE ARRIVA UNA RICHIESTA VIENE LANCIATA L APPLICAZIONE E QUINDI QUESTO FILE
PRODOTTA LA RISPOSTA SI HA IL MECCANISMO DEL PESCOLINO ROSSO */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
//istanzio una nuova applicazione zend, gli passo come paramentri, la modalita 
//di sviluppo(development ecc..), application path, che è il riferimento alla 
//cartella application contatenato con APLLICATION.INI CHE CONTIENE LA CONFINGURAZIONE INIZIALE
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
//l applicazione DOPO ESSERSI INIZIALIZZATA SECONDO QUANTO SCRITTO IN application.ini
//si inizializza con quanto scritto in file bootstrap, e poi runna
$application->bootstrap()
            ->run();