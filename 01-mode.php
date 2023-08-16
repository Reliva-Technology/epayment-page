<?php
$content_type = $_SERVER["CONTENT_TYPE"];

if(!$content_type){
    http_response_code(400); // Bad Request
    echo "Wrong content type";
}

$config_filename = 'config.json';

if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}

$config = json_decode(file_get_contents($config_filename), true);
$payload = NULL;

if($content_type == 'application/x-www-form-urlencoded'){
    $data = $_POST;
    if ($data !== null) {
        foreach ($data as $key => $val) {
            $payload .= "<input type='hidden' name='".$key."' value='".$val."'>";
        }
    } else {
        http_response_code(400); // Bad Request
        echo "Invalid post data";
    }
}

if($content_type == 'application/json'){
    $data = file_get_contents('php://input');
    if ($data !== null) {
        foreach (json_decode($data) as $key => $val) {
            $payload .= "<input type='hidden' name='".$key."' value='".$val."'>";
        }
    } else {
        http_response_code(400); // Bad Request
        echo "Invalid JSON data";
    }
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
    <title>E-Payment</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="theme-light">
    <div class="card">
        <div class="content mb-2">
            <h3 class="text-center">Cara Pembayaran</h3>
            <p class="text-center">Pilih Perbankan Internet (Individu/Korporat) atau Kad Kredit/Debit</p>
            <div class="list-group list-custom-small">
                <a href="#" class="payment-mode" data-payment-mode="fpx"><img src="images/fpx.svg" height="48" title="Personal Banking" alt="Personal Banking"><span class="mx-3">Perbankan Internet (Individu)</span><i class="fa fa-angle-right"></i></a>
                <a href="#" class="payment-mode" data-payment-mode="fpx1"><img src="images/fpx.svg" height="48" title="Corporate Banking" alt="Corporate Banking"><span class="mx-3">Perbankan Internet (Korporat)</span><i class="fa fa-angle-right"></i></a>
                <a href="#" class="payment-mode" data-payment-mode="migs"><img src="images/visa.svg" height="48" title="Credit/Debit Card" alt="Credit/Debit Card"><img src="images/mastercard.svg" height="48" title="Credit/Debit Card" alt="Credit/Debit Card"><span class="mx-3">Kad Kredit/Debit</span><i class="fa fa-angle-right"></i></a>
            </div>
            <dl class="mt-2">
                <dt>Perbankan Individu</dt>
                <dd>Minimum RM 1.00 dan maksimum RM 30,000.00</dd>
                <dt>Perbankan Korporat</dt>
                <dd>Minimum RM 2.00 dan maksimum RM 1,000,000.00</dd>
            </dl>
        </div>
        <div class="card-footer">
            <p class="text-center">Majlis Perbandaran Manjung. Hakcipta Terpelihara &copy; <?php echo date('Y') ?></p>
            <p class="text-center"><img src="images/logo.png" title="logo" alt="logo" height="48px" class="img"></p>
        </div>
    </div>
    <form method="post" action="action.php?id=choose-bank" id="form-bayar">
        <input type="hidden" id="payment-mode" name="payment_mode" value="">
        <?php echo $payload ?>
    </form>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script src="scripts/jquery.min.js"></script>
    <script>
        $('.payment-mode').each(function() {
            $(this).click(function() {
                let payment_mode = $(this).data('payment-mode');
                $('#payment-mode').val(payment_mode);
                $("#form-bayar").submit();
            });
        });
    </script>
</body>
</html>