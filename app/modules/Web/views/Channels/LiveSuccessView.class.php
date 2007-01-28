<?php

class Web_Channels_LiveSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$c = $this->getLayer('content');
		$c->setTemplate('LiveSuccess.wrapper');
		$i = $this->prependLayer($this->createLayer('AgaviFileTemplateLayer', 'wrapped'));
		$i->setTemplate('LiveSuccess');
	}
	
	public function executeJson(AgaviRequestDataHolder $rd)
	{
		parent::setupJson($rd);
	}
}

?>