<?php

class ChuckwallaIrcbotRouting extends AgaviRouting
{
	public function execute()
	{echo "\n\n\n\n\nmyRouting\n\n\n\n\n\n\n\n\n\n\n";
		$data = $this->getContext()->getRequest()->getAttribute('irc_request', 'org.agavi.Chuckwalla.irc_params');
		if($data) {
			$this->input = $data['message'];
		
/*
			$this->sources = array(
				'type' => strval($data['type'])
			);
*/
		} else {
			$this->input = uniqid();
			$this->sources = array();
		}
		
		return parent::execute();
	}
}

?>