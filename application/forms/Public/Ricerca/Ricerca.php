<?php


class Application_Form_Public_Ricerca_Ricerca extends App_Form_Abstract{     
    
    protected  $_modelbaseModel;
     
    public function init(){
        
        $this->_modelbaseModel = new Application_Model_Modelbase();
        $cats = $this->_modelbaseModel->getCategorie();
        $categories = array();
            
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
        $this->setAttrib('id', 'form');
        
        
        $categories["Categoria"] = 'Categoria';
        
        foreach ($cats as $cat) {
            
            $categories[$cat -> Nome] = $cat->Nome;
                
        }
        
        
     
        $this->addElement('select', 'Categoria', array('required' => true,
                                                        'multiOptions'=> $categories,
                                                        'decorators' => $this->elementDecorators))
                ->setDefault('Categoria', $categories["Categoria"] );
                
        
        $this->addElement('text', 'boxricerca', array( 'id' => 'textfield',
                                                        'placeholder' => 'Ricordi alcune parole della descrizone?',
                                                        'filters' => array('StringTrim'),
                                                        'required' => false,
                                                        'validators' => array(array('StringLength',true, array(1,200)),array('regex', false, array(
                                                        'pattern'   => '/[0-9a-zA-Z\s\'.-]+/',
                                                        'messages'  =>  'Attenzione: No caratteri speciali'))),
                                                        'decorators' => $this->elementDecorators));
    
        $this->addElement('submit', 'Cerca', array('class' => 'button',
                                                   'label' => 'Cerca',
                                                   'decorators' => $this->buttonDecorators));
        
    }
}

