<?php
class Webskills_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("storelocator_form", array("legend"=>Mage::helper("storelocator")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("storelocator")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("address", "text", array(
						"label" => Mage::helper("storelocator")->__("Address"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "address",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("storelocator")->__("City"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "city",
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("storelocator")->__("State"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "state",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getStorelocatorData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getStorelocatorData());
					Mage::getSingleton("adminhtml/session")->setStorelocatorData(null);
				} 
				elseif(Mage::registry("storelocator_data")) {
				    $form->setValues(Mage::registry("storelocator_data")->getData());
				}
				return parent::_prepareForm();
		}
}
