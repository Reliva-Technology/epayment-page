<?php
require_once ('fpx.php');
$bank = new FPX();

$post = [
	'mode' => $_POST['mode'],
	'env' => $_POST['env']
];

$bank_list = $bank->get_bank_list($post);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($bank_list,true);