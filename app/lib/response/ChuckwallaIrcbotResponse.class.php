<?php

class ChuckwallaIrcbotResponse extends AgaviResponse
{
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
	}
	
}

?>