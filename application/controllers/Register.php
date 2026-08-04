<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index()
    {
        // Tampilkan form registrasi
        $this->load->view('register');
    }

    public function process_register()
    {
        // Muat konfigurasi Midtrans
        $this->load->config('midtrans');
        \Midtrans\Config::$serverKey = $this->config->item('midtrans_server_key');
        \Midtrans\Config::$clientKey = $this->config->item('midtrans_client_key');
        \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil data dari form dengan sanitasi
        $post = $this->input->post(null, TRUE); 

        // Muat model user_m
        $this->load->model('user_m'); 

        // Paksa level menjadi 1 untuk keamanan
        $post['level'] = 1; 

        // Simpan data user
        $this->user_m->register($post);

        // Ambil harga dari form
        $price = $post['price']; 

        // Setup untuk transaksi Midtrans
        $transaction_details = [
            'order_id' => uniqid(),  // Order ID unik
            'gross_amount' => $price,  // Total harga
        ];

        // Tentukan detail customer (gunakan data dari form atau data user)
        $customer_details = [
            'first_name' => $post['name'],  // Nama pelanggan
            'email' => 'customer@example.com',  // Ganti dengan email yang valid
        ];

        // Set parameter transaksi untuk Midtrans
        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Ambil Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Proses pembayaran dengan Snap Token
            $data['snapToken'] = $snapToken;
            $this->load->view('register', $data);

        } catch (Exception $e) {
            // Jika terjadi kesalahan
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}