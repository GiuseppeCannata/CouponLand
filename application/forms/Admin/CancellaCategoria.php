<?php

class Application_Form_Admin_CancellaCategoria extends App_Form_Abstract
{
    protected $categorie_select;
    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('canccategoria');
        $this->setAttrib('id', 'form');
        $this->setAction('');
        
        $this->categorie_select = new Zend_Form_Element_Select('Nome');
        $this->categorie_select->setLabel('Categoria: ');
        //$this->categorie_select->setValue('---');
        $this->categorie_select->setDecorators($this->elementDecorators);
        $this->addElement($this->categorie_select);

       
        $this->addElement('submit', 'submitelimina', array(
                          'class' => 'bottom',
                          'label' => 'Fatto',
            'decorators' => $this->buttonDecorators,
            
        ));
        
        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));
    }
    
    public function AddCategorieToSelect($data){
        
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->categorie_select->addMultiOption($data[$i]['Id_categoria'], $data[$i]['Nome']);
        }

    }
}

