<?php
error_reporting(E_ALL | E_STRICT);
set_time_limit(0);

require './lib/IRC.php';

function omgfish (IRCConnection $connection, $parameters, IRCPeerInboundMessage $message) {
	
	$connection->getDefaultHandler()->send(new IRCPeerOutboundMessage('PRIVMSG', $message->getUser(), 'omg fish'));
	
}

$parameters = array(
	'server.hostname' => 'irc.freenode.net',
	'server.port' => 6667,
	
	'client.nickname' => array(
		'modualo',
		'moduali'
	),
	'client.username' => 'modualo',
	'client.realname' => 'Does it matter? Shattered!'
);

$irc = new IRCConnection($parameters);

$ph = $irc->getDefaultHandler();
$ph->bind(IRCSocket::ACTION_READ, 'identifier', array(IRCProtocol::MESSAGE_PRIVMSG => '#fish#i'), array('omgfish'));

$irc->getSocket()->setNonBlocking(true);
$irc->getSocket()->connect();

while ($irc->getSocket()->isConnected()) {
	
	$irc->getSocket()->execute();
	
}
?>