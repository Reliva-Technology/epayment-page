<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>E-Payment Test Page</title>
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
                                <h4>Maklumat Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="01-mode.php" id="form-bayar">
                                <div class="form-group row">
                                    <label for="merchant" class="col-lg-3 col-form-label">Jabatan/Agensi/Syarikat</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="merchant" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="trans_id" class="col-lg-3 col-form-label">ID Transaksi Pelanggan (mesti unik)</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="ORDER_ID" value="MPMM50633231893">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_name" class="col-lg-3 col-form-label">Nama Pembayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="CUSTOMER_NAME" value="Fadli Saad">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_email" class="col-lg-3 col-form-label">Email Pembayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="CUSTOMER_EMAIL" value="epic@reliva.com.my">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_phone_no" class="col-lg-3 col-form-label">No Telefon Pembayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="CUSTOMER_MOBILE" value="0137020114">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="amount" class="col-lg-3 col-form-label">Jumlah</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="AMOUNT" value="35.10">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Keterangan</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="TXN_DESC" value="Bayaran pembaharuan lesen">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="MERCHANT_CODE" value="sandbox">
                                <button type="submit" class="btn btn-primary">Pembayaran</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
        </section>
    </body>
</html>