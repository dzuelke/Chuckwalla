<?php

class Web_LoginInputView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->setAttribute('_title', 'Chuckwalla Bot');

		// If the user has a cookie - lets pre populate the login
		$this->setAttribute('email' ,$rd->getCookie('autologon[email]'));
		$this->setAttribute('password' ,$rd->getCookie('autologon[password]'));
	}
}

?>