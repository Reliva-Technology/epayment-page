<?php
define('ROOT_DIR', dirname(__DIR__, 1));

class StringerController
{
	private $config;

    public function __construct()
    {
        // read config.json
        $config_filename = ROOT_DIR.'/config.json';

        if (!file_exists($config_filename)) {
            throw new Exception("Can't find ".$config_filename);
        }
        $this->config = json_decode(file_get_contents($config_filename), true);
    }

	public function getChecksum($data)
	{
	    $data = [
	        'TRANS_ID' => $data['TRANS_ID'],
	        'PAYMENT_MODE' => $data['PAYMENT_MODE'],
	        'AMOUNT' => $data['AMOUNT'],
			'MERCHANT_CODE' => $data['MERCHANT_CODE']
		];

	    $header = null;

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config['stringer']['url']);
        if (!is_null($header)) {
	        curl_setopt($ch, CURLOPT_HEADER, true);
	    }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
		$response = curl_exec($ch);
		curl_close($ch);
		echo $response;
	}
}
