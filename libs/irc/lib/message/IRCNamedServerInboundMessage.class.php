<?php
class IRCNamedServerInboundMessage extends IRCInboundMessage {
	
	public function __construct (IRCBuffer $buffer, $parameters = array()) {
		
		parent::__construct($buffer, $parameters);
		
	}
	
	public function getCommand () {
		
		return $this->getBuffer()->getWord(0);
		
	}
	
	public function getValue () {
		
		return $this->getBuffer()->getWordsToLineEnd(1);
		
	}
	
}
?>