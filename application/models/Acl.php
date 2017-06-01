<?php 

class Application_Model_Acl extends Zend_Acl
{
	public function __construct()
	{
		// ACL per user non registrato
		$this->addRole(new Zend_Acl_Role('nonregistrato'))
			 ->add(new Zend_Acl_Resource('public'))
			 ->add(new Zend_Acl_Resource('error'))
			 ->allow('nonregistrato', array('public','error'));
			 
		// ACL per user
		$this->addRole(new Zend_Acl_Role('user'), 'nonregistrato')
			 ->add(new Zend_Acl_Resource('user'))
			 ->allow('user','user');
                
                // ACL per staff
		$this->addRole(new Zend_Acl_Role('staff'), 'nonregistrato')
			 ->add(new Zend_Acl_Resource('staff'))
			 ->allow('staff','staff');
                
				   
		// ACL per admin
		$this->addRole(new Zend_Acl_Role('admin'), 'nonregistrato')
			 ->add(new Zend_Acl_Resource('admin'))
			 ->allow('admin','admin');
	}
}