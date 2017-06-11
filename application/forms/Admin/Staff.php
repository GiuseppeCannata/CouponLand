<?php

class Application_Form_Admin_Staff extends App_Form_Abstract{
    
   
    protected  $etaposs = array();
    
    
    public function init(){
        
        $this->setMethod('post');
        $this->setName('staff');
        $this->setAction('');
        $this->setAttrib('id', 'form');


       //Array per la select età ( dai 18 ai 120 anni)
        $etaposs[18] = 18;
        for ($i = 19; $i < 121; $i++){
            
            $etaposs[$i] = $etaposs[$i-1] + 1;
            
        }
            
        $this->addElement('text', 'User', array( 'class' => 'inputform',
                                                'placeholder' => 'Username',
                                                'decorators' => $this->elementDecorators,
                                                'label' => 'Username',
                                                'filters' => array('StringTrim'),
                                                'required' => true,
                                                'validators' => array(array('StringLength',true, array(1,50)))));


        $this->addElement('password', 'Pass', array('class' => 'inputform',
                                                    'placeholder' => 'Password',
            'decorators' => $this->elementDecorators,
                                                     'label' => 'Password',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('StringLength',true, array(1,50)))));
        
        $this->addElement('text', 'Nome', array('class' => 'inputform',
                                                'placeholder' => 'Nome',
            'decorators' => $this->elementDecorators,
                                                'label' => 'Nome',
                                                'filters' => array('StringTrim'),
                                                'required' => true,
                                                'validators' => array(array('StringLength',true, array(1,20)))));


        $this->addElement('text', 'Cognome', array('class' => 'inputform',
                                                    'placeholder' => 'Cognome',
            'decorators' => $this->elementDecorators,
                                                    'label' => 'Cognome',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('StringLength',true, array(1,20)))));

        $this->addElement('text', 'Email', array('class' => 'inputform',
                                                'placeholder'  => 'Email',
            'decorators' => $this->elementDecorators,
                                                'label' => 'Email',
                                                'required'   => true,
                                                'filters'    => array('StringTrim'),
                                                'validators' => array('EmailAddress')));

        $this->addElement('text', 'Telefono', array('class' => 'inputform',
                                                    'placeholder' => 'Numero di telefono',
            'decorators' => $this->elementDecorators,
                                                     'label' => 'Numero di Tel.',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('Float', true, array('locale' => 'en_US')),array('StringLength',true, array(1,10)))));  

        $this->addElement('select', 'Eta', array('label' => 'Età',
            'decorators' => $this->elementDecorators,
                                                'required' => true,
                                                'multiOptions'=> $etaposs));


        $this->addElement('select', 'Genere', array('label' => 'Genere',
            'decorators' => $this->elementDecorators,
                                                    'required' => true,
                                                    'multiOptions'=> $genere = array('M' => 'M','F' => 'F')));
       
        $this->addElement('submit', 'registra', array('class' => 'bottom',
                                                      'label' => 'Fatto',
             'decorators' => $this->buttonDecorators,));


        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));   

    }

}

