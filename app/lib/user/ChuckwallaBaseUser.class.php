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
				$this->login($login['email'], $login['password']);
			} catch(AgaviSecurityException $e) {
				$response = $this->getContext()->getController()->getGlobalResponse();
				// login didn't work. that cookie sucks, delete it.
				$response->setCookie('autologon[email]', false);
				$response->setCookie('autologon[password]', false);
			}
		}
	}

	public function login($email, $password)
	{
		$c = new Criteria();
		$c->add(ChuckwallaUserPeer::EMAIL, $email);
		$c->add(ChuckwallaUserPeer::PASSWORD, md5($password));
		$user = $this->context->getModel('ChuckwallaUserPeer')->doSelectOne($c);
		if($user) {
			$this->setAttributes($user->toArray());
			$this->setAuthenticated(true);
		} else {
			throw new AgaviSecurityException('Login failed.');
		}
	}

	public function logout()
	{
		$this->clearCredentials();
		$this->setAuthenticated(false);
	}
}

?>