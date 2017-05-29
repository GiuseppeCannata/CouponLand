<?php

class Application_Service_Auth
{
    protected $_modelbaseModel;
    protected $_auth;

    public function __construct()
    {
        $this->_modelbaseModel = new Application_Model_Modelbase();
    }
    
    public function authenticate($credentials)
    {
        $adapter = $this->getAuthAdapter($credentials);
        $auth    = $this->getAuth();
        $result  = $auth->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }
        $user = $this->_modelbaseModel->e($credentials['User']);
        $auth->getStorage()->write($user);
        return true;
    }
    
    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }
   
    public function getIdentity()
    {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }
    
    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }
    
    private function getAuthAdapter($values)
    {
	$authAdapter = new Zend_Auth_Adapter_DbTable(
		Zend_Db_Table_Abstract::getDefaultAdapter(),
		'utenti',
		'User',
		'Pass'
	);
	$authAdapter->setIdentity($values['User']);
	$authAdapter->setCredential($values['Pass']);
        return $authAdapter;
    }
}
