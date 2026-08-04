<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Midtrans/Midtrans.php';

class Sale extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Sale_m');
        $this->load->model('Customer_m');
        $this->load->model('Item_m');
        $this->load->config('midtrans');
        \Midtrans\Config::$serverKey = $this->config->item('midtrans_server_key');
        \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function index() {
        $data['customer'] = $this->Customer_m->get()->result();
        $data['invoice'] = $this->Sale_m->invoice_no();
        $data['item'] = $this->Item_m->get()->result();
        $this->template->load('template', 'transaction/sale/sale_form', $data);
    }

    // public function process() {
    //     if ($this->input->post('add_to_cart')) {
    //         $data = [
    //             'item_id' => $this->input->post('item_id'),
    //             'price' => $this->input->post('price'),
    //             'qty' => $this->input->post('qty'),
    //             'discount' => $this->input->post('discount'),
    //             'total' => $this->input->post('total')
    //         ];

    //         // Validasi data
    //         if (!$data['item_id'] || !$data['price'] || !$data['qty'] || $data['qty'] <= 0) {
    //             $this->session->set_flashdata('error', 'Invalid data for cart.');
    //             redirect('sale');
    //         }

    //         // Cek apakah item sudah ada di cart
    //         $existing_cart = $this->db->get_where('t_cart', ['item_id' => $data['item_id']])->row();
    //         if ($existing_cart) {
    //             $this->session->set_flashdata('error', 'Item already in cart.');
    //             redirect('sale');
    //         }

    //         $this->db->insert('t_cart', $data);
    //         if ($this->db->affected_rows() > 0) {
    //             $this->session->set_flashdata('success', 'Item added to cart.');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to add item to cart.');
    //         }
    //     } elseif ($this->input->post('delete_cart')) {
    //         $cart_id = $this->input->post('cart_id');
    //         if ($cart_id) {
    //             $this->db->delete('t_cart', ['cart_id' => $cart_id]);
    //             if ($this->db->affected_rows() > 0) {
    //                 $this->session->set_flashdata('success', 'Item removed from cart.');
    //             } else {
    //                 $this->session->set_flashdata('error', 'Failed to remove item from cart.');
    //             }
    //         }
    //     } elseif ($this->input->post('process_payment')) {
    //         $sale = [
    //             'invoice' => $this->Sale_m->invoice_no(),
    //             'customer_id' => $this->input->post('customer_id') ?: null,
    //             'total_price' => $this->input->post('sub_total'),
    //             'discount' => $this->input->post('discount'),
    //             'final_price' => $this->input->post('grand_total'),
    //             'cash' => $this->input->post('cash'),
    //             'remaining' => $this->input->post('change'),
    //             'note' => $this->input->post('note'),
    //             'date' => date('Y-m-d H:i:s'),
    //             'user_id' => $this->fungsi->user_login()->user_id
    //         ];

    //         $this->db->insert('t_sale', $sale);
    //         if ($this->db->affected_rows() > 0) {
    //             $sale_id = $this->db->insert_id();
    //         } else {
    //             log_message('error', 'Failed to insert sale record');
    //             // Kirim pesan error ke frontend
    //         }
            
    //         if ($this->db->affected_rows() > 0) {
    //             $sale_id = $this->db->insert_id();
    //             $cart = $this->db->get('t_cart')->result();
    //             foreach ($cart as $c) {
    //                 $detail = [
    //                     'sale_id' => $sale_id,
    //                     'item_id' => $c->item_id,
    //                     'price' => $c->price,
    //                     'qty' => $c->qty,
    //                     'discount_item' => $c->discount,
    //                     'total' => $c->total
    //                 ];
    //                 $this->db->insert('t_sale_detail', $detail);

    //                 // Update stok barang
    //                 $this->db->set('stock', 'stock - ' . $c->qty, FALSE);
    //                 $this->db->where('item_id', $c->item_id);
    //                 $this->db->update('p_item');
    //             }

    //             $this->db->empty_table('t_cart');
    //             $this->session->set_flashdata('success', 'Payment processed successfully.');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to process payment.');
    //         }
    //     }
    //     redirect('sale');
    // }

    
    public function process() {
        log_message('error', '=== DEBUG SESSION add_to_cart: ' . print_r($this->session->userdata(), true));
        if ($this->input->post('process_payment')) {
            $this->db->trans_start();  // Mulai transaksi database
    
            $sale = [
                'invoice' => $this->Sale_m->invoice_no(),
                'customer_id' => $this->input->post('customer_id') ?: null,
                'total_price' => $this->input->post('sub_total'),
                'discount' => $this->input->post('discount'),
                'final_price' => $this->input->post('grand_total'),
                'cash' => $this->input->post('cash'),
                'remaining' => $this->input->post('change'),
                'note' => $this->input->post('note'),
                'date' => date('Y-m-d H:i:s'),
                'user_id' => $this->fungsi->user_login()->user_id
            ];
    
            $this->db->insert('t_sale', $sale);
            $sale_id = $this->db->insert_id();
    
            if (!$sale_id) {
                $this->session->set_flashdata('error', 'Gagal menyimpan transaksi.');
                redirect('sale');
            }
    
            //$cart = $this->db->get('t_cart')->result();
            $user_id = $this->session->userdata('userid');
            $cart = $this->db->get_where('t_cart', ['user_id' => $user_id])->result();

            foreach ($cart as $c) {
                // Pengecekan stok sebelum insert
                $item = $this->db->get_where('p_item', ['item_id' => $c->item_id])->row();
                if ($item->stock < $c->qty) {
                    $this->session->set_flashdata('error', 'Stok tidak mencukupi untuk ' . $item->name);
                    $this->db->trans_rollback();  // Rollback transaksi jika stok kurang
                    redirect('sale');
                }
    
                $detail = [
                    'sale_id' => $sale_id,
                    'item_id' => $c->item_id,
                    'price' => $c->price,
                    'qty' => $c->qty,
                    'discount_item' => $c->discount,
                    'total' => $c->total
                ];
                $this->db->insert('t_sale_detail', $detail);
    
                // Update stok barang
                $this->db->set('stock', 'stock - ' . $c->qty, FALSE);
                $this->db->where('item_id', $c->item_id);
                $this->db->update('p_item');
            }
    
            $this->db->empty_table('t_cart');
            $this->db->trans_complete();  // Selesaikan transaksi
    
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal memproses pembayaran.');
            } else {
                $this->session->set_flashdata('success', 'Pembayaran berhasil diproses.');
            }
            redirect('sale');
        }
    }
    

    
    // Fungsi untuk mendapatkan counter cart_id dan menambahkannya
