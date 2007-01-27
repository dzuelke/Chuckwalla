<?php

class Web_LoginErrorView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->getLayer('content')->setTemplate('LoginInput');
		$this->setAttribute('_title', 'Chuckwalla Bot');
	}
}

?>