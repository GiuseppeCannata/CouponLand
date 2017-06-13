<?php

class Application_Form_Staff_Nuovoprodotto extends App_Form_Abstract
{
	protected $_staffModel;
    
    public function init()
    {
    	$this->_staffModel = new Application_Model_Staff();
        $this->setMethod('post');
        $this->setName('addprom');
        $this->setAction(''); //la definirò in seguito
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'form');
        

        $this->addElement('text', 'Nome', array(
            'label' => 'Nome',
            'placeholder' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators
            
        ));
        
        $categories = array();
        $cats = $this->_staffModel->getCategorie();
        foreach ($cats as $cat) {
        	$categories[$cat -> Nome] = $cat->Nome;       
        }
        
        
        $this->addElement('select', 'Categoria', array(
            'label' => 'Categoria',
            'required' => true,
        	'multiOptions' => $categories,
            'decorators' => $this->elementDecorators
            
        ));
        
        
        $aziende = array();
        $aziendb = $this->_staffModel->getAziende();
        foreach ($aziendb as $azienda) {
        	$aziende[$azienda -> Nome] = $azienda->Nome;       
        }
        
        
        
        $this->addElement('select', 'Azienda', array(
            'placeholder' => 'Azienda',
            'label' => 'Azienda',
            'required' => true,
        	'multiOptions' => $aziende,
            'decorators' => $this->elementDecorators
            
        ));
        
        $this->addElement('file', 'Immagine', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/img/promozioni',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 3096000),
        			array('Extension', false, array('jpg', 'png'))),
                'decorators' => $this->fileDecorators
        			));
               
       
        
        $this->addElement('text', 'Offerta', array(
            'placeholder' => 'Offerta',
            'label' => 'Offerta',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,20))),
            'decorators' => $this->elementDecorators
            
        ));
        
        $todays_date = date("Y-m-d");
        
        $this->addElement('text', 'Inizio_promozione', array(
            'label' => 'Inizio promozione (aaaa-mm-gg)',
            'value' => $todays_date,
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('Date'),  
            'decorators' => $this->elementDecorators
            
        ));
        
       
        
         $this->addElement('text', 'Fine_promozione', array(
            'label' => 'Fine promozione (aaaa-mm-gg)',
             
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('Date'),  
            'decorators' => $this->elementDecorators
            
        ));

        $this->addElement('textarea', 'Descrizione_estesa', array(
            'placeholder' => 'Descrizione',
            'label' => 'Descizione promozione',
            'required' => true,
            'filters' => array('StringTrim'),
             'validators' => array(array('StringLength',true, array(1,5000))), 
            'decorators' => $this->elementDecorators
            
        ));

        $this->addElement('submit', 'addProm', array('class' => 'bottom',
            'label' => 'Aggiungi Promozione',
            'decorators' => $this->buttonDecorators
        ));
        
        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));
    }
}