<?php

class ChuckwallaIrcbotRequest extends AgaviRequest
{
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);

		$this->setMethod('read');

		$this->requestData = new AgaviRequestDataHolder(array());
	}
}

?>