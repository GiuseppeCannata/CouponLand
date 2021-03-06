<?php 

class Application_Form_Admin_Faq extends App_Form_Abstract{
    
    
  /*   //attributi
    protected $_domanda;
    protected $_risposta;
    protected $_id;*/
    
    
    
    /*public function __construct($domanda = null ,$risposta=null,$id=null){
        
        $this->_domanda = $domanda;
        $this->_risposta = $risposta;
        $this->_id = $id;
        $this->init();
        
    }*/
    
    
    public function init(){
        
        $this->setMethod('post');
        $this->setName('faqform');
        $this->setAction('');
        $this->setAttrib('id', 'form');
        
        
        $this->addElement('hidden','Id_faq',array(
            //'value'     => $this->_id
        ));


        $this->addElement('textarea', 'Domanda', array(
                        'label' => "Domanda",
                        'filters'    => array('StringTrim'),
                        'required'   => true,
                       /* 'value'      => $this->_domanda,*/
                        'placeholder' => 'Domanda F.A.Q',
                        'validators' => array(array('StringLength',true, array(1,500))),
                       'decorators' => $this->elementDecorators));

        $this->addElement('textarea', 'Risposta', array(
                        'label' => "Risposta",
                        'filters'    => array('StringTrim'),
                        'required'   => true,
                       /* 'value'      => $this->_risposta,*/
                        'placeholder' => 'Risposta F.A.Q',
                        'validators' => array(array('StringLength',true, array(1,500))),
                        'decorators' => $this->elementDecorators));
        

        $this->addElement('submit', 'submitInserisci', array(
                          'class' => 'bottom',
                          'label' => 'Fatto',
                          'decorators' => $this->buttonDecorators));
        
	$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        		     array('Description', array('placement' => 'prepend', 'class' => 'formerror')),'Form'));
    }
   
}