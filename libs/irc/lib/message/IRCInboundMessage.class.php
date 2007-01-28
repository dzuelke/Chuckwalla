<?php
abstract class IRCInboundMessage extends IRCMessage {
	
	protected $buffer = array();
	
	public function __construct (IRCBuffer $buffer, $parameters = array()) {
		
		$this->buffer = $buffer;
		
	}
	
	public function getBuffer () {
		
		return $this->buffer;
		
	}
	
}
?>