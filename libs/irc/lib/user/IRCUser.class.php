<?php
abstract class IRCUser {
	
	protected $hostname = '';
	
	public function __construct ($parameters = array()) {
		
		isset($parameters['hostname']) && $this->setHostname($parameters['hostname']);
		
	}
	
	public function getHostname () {
		
		return $this->hostname;
		
	}
	
	public function setHostname ($hostname) {
		
		$this->hostname = (string)$hostname;
		
	}
	
}
?>