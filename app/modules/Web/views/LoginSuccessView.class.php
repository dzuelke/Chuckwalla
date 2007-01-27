<?php

class Web_LoginSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		
		// redirect here in case the user was forwarded to the login form while trying to access a secure action
	}
}

?>