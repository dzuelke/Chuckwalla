<?php

class Web_IndexSuccessView extends AgaviView
{
	public function execute(AgaviRequestDataHolder $rd)
	{
		$this->loadLayout();

		// set the title
		$this->setAttribute('_title', 'Index Action');
	}
}

?>