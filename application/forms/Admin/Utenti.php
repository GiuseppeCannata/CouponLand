<?php

class Application_Form_Admin_Utenti extends App_Form_Abstract
{
    protected $_Modeladmin;
    public function init()
    {
        $this->setMethod('post');
        $this->setName('utentiform');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'statistiche');
      //  $this->setDescription('Scegli la promozione che ti interessa:');
        
      $this->_Modeladmin = new Application_Model_Admin();
       $users = $this->_Modeladmin->allUsersfirstlevel();
      
        $allusers = array();
        $allusers ['Seleziona'] = '-- Seleziona --';
       
       foreach ($users as $user) {
        	$allusers[$user -> Id_user] = $user->User;       
        }
      
        
         $this->addElement('select', 'User', array(
            'label' => 'Scegli la promozione che ti interessa',
            'id' => 'user',
            'required' => true,
            'multiOptions' => $allusers,
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