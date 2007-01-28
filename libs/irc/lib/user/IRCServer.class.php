<?php
class IRCServer extends IRCUser {
	
	protected $port = null;
	
	public function __construct ($parameters = array()) {
		
		parent::__construct($parameters);
		
		isset($parameters['port']) && $this->setPort($parameters['port']);
		
	}
	
	public function getPort () {
		
		return $this->port;
		
	}
	
	public function setPort ($port) {
		
		if (is_numeric($port) && $port >= 0 && $port < 65536) {
			
			$this->port = $port;
			
		}
		else {
			
			$this->port = null;
			
		}
		
	}
	
}
?>