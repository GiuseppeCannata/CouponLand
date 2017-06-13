<?php

class Application_Form_Admin_Azienda extends App_Form_Abstract
{
   
    protected $categorie_select;
    
     
  /*  public function __construct( $azienda = null ){
        
        $this->categorie_select = new Zend_Form_Element_Select('Tipologia');
        $this->categorie_select->setLabel('Tipologia: ');
        
        if ($azienda != null){
            
            $this->_nome = $azienda['Nome'];
            $this->_ragione = $azienda['Ragione_sociale'];
            $this->_logo = $azienda['Logo_aziendale'];
            $this->_localizzazione = $azienda['Localizzazione'];
            $this->_descrizione = $azienda['Descrizione'];
            $this->_id = $azienda['Id_azienda'];
            
            $this->categorie_select->setValue($azienda['Tipologia']);
            
        }
        else{
            $this->categorie_select->setValue('---');
        }
        
        $this->categorie_select->setDecorators($this->elementDecorators);
        $this->addElement($this->categorie_select);

        $this->init();
        
    }
    */
    
    public function init(){
        
        $this->setMethod('post');
        $this->setName('formAzienda');
        $this->setAttrib('id', 'form');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAction('');
        
        $this->categorie_select = new Zend_Form_Element_Select('Tipologia');
        $this->categorie_select->setLabel('Tipologia: ');
        $this->categorie_select->setValue('---');
        $this->categorie_select->setDecorators($this->elementDecorators);
        $this->addElement($this->categorie_select);
        
       
        

        $this->addElement('text', 'Nome', array(
            'label' => "Nome Azienda",
            'filters' => array('StringTrim'),
            'required' => true,
            /*'value' => $this->_nome,*/
            'placeholder' => 'Inserisci',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'Ragione_sociale', array(
            'label' => "Ragione sociale",
            'filters' => array('StringTrim'),
            'required' => true,
           /* 'value' => $this->_ragione,*/
            'placeholder' => 'Ragione sociale',
           'decorators' => $this->elementDecorators,
        ));
        

        $this->addElement('file', 'Logo_aziendale', array(
                        'label' => 'Logo',
                        'required' => false,
                        'destination' => APPLICATION_PATH . '/../public/img/aziende',
                        'validators' => array( 
                                        array('Count', false, 1),
                                        array('Size', false, 102400),
                                        array('Extension', false, array('jpg', 'gif','png'))),
                       'decorators' => $this->fileDecorators,));

        $this->addElement('text', 'Localizzazione', array(
            'label' => "Localizzazione",
            'filters' => array('StringTrim'),
            'required' => true,
           /* 'value' => $this->_localizzazione,*/
            'placeholder' => 'Localizzazione',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'Descrizione', array(
            'label' => "Descrizione azienda",
            'filters' => array('StringTrim'),
            'required' => true,
           /* 'value' => $this->_descrizione,*/
            'placeholder' => 'Descrizione azienda',
           'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('hidden','Id_azienda',array(
          /*  'value'=> $this->_id*/
        ));

        $this->addElement('submit', 'submitInserisci', array(
                          'class' => 'bottom',
                          'label' => 'Fatto',
            'decorators' => $this->buttonDecorators,
            
        ));
        
       
        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));

    }
    
    
     /* riceve i dati della query getCategorie()  */

    public function AddCategorieToSelect($data){
        
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->categorie_select->addMultiOption($data[$i]['Nome'], $data[$i]['Nome']);
        }

    }
}

