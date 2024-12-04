<?php

class SoapServer_Controller
{
	public $baseName = 'soapserver';
	public function main(array $vars)
	{
		$view = new View_Loader($this->baseName."_main");
	}

	public function handle() {
        $server = new SoapServer(null, ['uri' => 'http://localhost/soap-server']);
        $server->setClass('SoapServer_Model');
        $server->handle();
    }
}

?>