<?php

class ChuckwallaBotBaseView extends ChuckwallaBaseView
{
	public function setupIrc(AgaviRequestDataHolder $rd)
	{echo "setup\n\n\n\n\n";
		$this->loadLayout();

		$ircR = $this->getContext()->getRequest()->getAttribute('irc_request', 'org.agavi.Chuckwalla.irc_params');
		$rsp = $this->getResponse();
		if(!empty($ircR['channel'])) {
			$rsp->setTarget($ircR['channel']);
		}
	}

	
	public function executeIrc(AgaviRequestDataHolder $rd)
	{
		$this->setupIrc($rd);
	}

}

?>