<?php
define('IRC_BASE', dirname(__FILE__));

require IRC_BASE . '/message/IRCMessage.class.php';
require IRC_BASE . '/message/IRCInboundMessage.class.php';
require IRC_BASE . '/message/IRCPeerInboundMessage.class.php';
require IRC_BASE . '/message/IRCNamedServerInboundMessage.class.php';
require IRC_BASE . '/message/IRCNumericInboundMessage.class.php';
require IRC_BASE . '/message/IRCNamedInboundMessage.class.php';
require IRC_BASE . '/message/IRCOutboundMessage.class.php';
require IRC_BASE . '/message/IRCPeerOutboundMessage.class.php';

require IRC_BASE . '/user/IRCIPeer.interface.php';
require IRC_BASE . '/user/IRCUser.class.php';
require IRC_BASE . '/user/IRCClientPeer.class.php';
require IRC_BASE . '/user/IRCClient.class.php';
require IRC_BASE . '/user/IRCServerPeer.class.php';
require IRC_BASE . '/user/IRCServer.class.php';

require IRC_BASE . '/IRCBuffer.class.php';
require IRC_BASE . '/IRCHandler.class.php';
require IRC_BASE . '/IRCProtocol.class.php';
require IRC_BASE . '/IRCProtocolHandler.class.php';
require IRC_BASE . '/IRCSocketQueue.class.php';
require IRC_BASE . '/IRCSocket.class.php';

require IRC_BASE . '/IRCConnection.class.php';
?>