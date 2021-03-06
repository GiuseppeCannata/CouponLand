<?php

class Application_Form_Admin_ModificaUtente extends App_Form_Abstract {
    

    protected  $etaposs = array();
   


    public function init(){
        
                $this->setMethod('post');
		$this->setName('modificautente');
		$this->setAction('');
                $this->setAttrib('id', 'form');
               
                //Array per la select età ( dai 18 ai 120 anni)
                $etaposs[18] = 18;
                for ($i = 19; $i < 121; $i++){
                    $etaposs[$i] = $etaposs[$i-1] + 1;
                }
		
                
                
                $this->addElement('text', 'User', array('label' => 'Username', 
                                                        'placeholder' => 'Username',
                                                        'decorators' => $this->elementDecorators,
                                                        'filters' => array('StringTrim'),
                                                        'required' => true,
                                                        'validators' => array(array('StringLength',true, array(1,50))),
                                                        /*'decorators' => $this->elementDecorators,*/));
                
               
                $this->addElement('password', 'Pass', array(
                                  'label' => 'Nuova password', 
                                  'decorators' => $this->elementDecorators,
                                  'placeholder' => 'Password',
                                  'filters' => array('StringTrim'),
                                  'required' => false ));
                
                
                $this->addElement('text', 'Nome', array('label' => 'Nome',
                                  'placeholder'=> 'Nome',
                                   'decorators' => $this->elementDecorators,
                                    'filters' => array('StringTrim'),
                                    'required' => true,
                                    'validators' => array(array('StringLength',true, array(1,20))),));
              
                $this->addElement('text', 'Cognome', array(
                                   'label' => 'Cognome',
                                   'placeholder'=> 'Cognome',
                                   'decorators' => $this->elementDecorators,
                                   'filters' => array('StringTrim'),
                                   'required' => true,
                                   'validators' => array(array('StringLength',true, array(1,20)))));
                
                $this->addElement('text', 'Email', array(
                                   'label' => 'Email',
                                   'placeholder'=> 'Email',
                                   'decorators' => $this->elementDecorators,
                                   'required'   => true,
                                   'filters'    => array('StringTrim'),
                                   'validators' => array('EmailAddress',),));
                
                
                $this->addElement('text', 'Telefono', array(
                                'label' => 'Numero di telefono',
                                'placeholder'=> 'Telofono',
                                'decorators' => $this->elementDecorators,
                                'filters' => array('StringTrim'),
                                'required' => true,
                                'validators' => array(array('Float', true, 
                                array('locale' => 'en_US')),array('StringLength',true, array(1,10)))));  
                
                $this->addElement('select', 'Eta', array('label' => 'Età',
                                  'decorators' => $this->elementDecorators,
                                  'required' => true,
                                  'multiOptions'=> $etaposs));
                
                $this->addElement('select', 'Genere', array(
                                  'label' => 'Genere',
                                  'decorators' => $this->elementDecorators,
                                  'required' => true,
                                  'multiOptions'=> $genere = array('M' => 'M','F' => 'F'),));
                                   
            
                
                
                $this->addElement('submit', 'registra', array('id' => 'registra',
                                  'class' => 'bottom',
                                  'label' => 'Fatto',
                                  'decorators' => $this->buttonDecorators));
                
                $this->addElement('hidden','Id_user',array(
                /*  'value'=> $this->_id*/
                ));

                $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));   
                
     }
       
}

