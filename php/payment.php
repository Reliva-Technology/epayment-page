<?php
require ('stringer.php');
require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Payment
{
    private $config;

    public function __construct()
    {
        $config_filename = ROOT_DIR.'/config.json';

        if (!file_exists($config_filename)) {
            throw new Exception("Can't find ".$config_filename);
        }
        $this->config = json_decode(file_get_contents($config_filename), true);
    }

    # process online payment
    public function process($data)
    {
        if(isset($data)){

            $merchant_code = $data['MERCHANT_CODE'] ?? $this->config['fpx']['merchant-code'];
            $payment_mode = $data['payment_mode'];
            $transaction_id = $data['ORDER_ID'];

            if($payment_mode == 'fpx' || $payment_mode == 'fpx1'){
                $payment_method = 'FPX';
            } else {
                $payment_method = 'Kad Kredit/Debit';
            }

            $transaction_data = array(
                'service_id' => 1,
                'amount' => $data['AMOUNT'],
                'payment_method' => $payment_method,
                'payment_mode' => $payment_mode,
                'status' => '2',
                'payment_id' => '0'
            );

            $transaction_extra = array(
                'CUSTOMER_NAME' => $data['CUSTOMER_NAME'],
                'CUSTOMER_MOBILE' => $data['CUSTOMER_MOBILE'],
                'CUSTOMER_EMAIL' => $data['CUSTOMER_EMAIL'],
                'TXN_DESC' => $data['TXN_DESC']
            );

            $encrypt = new StringerController();

            $checksum_data = [
                'TRANS_ID' => $transaction_id,
                'PAYMENT_MODE' => $transaction_data['payment_mode'],
                'AMOUNT' => $transaction_data['amount'],
                'MERCHANT_CODE' => $merchant_code
            ];

            $checksum = $encrypt->getChecksum($checksum_data);

            $fpx_data = array(
                'TRANS_ID' => $transaction_id,
                'AMOUNT' => $transaction_data['amount'],
                'PAYEE_NAME' => $transaction_extra['CUSTOMER_NAME'],
                'PAYEE_EMAIL' => $transaction_extra['CUSTOMER_EMAIL'],
                'EMAIL' => $transaction_extra['CUSTOMER_EMAIL'],
                'PAYMENT_MODE' => $transaction_data['payment_mode'],
                'BANK_CODE' => $data['BANK_CODE'],
                'BE_MESSAGE' => $data['BE_MESSAGE'],
                'MERCHANT_CODE' => $merchant_code,
                'CHECKSUM' => $checksum
            );

            # pass to FPX controller
            echo "<form id=\"myForm\" action=\"".$this->config['fpx']['url']."\" method=\"post\">";
            foreach ($fpx_data as $a => $b) {
                echo '<input type="hidden" name="'.htmlentities($a).'" value="'.$b.'">';
            }
            foreach ($transaction_extra as $c => $d) {
                echo '<input type="hidden" name="'.htmlentities($c).'" value="'.$d.'">';
            }
            echo "</form>";
            echo "<script type=\"text/javascript\">
                document.getElementById('myForm').submit();
            </script>";

        } else {

            // error
        }
    }

    public function cancel()
    {
        $input = $_POST;

        switch ($input['payment_mode']) {
            case 'fpx':
                $payment_mode = 'FPX (Individual)';
                break;
            case 'fpx1':
                $payment_mode = 'FPX (Corporate)';
                break;
            case 'migs':
                $payment_mode = 'Kad Kredit/Debit';
                break;
            default:
                $payment_mode = 'FPX';
                break;
        }

        $data = [
            'STATUS_CODE' => '1C',
            'STATUS_DESC' => 'Failed',
            'TXN_TIMESTAMP' => date("Y-m-d h:i:s"),
            'PAY_TYPE' => $payment_mode,
            'ORDER_ID' => $input['ORDER_ID']
        ];

        # callback to mymanjung
        echo "<form id=\"myForm\" action=\"".$this->config['callback']."\" method=\"post\">";
        foreach ($data as $a => $b) {
            echo '<input type="hidden" name="'.htmlentities($a).'" value="'.$b.'">';
        }
        echo "</form>";
        echo "<script type=\"text/javascript\">
            document.getElementById('myForm').submit();
        </script>";
    }

    public function response()
    {
        $response = NULL;
        $input = $_POST;

        $data = $this->json_change_key($input, 'TRANS_ID', 'ORDER_ID');
        //$data = json_decode($data, true);

        # post back to merchant
        //$url = 'https://evault.develop.xlog.asia/thank-you/reliva';
        $url = 'https://httpbin.org/post';
        //return $this->render($response,$url);

        $client = new Client();
        $response = $client->request('POST', $url, [
            'json' => $data
        ]);
        echo $response->getBody();

        //header("Location:".$url);
    }

    
    private function json_change_key($arr, $oldkey, $newkey) {
        $json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
        return stripslashes($json);	
    }

    public static function render($fieldValues, $paymentUrl)
    {
        echo "<form id='autosubmit' action='".$paymentUrl."' method='post'>";
        if (is_array($fieldValues) || is_object($fieldValues))
        {
            foreach ($fieldValues as $key => $val) {
                echo "<input type='text' name='".$key."' value='".htmlspecialchars($val)."'>";
            }
        }
        echo "<script type='text/javascript'>
            function submitForm() {
                document.getElementById('autosubmit').submit();
            }
            //window.onload = submitForm;
        </script>";
    }
}
