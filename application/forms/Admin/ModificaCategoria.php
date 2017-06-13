<?php

class Application_Form_Admin_ModificaCategoria extends App_Form_Abstract
{
    protected $categorie_select;
    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('modifcacategoria');
        $this->setAttrib('id', 'form');
        $this->setAction('');
        
        $this->categorie_select = new Zend_Form_Element_Select('Nome_vecchio');
        $this->categorie_select->setLabel('Categoria: ');
        //$this->categorie_select->setValue('---');
        $this->categorie_select->setDecorators($this->elementDecorators);
        $this->addElement($this->categorie_select);
        
        $this->addElement('text','Nome_nuovo',
            array('label' => 'Nome categoria',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 50))),
                'decorators' => $this->elementDecorators
            ));

       
        $this->addElement('submit', 'submitmodifica', array(
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
