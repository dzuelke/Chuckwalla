<?php
class IRCBuffer {
	
	protected $words = array();
	protected $eols = array();
	protected $connection = null;
	
	public function __construct (IRCConnection $connection, $buffer = '') {
		
		$this->connection = $connection;
		$this->setBuffer($buffer);
		
	}
	
	public function getSourceConnection () {
		
		return $this->connection;
		
	}
	
	public function setBuffer ($buffer) {
		
		$count = strlen($buffer);
		$offset = 0;
		$isSpace = false;
		
		for ($i = 0; $i < $count; $i ++) {
			
			if ($buffer{$i} === ' ' || $i === $count - 1) {
				
				if (!$isSpace) {
					$this->words[] = substr($buffer, $offset, $i - $offset);
					$this->eols[] = substr($buffer, $offset);
				}
				$isSpace = true;
				$offset = $i + 1;
				
			}
			else {
				
				$isSpace = false;
				
			}
			
		}
		
	}
	
	public function getRawBuffer () {
		
		return $this->getWordsToLineEnd(0);
		
	}
	
	public function hasIndex ($offset) {
		
		return isset($this->words[$offset]);
		
	}
	
	public function getWord ($offset) {
		
		return $this->hasIndex($offset) ? $this->words[$offset] : '';
		
	}
	
	public function getWordsToLineEnd ($offset) {
		
		return $this->hasIndex($offset) ? $this->eols[$offset] : '';
		
	}
	
}
?>