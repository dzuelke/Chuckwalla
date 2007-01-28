<?php
class IRCNumericInboundMessage extends IRCPeerInboundMessage {
	
	public function __construct (IRCBuffer $buffer, $parameters = array()) {
		
		parent::__construct($buffer);
		
	}
	
	public function getCommand () {
		
		return (int)$this->getBuffer()->getWord(1);
		
	}
	
	public function getValue () {
		
		return $this->getBuffer()->getWordsToLineEnd(3);
		
	}
	
}
?>