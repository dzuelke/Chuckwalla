<?php
class IRCClient extends IRCUser {
	
	protected $nickname = '';
	protected $username = '';
	protected $realname = '';
	
	public function __construct ($parameters = array()) {
		
		parent::__construct($parameters);
		
		isset($parameters['nickname']) && $this->setNickname($parameters['nickname']);
		isset($parameters['username']) && $this->setUsername($parameters['username']);
		isset($parameters['realname']) && $this->setRealname($parameters['realname']);
		
	}
	
	public function getNickname () {
		
		return $this->nickname;
		
	}
	
	public function setNickname ($nickname) {
		
		$this->nickname = (string)$nickname;
		
	}
	
	public function getUsername () {
		
		return $this->username;
		
	}
	
	public function setUsername ($username) {
		
		$this->username = (string)$username;
		
	}
	
	public function getRealname () {
		
		return $this->realname;
		
	}
	
	public function setRealname ($realname) {
		
		$this->realname = (string)$realname;
		
	}
	
}
?>