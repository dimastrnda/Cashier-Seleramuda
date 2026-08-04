<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasirPlus Landing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-LYFLuBtpQF4LGzMv"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/dist/css/landing.css')?>">
</head>
<body>
    
    <nav class="navbar">
        <h1>KasirPlus</h1>
        <div>
            <ul>
                <li><a href="#signup">SignUp</a></li>
            </ul>
        </div>
    </nav>

    <section id="pricing" class="bg-white py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800">Pricing</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Basic Plan -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Basic</h3>
                    <p class="mt-4 text-gray-600">Rp 19.000 / bulan</p>
                    <button class="choose-plan mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" data-plan="Basic">Choose Plan</button>
                </div>
                <!-- Standard Plan -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Standard</h3>
                    <p class="mt-4 text-gray-600">Rp 49.000 / bulan</p>
                    <button class="choose-plan mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" data-plan="Standard">Choose Plan</button>
                </div>
                <!-- Premium Plan -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-bold text-gray-800">Premium</h3>
                    <p class="mt-4 text-gray-600">Rp 99.000 / bulan</p>
                    <button class="choose-plan mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" data-plan="Premium">Choose Plan</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.choose-plan').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const plan = this.getAttribute('data-plan');
                const price = plan === 'Basic' ? 19000 :
                              plan === 'Standard' ? 49000 : 99000;

                // Arahkan ke halaman register dengan membawa data plan dan harga
                window.location.href =`<?= site_url('register/index') ?>?plan=${plan}&price=${price}`;
            });
        });
    </script>
</body>
</html>