<?php
class IRCProtocolHandler extends IRCHandler {
	
	protected $callbacks = array(
		IRCSocket::ACTION_OPEN => array(),
		IRCSocket::ACTION_READ => array(),
		IRCSocket::ACTION_WRITE => array(),
		IRCSocket::ACTION_CLOSE => array(),
		IRCSocket::ACTION_ERROR => array()
	);
	
	public function __construct () {
		
		$this->bind(IRCSocket::ACTION_OPEN, '_handle_open', array(), array(array($this, 'handleOpen')));
		$this->bind(IRCSocket::ACTION_READ, '_handle_ping', array(IRCProtocol::SERVER_MESSAGE_PING => '##'), array(array($this, 'handlePing')));
		
	}
	
	public function handleOpen (IRCConnection $connection, $parameters) {
		
		$nickname = $connection->getParameter('client.nickname');
		$this->send(new IRCOutboundMessage('NICK', $nickname[0]));
		$this->send(new IRCOutboundMessage('USER',
			array(
				$connection->getParameter('client.username'),
				$connection->getParameter('server.hostname'),
				$connection->getParameter('client.hostname', 'unknown'),
				$connection->getParameter('client.realname')
			)
		));
		
		$this->bind(IRCSocket::ACTION_READ, '_handle_nick_error', array(IRCProtocol::ERROR_NICKNAMEINUSE => '##'), array(array($this, 'handleNickError')));
		$this->bind(IRCSocket::ACTION_READ, '_handle_welcome', array(IRCProtocol::REPLY_WELCOME => '##'), array(array($this, 'handleWelcome')));
		
	}
	
	public function handlePing (IRCConnection $connection, $parameters, IRCInboundMessage $message) {
		
		$out = new IRCOutboundMessage('PING');
		$out->setRawValue($message->getValue());
		
		$this->send($out);
		
	}
	
	public function handleNickError (IRCConnection $connection, $parameters, IRCInboundMessage $message) {
		
		static $try = 0;
		
		$nicknames = $connection->getParameter('client.nickname');
		
		$try ++;
		
		if (!isset($nicknames[$try])) {
			
			$this->send(new IRCOutboundMessage('QUIT'));
			$this->getSocket()->disconnect();
			return;
			
		}
		
		$this->send(new IRCOutboundMessage('NICK', $nicknames[$try]));
		
	}
	
	public function handleWelcome (IRCConnection $connection, $parameters, IRCInboundMessage $message) {
		
		$this->unbind(IRCSocket::ACTION_READ, '_handle_nick_error');
		
	}
	
	public function bind ($action, $identifier, $limits, $callbacks) {
		
		$this->callbacks[$action][$identifier] = array(
			'limits' => $limits,
			'callbacks' => $callbacks
		);
		
	}
	
	public function unbind ($action, $identifier) {
		
		if (isset($this->callbacks[$action][$identifier])) {
			
			unset($this->callbacks[$action][$identifier]);
			return true;
			
		}
		
		return false;
		
	}

	/*
	 * Basically, there are three options for receiving messages.
	 * 
	 * ERROR|NOTICE|PING. These are named server messages.
	 * :someserver 001 DATA HERE. Numeric.
	 * :someclient!who@am.i PRIVMSG loc :STUFF. Named client message.
	 */
	protected function parse ($buffer) {
		
		$preparedBuffer = new IRCBuffer($this->getConnection(), $buffer);
		$message = null;
		
		if ($buffer{0} != ':') {
			
			$message = new IRCNamedServerInboundMessage($preparedBuffer);
			
		}
		else {
			
			if (ctype_digit($preparedBuffer->getWord(1))) {
				
				$message = new IRCNumericInboundMessage($preparedBuffer);
				
			}
			else {
				
				$message = new IRCNamedInboundMessage($preparedBuffer);
				
			}
			
		}
		
		return $message;
		
	}
	
	public function send (IRCOutboundMessage $message) {
		
		return $this->getSocket()->send($message->format(), array('message' => $message));
		
	}
	
	public function execute ($action, $parameters) {
		
		switch ($action) {
			
			case IRCSocket::ACTION_OPEN:
			case IRCSocket::ACTION_CLOSE:
			case IRCSocket::ACTION_ERROR:
				foreach ($this->callbacks[$action] as $callbacks) {
					foreach ($callbacks['callbacks'] as $callback) {
						call_user_func($callback, $this->getConnection(), $parameters);
					}
				}
				break;
				
			case IRCSocket::ACTION_READ:
				$message = $this->parse($parameters['buffer']);
				
				foreach ($this->callbacks[$action] as $callbacks) {
					if ((isset($callbacks['limits'][$message->getCommand()]) && preg_match($callbacks['limits'][$message->getCommand()], $message->getValue())) ||
						(isset($callbacks['limits']['*']) && preg_match($callbacks['limits']['*'], $message->getValue()))) {
						foreach ($callbacks['callbacks'] as $callback) {
							call_user_func($callback, $this->getConnection(), $parameters, $message);
						}
					}
				}
				break;
				
			case IRCSocket::ACTION_WRITE:
				foreach ($this->callbacks[$action] as $callbacks) {
					if ((isset($callbacks['limits'][$parameters['message']->getCommand()]) && preg_match($callbacks['limits'][$parameters['message']->getCommand()], $parameters['message']->formatValue())) ||
						(isset($callbacks['limits']['*']) && preg_match($callbacks['limits']['*'], $parameters['message']->formatValue()))) {
						foreach ($callbacks['callbacks'] as $callback) {
							call_user_func($callback, $this->getConnection(), $parameters);
						}
					}
				}
				break;
				
		}
		
		return true;
		
	}
	
}
?>