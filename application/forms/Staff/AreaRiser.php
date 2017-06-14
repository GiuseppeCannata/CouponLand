<?php

class Application_Form_Staff_AreaRiser extends App_Form_Abstract
{
    
    protected  $_ModelUser;
    protected  $etaposs = array();
    protected  $_authService;


    public function init(){
        
                $this->_ModelUser = new Application_Model_User();
                $this->_authService = new Application_Service_Auth();
                $this->setMethod('post');
		$this->setName('registra');
		$this->setAction('');
                $this->setAttrib('id', 'form');
                $this->setDescription('Area riservata: puoi modificare i tuoi dati nei seguenti campi!');
                
                
               //Array per la select età ( dai 18 ai 120 anni)
                $etaposs[18] = 18;
                for ($i = 19; $i < 121; $i++){
                    $etaposs[$i] = $etaposs[$i-1] + 1;
                    }
		
                
                
                $this->addElement('text', 'User', array('class' => 'inputform',
                                                        'label' => 'Username',
                                                        'value' => $this->_authService->getIdentity()->User,         
                                                        'filters' => array('StringTrim'),
                                                        'required' => true,
                                                        'validators' => array(array('StringLength',true, array(1,50))),));
                
               
                $this->addElement('password', 'Pass', array(
                    'class' => 'inputform',
            'label' => 'Nuova password',
             'value' => $this->_authService->getIdentity()->Pass,  
            'filters' => array('StringTrim'),
            'required' => false ));
                
                
              $this->addElement('text', 'Nome', array(
                  'class' => 'inputform',
            'label' => 'Nome',
            'value' => $this->_authService->getIdentity()->Nome,   
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,20))),
           
		));
              
              
                $this->addElement('text', 'Cognome', array(
                    'class' => 'inputform',
            'label' => 'Cognome',
            'value' => $this->_authService->getIdentity()->Cognome,
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,20))),
            
		));
                
             
		
                
                $this->addElement('text', 'Email', array(
                    'class' => 'inputform',
            'label'      => 'Email',
            'value' => $this->_authService->getIdentity()->Email,
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
                
                
               
                $this->addElement('text', 'Telefono', array('class' => 'inputform',
            'label' => 'Numero di telefono',
            'value' => $this->_authService->getIdentity()->Telefono,
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('Float', true, array('locale' => 'en_US')),array('StringLength',true, array(1,10))),
            
		));  
                
                   $this->addElement('select', 'Eta', array(
            
            'label' => 'Età',
            
            'required' => true,
            'multiOptions'=> $etaposs,
            
		))
                         ->setDefault('Eta', $this->_authService->getIdentity()->Eta );
                
                   
                
                $this->addElement('select', 'Genere', array(
           
            'label' => 'Genere',
            'required' => true,
            'multiOptions'=> $genere = array('M' => 'M','F' => 'F'),
                    ))
                        ->setDefault('Genere', $this->_authService->getIdentity()->Genere );
            
                
                
                $this->addElement('submit', 'registra', array(
          
                'id' => 'registra',
            'label' => 'Modifica',
                
		
		));
    
                
                $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));    
                
        }
       
}


