<?php

class Application_Form_Public_utenti_Registra extends App_Form_Abstract{
    
    protected  $_modelbaseModel;
    protected  $etaposs = array();
    
    
    public function init(){
        
        $this->_modelbaseModel = new Application_Model_Modelbase();

        $this->setMethod('post');
        $this->setName('registraform');
        $this->setAction('');
        


       //Array per la select età ( dai 18 ai 120 anni)
        $etaposs['Età'] = 'Età';
        $etaposs[18] = 18;
        for ($i = 19; $i < 121; $i++){
            
            $etaposs[$i] = $etaposs[$i-1] + 1;
            
        }
            
        $this->addElement('text', 'User', array( 'class' => 'inputform',
                                                'placeholder' => 'Username',
                                                'id' => 'insertuser',
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
        
        $this->addElement('text', 'Nome', array('class' => 'inputform',
                                                'placeholder' => 'Nome',
                                                'filters' => array('StringTrim'),
                                                'required' => true,
                                                'validators' => array(array('StringLength',true, array(1,20)),array('regex', false, array(
                                                'pattern'   => '/[0-9a-zA-Z\s\']+/',
                                                'messages'  =>  'Attenzione: No caratteri speciali')))));


        $this->addElement('text', 'Cognome', array('class' => 'inputform',
                                                    'placeholder' => 'Cognome',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('StringLength',true, array(1,20)),array('regex', false, array(
                                                    'pattern'   => '/[0-9a-zA-Z\s\']+/',
                                                    'messages'  =>  'Attenzione: No caratteri speciali')))));

        $this->addElement('text', 'Email', array('class' => 'inputform',
                                                'placeholder'  => 'Email',
                                                'required'   => true,
                                                'filters'    => array('StringTrim'),
                                                'validators' => array('EmailAddress')));

        $this->addElement('text', 'Telefono', array('class' => 'inputform',
                                                    'placeholder' => 'Numero di telefono',
                                                    'filters' => array('StringTrim'),
                                                    'required' => true,
                                                    'validators' => array(array('Float', true, array('locale' => 'en_US')),array('StringLength',true, array(1,10)))));  

        $this->addElement('select', 'Eta', array('title' => 'Età',
                                                'required' => true,
                                                'multiOptions'=> $etaposs));


        $this->addElement('select', 'Genere', array('title' => 'Genere',
                                                    'required' => true,
                                                    'multiOptions'=> $genere = array('Genere' =>'Genere', 'M' => 'M','F' => 'F')));
       
        $this->addElement('submit', 'registra', array('id' => 'registra',
                                                      'label' => 'Registrati'));


        $this->setDecorators( array('FormElements', array('HtmlTag', array('tag' => 'table')),
                             array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));    

    }

}


