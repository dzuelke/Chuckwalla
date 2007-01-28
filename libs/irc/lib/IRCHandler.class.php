<?php
abstract class IRCHandler {
	
	private $socket;
	private $connection;
	
	public function setConnection (IRCConnection $connection) {
		
		$this->connection = $connection;
		
	}
	
	public function getConnection () {
		
		return $this->connection;
		
	}
	
	public function setSocket (IRCSocket $socket) {
		
		$this->socket = $socket;
		
	}
	
	public function getSocket () {
		
		return $this->socket;
		
	}
	
	abstract public function execute ($action, $parameters);
	
}
?>