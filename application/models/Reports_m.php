<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reports_m extends CI_Model {

    // public function get_sales_history() {
    //     // Query untuk mengambil data penjualan dari tabel 't_sale'
    //     $this->db->select('invoice, date, customer_id, total_price, discount, dinal_price, cash, remaining, note, user_id');
    //     $this->db->from('t_sale');
    //     $this->db->order_by('date', 'DESC');  // Menampilkan data terbaru dulu
        
    //     $query = $this->db->get();

    //     // Cek jika query gagal
    //     if ($query === false) {
    //         // Log error jika query gagal
    //         log_message('error', 'Error querying the database: ' . $this->db->last_query());
    //         return [];  // Kembalikan array kosong jika query gagal
    //     }

    //     // Log query yang dijalankan untuk debugging
    //     log_message('debug', 'Last Query: ' . $this->db->last_query());

    //     // Kembalikan hasil query dalam bentuk array
    //     return $query->result_array();
    // }

    public function get_sales($order = 'desc')
    {
    $this->db->from('t_sale');
    $this->db->order_by('date', $order);
    return $this->db->get()->result_array();
    }


    public function delete_sale($id)
{
    // Hapus detail dulu
    $this->db->where('sale_id', $id);
    $this->db->delete('t_sale_detail');

    // Baru hapus header sale
    $this->db->where('sale_id', $id);
    $this->db->delete('t_sale');

    //return $delete;
}

    // public function delete_sale($sale_id)
    // {
    //     // Menghapus data penjualan berdasarkan ID
    //     $this->db->where('sale_id', $sale_id);
    //     return $this->db->delete('t_sale'); // Asumsikan nama tabel penjualan adalah 'sales'
    // }

    public function get_sales_by_date($start_date, $end_date, $order = 'desc')
    {
    $this->db->from('t_sale');
    if ($start_date && $end_date) {
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
    }
    $this->db->order_by('date', $order);
    return $this->db->get()->result_array();
    }

    public function get_sale_detail($sale_id)
{
    $this->db->select('
        t_sale_detail.*,
        t_sale.invoice,
        p_item.name as product_name,
        p_item.purchase_price
    ');
    $this->db->from('t_sale_detail');
    $this->db->join('t_sale', 't_sale.sale_id = t_sale_detail.sale_id');
    $this->db->join('p_item', 'p_item.item_id = t_sale_detail.item_id');
    $this->db->where('t_sale_detail.sale_id', $sale_id);
    return $this->db->get();
}


     public function get_sale_by_id($sale_id)
    {
        $this->db->from('t_sale');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row();
    }


    public function get_sales_grouped_by_day()
{
    $this->db->select("DATE(date) as period_date, SUM(final_price) as total_sales, COUNT(*) as total_transactions");

    $this->db->group_by("DATE(date)");
    $this->db->order_by("DATE(date)", "DESC");
    return $this->db->get("t_sale")->result();
}

public function get_sales_grouped_by_week()
{
    $this->db->select("YEAR(date) as year, WEEK(date, 1) as week, SUM(final_price) as total_sales, COUNT(*) as total_transactions");

    $this->db->group_by(["YEAR(date)", "WEEK(date, 1)"]);
    $this->db->order_by("year DESC, week DESC");
    return $this->db->get("t_sale")->result();
}

public function get_sales_grouped_by_year()
{
    $this->db->select("YEAR(date) as year, SUM(final_price) as total_sales, COUNT(*) as total_transactions");

    $this->db->group_by("YEAR(date)");
    $this->db->order_by("year DESC");
    return $this->db->get("t_sale")->result();
}





}

