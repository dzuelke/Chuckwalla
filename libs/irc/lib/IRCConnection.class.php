<?php
class IRCConnection {
	
	protected $socket = null;
	protected $clientPeer = null;
	protected $serverPeer = null;
	
	protected $parameters = array();
	
	protected $self = null;
	
	public function __construct ($parameters = array()) {
		
		$self = new IRCClient(
			array(
				'nickname' => $parameters['client']['nickname'][0],
				'username' => $parameters['client']['username'],
				'realname' => $parameters['client']['realname'],
				'hostname' => isset($parameters['client']['hostname']) ? $parameters['client']['hostname'] : ''
			)
		);
		
		if (!isset($parameters['classes'])) {
			$parameters['classes'] = array();
		}
		
		$parameters['classes']['socket'] = isset($parameters['classes']['socket']) ? $parameters['classes']['socket'] : 'IRCSocket';
		if (!isset($parameters['classes']['protocol_handlers'])) {
			$parameters['classes']['protocol_handlers'] = array('protocol' => 'IRCProtocolHandler');
		}
		$parameters['classes']['server_peer'] = isset($parameters['classes']['server_peer']) ? $parameters['classes']['server_peer'] : 'IRCServerPeer';
		$parameters['classes']['client_peer'] = isset($parameters['classes']['client_peer']) ? $parameters['classes']['client_peer'] : 'IRCClientPeer';
		
		$this->socket = new $parameters['classes']['socket']($this, $parameters['server']['hostname'], $parameters['server']['port']);
		
		foreach ($parameters['classes']['protocol_handlers'] as $name => $class) {
			$this->socket->setHandler($name, new $class());
		}
		
		$this->serverPeer = new $parameters['classes']['server_peer']($this);
		
		$this->clientPeer = new $parameters['classes']['client_peer']($this);
		$this->clientPeer->set($self);
		
		$this->parameters = $parameters;
		
	}
	
	public function getServerPeer () {
		
		return $this->serverPeer;
		
	}
	
	public function getClientPeer () {
		
		return $this->clientPeer;
		
	}
	
	public function getSocket () {
		
		return $this->socket;
		
	}
	
	public function getParameters () {
		
		return $this->parameters;
		
	}
	
}
?>