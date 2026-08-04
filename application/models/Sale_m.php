<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_m extends CI_Model {

    // Generate Unique Invoice Number with Locking
    public function invoice_no() 
    {
        // Lock table to prevent duplicate invoice
        $this->db->query("LOCK TABLES t_sale WRITE");

        $sql = "SELECT MAX(MID(invoice,9,4)) AS invoice_no 
                FROM t_sale 
                WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(), '%y%m%d')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int)$row->invoice_no) + 1;
            $no = sprintf("%'.04d", $n);  // Format nomor menjadi 4 digit (0001)
        } else {
            $no = "0001";
        }

        $invoice = "MP" . date('ymd') . $no;

        // Unlock table after invoice generation
        $this->db->query("UNLOCK TABLES");

        return $invoice;
    }

    // Retrieve All Cart Items
    public function get_cart($user_id = null)
{
    $this->db->select('t_cart.*, p_item.barcode, p_item.name as product_name');
    $this->db->from('t_cart');
    $this->db->join('p_item', 'p_item.item_id = t_cart.item_id');
    if ($user_id !== null) {
        $this->db->where('t_cart.user_id', $user_id);
    }
    $query = $this->db->get();
    return $query->result();
}




    

    // Retrieve Cart by User ID
    public function get_cart_by_user($user_id) {
        $this->db->select('c.*, i.barcode, i.name as product_name');
        $this->db->from('t_cart c');
        $this->db->join('p_item i', 'i.item_id = c.item_id');
        $this->db->where('c.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Add Item to Cart
    public function add_to_cart($data) {
        return $this->db->insert('t_cart', $data);
    }

    public function add_cart($params)
    {
        $this->db->insert('t_cart', $params);
    }

    
    // Remove Item from Cart
    public function remove_from_cart($cart_id) {
        return $this->db->delete('t_cart', ['cart_id' => $cart_id]);
    }

    // Clear Cart for Specific User (Optional)
    public function clear_cart_by_user($user_id) {
        return $this->db->delete('t_cart', ['user_id' => $user_id]);
    }


    // Menyimpan data transaksi ke t_sale
    public function insert_sale($data)
    {
        // Insert data ke tabel t_sale
        $this->db->insert('t_sale', $data);
        
        // Mengembalikan ID sale yang baru saja disimpan
        return $this->db->insert_id();
    }

    // Menyimpan detail transaksi ke t_sale_detail
    public function insert_sale_detail($data)
    {
        // Insert data ke tabel t_sale_detail
        $this->db->insert('t_sale_detail', $data);
    }

    // Menyimpan data cart
    public function insert_cart($data)
{
    if (!isset($data['user_id'])) {
        $data['user_id'] = $this->session->userdata('user_id') ?? null;
    }
    $this->db->insert('t_cart', $data);
}


    // Mengambil semua data cart berdasarkan user_id
    public function get_cart_items($user_id)
    {
        $this->db->select('*');
        $this->db->from('t_cart');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result_array();
    }

    // Menghapus data cart berdasarkan user_id
    public function delete_cart()
    {
        $this->db->empty_table('t_cart');  // Menghapus semua data dari tabel t_cart
        return true;

        //$this->db->where('user_id', $user_id);
        //$this->db->delete('t_cart');
    }

    public function clear_cart()
{
        $this->db->delete('t_cart', ['user_id' => $user_id]);

        return true;

}


    public function total_price()
    {

    $total_price = $this->input->post('price') * $this->input->post('qty');
    }
    
}
