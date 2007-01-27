<?php

class Web_AccountAction extends ChuckwallaWebBaseAction
{
	 public function executeRead(AgaviRequestDataHolder $rd)
	 {
		return "Input";
	 }
	
	 public function executeWrite(AgaviRequestDataHolder $rd)
	 {
		$user = $this->getContext()->getUser();
		$propelUser = $user->getPropelUser();
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