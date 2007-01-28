<?php
class IRCProtocolHandler extends IRCHandler {
	
	public function __construct () {
		
		
		
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
		
		return $this->getSocket()->send($message->format());
		
	}
	
	public function execute ($action, $parameters) {
		
		switch ($action) {
			
			case IRCSocket::ACTION_OPEN:
				$this->send(new IRCOutboundMessage('NICK', 'implbot'));
				$this->send(new IRCOutboundMessage('USER', array('implbot', 'unknown', 'unknown', 'implbot')));
				break;
				
			case IRCSocket::ACTION_READ:
				$message = $this->parse($parameters['buffer']);
				echo 'CMD: ' . $message->getCommand() . '; VALUE: ' . $message->getValue() . "\n";
				echo $message->getBuffer()->getRawBuffer() . "\n\n";
				break;
			
		}
		
		return true;
		
	}
	
}
?>