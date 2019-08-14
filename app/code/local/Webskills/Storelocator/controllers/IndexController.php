<?php
class Webskills_Storelocator_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Storelocator"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("storelocator", array(
                "label" => $this->__("Storelocator"),
                "title" => $this->__("Storelocator")
		   ));

      $this->renderLayout(); 
	  
    }
    
	public function MapAction() 
	{
		function parseToXML($htmlStr)
		{
			$xmlStr=str_replace('<','&lt;',$htmlStr);
			$xmlStr=str_replace('>','&gt;',$xmlStr);
			$xmlStr=str_replace('"','&quot;',$xmlStr);
			$xmlStr=str_replace("'",'&#39;',$xmlStr);
			$xmlStr=str_replace("&",'&amp;',$xmlStr);
			return $xmlStr;
		}
		
		$data = array();
		$collection = Mage::getModel('storelocator/storelocator')->getCollection();
		header("Content-type: text/xml");

		echo '<markers>';

		foreach ($collection as $record) 
				if ($record->lat != '' ){
				{
					echo '<marker ';
					echo 'name="' . parseToXML($record->name) . '" ';
					echo 'address="' . parseToXML($record->address) . '" ';
					echo 'lat="' . $record->lat . '" ';
					echo 'lng="' . $record->lng . '" ';
					echo '/>';
				}}
		echo '</markers>';die;

	}
}
