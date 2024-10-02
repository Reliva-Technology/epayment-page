<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
$mode = $_POST['payment_mode'];
if($mode == 'fpx'){
    $fpx = '01';
    $bank_type = 'Individual';
    $bank_description = 'For payment minimum RM 1 up to RM 30,000';
} else {
    $fpx = '02';
    $bank_type = 'Corporate';
    $bank_description = 'For payment minimum RM 2 up to RM 1,000,000';
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>E-Payment Response</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/custom.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="theme-light">
<section class="section mt-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Status Pembayaran</h5>
                        <p>Sila Semak Status Pembayaran berikut</p>
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>ORDER_ID</dt><dd><?php echo $_POST['ORDER_ID'] ?? NULL ?></dd>
                            <dt>PAYMENT_DATETIME</dt><dd><?php echo $_POST['PAYMENT_DATETIME'] ?? NULL ?></dd>
                            <dt>AMOUNT</dt><dd>RM <?php echo $_POST['AMOUNT'] ?? NULL ?></dd>
                            <dt>PAYMENT_MODE</dt><dd><?php echo $_POST['payment_mode'] == 'migs' ? 'Kad Kredit/Debit' : 'Perbankan Internet - '.$_POST['BUYER_BANK'] ?></dd>
                            <dt>STATUS</dt><dd><?php echo $_POST['STATUS'] ?? NULL ?></dd>
                            <dt>STATUS_CODE</dt><dd><?php echo $_POST['STATUS_CODE'] ?? NULL ?></dd>
                            <dt>STATUS_MESSAGE</dt><dd><?php echo $_POST['STATUS_MESSAGE'] ?? NULL ?></dd>
                            <dt>PAYMENT_TRANS_ID</dt><dd><?php echo $_POST['PAYMENT_TRANS_ID'] ?? NULL ?></dd>
                            <dt>APPROVAL_CODE</dt><dd><?php echo $_POST['APPROVAL_CODE'] ?? NULL ?></dd>
                            <dt>RECEIPT_NO</dt><dd><?php echo $_POST['RECEIPT_NO'] ?? NULL ?></dd>
                            <dt>MERCHANT_CODE</dt><dd><?php echo $_POST['MERCHANT_CODE'] ?? NULL ?></dd>
                            <dt>MERCHANT_ORDER_NO</dt><dd><?php echo $_POST['MERCHANT_ORDER_NO'] ?? NULL ?></dd>
                            <dt>BUYER_BANK</dt><dd><?php echo $_POST['BUYER_BANK'] ?? NULL ?></dd>
                            <dt>BUYER_NAME</dt><dd><?php echo $_POST['BUYER_NAME'] ?? NULL ?></dd>
                            <dt>CHECKSUM</dt><dd><?php echo $_POST['CHECKSUM'] ?? NULL ?></dd>
                            <dt>payee_name</dt><dd><?php echo $_POST['payee_name'] ?? NULL ?></dd>
                            <dt>payee_email</dt><dd><?php echo $_POST['payee_email'] ?? NULL ?></dd>
                            <dt>email</dt><dd><?php echo $_POST['email'] ?? NULL ?></dd>
                            <dt>bank_code</dt><dd><?php echo $_POST['bank_code'] ?? NULL ?></dd>
                            <dt>be_message</dt><dd><?php echo $_POST['be_message'] ?? NULL ?></dd>
                            <dt>callback_url</dt><dd><?php echo $_POST['callback_url'] ?? NULL ?></dd>
                            <dt>update_url</dt><dd><?php echo $_POST['update_url'] ?? NULL ?></dd>
                            <dt>Nama Pembayar</dt><dd><?php echo $_POST['CUSTOMER_NAME'] ?? NULL ?></dd>
                            <dt>E-mail</dt><dd><?php echo $_POST['CUSTOMER_EMAIL'] ?? NULL ?></dd>
                            <dt>No. Telefon</dt><dd><?php echo $_POST['CUSTOMER_MOBILE'] ?? NULL ?></dd>
                            <dt>ID Transaksi</dt><dd><?php echo $_POST['ORDER_ID'] ?? NULL ?></dd>
                            <dt>Keterangan</dt><dd><?php echo $_POST['TXN_DESC'] ?? NULL ?></dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">Hakcipta Terpelihara &copy; <?php echo date('Y') ?></p>
                        <p class="text-center"><img src="images/logo.png" title="logo" alt="logo" height="48px" class="img"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>