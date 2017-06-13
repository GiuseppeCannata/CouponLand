<?php

class Application_Form_Staff_Selezionaprodotto extends App_Form_Abstract
{
	protected $_staffModel;
    
    public function init()
    {
    	$this->_staffModel = new Application_Model_Staff();
        $this->setMethod('post');
        $this->setName('selezionapromform');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        
        
        
        $categories = array();
        $cats = $this->_staffModel->getCategorie();
        foreach ($cats as $cat) {
        	$categories[$cat -> Nome] = $cat->Nome;       
        }
        
        
        $this->addElement('select', 'Categoria', array(
            'label' => 'Categoria',
            'required' => true,
            'id' => 'selezCat',
        	'multiOptions' => $categories,
            'decorators' => $this->elementDecorators
        ));
        
        
        
        
        
        $this->addElement('select', 'Nome', array(
            'label' => 'Promozione',
            'id' => 'selezProm',
       //     'required' => true,
            
            'decorators' => $this->elementDecorators
             ));
                

            
        
        
         $this->addElement('select', 'Azienda', array(
            'label' => 'Azienda',
            'id' => 'selezAz',
           // 'required' => true,
              'options' => array(
                    'disable_inarray_validator' => true,
                    ),
            'decorators' => $this->elementDecorators
              ));
                 
                 
            
         
         $this->addElement('submit', 'modifica', array(
            'label' => 'Modifica',
             'value' => 'vaiamodificaprom',
            'decorators' => $this->buttonDecorators
        ));
         
         
          $this->addElement('submit', 'cancella', array(
            'label' => 'Cancella',
              'value' => 'elimina',
            'decorators' => $this->buttonDecorators 
        	
        ));
       
          
          $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
        
        
        
    
    
    
    }
    
    
    
    
    
    
}