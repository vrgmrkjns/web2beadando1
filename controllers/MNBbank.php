<?php

class mnbbank_Controller
{
	public $baseName = 'mnbbank'; 
	public function main(array $vars)
	{
		$view = new View_Loader($this->baseName.'_main');
	}
}

?>