<?php

require 'chuckwallaom/om/ChuckwallaBaseNickPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'nick' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Sat Jan 27 21:27:35 2007
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    chuckwallaom
 */
class ChuckwallaNickPeer extends ChuckwallaBaseNickPeer {
	/**
	 * Retrieve a channel by its name. A new channel object is created and 
	 * returned when it doesn't exist in the database yet. Note that the new
	 * object is returned in an unsaved state, so before getting an id you need
	 * to save it.
	 * 
	 *
	 * @param      string The name of the channel.
	 * @return     Channel
	 */
	public function retrieveOrCreateByName($name)
	{
		$criteria = new Criteria(ChuckwallaNickPeer::DATABASE_NAME);

		$criteria->add(ChuckwallaNickPeer::NICK, $name);

		$v = $this->getContext()->getModel('ChuckwallaNickPeer')->doSelect($criteria);

		if(empty($v)) {
			$nick = $this->getContext()->getModel('ChuckwallaNick');
			$nick->setNick($name);
		} else {
			$nick = $v[0];
		}

		return $nick;
	}

} // ChuckwallaNickPeer
