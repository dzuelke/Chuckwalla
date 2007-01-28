<?php

class Web_LoginAction extends ChuckwallaWebBaseAction
{
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		try {
			$this->getContext()->getUser()->login($rd->getParameter('email'), $rd->getParameter('password'));
		} catch(Exception $e) {
			return 'Input';
		}
		return 'Success';
	}

}

?>