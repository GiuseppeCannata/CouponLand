<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_Public_Utenti_Login extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
        $this->setAttrib('id', 'form');
    	
          
                $this->addElement('text', 'User', array(
                    'class' => 'inputform',
            'placeholder' => 'Username',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,50))),
            
		));
        
        $this->addElement('password', 'Pass', array(
                    'class' => 'inputform',
            'placeholder' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,50))),
            
		));
                

        $this->addElement('submit', 'Accedi', array(
          
                'id' => 'registra',
            'label' => 'Accedi',
                
		
		));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
