<?php
class Ameex_EasyStorecreation_Model_Observer
{
	public function handle_adminSystemConfigChangedSection(Varien_Event_Observer $observer)
    {
	
		$allStores = Mage::app()->getStores();
		foreach ($allStores as $_eachStoreId => $val)
		{
			$_storeCode[] = Mage::app()->getStore($_eachStoreId)->getCode();
		}
		$postData = Mage::app()->getRequest()->getPost();
		$string = $postData['groups']['configure']['fields'];
		foreach ($string as $str)
			{
				foreach ($str as $keyvalues => $valuelabel)
					{
						$stringvalue=$valuelabel;
					}
		     }
		$urls=$stringvalue;
		$languageoptions=Mage::app()->getLocale()->getOptionLocales();
			foreach($languageoptions as $languageoption)
				{
					$value[]=$languageoption[value];
					$label[]=$languageoption[label];

				}
		$languagecombined=array_combine($value,$label);
			foreach ($urls as $url)
				{
					$url = explode(" ",$url);
					$urls=array_flip($url);
					$new[]=array_intersect_key($languagecombined,$urls);
				}
				$newscode=array();
					foreach ($new as $newcode){
						$newcode[key($newcode)]=current($newcode);
						$lab[]=array_keys($newcode);
						$labvalue=array_values($newcode);
						$label=implode($labvalue); // here we get the locale with country code
						$string = preg_replace('/[(,)]/', '', $label);  //removing the bracket in the country name
						$newtexts=str_replace(' ', '_', $string); //replacing the locale with country name
						$newlabel[]=strtolower($newtexts); //converting the label to lowercase and assigning these value as a store name and code
						}
						foreach ($newlabel as $keys=>$newsite){
							if(!in_array($newsite,$_storeCode))
								{
									$store = Mage::getModel('core/store'); //this section creates the storeview
									$store->setCode($newsite)
									->setWebsiteId(1)
									->setGroupId(1)
									->setName($newsite)
									->setIsActive(1)
									->save();
									$newval = $lab[$keys];
									$newvals=implode($newval);
									$store->load('store_code','code');
									$storeId=$store->getStoreId();
									Mage::getModel('core/config')->saveConfig('general/locale/code',$newvals,'stores',$storeId); //this assign locale to storeview
								}
						}
		}
	public function handleproducts_adminSystemConfigChangedSection(Varien_Event_Observer $observer){
			$all = Mage::app()->getWebsites();
			foreach ($all as $eachStoreId => $vals)
			{
			$storeCode[]= Mage::app()->getWebsite($eachStoreId)->getId();
			
			}
			$post = Mage::app()->getRequest()->getPost();
			$selectval= $post['groups']['productsconfigure']['fields'];
			foreach ($selectval as $selectedval)
			{
				foreach ($selectedval as $keyselect => $valueselect)
				{
					$selectedlabels[]=$valueselect;
				}
			}
				if(in_array(1,$selectedlabels)){
					$productIds= Mage::getResourceModel('catalog/product_collection')->getAllIds();
					Mage::getModel('catalog/product_website')->addProducts($storeCode, $productIds); //this section for assigning all the products to main website
				}
			}
   public function handlecms_adminSystemConfigChangedSection(Varien_Event_Observer $observer){
	   $allStores = Mage::app()->getStores();
		foreach ($allStores as $_eachStoreId => $val)
		{
			$_storeCode[] = Mage::app()->getStore($_eachStoreId)->getId();
		}
	    $storefirst=$_storeCode[0];
		$postcms = Mage::app()->getRequest()->getPost();
		$cmsval= $postcms['groups']['cmsconfigure']['fields'];
		foreach ($cmsval as $selectedcms)
			{
			foreach ($selectedcms as $cmsselect => $valuecms)
				{
					$cmsoption[]=$valuecms;
				}
			}
			if(in_array(2,$cmsoption)){
				$cms_pages = Mage::getModel('cms/page')->getCollection()->load(); //this section for assigning cms pages
					foreach($cms_pages as $_page)
					{
						$data = $_page->getData(); 
						$url[]=$data['identifier'];
					}
					foreach ($url as $identifier){
						Mage::getModel('cms/page')->load($identifier)
						->setData('stores', 0) //array(0) represents all storeview
						->save();
					}
			}
			if(in_array(1,$cmsoption)){
				$cms_pages = Mage::getModel('cms/page')->getCollection()->load(); 
					foreach($cms_pages as $_page)
					{
						$data = $_page->getData(); 
						$url[]=$data['identifier'];
					}
					foreach ($url as $identifier){
						Mage::getModel('cms/page')->load($identifier)
						->setData('stores',$storefirst) //array (1) represents default storeview
						->save();
					}
			}
			if(in_array(4,$cmsoption)){
				$cms_blocks = Mage::getModel('cms/block')->getCollection()->load(); //this section for assigning cms blocks
					foreach($cms_blocks as $_block)
						{
							$data = $_block->getData(); 
							$urls[]=$data['identifier'];
						}
					foreach ($urls as $identifiers)
						{
							Mage::getModel('cms/block')->load($identifiers)
							->setData('stores', 0)
							->save();
						}
				}
					if(in_array(3,$cmsoption)){
				$cms_blocks = Mage::getModel('cms/block')->getCollection()->load(); 
					foreach($cms_blocks as $_block)
						{
							$data = $_block->getData(); 
							$urls[]=$data['identifier'];
						}
					foreach ($urls as $identifiers)
						{
							Mage::getModel('cms/block')->load($identifiers)
							->setData('stores', $storefirst)
							->save();
						}
				}
	}
}
