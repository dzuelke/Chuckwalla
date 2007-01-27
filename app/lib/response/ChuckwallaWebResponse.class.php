<?php

class ChuckwallaWebResponse extends AgaviWebResponse
{
	public function send(AgaviOutputType $ot = null)
	{
		// if the output type is flagged as json, we build a json response instead of just sending raw html back
		// we could check for the name of the output type, too, but that's too lame ;)
		if($ot->getParameter('build_json_response', false)) {
			// the json response has the original content in the key "content", and any additional parameters set in the "json" parameter in the response will be added there, too
			$this->setContent(
				json_encode(
					array_merge(
						(array)$this->getParameter('json', array()), 
						array('content' => $this->getContent())
					)
				)
			);
		}
		parent::send($ot);
	}
}

?>