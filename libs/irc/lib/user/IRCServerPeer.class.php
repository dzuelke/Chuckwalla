<?php
class IRCServerPeer implements IRCIPeer {
	
	protected $servers = array();
	
	public function find ($hostname) {
		
		return ($this->has($hostname)) ? $this->servers[$hostname] : null;
		
	}
	
	public function has ($hostname) {
		
		return isset($this->servers[$hostname]);
		
	}
	
	public function set ($server) {
		
		if ($server instanceof IRCServer) {
				
			$this->servers[$server->getHostname()] = $server;	
			
		}
		
	}
	
	public function remove ($hostname) {
		
		if ($this->has($hostname)) {
			
			unset($this->servers[$hostname]);
			return true;
			
		}
		
		return false;
		
	}
	
}
?>