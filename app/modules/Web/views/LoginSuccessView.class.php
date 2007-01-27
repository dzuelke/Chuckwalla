<?php

class Web_LoginSuccessView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);

		$usr = $this->getContext()->getUser();
		$res = $this->getResponse();

		// set the autologon cookie if requested
		if($rd->hasParameter('remember')) {
			$res->setCookie('autologon[username]', $rd->getParameter('username'), 60*60*24*14);
			$res->setCookie('autologon[password]', $rd->getParameter('password'), 60*60*24*14);
		}

		if($usr->hasAttribute('redirect', 'org.agavi.Chuckwalla.login')) {
			$this->getResponse()->setRedirect($usr->removeAttribute('redirect', 'org.agavi.Chuckwalla.login'));
			return;
		}

	}
}

?>