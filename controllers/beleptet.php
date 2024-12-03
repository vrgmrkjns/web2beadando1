<?php

class Beleptet_Controller
{
	public $baseName = 'beleptet';
	public function main(array $vars)
	{
		$beleptetModel = new Beleptet_Model;

		$retData = $beleptetModel->get_data($vars);

		$view = new View_Loader($this->baseName.'_main');

		foreach($retData as $name => $value)
			$view->assign($name, $value);
	}
}

?>