<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->config('midtrans');
        \Midtrans\Config::$serverKey = $this->config->item('midtrans_server_key');
        \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function index()
    {
        $this->load->view('landing_view');
    }

    public function create_payment()
    {
        $plan = $this->input->post('plan');
        $price = 0;

        // Tentukan harga berdasarkan plan
        switch ($plan) {
            case 'Basic':
                $price = 19000; // Harga dalam IDR
                break;
            case 'Standard':
                $price = 49000;
                break;
            case 'Premium':
                $price = 99000;
                break;
        }

        $transaction_details = [
            'order_id' => uniqid(), // Order ID unik
            'gross_amount' => $price, // Total harga
        ];

        $customer_details = [
            'first_name' => 'Customer',
            'email' => 'customer@example.com', // Bisa diganti dengan data user
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            echo json_encode(['snapToken' => $snapToken]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}