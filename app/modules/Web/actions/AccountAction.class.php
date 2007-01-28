<?php

class Web_AccountAction extends ChuckwallaWebBaseAction
{

	 public function executeWrite(AgaviRequestDataHolder $rd)
	 {
		// Grab the user from the orm
		$user = $this->getContext()->getUser();
		$propelUser = $user->getPropelUser();
		// Update the User - validators ensure the data quality
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