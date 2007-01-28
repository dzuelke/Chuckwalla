<?php

class ChuckwallaIrcbotResponse extends AgaviResponse
{
	/**
	 * The target of the response (either a channel or user)
	 */
	protected $target;

	public function setTarget($target)
	{
		$this->target = $target;
	}

	public function getTarget()
	{
		return $this->target;
	}

	public function setRedirect($to)
	{
	}

	/**
	 * Import response metadata from another response.
	 *
	 * @param      AgaviResponse The other response to import information from.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function merge(AgaviResponse $otherResponse)
	{
		if(!$this->getTarget() && $otherResponse->getTarget()) {
			$this->setTarget($otherResponse->getTarget());
		}
	}
	
	/**
	 * Clear all data for this Response.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function clear()
	{
	}
	
	/**
	 * Send all response data to the client.
	 *
	 * @param      AgaviOutputType An optional Output Type object with information
	 *                             the response can use to send additional data.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function send(AgaviOutputType $outputType = null)
	{
		if($this->content) {
			// only try to send something when there is content to send
			$ircClient = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot');
			$ircClient->message($this->target, $this->content);
		}
	}
	
}

?>