function generate_cart_id() {
    // Ambil nilai counter terakhir
    $query = $this->db->get('cart_counter');
    $counter = $query->row();

    // Jika belum ada counter, set ke 1
    if (!$counter) {
        $this->db->insert('cart_counter', ['id' => 1, 'current_counter' => 1]);
        return 1;
    }

    // Increment nilai counter dan update
    $new_counter = $counter->current_counter + 1;
    $this->db->update('cart_counter', ['current_counter' => $new_counter], ['id' => 1]);

    return $new_counter;
}




    public function cart_data() {
        $data['cart'] = $this->db->get('t_cart')->result();
        $this->load->view('transaction/cart_data', $data);
    }

    public function cart_delete($cart_id) {
        if ($cart_id) {
            $this->db->delete('t_cart', ['cart_id' => $cart_id]);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Item deleted.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete item.');
            }
        }
        redirect('sale');
    }

    public function save_cart() {
        // Logic to save item in cart
        log_message('error', '=== DEBUG user_id session: ' . print_r($this->session->userdata(), true));
        $user_id = $this->session->userdata('user_id'); // Ambil user ID dari session
        $item_id = $this->input->post('item_id');
        $price = $this->input->post('price');
        $qty = $this->input->post('qty');
        $discount = $this->input->post('discount');
        $total = $this->input->post('total');

        if (empty($item_id) || empty($price) || empty($qty)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        // Cek apakah item sudah ada dalam cart
        $existing_cart = $this->db->get_where('t_cart', ['item_id' => $item_id])->row();
        if ($existing_cart) {
            echo json_encode(['status' => 'error', 'message' => 'Item already in cart']);
            return;
        }

        $data = [
            'item_id' => $item_id,
            'price' => $price,
            'qty' => $qty,
            'discount' => $discount,
            'total' => $total,
            'user_id' => $user_id
        ];

        // Simpan ke database
        if ($this->db->insert('t_cart', $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Item added to cart']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart']);
        }
        

        echo '<pre>';
        print_r($this->session->userdata());
        exit;

    }

    public function load_cart() {
        // Load the current cart items
        $user_id = $this->session->userdata('user_id'); // Ambil user ID dari session
      // $cart_items = $this->sale_m->get_cart(['t_cart.user_id' => $user_id]);
       // $data = $this->Sale_m->get_cart_by_user($user_id); // Panggil fungsi model yang difilter user_id

        $cart = $this->Sale_m->get_cart();
        $response = [];
        foreach ($cart as $index => $item) {
            $response[] = [
                'no' => $index + 1,
                'barcode' => $item->barcode,
                'product_name' => $item->product_name,
                'price' => $item->price,
                'qty' => $item->qty,
                'discount' => $item->discount,
                'total' => $item->total,
                'cart_id' => $item->cart_id,
                'item_id' => $item->item_id

            ];
        }
        echo json_encode($response);
    }

    public function remove_cart() {
        // Logic to remove item from cart
        $user_id = $this->session->userdata('user_id'); // Ambil user ID dari session
        $cart_id = $this->input->post('cart_id');
        $this->db->delete('t_cart', ['cart_id' => $cart_id]);
        $response = ['status' => 'success', 'message' => 'Item removed from cart'];
        echo json_encode($response);
    }

    public function get_cart() {
        $user_id = $this->session->userdata('userid');
        $cart = $this->Sale_m->get_cart($user_id);

        $this->db->select('t_cart.*, p_item.barcode, p_item.name as product_name');
        $this->db->from('t_cart');
        $this->db->join('p_item', 'p_item.item_id = t_cart.item_id');
        $query = $this->db->get();
        $data['cart'] = $query->result();

        // Send data as JSON
        echo json_encode($data);
    }



    // Fungsi untuk menyimpan transaksi
    public function save_sale() {
    // Ambil data yang dikirimkan dari frontend
    $user_id = $this->session->userdata('userid');

    $invoice = $this->input->post('invoice');
    $date = $this->input->post('date');
    $cashier = $this->input->post('cashier');

    $customer_id = $this->input->post('customer');
    if (empty($customer_id)) 
    $customer_id = 3; // default "Umum"
    $sub_total = $this->input->post('sub_total');
    $discount = $this->input->post('discount');
    $grand_total = $this->input->post('grand_total');
    $cash = $this->input->post('cash');
    $change = $this->input->post('change');
    $note = $this->input->post('note');

    // Ambil data items dalam bentuk array langsung dari POST
    $items_json = $this->input->post('items');  // Tidak perlu decode JSON
    $items = json_decode($items_json, true);


    log_message('debug', 'POST items JSON: ' . $this->input->post('items'));

    // 🔎 Deteksi error decode
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'error', 'message' => 'JSON decode gagal: ' . json_last_error_msg()]);
        return;
    }
   // $items = json_decode($this->input->post('items'), true);
    log_message('debug', 'Items POST: ' . print_r($items, true));
   // log_message('debug', 'Decoded items: ' . print_r($items, true));
   log_message('debug', 'Raw POST Data: ' . print_r($this->input->post(), true));



    // Jika items kosong, kirimkan pesan error
    if (empty($items)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart kosong']);
        return;
    }

    // Simpan data transaksi ke tabel t_sale
    $sale_data = [
    'invoice' => $this->input->post('invoice'),
    'customer_id' => $customer_id, // ✅ gunakan variabel yang sudah difilter
    'total_price' => str_replace('.', '', $this->input->post('sub_total')),
    'discount' => str_replace('.', '', $this->input->post('discount')),
    'final_price' => str_replace('.', '', $this->input->post('grand_total')),
    'cash' => str_replace('.', '', $this->input->post('cash')),
    'remaining' => str_replace('.', '', $this->input->post('change')),
    'note' => $this->input->post('note'),
    'date' => $this->input->post('date'),
    'user_id' => $this->input->post('cashier'),
    'created' => date('Y-m-d H:i:s')
];



    log_message('debug', 'Insert Sale Data: ' . print_r($sale_data, true));
    $this->db->insert('t_sale', $sale_data);
    $sale_id = $this->db->insert_id();  // Ambil ID transaksi yang baru saja dimasukkan
    log_message('debug', 'Insert Sale DONE. Error? ' . $this->db->error()['message']);


    // Simpan detail transaksi ke tabel t_sale_detail
    foreach ($items as $item) {
        $sale_detail_data = [
            'sale_id' => $sale_id,
            'item_id' => $item['item_id'],
            'price' => $item['price'],
            'qty' => $item['qty'],
            'discount' => $item['discount'],
            'total' => $item['total']
        ];
        $this->db->insert('t_sale_detail', $sale_detail_data);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', 'Gagal insert t_sale_detail: ' . $this->db->error()['message']);
        }
         // ⬇️ Tambahkan ini untuk mengurangi stok
        $stock_params = [
            'item_id' => $item['item_id'],
            'qty' => $item['qty']
        ];
        $this->Item_m->update_stock_out($stock_params);
        
        log_message('debug', 'Stock reduced for item: ' . $item['item_id']);
    }

    // Kirimkan respon kembali ke frontend
    echo json_encode(['status' => 'success']);
    

}

