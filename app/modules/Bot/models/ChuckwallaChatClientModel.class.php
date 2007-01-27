<?php

class Bot_ChuckwallaChatClientModel extends ChuckwallaBaseModel implements AgaviISingletonModel 
{
	protected $connectFinished = false;
	protected $connectionConfig = array();
	protected $ircConn = null;

	public function initialize()
	{
		$this->connectionConfig = require(AgaviConfigCache::checkConfig(AgaviConfig::get('core.module_dir') . '/Bot/config/connection.xml'));

		$this->ircConn = new Net_SmartIRC();
		$this->ircConn->registerActionHandler(SMARTIRC_TYPE_LOGIN, '', $this, 'onConnected');

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
	}

	public function join()
	{
		if(func_num_args() > 0) {
			$this->ircConn->join(func_get_args());
		}
	}

	public function onConnected()
	{
		if(!$this->connectFinished) {
			$this->connectFinished = true;
			$this->executeConnectCommands();
		}
		
	}

}

?>