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
        //$input = '{"TRANS_ID":"RLVAREDLI20240119A001","PAYMENT_DATETIME":"2024-01-19 09:51:07","AMOUNT":"746.00","PAYMENT_MODE":"fpx","STATUS":"1","STATUS_CODE":"00|00","STATUS_MESSAGE":"Debit:Approved|Credit:Approved","PAYMENT_TRANS_ID":"2401190951070213","APPROVAL_CODE":"15733223","RECEIPT_NO":"SBOX240119-0000007","MERCHANT_CODE":"sandbox","MERCHANT_ORDER_NO":"2024011909510500000000000000000044","BUYER_BANK":"SBI BANK A","BUYER_NAME":"nama","CHECKSUM":"rgP5k7\/37bQQOfbdPzXM99tP5ck+QbKv+u4gEBX3SQ8RVcCrxRa2sZh62Lg9yEGD","payee_name":"Redline Trucking","payee_email":"logisticexpress@yopmail.com","email":"logisticexpress@yopmail.com","bank_code":"TEST0021","be_message":"ABB0233~A,ABB0234~A,ABMB0212~A,AGRO01~A,AMBB0209~A,BCBB0235~A,BIMB0340~A,BKRM0602~A,BMMB0341~A,BOCM01~A,BSN0601~A,CIT0219~B,HLB0224~A,HSBC0223~A,KFH0346~A,LOAD001~A,MB2U0227~A,MBB0228~A,OCBC0229~A,PBB0233~A,RHB0218~A,SCB0216~A,TEST0021~A,TEST0022~A,TEST0023~B,UOB0226~A|01|BC|EX00011906","customer_name":"Redline Trucking","customer_mobile":"+60532453245","customer_email":"logisticexpress@yopmail.com","txn_desc":"Reliva E-Payment : RLVAREDLI20240119A001"}';

        $process = json_decode($input, true);

        $data = json_encode($this->json_change_key($process, 'TRANS_ID', 'ORDER_ID'));
        $data = json_decode($data, true);

        # post back to merchant
        $url = 'https://evault.develop.xlog.asia/thank-you/reliva';
        return $this->render($response,$url);

        /* $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => $data
        ]);

        return $response->getBody(); */
    }

    
    private function json_change_key($arr, $oldkey, $newkey) {
        $json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
        return json_decode($json);	
    }

    public static function render($fieldValues, $paymentUrl)
    {
        echo "<form id='autosubmit' action='".$paymentUrl."' method='post'>";
        if (is_array($fieldValues) || is_object($fieldValues))
        {
            foreach ($fieldValues as $key => $val) {
                echo "<input type='hidden' name='".$key."' value='".htmlspecialchars($val)."'>";
            }
        }
        echo "<script type='text/javascript'>
            function submitForm() {
                document.getElementById('autosubmit').submit();
            }
            window.onload = submitForm;
        </script>";
    }
}
