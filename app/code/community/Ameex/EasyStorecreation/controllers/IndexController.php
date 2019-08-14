<?php 
class Ameex_EasyStorecreation_IndexController extends Mage_Core_Controller_Front_Action{
public function indexAction(){
	$this->loadLayout();
	$this->renderLayout();
$allStores = Mage::app()->getStores();
		foreach ($allStores as $_eachStoreId => $val)
		{
			$_storeCode[] = Mage::app()->getStore($_eachStoreId)->getId();
		}
	print_r($_storeCode[0]);
	}

}
