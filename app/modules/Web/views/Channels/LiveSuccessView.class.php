<?php

class Web_Channels_LiveSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$c = $this->getLayer('content');
		$c->setTemplate('Channels/LiveSuccess.wrapper');
		$i = $this->prependLayer($this->createLayer('AgaviFileTemplateLayer', 'wrapped'));
		$i->setTemplate('Channels/LiveSuccess');
	}
	
	public function executeJson(AgaviRequestDataHolder $rd)
	{
		parent::setupJson($rd);
		$messages = $this->getAttribute('messages');
		$this->getResponse()->setParameter('json[since]', $messages[count($messages)-1]->getId());
	}
}

?>