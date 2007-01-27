<?php

class ChuckwallaBaseUser extends AgaviSecurityUser
{
	public function startup()
	{
		parent::startup();
		
		$reqData = $this->getContext()->getRequest()->getRequestData();
		
		if(!$this->isAuthenticated() && $reqData->hasCookie('autologon')) {
			$login = $reqData->getCookie('autologon');
			try {
				$this->login($login['username'], $login['password']);
			} catch(AgaviSecurityException $e) {
				$response = $this->getContext()->getController()->getGlobalResponse();
				// login didn't work. that cookie sucks, delete it.
				$response->setCookie('autologon[username]', false);
				$response->setCookie('autologon[password]', false);
			}
		}
	}

	public function login() 
	{
		$this->setAuthenticated(true);
	}

	public function logout()
	{
			$this->clearCredentials();
			$this->setAuthenticated(false);		
	}
}

?>