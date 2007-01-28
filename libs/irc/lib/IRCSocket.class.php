<?php
class IRCSocket {
	
	protected $socket = null;
	protected $server = null;
	protected $nonBlocking = false;
	protected $streamContext = null;
	protected $handlers = array();
	protected $connection = null;
	protected $queue = null;
	
	const ACTION_OPEN = 0x01;
	const ACTION_CLOSE = 0x02;
	const ACTION_READ = 0x04;
	const ACTION_WRITE = 0x08;
	const ACTION_ERROR = 0x10;
	
	public function __construct (IRCConnection $connection, $hostname = null, $port = null, $context = null) {
		
		$this->connection = $connection;
		
		$this->server = new IRCServer(
			array(
				'hostname' => $hostname,
				'port' => $port
			)
		);
		
		$this->streamContext = $context;
		
		$this->queue = new IRCSocketQueue($this->getConnection());
		
	}
	
	public function getConnection () {
		
		return $this->connection;
		
	}
	
	public function setHostname ($hostname) {
		
		$this->getServer()->setHostname($hostname);
		
	}
	
	public function setPort ($port) {
		
		$this->getServer()->setPort($port);
		
	}
	
	public function setContext ($context) {
		
		$this->streamContext = $context;
		
	}
	
	public function setHandler ($name, IRCHandler $handler) {
		
		if (!$this->hasHandler($name) || $this->getHandler($name) !== $handler) {
			
			$this->handlers[$name] = $handler;
			$this->handlers[$name]->setSocket($this);
			$this->handlers[$name]->setConnection($this->getConnection());
			
		}
		
	}
	
	public function getHandler ($name) {
		
		return $this->hasHandler($name) ? $this->handlers[$name] : null;
		
	}
	
	public function removeHandler ($name) {
		
		if ($this->hasHandler($name)) {
			
			unset($this->handlers[$name]);
			
		}
		
	}
	
	public function hasHandler ($name) {
		
		return isset($this->handlers[$name]);
		
	}
	
	public function getServer () {
		
		return $this->server;
		
	}
	
	public function isConnected () {
		
		return is_resource($this->socket);
		
	}
	
	public function setNonBlocking ($nonBlocking) {
		
		$this->nonBlocking = (bool)$nonBlocking;
		
		if ($this->isConnected()) {
			
			stream_set_blocking($this->socket, !$nonBlocking);
			
		}
		
	}
	
	public function connect () {
		
		$hostname = 'tcp://' . $this->getServer()->getHostname() . ':' . $this->getServer()->getPort();
		
		if ($this->streamContext) {
			
			$this->socket = stream_socket_client($hostname, $errorCode, $error, 120, STREAM_CLIENT_CONNECT, $this->streamContext);
			
		}
		else {
			
			$this->socket = stream_socket_client($hostname, $errorCode, $error);
			
		}
		
		if ($this->socket) {
			
			$this->setNonBlocking($this->nonBlocking);
			$this->executeHandlers(self::ACTION_OPEN);
			
		}
		else {
			
			$this->executeHandlers(self::ACTION_ERROR, array('error_code' => $errorCode, 'error' => $error));
			$this->socket = null;
			
		}
		
	}
	
	public function disconnect () {
		
		$this->executeHandlers(self::ACTION_CLOSE);
		
		fclose($this->socket);
		$this->socket = null;
		
	}
	
	public function send ($buffer, $parameters = array()) {
		
		$this->queue->set(array_merge($parameters, array('buffer' => $buffer)));
		
	}
	
	protected function sendReal ($parameters) {
		
		fwrite($this->socket, $parameters['buffer'] . "\n");
		
		$this->executeHandlers(self::ACTION_WRITE, $parameters);
		
	}
	
	protected function executeHandlers ($action, $parameters = array()) {
		
		foreach ($this->handlers as $handler) {
			
			if (!$handler->execute($action, $parameters)) {
				
				return false;
				
			}
			
		}
		
		return true;
		
	}
	
	public function execute () {
		
		static $buffer = '';
		
		if ($send = $this->queue->execute()) {
			$this->sendReal($send);
		}
		
		if (feof($this->socket)) {
			
			$this->disconnect();
			return;
			
		}
		
		$buffer .= fgets($this->socket);
		
		if ($buffer !== '' && substr($buffer, -1) === "\n") {
			
			$this->executeHandlers(self::ACTION_READ, array('buffer' => trim($buffer)));
			$buffer = '';
			
		}
		
	}
	
}
?>