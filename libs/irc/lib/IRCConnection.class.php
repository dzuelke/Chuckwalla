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
				'nickname' => $parameters['client.nickname'][0],
				'username' => $parameters['client.username'],
				'realname' => $parameters['client.realname'],
				'hostname' => isset($parameters['client.hostname']) ? $parameters['client.hostname'] : ''
			)
		);
		
		$parameters['classes.socket'] = isset($parameters['classes.socket']) ? $parameters['classes.socket'] : 'IRCSocket';
		$parameters['classes.protocol_handlers'] = isset($parameters['classes.protocol_handlers']) ? $parameters['classes.protocol_handlers'] : array('_' => 'IRCProtocolHandler');
		$parameters['classes.server_peer'] = isset($parameters['classes.server_peer']) ? $parameters['classes.server_peer'] : 'IRCServerPeer';
		$parameters['classes.client_peer'] = isset($parameters['classes.client_peer']) ? $parameters['classes.client_peer'] : 'IRCClientPeer';
		
		if (isset($parameters['client.hostname'])) {
			$context = stream_context_create(array('socket' => array('bindto' => $parameters['client.hostname'] . ':0')));
			$this->socket = new $parameters['classes.socket']($this, $parameters['server.hostname'], $parameters['server.port'], $context);
		}
		else {
			$this->socket = new $parameters['classes.socket']($this, $parameters['server.hostname'], $parameters['server.port']);	
		}
		
		foreach ($parameters['classes.protocol_handlers'] as $name => $class) {
			$this->socket->setHandler($name, new $class());
		}
		
		$this->serverPeer = new $parameters['classes.server_peer']($this);
		
		$this->clientPeer = new $parameters['classes.client_peer']($this);
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
	
	public function getParameter ($name, $default = '') {
		
		return $this->hasParameter($name) ? $this->parameters[$name] : $default;
		
	}
	
	public function hasParameter ($name) {
		
		return isset($this->parameters[$name]);
		
	}
	
	public function getClient () {
		
		return $this->self;
		
	}
	
	public function getDefaultHandler () {
		
		return $this->getSocket()->hasHandler('_') ? $this->getSocket()->getHandler('_') : null;
		
	}
	
}
?>