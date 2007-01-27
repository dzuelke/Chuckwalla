<?php

class Web_AccountAction extends ChuckwallaWebBaseAction
{
	 public function executeRead(AgaviRequestDataHolder $rd)
	 {
		$user = $this->getContext()->getUser();
		return "Input";
	 }
	
	// public function executeWrite(AgaviRequestDataHolder $rd)
	// {
	// }
}

?>