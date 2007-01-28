<?php
class IRCSocketQueue {
	
	/* for every 10 high prio messages, send 5 medium prio and 2 low prio */
	
	/*const PRIORITY_HIGH = 100;
	const PRIORITY_MEDIUM = 50;
	const PRIORITY_LOW = 20;*/
	
	protected $queue = array(
		/*self::PRIORITY_HIGH => array(),
		self::PRIORITY_MEDIUM => array(),
		self::PRIORITY_LOW => array()*/
	);
	
	protected $executions = array(
	
	);
	
	protected $queued = false;
	
	protected $connection = null;
	
	public function __construct (IRCConnection $connection) {
		
		$this->connection = $connection;
		$this->executions = array_fill(0, $this->connection->getParameter('sendq.max_at_once'), 0);
		
	}
	
	public function set ($buffer, $priority = 0) {
		
		echo 'QUEUE OK: ' . $buffer['buffer'] . "\n";
		$this->queue[] = $buffer;
		
	}
	
	protected function unqueue () {
		
		$this->executions[$this->connection->getParameter('sendq.max_at_once')] = microtime(true);
		array_shift($this->executions);
		
		echo 'DEQUEUE OKAY: ' . $this->queue[0]['buffer'] . "\n";
		return array_shift($this->queue);
		
	}
	
	public function execute () {
		
		$time = microtime(true);
		
		if (count($this->queue) === 0) {
			
			$this->queued = false;
			return false;
			
		}
		
		if ($this->queued || $time - ($this->connection->getParameter('sendq.in') / 1000) < $this->executions[0]) {
			
			/* start queuing */
			if ($time - ($this->connection->getParameter('sendq.delay') / 1000) >= $this->executions[$this->connection->getParameter('sendq.max_at_once') - 1]) {
				
				$this->queued = true;
				return $this->unqueue();
				
			}
			
			return false;
			
		}
		else {
			
			return $this->unqueue();
			
		}
		
	}
	
}
?>