<?php

class Application_Form_Public_Utenti_Login extends App_Form_Abstract{
    
    public function init(){
            
        $this->setMethod('post');
        $this->setName('registraform');
        $this->setAction('');
        
    	
          
        $this->addElement('text', 'User', array('class' => 'inputform',
                                                'placeholder' => 'Username',
                                                'filters' => array('StringTrim'),
                                                'required' => true,
                                                'validators' => array(array('StringLength',true, array(1,50)),
                                                                array('regex', false, array(
                                                'pattern'   => '/[0-9a-zA-Z\s\']+/',
                                                'messages'  =>  'Attenzione: No caratteri speciali')))));
        
        $this->addElement('password', 'Pass', array('class' => 'inputform',
                                                    'placeholder' => 'Password',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('StringLength',true, array(1,50)),
                                                                array('regex', false, array(
                                                    'pattern'   => '/[0-9a-zA-Z\s\']+/',
                                                    'messages'  =>  'Attenzione: No caratteri speciali')))));
                

        $this->addElement('submit', 'Accedi', array('id' => 'registra',
                                                    'label' => 'Accedi'));

        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));
        
    }
}
