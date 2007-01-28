<?php

class Bot_ChuckwallaChatClientModel extends ChuckwallaBaseModel implements AgaviISingletonModel 
{
	protected $isInited = false;
	protected $knownNicks = array();
	protected $knownChannels = array();
	protected $channelNickMap = array();

	protected $connectFinished = false;
	protected $connectionConfig = array();
	protected $ircConn = null;

	public function getAndCreateChannel($name)
	{
		if(!isset($this->knownChannels[$name])) {
			$channel = $this->getContext()->getModel('ChuckwallaChannelPeer')->retrieveOrCreateByName($name);

			if($channel->isModified()) {
				$channel->save();
			}
			$this->knownChannels[$name] = $channel;
			return $channel;
		}

		return $this->knownChannels[$name];
	}

	protected function addUserToChannel($channel, $user)
	{
		if(!isset($this->channelNickMap[$channel][$user->getId()])) {
			if(!$this->getContext()->getModel('ChuckwallaChannelNickPeer')->retrieveByPK($this->getAndCreateChannel($channel)->getId(), $user->getId())) {
				$linkObj = $this->getContext()->getModel('ChuckwallaChannelNick');
				$linkObj->setChannelId($this->getAndCreateChannel($channel)->getId());
				$linkObj->setNickId($user->getId());
				$linkObj->save();
			}
			$this->channelNickMap[$channel][$user->getId()] = $user;
		}
	}

	protected function removeUserFromChannel($channel, $user)
	{
		if(isset($this->channelNickMap[$channel][$user->getId()])) {
			unset($this->channelNickMap[$channel][$user->getId()]);
			
			if($linkObj = $this->getContext()->getModel('ChuckwallaChannelNickPeer')->retrieveByPK($this->getAndCreateChannel($channel)->getId(), $user->getId())) {
				$linkObj->delete();
			}
		}
	}

	protected function refreshUser($nick)
	{
		$this->who($nick);
	}

	public function getAndCreateUser($nick)
	{
		if(!isset($this->knownNicks[$nick])) {
			$nickObj = $this->getContext()->getModel('ChuckwallaNickPeer')->retrieveOrCreateByName($nick);
			if($nickObj->isModified()) {
				$nickObj->save();
			}
			$this->knownNicks[$nick] = $nickObj;
			return $nickObj;
		}

		return $this->knownNicks[$nick];
	}

	public function onConnected(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		if(!$this->connectFinished) {
			// because net_smartirc is so smart, it will skip internal handlers when you register an handler on the notice type
			// so we need to set this (_private_) variable from here
			$this->ircConn->_loggedin = true;
			$this->connectFinished = true;
			$this->executeConnectCommands();
		}
	}

	public function onUserJoined(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$msg = $this->splitIrcMessage($message->getBuffer()->getRawBuffer());
		$nick = $this->getNickFromPrefix($msg->prefix);
		if($msg->command == 'JOIN') {
			if($nick != $connection->getClient()->getNickname()) {
				// we don't need to refresh ourselves
				$this->refreshUser($nick);
			}
		} elseif($msg->command = 'PART') {
			$user = $this->getAndCreateUser($nick);
			foreach($msg->params as $channel) {
				$this->removeUserFromChannel($channel, $user);
			}
			$c = new Criteria();
			$c->add(ChuckwallaChannelNickPeer::NICK_ID, $user->getId());
			$isInMoreChans = $this->getContext()->getModel('ChuckwallaChannelNickPeer')->doSelect($c);
			if(!count($isInMoreChans)) {
				// the user parted the last channel we're in, so lets flag him offline
				$identity = $user->getOrCreateIrcIdentity();
				$identity->setIsOnline(false);
				$identity->setLastQuitMessage(isset($msg->params[1]) ? $msg->params[1] : '');
				$identity->setLastQuitTime(time());
				$identity->save();
				$user->save();
			}
		}
	}

	public function onChannelUserList(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$command = $message->getCommand();
		$msg = $this->splitIrcMessage($message->getBuffer()->getRawBuffer());
		if($command == 353 /*RPL_NAMREPLY*/) {
			$channel = $msg->params[2];
			$len = count($msg->params);
			for($i = 3; $i < $len; ++$i) {
				$nicks = explode(' ', $msg->params[$i]);
				foreach($nicks as $nick) {
					$nick = trim($nick);
					if(empty($nick)) {
						continue;
					}
					if($nick[0] == '*' || $nick[0] == '@' || $nick[0] == '%' || $nick[0] == '+') {
						$nick = substr($nick, 1);
					}

					$user = $this->getAndCreateUser($nick);
					$identity = $user->getOrCreateIrcIdentity();
					if(!$identity->getIsOnline()) {
						$identity->setIsOnline(true);
						$identity->save();
					}
					$this->addUserToChannel($channel, $user);
				}
			}
		} elseif($command == 366 /*RPL_ENDOFNAMES*/) {
			$channelName = $msg->params[1];
			$this->who($channelName);

			// we received the full user list for a channel, lets update our internal info
			//$channelId = $this->getContext()->getModel('ChuckwallaChannel', 'Bot')->getOrAddChannelId($data->rawmessageex[3]);
			//var_dump($irc->channel[$channel]->topic);

			//var_dump($channelId);
		}
	}

