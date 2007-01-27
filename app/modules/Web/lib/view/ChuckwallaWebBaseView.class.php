<?php

class ChuckwallaWebBaseView extends ChuckwallaBaseView
{
	public function setupHtml(AgaviRequestDataHolder $rd)
	{
		// layout "standard" in output type "html"
		$this->loadLayout('standard');
		$this->setAttribute('_contentType', $this->container->getOutputType()->getParameter('Content-Type'));
	}
	
	public function setupJson(AgaviRequestDataHolder $rd)
	{
		// layout "standard" in output type "json"
		$this->loadLayout('standard');
		$this->setAttribute('_contentType', $this->container->getOutputType()->getParameter('Content-Type'));
	}
	
	public function setupAtom(AgaviRequestDataHolder $rd)
	{
		// layout "standard" in output type "atom"
		$this->loadLayout('standard');
		$this->setAttribute('_contentType', $this->container->getOutputType()->getParameter('Content-Type'));
	}
}

?>