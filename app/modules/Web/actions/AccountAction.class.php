<?php

class Web_AccountAction extends ChuckwallaWebBaseAction
{
	 public function executeRead(AgaviRequestDataHolder $rd)
	 {
		return "Input";
	 }
	
	 public function executeWrite(AgaviRequestDataHolder $rd)
	 {
		// Grab the user from the orm
		$user = $this->getContext()->getUser();
		$propelUser = $user->getPropelUser();
		// Update the User - validators handle the data
		$propelUser->fromArray($rd->getParameters(), BasePeer::TYPE_FIELDNAME);
		$rd->setParameter('updated', 'true');
		return "Input";
	 }
	
	public function isSecure()
	{
		return true;
	}
}

?>