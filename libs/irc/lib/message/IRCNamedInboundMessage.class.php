<?php
class IRCNamedInboundMessage extends IRCPeerInboundMessage {
	
	protected $value = '';
	
	public function __construct (IRCBuffer $buffer, $parameters = array()) {
		
		parent::__construct($buffer, $parameters);
		
		$this->value = substr($buffer->getWordsToLineEnd(3), 1);
		
	}
	
	public function getCommand () {
		
		return $this->getBuffer()->getWord(1);
		
	}
	
	public function getValue () {
		
		return $this->value;
		
	}
	
}
?>