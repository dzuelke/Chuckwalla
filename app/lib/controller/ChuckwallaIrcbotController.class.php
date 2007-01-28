<?php

class ChuckwallaIrcbotController extends AgaviController
{
	public function dispatch(AgaviRequestDataHolder $arguments = null)
	{
		$chatModel = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot');

		$chatModel->getConnection()->registerActionHandler(
SMARTIRC_TYPE_CHANNEL | SMARTIRC_TYPE_JOIN | SMARTIRC_TYPE_ACTION | SMARTIRC_TYPE_TOPICCHANGE | SMARTIRC_TYPE_NICKCHANGE | SMARTIRC_TYPE_KICK | SMARTIRC_TYPE_QUIT | /*SMARTIRC_TYPE_MODECHANGE | */ SMARTIRC_TYPE_PART | SMARTIRC_TYPE_TOPIC,
#SMARTIRC_TYPE_NOTICE,

		'', $this, 'logHandler');

		$chatModel->connectLoop();
	}

	protected function doDispatch($data)
	{
		$requestData = array(
			'user' => $data->user,
			'channel' => $data->channel,
			'message' => $data->message,
		);

		$this->getContext()->getRequest()->clearParameters();
		$this->getContext()->getRequest()->setAttribute('irc_request', $requestData, 'org.agavi.Chuckwalla.irc_params');
		parent::dispatch();
	}

	public function logHandler($irc, $data)
	{
		echo "myHANDLE\n\n\n\n\n";
		$this->doDispatch($data);
		$msg = $this->getContext()->getModel('ChuckwallaChatClient', 'Bot')->splitIrcMessage($data->rawmessage);
		var_dump($msg);

		$type = $data->type;
		$channel = $data->channel !== null ? $data->channel : $data->rawmessageex[2];
//		var_dump($data->rawmessageex[2]);
		if($type == SMARTIRC_TYPE_NOTICE) {
//			var_dump($data);
		} elseif($type == SMARTIRC_TYPE_JOIN) {
		}

//var_dump(gettype($irc));
//var_dump($data);
	}


}

?>