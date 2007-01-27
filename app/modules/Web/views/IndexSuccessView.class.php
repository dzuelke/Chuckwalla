<?php

class Web_IndexSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);

		$this->setAttribute('_title', 'Welcome - Chuckwalla Bot');
	}
}

?>