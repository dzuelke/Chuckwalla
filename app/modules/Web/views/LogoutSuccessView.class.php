<?php

class Web_LogoutSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->setAttribute('_title', 'Chuckwalla Bot');
	}
}

?>