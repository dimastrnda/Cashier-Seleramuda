<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item_m extends CI_Model {

    var $column_order = array(null, 'barcode', 'p_item.name', 'category_name', 'unit_name', 'purchase_price', 'price', 'stock');
    var $column_search = array('barcode', 'p_item.name', 'purchase_price', 'price');
    var $order = array('item_id' => 'asc');

    private function _get_datatables_query() {
        $this->db->select('p_item.*, 
            p_category.name as category_name, 
            p_unit.name as unit_name,
            p_item.purchase_price'); // ✅ NEW
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_item.category_id = p_category.category_id');
        $this->db->join('p_unit', 'p_item.unit_id = p_unit.unit_id');

        $i = 0;
        foreach ($this->column_search as $item) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $this->db->from('p_item');
        return $this->db->count_all_results();
    }

    public function get($id = null) {
        $this->db->select("p_item.*, 
            p_category.name as category_name, 
            p_unit.name as unit_name,
            supplier.name as supplier_name,
            p_item.purchase_price");
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_category.category_id = p_item.category_id');
        $this->db->join('p_unit', 'p_unit.unit_id = p_item.unit_id');
        $this->db->join('supplier', 'supplier.supplier_id = p_item.supplier_id', 'left');
        $this->db->where('p_item.user_id', $this->session->userdata('user_id'));
        if ($id != null) {
            $this->db->where('item_id', $id);
        }
        $this->db->order_by('barcode', 'asc');
        $query = $this->db->get();
        return $query;
    }

    public function get_by_user($user_id) {
        $this->db->select("p_item.*, 
            p_category.name as category_name, 
            p_unit.name as unit_name,
            p_item.purchase_price");
        $this->db->from('p_item');
        $this->db->join('p_category', 'p_category.category_id = p_item.category_id');
        $this->db->join('p_unit', 'p_unit.unit_id = p_item.unit_id');
        $this->db->where('p_item.user_id', $user_id);
        $this->db->order_by('barcode', 'asc');
        $query = $this->db->get();
        return $query;
    }

    public function add($post) {
        $params = [
            'barcode' => $post['barcode'],
            'name' => $post['product_name'],
            'category_id' => $post['category'],
            'unit_id' => $post['unit'],
            'price' => $post['price'],
            'purchase_price' => $post['purchase_price'], // ✅ NEW
            'supplier_id' => $post['supplier'],
            'image' => $post['image'],
            'user_id' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('p_item', $params);
    }

    public function edit($post) {
        $params = [
            'barcode' => $post['barcode'],
            'name' => $post['product_name'],
            'category_id' => $post['category'],
            'unit_id' => $post['unit'],
            'price' => $post['price'],
            'purchase_price' => $post['purchase_price'], // ✅ NEW
            'supplier_id' => $post['supplier'],
            'updated' => date('Y-m-d H:i:s'),
        ];

        if ($post['image'] != null) {
            $params['image'] = $post['image'];
        }

        $this->db->where('item_id', $post['id']);
        $this->db->update('p_item', $params);
    }

    function check_barcode($code, $id = null) {
        $this->db->from('p_item');
        $this->db->where('barcode', $code);
        if ($id != null) {
            $this->db->where('item_id !=', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function del($id) {
        $this->db->where('item_id', $id);
        $this->db->delete('p_item');
    }

    function update_stock_in($data) {
        $qty = $data['qty'];
        $id = $data['item_id'];
        $sql = "UPDATE p_item SET stock = stock + $qty WHERE item_id = $id";
        $this->db->query($sql);
    }

    function update_stock_out($data) {
        $qty = $data['qty'];
        $id = $data['item_id'];
        $sql = "UPDATE p_item SET stock = stock - $qty WHERE item_id = $id";
        $this->db->query($sql);
    }
}
