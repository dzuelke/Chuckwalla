<?php

class ChuckwallaIrcbotRouting extends AgaviRouting
{
	public function execute()
	{
		$data = $this->getContext()->getRequest()->getAttribute('irc_request', 'org.agavi.Chuckwalla.irc_params');
		if($data) {
			$this->input = $data['message'];
		} else {
			$this->input = uniqid();
			$this->sources = array();
		}
		
		return parent::execute();
	}
}

?>