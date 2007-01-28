<?php

class Web_ChannelListSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		
		/*dummy data */
		$channel = array();
		$channel['name'] = 'Agavi';
		$channel['number_of_members'] = 1;
		$channel['id'] = 1;
		$user = array('name' => 'Ross');
		$channel['users'] = array((object) $user);
		$this->setAttribute('channels', array((object)$channel));
	}
}

?>