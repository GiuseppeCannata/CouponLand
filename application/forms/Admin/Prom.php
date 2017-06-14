<?php

class Application_Form_Admin_Prom extends App_Form_Abstract
{
    protected $_Modeladmin;
    public function init()
    {
        $this->setMethod('post');
        $this->setName('promform');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'statistiche');
      //  $this->setDescription('Scegli la promozione che ti interessa:');
        
      $this->_Modeladmin = new Application_Model_Admin();
       $proms = $this->_Modeladmin->promTutte();
      
        $allprom = array();
        $allprom ['Seleziona'] = '-- Seleziona --';
       
       foreach ($proms as $prom) {
        	$allprom[$prom -> Id_promozione] = $prom->Nome;       
        }
      
        
         $this->addElement('select', 'Nome', array(
            'label' => 'Scegli la promozione che ti interessa',
            'id' => 'prom',
            'required' => true,
            'multiOptions' => $allprom,
            'decorators' => $this->elementDecorators
        ));
         
         
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    
    }
    
      
    
    
}
