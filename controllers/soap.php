<?php

class Soap_Controller
{
	public $baseName = 'soap';
	public function main(array $vars)
	{
		$view = new View_Loader($this->baseName."_main");
	}


    public function index() {
        try {
            $client = new \SoapClient(null, [
                'location' => 'http://localhost/soap',
                'uri' => 'http://localhost/soap-server',
                'trace' => 1
            ]);

            $data = $client->getJoinedData();
            include 'views/soapView.php'; // Adatok megjelenítése
        } catch (Exception $e) {
            echo "Hiba: " . $e->getMessage();
        }
    }
}

?>