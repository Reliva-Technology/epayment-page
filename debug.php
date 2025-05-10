<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>E-Payment Integration DEBUG</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Fadli Saad" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="images/favicon.png">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="styles/bootstrap.css" type="text/css">
    </head>

    <body>
        <!-- content start -->
        <section class="section d-flex justify-content-center align-items-center mt-3">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card border">
                            <div class="card-header">
                                <h4>DEBUG</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="action.php?id=debug" id="form-bayar">
                                <div class="form-group row">
                                    <label for="exchange_id" class="col-lg-3 col-form-label">Exchange ID <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="EXCHANGE_ID" value="EX00002640">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="merchant_code" class="col-lg-3 col-form-label">Merchant Code <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="MERCHANT_CODE" value="">
                                    </div>
                                </div>
                                  <div class="form-group row">
                                    <label for="merchant_code" class="col-lg-3 col-form-label">Payment Mode<span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="PAYMENT_MODE" value="fpx">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="merchant" class="col-lg-3 col-form-label">Checksum <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="CHECKSUM" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="trans_id" class="col-lg-3 col-form-label">ID Transaksi Pelanggan (mesti unik) <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="ORDER_ID" value="<?php echo uniqid('UAT_'); ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="amount" class="col-lg-3 col-form-label">Amount <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="AMOUNT" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Kod Hasil</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="KOD_HASIL" value="">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Process Code</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="PROCESS_CODE" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Process Code</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="CALLBACK_URL" value="https://fpx.reliva.com.my/response.php">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Module ID</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="MODULE_ID" value="https://fpx.reliva.com.my/response.php">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Transaction Description</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="TRANS_DESC" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Bank Code</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="BANK_CODE" value="">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Email</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="EMAIL" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Debug</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
        </section>
    </body>
</html>
