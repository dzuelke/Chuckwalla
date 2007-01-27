<?php

class ChuckwallaBaseUser extends AgaviSecurityUser
{
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