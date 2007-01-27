<?php

class Web_LogoutAction extends ChuckwallaWebBaseAction
{
 	public function execute(AgaviRequestDataHolder $rd)
	{
		$this->getContext()->getUser()->logout();
		return 'Success';
	}
}

?>