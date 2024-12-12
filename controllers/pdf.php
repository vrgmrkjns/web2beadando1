<?php

class pdf_Controller
{
	public $baseName = 'pdf'; 
	public function main(array $vars)
	{
		$view = new View_Loader($this->baseName.'_main');
	}
}

?>