<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Skrip Midtrans -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-LYFLuBtpQF4LGzMv"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="login-logo">
            <a href="#"><b>KasirPlus</b></a>
        </div>
        <div class="Catatan">
            <p class="col-md-3 offset-md-2">Registrasi ini hanya dilakukan untuk Admin! Jika Anda Seorang Kasir, Maka Akun anda akan dibuatkan oleh Admin.</p>
        </div>
        <div class="col-md-8 offset-md-2">
            <form action="<?=site_url('register/process_register')?>" method="post">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo set_value("username") ?>">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" value="<?php echo set_value("password") ?>">
                </div>
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo set_value("name") ?>">
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo set_value("address") ?>">
                </div>
                <div class="mb-3">
                    <label>Level</label>
                    <input type="text" name="level" class="form-control" value="1" readonly>
                </div>
                <!-- Row untuk Plan dan Price -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Plan</label>
                            <input type="text" name="plan" class="form-control" value="<?= $this->input->get('plan') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?= $this->input->get('price') ?>" readonly>
                        </div>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary btn-block">Submit</button>
            </form>

            <!-- Jika Snap Token ada, panggil Snap -->
            <?php if(isset($snapToken)): ?>
                <script>
                    window.onload = function() {
                        snap.pay('<?= $snapToken ?>', {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil!');
                                window.location.href = 'http://localhost/kasirplus/auth/login';
                            },
                            onPending: function(result) {
                                alert('Pembayaran sedang diproses.');
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal.');
                            }
                        });
                    };
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>