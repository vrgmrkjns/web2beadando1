<?php

class Beregiszt_Controller
{
	public $baseName = 'beregiszt';
	public function main(array $vars)
	{
		$beregisztModel = new Beregiszt_Model;

		$retData = $beregisztModel->register_user($vars);

		$view = new View_Loader($this->baseName.'_main');

		foreach($retData as $name => $value)
			$view->assign($name, $value);
	}
}

?>