	public function onChannelTopic(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$msg = $this->splitIrcMessage($message->getBuffer()->getRawBuffer());
		$channel = $this->getAndCreateChannel($msg->params[1]);
		$channel->setTopic($msg->params[2]);
		$channel->save();
	}
	public function onChannelWho(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$type = $message->getCommand();
		$msg = $this->splitIrcMessage($message->getBuffer()->getRawBuffer());
		if($type == 352) {
			$user = $this->getAndCreateUser($msg->params[5]);
			$identity = $user->getOrCreateIrcIdentity();

			$channel = $msg->params[1];
			// the who reply for an individual user
			$channelObj = $this->getAndCreateChannel($channel);

			$c = new Criteria();
			$c->add(ChuckwallaChannelNickPeer::CHANNEL_ID, $channelObj->getId());
			$channelNicks = $user->getChannelNicks($c);

			if(!$channelNicks) {
				$channelNick = $this->getContext()->getModel('ChuckwallaChannelNick');
				$channelNick->setChannel($channelObj);
				$channelNick->setNick($user);
			} else {
				$channelNick = $channelNicks[0];
			}

			$identity->setIsOnline(true);
			$identity->setIdent($msg->params[2]);
			$identity->setHost($msg->params[3]);
			$identity->setServer($msg->params[4]);
			$identity->setIrcop(false);

			$usermode = $msg->params[6];
			$len = strlen($usermode);

			for($i = 0; $i < $len; $i++) {
				switch($usermode[$i]) {
					case 'H':
						$identity->setIsAway(false);
						break;
					case 'G':
						$identity->setIsAway(true);
						break;
					case '@':
						$channelNick->setOpped(true);
						break;
					case '+':
						$channelNick->setVoiced(true);
						break;
					case '*':
						$identity->setIrcop(true);
						break;
				}
			}

			$identity->setRealname(implode(array_slice($msg->params, 7), ' '));

			$identity->save();
			$user->save();
			if($channel != '*') {
				$this->addUserToChannel($channel, $user);
			}
		}
	}

	public function onUserQuit(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$msg = $this->splitIrcMessage($data->rawmessage);
		$nick = $this->getNickFromPrefix($msg->prefix);
		$user = $this->getAndCreateUser($nick);
		$identity = $user->getOrCreateIrcIdentity();
		$identity->setIsOnline(false);
		$identity->setLastQuitMessage(isset($msg->params[0]) ? $msg->params[0] : '');
		$identity->setLastQuitTime(time());
		// lets clear the channel associations
		$c = new Criteria();
		$c->add(ChuckwallaChannelNickPeer::NICK_ID, $user->getId());
		$this->getContext()->getModel('ChuckwallaChannelNickPeer')->doDelete($c);
		$identity->save();
		$user->save();
	}


	public function onPing(IRCConnection $connection, $parameters, IRCInboundMessage $message)
	{
		$value = $message->getValue();
		if($value[0] == ':') {
			$value = substr($value, 1);
		}
		$connection->getDefaultHandler()->send(new IRCOutboundMessage(IRCProtocol::MESSAGE_PONG, array($value)));
	}

