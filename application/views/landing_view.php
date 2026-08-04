<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeleraMuda Landing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-LYFLuBtpQF4LGzMv"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/dist/css/landing.css')?>">
</head>
<body>
    
    <nav class="navbar">
        <h1>SeleraMuda</h1>
        <div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="Auth/login">Login</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero-container">
        <div>
            <div>
                <h1>Aplikasi Kasir Untuk Toko Selera Muda</h1>
                <p>Solusi Cerdas untuk Transaksi Mudah dan Cepat!</p>
            </div>
        </div>
        <img src="<?=base_url('assets/dist/img/8742.png')?>" style="width:" alt="hero">
    </section>

    <section class="description-container">
        <div>
            <div>
                <h2>SeleraMuda</h2>
                <p>Kasir yang dirancang khusus untuk memudahkan pengelolaan transaksi di toko Selera Muda. 
                    Dengan antarmuka yang user-friendly, memungkinkan pemilik toko dan karyawan untuk melakukan pencatatan penjualan, pengelolaan inventaris, serta laporan keuangan dengan cepat dan efisien.</p>
            </div>
        </div>
        <img src="<?=base_url('assets/dist/img/market.jpg')?>"  style="width:" alt="desc">
    </section>

    <section id="features">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800">Features</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-cash-register text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Transaksi Mudah</h3>
                    <p class="mt-2 text-gray-600">Tangani transaksi dengan mudah dan efisien.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-chart-line text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Laporan Terperinci</h3>
                    <p class="mt-2 text-gray-600">Hasilkan laporan terperinci untuk melacak kinerja bisnis Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-users text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Manajemen Pelanggan</h3>
                    <p class="mt-2 text-gray-600">Kelola pelanggan Anda secara efisien dengan alat kami.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-box-open text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Manajemen Inventaris</h3>
                    <p class="mt-2 text-gray-600">Lacak inventaris Anda secara real-time.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-shield-alt text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Aman</h3>
                    <p class="mt-2 text-gray-600">Data Anda aman dengan langkah-langkah keamanan terbaik kami.</p>
                </div>
            </div>
        </div>
    </section>

    


    <!-- <section id="pricing" class="bg-white py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800">Pricing</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Basic</h3>
                    <p class="mt-4 text-gray-600">Rp 19.000 / bulan</p>
                </div>
                
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Standard</h3>
                    <p class="mt-4 text-gray-600">Rp 49.000 / bulan</p>
                    
                </div>
               
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Premium</h3>
                    <p class="mt-4 text-gray-600">Rp 99.000 / bulan</p>
                </div>
            </div>
        </div>
    </section>

    <section id="signup">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800">SignUp</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-cash-register text-4xl text-blue-500"></i>
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Mulai Bisnis Anda</h3>
                    <p class="mt-2 text-gray-600">Daftar dan Berlangganan Sekarang!</p>
                    <a href="<?=site_url('pricing')?>" class="btn btn-primary btn-block">Registrasi</a>

                </div>
            </div>
        </div>
    </section> -->

    <footer style="margin-top: 30px; text-align: center; padding: 20px; background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
        <div class="logo-footer">
        <h1>SeleraMuda</h1>
        </div>
        <p style="margin-top: 10px; font-size: 14px; color: #6c757d;">&copy; 2025 SeleraMuda. All rights reserved.</p>
    </footer>


    <!-- <script>
        document.querySelectorAll('.choose-plan').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plan = this.getAttribute('data-plan');

                fetch('<?= site_url('landing/create_payment') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: plan=${plan}
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil!');
                                window.location.href = '<?= site_url('auth/login') ?>';
                            },
                            onPending: function(result) {
                                alert('Pembayaran sedang diproses.');
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal.');
                            }
                        });
                    } else {
                        alert('Terjadi kesalahan: ' + data.error);
                    }
                });
            });
        });
    </script> -->
</body>
</html>