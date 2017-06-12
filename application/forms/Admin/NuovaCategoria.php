<?php

class Application_Form_Admin_NuovaCategoria extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('nuovacategoria');
        $this->setAction('');

        $this->addElement('text','Nome',
            array(
                'label' => 'Nome categoria',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 50))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement('submit', 'submiteditsottocategoria', array(
            'label' => 'Fatto',
            'decorators' => $this->buttonDecorators,
        ));
        
        
        $this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));
    }
}

