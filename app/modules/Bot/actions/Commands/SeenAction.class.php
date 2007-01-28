<?php

class Bot_SeenAction extends ChuckwallaBaseAction
{
	public function executeRead(AgaviRequestDataHolder $rd)
	{
		$nick = $rd->getParameter('nickname');
		$this->setAttribute('nickname', $nick);

		$result = null;

		$c = new Criteria();
		$c->add(ChuckwallaNickPeer::NICK, $nick);
		$nickObjs = $this->getContext()->getModel('ChuckwallaNickPeer')->doSelect($c);

		if(count($nickObjs)) {
			$nickObj = $nickObjs[0];
			if($identity = $nickObj->getIrcIdentity()) {
				$result['is_online'] = $identity->getIsOnline();
				$result['last_quit_time'] = $identity->getLastQuitTime();
				$result['last_quit_message'] = $identity->getLastQuitMessage();
			}
			$this->setAttribute('result', $result);
			return 'Success';
		}

		return 'UserNotFound';
	}

	public function getDefaultViewName()
	{
		return 'UserNotFound';
	}
}

?>