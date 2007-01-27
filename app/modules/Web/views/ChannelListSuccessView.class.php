<?php

class Web_ChannelListSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->loadLayout('slot');
		
	}
}

?>