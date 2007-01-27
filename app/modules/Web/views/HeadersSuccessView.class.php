<?php

class Web_HeadersSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->loadLayout('slot');
	}
}

?>