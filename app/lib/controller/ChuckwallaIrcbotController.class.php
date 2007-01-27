<?php

class ChuckwallaIrcbotController extends AgaviController
{
	public function dispatch(AgaviRequestDataHolder $arguments = null)
	{
		$chatModel = $this->getContext()->getModel('ChuckwallaChatClient');
		$chatModel->connectLoop();
	}


}

?>