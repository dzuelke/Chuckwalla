<?php

class Web_AccountInputView extends ChuckwallaWebBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		parent::setupHtml($rd);
		$this->setAttribute('_title', 'Chuckwalla Bot');
		
		$user = $this->getContext()->getUser()->getPropelUser();
		$this->setAttribute('user', $user);
		$updated = ($rd->getParameter('updated')) ? true : false;
		$this->setAttribute('updated', $updated);
	}
}

?>