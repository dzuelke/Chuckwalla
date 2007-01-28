<?php
class IRCPeerOutboundMessage extends IRCOutboundMessage {
	
	protected $user = null;
	
	public function __construct ($command = null, IRCUser $user = null, $value = null) {
		
		parent::__construct($command, $value);
		
		$this->setUser($user);
		
	}
	
	public function setUser (IRCUser $user) {
		
		$this->user = $user;
		
	}
	
	public function getUser () {
		
		return $this->user;
		
	}
	
	public function format () {
		
		return $this->command . ' ' . $this->user->getNickname() . ' ' . $this->formatValue();
		
	}
	
}
?>