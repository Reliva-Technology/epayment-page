<?php
require ('stringer.php');

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
                'CUSTOMER_ID' => $data['CUSTOMER_ID'],
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
            $checksum = json_decode($checksum,true);

            $fpx_data = array(
                'TRANS_ID' => $transaction_id,
                'AMOUNT' => $transaction_data['amount'],
                'PAYEE_NAME' => $transaction_extra['nama_pelanggan'],
                'PAYEE_EMAIL' => $transaction_extra['email_pelanggan'],
                'EMAIL' => $transaction_extra['email_pelanggan'],
                'PAYMENT_MODE' => $transaction_data['payment_mode'],
                'BANK_CODE' => $data['BANK_CODE'],
                'BE_MESSAGE' => $data['BE_MESSAGE'],
                'MERCHANT_CODE' => $merchant_code,
                'CHECKSUM' => trim($checksum['checksum'])
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
            'STATUS' => '99',
            'STATUS_CODE' => '2',
            'STATUS_MESSAGE' => 'Failed',
            'TXN_TIMESTAMP' => date(),
            'PAY_TYPE' => $payment_mode,
            'AMOUNT' => $data['amount'],
            'ORDER_ID' => $data['ORDER_ID'],
            'CUSTOMER_NAME' => $data['nama_pelanggan'],
            'CUSTOMER_ID' => $data['id_pelanggan'],
            'CUSTOMER_MOBILE' => $data['telefon_pelanggan'],
            'CUSTOMER_EMAIL' => $data['email_pelanggan'],
            'TXN_DESC' => $data['keterangan_transaksi']
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
}
