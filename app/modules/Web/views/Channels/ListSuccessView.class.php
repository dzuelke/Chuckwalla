<?php

class Web_Channels_ListSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		
		if($rd->getParameter('is_slot', false)) {
			$this->loadLayout('slot');
			$this->getLayer('content')->setExtension('.slot.php');
		}
	}
}

?>