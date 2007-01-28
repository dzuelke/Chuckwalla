<?php

class Web_Channels_LiveAction extends ChuckwallaWebBaseAction
{
	public function execute(AgaviRequestDataHolder $rd)
	{
		$this->setAttribute('messages', array());
	}
}

?>