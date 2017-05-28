<?php
class Zend_View_Helper_ProductImg extends Zend_View_Helper_HtmlElement
{
	private $_attrs;
	
	public function productImg($imgFile, $attrs = false, $chiamante){
            if (empty($imgFile)) {
                    $imgFile = 'default.jpg';
            }
            if (null !== $attrs) {
                    $_attrs = $this->_htmlAttribs($attrs);
            } else {
                    $_attrs = '';
            }

            switch($chiamante){

                case 'prom':{

                    $tag = '<img src="'. $this->view->baseUrl('img/promozioni/' . $imgFile) .'" ' . $_attrs . '>';
                    break;

                }

                case 'aziende':{

                    $tag = '<img src="'. $this->view->baseUrl('img/aziende/' . $imgFile) .'" ' . $_attrs . '>';
                    break;
                }
            }
            return $tag;
	}
}