<?php 
class Ameex_EasyStorecreation_Model_Value
{
	public function toOptionArray()
	{
	  return array(
            array('value'=>1, 'label'=>Mage::helper('easystorecreation')->__('Yes')),
            array('value'=>2, 'label'=>Mage::helper('easystorecreation')->__('No')));        
    
	}
}
