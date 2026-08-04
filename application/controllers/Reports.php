<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    // public function __construct() {
    //     parent::__construct();
    //     // Load model untuk mengambil data penjualan
    //     $this->load->model('Reports_m');
    // }

    // public function index() {
    //     // Ambil histori penjualan dari database
    //     $sales = $this->Reports_m->get_sales_history();
    //     $this->template->load('template', 'reports/sales_reports');

    //     // Kirim data ke view
    //     $data['sales'] = $sales;
    //     $this->load->view('reports/sales_reports', $data);
    // }
    
    public function index() {
    $this->load->model('Reports_m');

    // Tangkap filter dari input
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');
    $order = $this->input->get('order') ?? 'desc'; // default terbaru

    // Ambil data berdasarkan filter
    if ($start_date && $end_date) {
        $data['sales'] = $this->Reports_m->get_sales_by_date($start_date, $end_date, $order);
    } else {
        $data['sales'] = $this->Reports_m->get_sales($order);
    }

    // Kirim data ke view
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['order'] = $order;

    $this->template->load('template', 'reports/sales_reports', $data);
    }


    
    public function delete_sale($sale_id)
{
    $this->load->model('Reports_m');

    // Panggil method delete (meskipun return NULL, tetap anggap sukses)
    $this->Reports_m->delete_sale($sale_id);

    $this->session->set_flashdata('success', 'Sale deleted successfully.');

    redirect('reports/index');
}

    
    public function print() {
    $this->load->model('Reports_m');

    // Tangkap filter dari URL (sama seperti index)
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');
    $order = $this->input->get('order') ?? 'desc';

    if ($start_date && $end_date) {
        $data['sales'] = $this->Reports_m->get_sales_by_date($start_date, $end_date, $order);
    } else {
        $data['sales'] = $this->Reports_m->get_sales($order);
    }

    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;

    $this->load->view('reports/print_sales_reports', $data);
    }

    public function sales_detail_report()
{
    $this->load->model('Reports_m');
    $data['detail'] = $this->Reports_m->get_sales_detail();
    $this->template->load('template', 'reports/sales_detail_reports', $data);
}

public function sale_detail_ajax($sale_id)
{
    $this->load->model('Reports_m');

    $sale = $this->Reports_m->get_sale_by_id($sale_id);
    $detail = $this->Reports_m->get_sale_detail($sale_id);

    if (!$sale) {
        echo json_encode(['status' => false, 'message' => 'Sale not found.']);
        return;
    }

    $sale_data = [
        'invoice' => $sale->invoice,
        'customer_id' => $sale->customer_id,
        'total_price' => $sale->total_price,
        'discount' => $sale->discount,
        'final_price' => $sale->final_price,
        'cash' => $sale->cash,
        'remaining' => $sale->remaining,
        'date' => indo_date($sale->date),
        'note' => $sale->note,
    ];

    $detail_data = [];
    foreach ($detail->result() as $d) {
        $profit = ($d->price - $d->purchase_price) * $d->qty;

        $detail_data[] = [
            'product_name' => $d->product_name,
            'purchase_price' => $d->purchase_price,
            'price' => $d->price,
            'qty' => $d->qty,
            'total' => $d->total,
            'profit' => $profit
        ];
    }

    echo json_encode([
        'status' => true,
        'sale' => $sale_data,
        'detail' => $detail_data
    ]);
}

public function print_nota($sale_id)
{
    $this->load->model('Reports_m');

    // Ambil data header transaksi
    $sale = $this->Reports_m->get_sale_by_id($sale_id);
    $detail = $this->Reports_m->get_sale_detail($sale_id);

    if(!$sale) {
        show_404();
    }

    $data['sale'] = $sale;
    $data['detail'] = $detail->result();

    $this->load->view('reports/print_nota', $data);
}

public function summary_report($period = 'daily')
{
    $this->load->model('Reports_m');

    $data['period'] = $period;

    switch($period) {
        case 'daily':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_day();
            $data['title'] = 'Laporan Penjualan Harian';
            break;
        case 'weekly':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_week();
            $data['title'] = 'Laporan Penjualan Mingguan';
            break;
        case 'yearly':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_year();
            $data['title'] = 'Laporan Penjualan Tahunan';
            break;
        default:
            show_404();
    }

    // Hitung total keseluruhan
    $total_sales = 0;
    foreach ($data['reports'] as $row) {
        $total_sales += $row->total_sales;
    }
    $data['total_sales'] = $total_sales;

    $this->template->load('template', 'reports/summary_reports', $data);
}


public function summary_print($period = 'daily')
{
    $this->load->model('Reports_m');

    switch($period) {
        case 'daily':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_day();
            $data['title'] = 'Laporan Penjualan Harian';
            break;
        case 'weekly':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_week();
            $data['title'] = 'Laporan Penjualan Mingguan';
            break;
        case 'yearly':
            $data['reports'] = $this->Reports_m->get_sales_grouped_by_year();
            $data['title'] = 'Laporan Penjualan Tahunan';
            break;
        default:
            show_404();
    }

    $data['period'] = $period;

    $this->load->view('reports/summary_print', $data);
}








}