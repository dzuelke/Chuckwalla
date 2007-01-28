<?php
class IRCOutboundMessage extends IRCMessage {
	
	protected $command = null;
	protected $value = null;
	
	public function __construct ($command = null, $value = null) {
		
		$this->setCommand($command);
		$this->setValue($value);
		
	}
	
	public function setCommand ($command) {
		
		$this->command = (string)$command;
		
	}
	
	public function getCommand () {
		
		return $this->command;
		
	}
	
	public function setValue ($value) {
		
		if (!is_array($value)) {
			
			$this->value = ':' . $value;
			
		}
		elseif (count($value) === 1) {
			
			$this->value = ':' . $value[0];
			
		}
		else {
			
			$this->value = $value;
			
		}
		
	}
	
	public function setRawValue ($value) {
		
		$this->value = $value;
		
	}
	
	public function getValue () {
		
		return $this->value;
		
	}
	
	public function format () {
		
		$value = '';
		
		if (is_array($this->value)) {
			
			$value = implode(' ', array_slice($this->value, 0, -1)) . ' :' . end($this->value);
			
		}
		else {
			
			$value = $this->value;
			
		}
		
		return $this->command . ' ' . $value;
		
	}
	
}
?>