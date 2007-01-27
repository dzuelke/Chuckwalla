<?php

include(dirname(__FILE__) . '/ChuckwallaIrcModel.class.php');

class Bot_ChuckwallaChatClientModel extends ChuckwallaBaseModel implements AgaviISingletonModel 
{
	protected $knownNicks = array();
	protected $knownChannels = array();
	protected $channelNickMap = array();

	protected $connectFinished = false;
	protected $connectionConfig = array();
	protected $ircConn = null;

	protected function getAndCreateChannel($name)
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
			$linkObj = $this->getContext()->getModel('ChuckwallaChannelNick');
			$linkObj->setChannelId($this->getAndCreateChannel($channel)->getId());
			$linkObj->setNickId($user->getId());
			$this->channelNickMap[$channel][$user->getId()] = $user;
		}
	}

	protected function removeUserFromChannel($channel, $user)
	{
		if(isset($this->channelNickMap[$channel][$user->id])) {
			unset($this->channelNickMap[$channel][$user->id]);
		}
	}

	protected function refreshUser($nick)
	{
		$this->ircConn->who($nick);
	}

	protected function getAndCreateUser($nick)
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

	public function onConnected($irc, $data)
	{
		if(!$this->connectFinished) {
			// because net_smartirc is so smart, it will skip internal handlers when you register an handler on the notice type
			// so we need to set this (_private_) variable from here
			$this->ircConn->_loggedin = true;
			$this->connectFinished = true;
			$this->executeConnectCommands();
		}
	}

	public function onUserJoined($irc, $data)
	{
		$msg = $this->splitIrcMessage($data->rawmessage);
		$nick = $this->getNickFromPrefix($msg->prefix);
		if($msg->command == 'JOIN') {
			if($nick != $irc->_nick) {
				// we don't need to refresh ourselves
				$this->refreshUser($nick);
			}
		} elseif($msg->command = 'PART') {
			$user = $this->getAndCreateUser($nick);
			foreach($msg->params as $channel) {
				$this->removeUserFromChannel($channel, $user);
			}
		}
	}

	public function onChannelUserList($irc, $data)
	{
		if($data->rawmessageex[1] == 353 /*RPL_NAMREPLY*/) {
			$msg = $this->splitIrcMessage($data->rawmessage);
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
					$this->addUserToChannel($channel, $this->getAndCreateUser($nick));
				}
			}
		} elseif($data->rawmessageex[1] == 366 /*RPL_ENDOFNAMES*/) {
			$channelName = $data->rawmessageex[3];
			$irc->who($channelName);

			// we received the full user list for a channel, lets update our internal info
			//$channelId = $this->getContext()->getModel('ChuckwallaChannel', 'Bot')->getOrAddChannelId($data->rawmessageex[3]);
			//var_dump($irc->channel[$channel]->topic);

			//var_dump($channelId);
		}
	}

	public function onChannelTopic($irc, $data)
	{
		echo "topic\n\n\n\n";
		$msg = $this->splitIrcMessage($data->rawmessage);
		$channel = $this->getAndCreateChannel($msg->params[1]);
		$channel->setTopic($msg->params[2]);
		$channel->save();
	}
	public function onChannelWho($irc, $data)
	{
		$type = $data->rawmessageex[1];
		if($type == 352) {
			$user = $this->getAndCreateUser($data->rawmessageex[7]);
			$identity = $user->getOrCreateIrcIdentity();

			$channel = $data->rawmessageex[3];
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

			$identity->setIdent($data->rawmessageex[4]);
			$identity->setHost($data->rawmessageex[5]);
			$identity->setServer($data->rawmessageex[6]);
			$identity->setIrcop(false);

			$usermode = $data->rawmessageex[8];
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

			$identity->setRealname(implode(array_slice($data->rawmessageex, 10), ' '));

			$identity->save();
			$user->save();
			if($channel != '*') {
				$channelNick->save();
				$this->addUserToChannel($channel, $user);
			}
		}
	}

	public function onMessage($irc, $data)
	{
		echo "OnMessage\n\n";
		$msg = $this->splitIrcMessage($data->rawmessage);
		if($msg->params[1] == '!foo') {
			var_dump($this->channelNickMap);
		}
	}

	public function initialize($context)
	{
		parent::initialize($context);

		$this->connectionConfig = require(AgaviConfigCache::checkConfig(AgaviConfig::get('core.module_dir') . '/Bot/config/connection.xml'));

		$this->ircConn = new Net_SmartIRC();
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_LOGIN, '', $this, 'onConnected');

		// this is for our own user tracking
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_TOPIC, '', $this, 'onChannelTopic');
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_NAME, '', $this, 'onChannelUserList');
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_WHO, '', $this, 'onChannelWho');

//		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_JOIN | SMARTIRC_TYPE_PART, '', $this, 'onUserJoined');

//		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_CHANNEL, '', $this, 'onMessage');


		$this->ircConn->setDebug(isset($this->connectionConfig['debug']) ? $this->connectionConfig['debug'] : SMARTIRC_DEBUG_NONE);
		$this->ircConn->setUseSockets(false);
		$this->ircConn->setChannelSyncing(false);
	}

	public function getConnection()
	{
		return $this->ircConn;
	}

	public function connectLoop()
	{
		// lets reset all needed flags before we connect (again)
		$this->connectFinished = false;

		$this->ircConn->connect($this->connectionConfig['hostname'], $this->connectionConfig['port']);
		$login = array(
			$this->connectionConfig['nickname'],
			isset($this->connectionConfig['realname']) ? $this->connectionConfig['realname'] : $this->connectionConfig['nickname'],
			isset($this->connectionConfig['usermode']) ? $this->connectionConfig['usermode'] : 0,
			isset($this->connectionConfig['username']) ? $this->connectionConfig['username'] : $this->connectionConfig['nickname'],
		);

		call_user_func_array(array($this->ircConn, 'login'), $login);

		$this->ircConn->listen();
		$this->ircConn->disconnect();
	}

	public function executeConnectCommands()
	{
		$this->join('#testkaos');
		$this->ircConn->message(SMARTIRC_TYPE_QUERY, 'NickServ', 'IDENTIFY AgaviBot test0r');
//		$this->ircConn->message(SMARTIRC_TYPE_QUERY, 'NickServ', 'IDENTIFY r0ck3t33r');
	}

	public function join($channel, $key = null)
	{
		$this->ircConn->join((array) $channel, $key);
	}

	public function part($channel, $reason)
	{
		$this->ircConn->part((array) $channel, $reason);
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

	protected function getNickFromPrefix($prefix)
	{
		$nick = explode("!", $prefix);
		return $nick[0];
	}

}

?>