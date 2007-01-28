<?php

class ChuckwallaIrcbotController extends AgaviController
{
	public function dispatch(AgaviRequestDataHolder $arguments = null)
	{
		$chatModel = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot');

		$handler = $chatModel->getConnection()->getDefaultHandler();

		$x = 100;
		$handler->bind(IRCSOcket::ACTION_READ, $x++, array('*' => '##'), array(array($this, 'onLog'), array($this, 'onData')));

		$chatModel->connectLoop();
		echo "connect end";
	}

	protected function doDispatch($message)
	{
		$requestData = array(
			'user' => null,
			'channel' => null,
			'message' => null,
		);

		$ircClient = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot');
		$msg = $ircClient->splitIrcMessage($message->getBuffer()->getRawBuffer());
		if($msg->command == IRCProtocol::MESSAGE_NOTICE) {
			$requestData['user'] = $ircClient->getNickFromPrefix($msg->prefix);
			$requestData['message'] = $msg->params[1];
		} elseif($msg->command == IRCProtocol::MESSAGE_PRIVMSG) {
			$requestData['user'] = $ircClient->getNickFromPrefix($msg->prefix);
			$requestData['channel'] = $msg->params[0];
			$requestData['message'] = $msg->params[1];
		}
		

		$this->getContext()->getRequest()->clearParameters();
		$this->getContext()->getRequest()->setAttribute('irc_request', $requestData, 'org.agavi.Chuckwalla.irc_params');
		parent::dispatch();
	}

	public function onLog(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		static $typeMap = array(
			IRCProtocol::MESSAGE_PRIVMSG => 1,
			IRCProtocol::MESSAGE_NOTICE => 20,
			IRCProtocol::MESSAGE_JOIN => 30,
			IRCProtocol::MESSAGE_PART => 40,
			IRCProtocol::MESSAGE_QUIT => 50,
		);

		$ircClient = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot');
		$msg = $ircClient->splitIrcMessage($message->getBuffer()->getRawBuffer());

		if(isset($typeMap[$msg->command])) {
			if($msg->params[0] != 'AUTH' && $msg->params[0] != $ircClient->getConnection()->getClient()->getNickname()) {
				// don't log notices directed at us
				$logEntry = $this->getContext()->getModel('ChuckwallaMessageLog');
				$logEntry->setType($typeMap[$msg->command]);
				$logEntry->setNick($ircClient->getAndCreateUser($ircClient->getNickFromPrefix($msg->prefix)));
				$logEntry->setChannel($ircClient->getAndCreateChannel($msg->params[0]));
				$logEntry->setMessage(isset($msg->params[1]) ? utf8_encode($msg->params[1]) : '');
				$logEntry->setMessageDate(time());
				$logEntry->save();
			}
		}
	}

	public function onData(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$this->doDispatch($message);
	}



}

?>