<?php
abstract class IRCMessage {
	
	abstract public function getCommand ();
	abstract public function getValue ();
	
}
?>