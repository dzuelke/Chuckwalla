<?php
abstract class IRCPeerInboundMessage extends IRCInboundMessage {
	
	protected $user = null;
	protected $target = null;
	
	public function __construct (IRCBuffer $buffer, $parameters = array()) {
		
		parent::__construct($buffer, $parameters);
		
		$origin = $buffer->getWord(0);
		if (strpos($origin, '@') === FALSE) {
			
			$serverName = substr($origin, 1);
			
			$this->user = $buffer->getSourceConnection()->getServerPeer()->find($serverName);
			if (!$this->user) {
				
				$this->user = $buffer->getSourceConnection()->getServerPeer()->set(
					new IRCServer(
						array(
							'hostname' => $serverName
						)
					)
				);
				
			}
			
		}
		else {
			
			$point = strpos($origin, '!');
			$nickname = substr($origin, 1, $point - 1);
			
			$this->user = $buffer->getSourceConnection()->getClientPeer()->findByNickname($nickname);
			if (!$this->user) {
				
				$at = strpos($origin, '@');
				$username = substr($origin, $point, $at - 1);
				$hostname = substr($origin, $at);
				
				$this->user = $buffer->getSourceConnection()->getClientPeer()->set(
					new IRCClient(
						array(
							'nickname' => $nickname,
							'username' => $username,
							'hostname' => $hostname
						)
					)
				);
				
			}
			
		}
		
	}
	
	public function getUser () {
		
		return $this->user;
		
	}
	
}
?>