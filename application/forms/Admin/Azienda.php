<?php

class Application_Form_Admin_Azienda extends App_Form_Abstract
{
    
    protected $_id;
    protected $_Modelbase;
    protected $categorie_select;
    protected $_cat;
     
    public function __construct( $cat  , $id=null ){
        
        if ($id != null){
            
            
            
            //fai qualcosa
        }
        
        $this->_id = $id;
        
        
        $this->categorie_select = new Zend_Form_Element_Select('Tipologia');
        $this->categorie_select->setLabel('Categoria azienda: ');
        $this->categorie_select->setValue('---');
        $this->categorie_select->setDecorators($this->elementDecorators);
        $this->addElement($this->categorie_select);

        $this->init();
        
    }
    
    
    public function init(){
        
        $this->setMethod('post');
        $this->setName('formAzienda');
        $this->setAction('');
        $this->setAttrib('id', 'form');

        $this->addElement('text', 'Nome', array(
            'label' => "Nome Azienda",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Inserisci',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'Ragione_Sociale', array(
            'label' => "Ragione sociale",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Ragione sociale',
           'decorators' => $this->elementDecorators,
        ));
        

        $this->addElement('file', 'Logo_aziendale', array(
                        'label' => 'Logo',
                        'destination' => APPLICATION_PATH . '/../public/img/aziende',
                        'validators' => array( 
                                        array('Count', false, 1),
                                        array('Size', false, 102400),
                                        array('Extension', false, array('jpg', 'gif'))),
                       'decorators' => $this->fileDecorators,));

        $this->addElement('text', 'Localizzazione', array(
            'label' => "Localizzazione",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Descrizione azienda',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'Descrizione', array(
            'label' => "Descrizione azienda",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Descrizione azienda',
           'decorators' => $this->elementDecorators,
        ));
        
        
        

        $this->addElement('hidden','Id_azienda',array(
            'value'=> $this->_id
        ));

        $this->addElement('submit', 'submitInserisci', array(
                          'label' => 'Fatto',
            'decorators' => $this->buttonDecorators,
            
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));

        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));

    }
    
    
     /* riceve i dati della query getCategorie()  */

    public function AddCategorieToSelect($data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->categorie_select->addMultiOption($data[$i]['Nome'], $data[$i]['Nome']);
        }

    }
    
    
    
   

}

