<?php

class Web_LoginAction extends ChuckwallaWebBaseAction
{
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		try {
			$this->getContext()->getUser()->login($rd->getParamter('email'), $rd->getParameter('password'));
		} catch(Exception $e) {
			return 'Error';
		}
		
		return 'Success';
	}
	
	public function getDefaultViewName()
	{
		return "Input";
	}
}

?>