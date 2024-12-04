<?php

class MNBbank_Controller
{
	public $baseName = 'MNBbank'; 
	public function main(array $vars)
	{
		$view = new View_Loader($this->baseName.'_main');
	}
}

?>