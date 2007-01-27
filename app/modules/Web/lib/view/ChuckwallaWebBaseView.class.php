<?php

class ChuckwallaWebBaseView extends ChuckwallaBaseView
{
	public function setupHtml(AgaviRequestDataHolder $rd)
	{
		// layout "standard" in output type "html"
		$this->loadLayout('standard');
	}
	
	public function setupJson(AgaviRequestDataHolder $rd)
	{
		// layout "standard" in output type "json"
		$this->loadLayout('standard');
	}
}

?>