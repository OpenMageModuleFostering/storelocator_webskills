<?php

class Webskills_Storelocator_Adminhtml_StorelocatorController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("storelocator/storelocator")->_addBreadcrumb(Mage::helper("adminhtml")->__("Storelocator  Manager"),Mage::helper("adminhtml")->__("Storelocator Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Storelocator"));
			    $this->_title($this->__("Manager Storelocator"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Storelocator"));
				$this->_title($this->__("Storelocator"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("storelocator/storelocator")->load($id);
				if ($model->getId()) {
					Mage::register("storelocator_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("storelocator/storelocator");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storelocator Manager"), Mage::helper("adminhtml")->__("Storelocator Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storelocator Description"), Mage::helper("adminhtml")->__("Storelocator Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit"))->_addLeft($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("storelocator")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Storelocator"));
		$this->_title($this->__("Storelocator"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("storelocator/storelocator")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("storelocator_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("storelocator/storelocator");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storelocator Manager"), Mage::helper("adminhtml")->__("Storelocator Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storelocator Description"), Mage::helper("adminhtml")->__("Storelocator Description"));


		$this->_addContent($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit"))->_addLeft($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						/****** Calculate Longitude and Latitude ******/
						$postfields = $this->getRequest()->getParams();
						$Address = urlencode($postfields['address'].'+'.$postfields['city'].'+'.$postfields['state']);
						$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=false&sensor=true";
						$xml = simplexml_load_file($request_url) ;
						$status = $xml->status;
						if ($status=="OK") 
						{ 
							$Lat = $xml->result->geometry->location->lat;
							$Lon = $xml->result->geometry->location->lng;
						}
						/****** End Calculate Longitude and Latitude ******/

						$model = Mage::getModel("storelocator/storelocator")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->setlat($Lat)
						->setlng($Lon)
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Storelocator was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setStorelocatorData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setStorelocatorData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("storelocator/storelocator");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("storelocator/storelocator");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'storelocator.csv';
			$grid       = $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'storelocator.xml';
			$grid       = $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
