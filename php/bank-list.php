<?php
require_once ('fpx.php');
$bank = new FPX();

$post = [
	'mode' => $_REQUEST['mode'],
	'env' => $_REQUEST['env'],
	'exchange' => $_REQUEST['exchange']
];

$bank_list = $bank->get_bank_list($post);
echo json_encode($bank_list,true);