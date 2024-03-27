<?php
$config_filename = 'config.json';

if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}

$config = json_decode(file_get_contents($config_filename), true);

$id = $_REQUEST['id'];

switch ($id) {

    case 'confirm-payment':

        $data = $_POST;

        echo "<form id='autosubmit' action='confirm.php' method='post'>";
        if (is_array($data) || is_object($data))
        {
            foreach ($data as $key => $val) {
                echo "<input type='hidden' name='".$key."' value='".$val."'>";
            }
        }
        echo "</form>";
        echo "
        <script type='text/javascript'>
            function submitForm() {
                document.getElementById('autosubmit').submit();
            }
            window.onload = submitForm;
        </script>";

    break;

    case 'choose-bank':

        $data = $_POST;
        $url = NULL;

        if($data['payment_mode'] == 'migs') $url = 'confirm.php';
        if($data['payment_mode'] == 'fpx') $url = '02-bank.php';
        if($data['payment_mode'] == 'fpx1') $url = '02-bank.php';

        echo "<form id='autosubmit' action='".$url."' method='post'>";
        if (is_array($data) || is_object($data))
        {
            foreach ($data as $key => $val) {
                echo "<input type='hidden' name='".$key."' value='".$val."'>";
            }
        }
        echo "</form>";
        echo "
        <script type='text/javascript'>
            function submitForm() {
                document.getElementById('autosubmit').submit();
            }
            window.onload = submitForm;
        </script>";

    break;

	case 'process-payment':
	
		require_once('php/payment.php');
		$payment = new Payment();

		$data = $_POST;

		return $payment->process($data);
		
	break;

	case 'response':

        require_once('php/payment.php');
        $payment = new Payment();

        $data = $_POST;

        return $payment->response($data);
		
	break;

    case 'update':

        require_once('php/payment.php');
        $payment = new Payment();

        $data = $_POST;

        return $payment->update($data);
		
	break;

    case 'cancel-payment':
	
		require_once('php/payment.php');
		$payment = new Payment();

		$data = $_POST;

		return $payment->cancel($data);
		
	break;
}
