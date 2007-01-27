<?php

class ChuckwallaWebBaseUser extends ChuckwallaBaseUser
{
	public function startup()
	{
		parent::startup();
		
		$reqData = $this->getContext()->getRequest()->getRequestData();
		
		if(!$this->isAuthenticated() && $reqData->hasCookie('autologon')) {
			
			$login = $reqData->getCookie('autologon');
			
			try {
				
				$this->login($login['email'], $login['password']);
				
			} catch(AgaviSecurityException $e) {
				$response = $this->getContext()->getController()->getGlobalResponse();
				// login didn't work. that cookie sucks, delete it.
				$response->setCookie('autologon[email]', false);
				$response->setCookie('autologon[password]', false);
			}
		}
	}
}

?>