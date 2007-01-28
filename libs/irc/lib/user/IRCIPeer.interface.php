<?php
interface IRCIPeer {
	
	public function find ($parameter);
	public function has ($parameter);
	public function set ($parameter);
	public function remove ($parameter);
	
}
?>