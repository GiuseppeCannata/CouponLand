<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;
	protected $_Livello;
	protected $_auth;

	public function __construct()
	{
                $this->_auth = Zend_Auth::getInstance();
		$this->_Livello = !$this->_auth->hasIdentity() ? 'nonregistrato' : $this->_auth->getIdentity()->Livello;
    		$this->_acl = new Application_Model_Acl();    	
	}

        public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if (!$this->_acl->isAllowed($this->_Livello, $request->getControllerName())) {
			$this->_auth->clearIdentity();
			$this->denyAccess();
		}
	}
	
	private function denyAccess()
	{
   		$this->_request->setModuleName('default')
   					   ->setControllerName('public')
					   ->setActionName('index');
	}
}
