<?php

class Web_Channels_LiveAction extends ChuckwallaWebBaseAction
{
	public function execute(AgaviRequestDataHolder $rd)
	{
		$this->getContext()->getModel('ChuckwallaNickPeer');
		$chan = $this->getContext()->getModel('ChuckwallaChannelPeer')->retrieveOrCreateByName($rd->getParameter('channel'));
		$this->setAttribute('topic', $chan->getTopic());
		
		$this->setAttribute('messages', $this->getContext()->getModel('ChuckwallaMessageLogPeer')->retrieveSince($chan->getId(), $rd->getParameter('since')));
		
		return 'Success';
	}
}

?>