<?php 
class Ameex_EasyStorecreation_Model_Blockvalue
{
	public function toOptionArray()
	{
	  return array(
            array('value'=>3, 'label'=>Mage::helper('easystorecreation')->__('No')),
            array('value'=>4, 'label'=>Mage::helper('easystorecreation')->__('Yes')));        
    
	}
}
