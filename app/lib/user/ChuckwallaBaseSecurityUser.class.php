<?php

class ChuckwallaBaseSecurityUser extends AgaviSecurityUser
{
	public function login($email, $password)
	{
		return false;
		$c = new Criteria();
		$c->add(ChuckwallaUserPeer::EMAIL, $email);
		$c->add(ChuckwallaUserPeer::PASSWORD, md5($password));
		$user = $this->context->getModel('ChuckwallaUserPeer')->doSelectOne($c);
		if($user) {
			$this->setAttributes($user->toArray(BasePeer::TYPE_FIELDNAME));
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