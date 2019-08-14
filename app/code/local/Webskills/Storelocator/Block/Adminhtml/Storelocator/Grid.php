<?php

class Webskills_Storelocator_Block_Adminhtml_Storelocator_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("storelocatorGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("storelocator/storelocator")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("storelocator")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("storelocator")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("address", array(
				"header" => Mage::helper("storelocator")->__("Address"),
				"index" => "address",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("storelocator")->__("City"),
				"index" => "city",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("storelocator")->__("State"),
				"index" => "state",
				));
				$this->addColumn("lat", array(
				"header" => Mage::helper("storelocator")->__("Latitude"),
				"index" => "lat",
				));
				$this->addColumn("lng", array(
				"header" => Mage::helper("storelocator")->__("Longitude"),
				"index" => "lng",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_storelocator', array(
					 'label'=> Mage::helper('storelocator')->__('Remove Storelocator'),
					 'url'  => $this->getUrl('*/adminhtml_storelocator/massRemove'),
					 'confirm' => Mage::helper('storelocator')->__('Are you sure?')
				));
			return $this;
		}
			

}