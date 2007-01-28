<?php
class IRCClientPeer implements IRCIPeer {
	
	protected $clients = array();
	
	public function find ($nickname) {
		
		return $this->findByNickname($nickname);
		
	}
	
	public function findByNickname ($nickname) {
		
		return ($this->hasByNickname($nickname)) ? $this->clients[$nickname] : null;
		
	}
	
	public function has ($nickname) {
		
		return $this->hasByNickname($nickname);
		
	}
	
	public function hasByNickname ($nickname) {
		
		return isset($this->clients[$nickname]);
		
	}
	
	public function set ($client) {
		
		if ($client instanceof IRCClient) {
			
			$this->clients[$client->getHostname()] = $client;
			
		}
		
	}
	
	public function change ($nickname, $client) {
		
		$this->removeByNickname($nickname);
		$this->set($client);
		
	}
	
	public function remove ($nickname) {
		
		return $this->removeByNickname($nickname);
		
	}
	
	public function removeByNickname ($nickname) {
		
		if ($this->hasByNickname($nickname)) {
			
			unset($this->clients[$nickname]);
			return true;
			
		}
		
		return false;
		
	}
	
}
?>