	public function initialize($context)
	{
		if(!$this->isInited) {
			$this->isInited = true;
			parent::initialize($context);

			$this->connectionConfig = require(AgaviConfigCache::checkConfig(AgaviConfig::get('core.module_dir') . '/Bot/config/connection.xml'));



	$params = array(
		'client.nickname' => array($this->connectionConfig['nickname']),
		'client.realname' => isset($this->connectionConfig['realname']) ? $this->connectionConfig['realname'] : $this->connectionConfig['nickname'],
		'client.username' => isset($this->connectionConfig['username']) ? $this->connectionConfig['username'] : $this->connectionConfig['nickname'],

		'server.hostname' => $this->connectionConfig['hostname'],
		'server.port' => $this->connectionConfig['port'],
	);

			$this->ircConn = new IRCConnection($params);


			$handler = $this->ircConn->getDefaultHandler();

			$x = 1;


			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::REPLY_WELCOME => '##'), array(array($this, 'onConnected')));

			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::SERVER_MESSAGE_PING => '##'), array(array($this, 'onPing')));


			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::REPLY_TOPIC => '##'), array(array($this, 'onChannelTopic')));
			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::REPLY_NAMREPLY => '##', IRCProtocol::REPLY_ENDOFNAMES => '##'), array(array($this, 'onChannelUserList')));
			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::REPLY_WHOREPLY => '##'), array(array($this, 'onChannelWho')));

			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::MESSAGE_QUIT => '##'), array(array($this, 'onUserQuit')));

			$handler->bind(IRCSOcket::ACTION_READ, $x++, array(IRCProtocol::MESSAGE_JOIN => '##', IRCProtocol::MESSAGE_PART => '##'), array(array($this, 'onUserJoined')));

		}

/*
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_LOGIN, '', $this, 'onConnected');

		// this is for our own user tracking
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_TOPIC, '', $this, 'onChannelTopic');
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_NAME, '', $this, 'onChannelUserList');
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_WHO, '', $this, 'onChannelWho');

		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_QUIT, '', $this, 'onUserQuit');

		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_JOIN | SMARTIRC_TYPE_PART, '', $this, 'onUserJoined');
*/
//		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_CHANNEL, '', $this, 'onMessage');
	}

	public function getConnection()
	{
		return $this->ircConn;
	}

	public function connectLoop()
	{
		// lets reset all needed flags before we connect (again)
		$this->connectFinished = false;

		$this->ircConn->getSocket()->setNonBlocking(true);
		$this->ircConn->getSocket()->connect();

		while($this->ircConn->getSocket()->isConnected()) {
			$this->ircConn->getSocket()->execute();
		}

	}

	public function executeConnectCommands()
	{
		$this->join('#testkaos');
//		$this->ircConn->message(SMARTIRC_TYPE_QUERY, 'NickServ', 'IDENTIFY AgaviBot test0r');
//		$this->ircConn->message(SMARTIRC_TYPE_QUERY, 'NickServ', 'IDENTIFY r0ck3t33r');
	}

	public function who($channel)
	{
		$this->ircConn->getDefaultHandler()->send(new IRCOutboundMessage('WHO', (array)$channel));
	}

	public function join($channel, $key = null)
	{
		$this->ircConn->getDefaultHandler()->send(new IRCOutboundMessage(IRCProtocol::MESSAGE_JOIN, array_merge((array)$channel, (array)$key)));
	}

	public function part($channel, $reason)
	{
		$this->ircConn->getDefaultHandler()->send(new IRCOutboundMessage(IRCProtocol::MESSAGE_PART, array_merge((array)$channel, (array)$reason)));
	}

	public function message($target, $message)
	{
		echo "sending message $message to $target\n\n";
		$this->ircConn->getDefaultHandler()->send(new IRCOutboundMessage(IRCProtocol::MESSAGE_PRIVMSG, array($target, $message)));
	}

	public function splitIrcMessage($buf)
	{
		$message = new StdClass();

		$len = strlen($buf);
		$y = 0;
		$endpos = 0;
		$isLast = 0;
		$isFirst = 0;

		if($buf[$y] == ':') {
			// the message comes from a server
			$y = strpos($buf, ' ');
			if($y === false) {
				$y = $len;
			}
				
			$message->prefix = substr($buf, 1, $y - 1);
			$endpos = ++$y;
		} else {
			$message->prefix = null;
		}

		$y = strpos($buf, ' ', $y);
		if($y === false) {
			$y = $len;
		}

		$message->command = substr($buf, $endpos, $y - $endpos);
		$endpos = ++$y;
		$isFirst = true;

		for(; $y <= $len; $y++) {
			if($y == $len || $buf[$y] == ' ') {
				if($y + 1 < $len && $buf[$y + 1] == ':') {
					$message->params[] = substr($buf, $endpos, $y - $endpos);
					$isLast = 1;
					$endpos = ++$y;
					break;
				}
				$message->params[] = substr($buf, $endpos, $y - $endpos);
				$endpos = ++$y;
				$isFirst = false;
			} elseif($buf[$y] == ':' && $isFirst) {
				$isLast = 1;
				$endpos = $y;
				break;
			}
		}

		if($isLast)
		{
			$message->params[] = substr($buf, $endpos + 1);
		}

		return $message;
	}

	public function getNickFromPrefix($prefix)
	{
		$nick = explode("!", $prefix);
		return $nick[0];
	}

}

?>