public function clear_cart() {
    // Panggil fungsi di model untuk menghapus data cart
    $result = $this->Sale_m->delete_cart();

    // Berikan response JSON ke frontend
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Cart telah dibersihkan.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus cart.']);
    }
}

public function add_to_cart()
{
    log_message('error', '=== DEBUG SESSION add_to_cart: ' . print_r($this->session->userdata(), true));
    $post = $this->input->post();
    $user_id = $this->session->userdata('userid');

    // Cek apakah item sudah ada
    $existing = $this->db->get_where('t_cart', [
        'item_id' => $post['item_id'],
        'user_id' => $user_id
    ])->row();

    if ($existing) {
        // Kalau sudah ada, kamu bisa update qty-nya, atau tolak:
        echo json_encode(['status' => 'error', 'message' => 'Item sudah ada di cart.']);
        return;
    }

    $params = [
        'item_id' => $post['item_id'],
        'price' => $post['price'],
        'qty' => $post['qty'],
        'total' => $post['price'] * $post['qty'],
        'user_id' => $user_id
    ];

    $this->Sale_m->add_cart($params);
    echo json_encode(['status' => 'success']);
}


public function create_midtrans_transaction()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    header('Content-Type: application/json');
    require_once APPPATH . 'libraries/Midtrans/Midtrans.php';

    \Midtrans\Config::$serverKey = 'SB-Mid-server-bHyOXoGMx1f-OnA5VwfQHV92';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // Ambil items dari frontend
    $items_raw = json_decode($this->input->post('items'), true);

    if (empty($items_raw)) {
        echo json_encode(['status' => 'error', 'message' => 'Items kosong.']);
        return;
    }

    $items = [];
    $discount_total = 0;

    // Proses setiap item
    foreach ($items_raw as $item) {
        $id = isset($item['item_id']) ? $item['item_id'] : (isset($item['id']) ? $item['id'] : null);
        $name = $item['product_name'] ?? $item['name'] ?? 'Produk Tanpa Nama';
        $price = (int)($item['price'] ?? 0);
        $qty = (int)($item['qty'] ?? $item['quantity'] ?? 1);
        $discount = (int)($item['discount'] ?? 0);

        // Jika item diskon dikirim sebagai produk terpisah (id = DISCOUNT)
        if (strtoupper($id) === 'DISCOUNT' || stripos($name, 'diskon') !== false) {
            $discount_total += abs($price); // simpan nilai diskon
            continue; // skip dari item utama
        }

        // Simpan item normal
        $items[] = [
            'id' => $id,
            'price' => $price,
            'quantity' => $qty,
            'name' => $name
        ];
    }

    // Hitung total dari semua item normal
    $gross_amount = 0;
    foreach ($items as $it) {
        $gross_amount += ($it['price'] * $it['quantity']);
    }

    // Kurangi total dengan diskon
    $gross_amount -= $discount_total;
    if ($gross_amount < 0) $gross_amount = 0;

    // Tambahkan baris diskon (biar muncul juga di popup Midtrans)
    if ($discount_total > 0) {
        $items[] = [
            'id' => 'DISCOUNT',
            'price' => -$discount_total,
            'quantity' => 1,
            'name' => 'Diskon'
        ];
    }

    // Kalau grand_total dari form berbeda (misalnya hasil hitung manual kasir), pakai itu
    if ($this->input->post('grand_total')) {
        $form_total = (int)preg_replace("/[^0-9]/", "", $this->input->post('grand_total'));
        if ($form_total != $gross_amount) {
            $gross_amount = $form_total;
        }
    }

    // Siapkan payload ke Midtrans
    $transaction = [
        'transaction_details' => [
            'order_id' => $this->input->post('invoice'),
            'gross_amount' => $gross_amount
        ],
        'item_details' => $items
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        echo json_encode(['snapToken' => $snapToken]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}





public function save_sale_midtrans()
{
    $transaction_result = json_decode($this->input->post('transaction_result'), true);
    $items = json_decode($this->input->post('items'), true);
    $user_id = $this->input->post('user_id') ?? $this->session->userdata('userid') ?? 1;
    $customer_id = $this->input->post('customer');

    if (!$transaction_result || !$items) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        return;
    }

    // Ambil data pembayaran dari frontend
    $sub_total = (float)preg_replace("/[^0-9]/", "", $this->input->post('sub_total'));
    $discount = (float)preg_replace("/[^0-9]/", "", $this->input->post('discount'));
    $grand_total = (float)preg_replace("/[^0-9]/", "", $this->input->post('grand_total'));

    // Data dari Midtrans
    $transaction_id = $transaction_result['transaction_id'] ?? '';
    $order_id = $transaction_result['order_id'] ?? '';
    $gross_amount = $transaction_result['gross_amount'] ?? 0;
    $payment_type = $transaction_result['payment_type'] ?? '';
    $transaction_status = $transaction_result['transaction_status'] ?? '';

    if (!$order_id) {
        echo json_encode(['status' => 'error', 'message' => 'order_id kosong']);
        return;
    }

    $this->db->trans_start();

    // ✅ Simpan ke tabel t_sale
    $saleData = [
        'invoice'           => $order_id,
        'date'              => date('Y-m-d H:i:s'),
        'customer_id'       => !empty($customer_id) ? $customer_id : 3,
        'total_price'       => $sub_total,
        'discount'          => $discount,
        'final_price'       => $grand_total,
        'cash'              => 0,
        'remaining'         => 0,
        'note'              => 'Pembayaran via Midtrans',
        'user_id'           => $user_id,
        'cashier'           => $this->session->userdata('username') ?? 'Midtrans',
        'payment_type'      => $payment_type,
        'transaction_status'=> $transaction_status,
        'transaction_id'    => $transaction_id
    ];

    $this->db->insert('t_sale', $saleData);
    $sale_id = $this->db->insert_id();

    if (!$sale_id) {
        $error = $this->db->error();
        echo json_encode(['status' => 'error', 'message' => 'Gagal insert sale: ' . $error['message']]);
        return;
    }

    // ✅ Simpan detail produk
    foreach ($items as $item) {
        $item_id = $item['item_id'] ?? ($item['id'] ?? null);
        $qty = $item['qty'] ?? ($item['quantity'] ?? 1);
        $discount_item = $item['discount'] ?? 0;
        $price = $item['price'] ?? 0;
        $total = $item['total'] ?? ($price * $qty);

        $detail = [
            'sale_id'   => $sale_id,
            'item_id'   => $item_id,
            'price'     => $price,
            'qty'       => $qty,
            'discount'  => $discount_item,
            'total'     => $total
        ];

        $this->db->insert('t_sale_detail', $detail);

        if ($this->db->affected_rows() <= 0) {
            log_message('error', '❌ Gagal insert t_sale_detail: ' . $this->db->error()['message']);
        }

        // ✅ Update stok
        if ($item_id) {
            $this->db->set('stock', 'stock - ' . (int)$qty, false);
            $this->db->where('item_id', $item_id);
            $this->db->update('p_item');
        }
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $error = $this->db->error();
        echo json_encode(['status' => 'error', 'message' => 'Transaksi gagal: ' . $error['message']]);
    } else {
        if (method_exists($this->Sale_m, 'clear_cart_by_user')) {
            $this->Sale_m->clear_cart_by_user($user_id);
        }
        echo json_encode(['status' => 'success']);
    }
}









}


