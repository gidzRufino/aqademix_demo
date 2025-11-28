<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Canteen_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }
    
    function getItemPerDay($date, $item_id)
    {
       
       $this->db->select('item_id');
       $this->db->select('item_price');
       $this->db->select('transaction_date');
       $this->db->select('SUM(item_quantity) as item_quantity');
       $this->db->where("transaction_date", $date);
       $this->db->where("item_id", $item_id);
       $q = $this->db->get('canteen_transaction_rec');
       return $q->row();
    }
    
    function getSalesPerItem($from, $to)
    {
       
       $this->db->select('canteen_items.canteen_item_id');
       $this->db->select('transaction_num');
       $this->db->select('transaction_date');
       $this->db->select('canteen_item_name');
       $this->db->select('item_price');
       $this->db->where("transaction_date between '" . ($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
       $this->db->join('canteen_items','canteen_transaction_rec.item_id = canteen_items.canteen_item_id','left');
       $this->db->group_by('canteen_items.canteen_item_id');
       $this->db->order_by('transaction_date','ASC');
       $this->db->order_by('canteen_items.canteen_item_id','ASC');
       $q = $this->db->get('canteen_transaction_rec');
       return $q->result();
    }
    
    function getSales($from, $to)
    {
       $this->db->where("transaction_date between '" . ($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
       $this->db->join('canteen_items','canteen_transaction_rec.item_id = canteen_items.canteen_item_id','left');
       $q = $this->db->get('canteen_transaction_rec');
       return $q->result();
    }
    
    function updateProduct($item_id, $details)
    {
        $this->db->where('canteen_item_id', $item_id);
        $q = $this->db->update('canteen_items', $details);
        return $q;
    }
    
    function viewTransaction($user_id)
    {
        $this->db->join('canteen_items','canteen_transaction_rec.item_id = canteen_items.canteen_item_id', 'left');
        $this->db->where('customer_id', $user_id);
        $this->db->order_by('rec_id','DESC');
        $q = $this->db->get('canteen_transaction_rec');
        return $q->result();
    }
    
    function getCategories()
    {
        $q = $this->db->get('canteen_menu_categories');
        return $q->result();
    }
    
    function getProducts($id=NULL)
    {
        ($id==NULL?'':$this->db->where('canteen_item_id', $id));
        $this->db->join('canteen_menu_categories','canteen_items.canteen_item_cat = canteen_menu_categories.menu_cat_id', 'left');
        $q = $this->db->get('canteen_items');
        return $q;
    }
    
    function deductLoad($user_id, $cash)
    {
        $this->db->where('cpli_user_id', $user_id);
        $q = $this->db->get('canteen_personal_load_info');
        $remaining = $q->row()->cpli_load - $cash;
        $this->db->where('cpli_user_id', $user_id);
        if($this->db->update('canteen_personal_load_info', array('cpli_load' => $remaining))):
            return json_encode(array('status' => TRUE, 'id' => $q->row()->cpli_id));
        else:
            return json_encode(array('status'=>FALSE));
        endif;
    }
    
    function saveCanteenTransaction($details)
    {
        if($this->db->insert('canteen_transaction_rec', $details)):
            return json_encode(array('status'=> TRUE, 'id' => $this->db->insert_id()));
        else:
            return json_encode(array('status'=> FALSE));
        endif;
    }
            
    function creditStudent($value)
    {
        $this->db->where('rfid', $value);
        $this->db->where('account_type !=', 1 );
        $this->db->where('account_type !=', 4 );
        $this->db->join('canteen_personal_load_info','profile.user_id = canteen_personal_load_info.cpli_user_id', 'left');
        $q = $this->db->get('profile');
        return $q->row();
    }
            
    function saveLoad($loadAmount, $user_id, $budget, $reload)
    {
        $this->db->where('cpli_user_id', $user_id);
        $q = $this->db->get('canteen_personal_load_info');
        if($q->num_rows()>0):
            $prevLoad = $q->row()->cpli_load;
        
            $details = array(
                'cpli_user_id' => $user_id,
                'cpli_load' => ($prevLoad+$loadAmount),
                'cpli_daily_limit' => $budget,
                'cpli_refill_reminder' => $reload
            );
            $this->db->where('cpli_user_id', $user_id);
            if($this->db->update('canteen_personal_load_info', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $details = array(
                'cpli_user_id'  => $user_id,
                'cpli_load' => $loadAmount,
                'cpli_daily_limit' => $budget,
                'cpli_refill_reminder' => $reload
            );
            if($this->db->insert('canteen_personal_load_info', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
            
    function scanStudent($value)
    {    
        $this->db->where('rfid', $value);
        $this->db->join('canteen_personal_load_info','profile.user_id = canteen_personal_load_info.cpli_user_id', 'left');
        $q = $this->db->get('profile');
        return $q->row();
    }
    
    function searchStudent($value)
    {
//       $sql = 'Select * from esk_profile where account_type != 1 and where lastname like %'.$value.'%';
//       $q = $this->db->query($sql);
//       return $q->result();
        //$this->db->where('profile.account_type !=', '4');
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('canteen_personal_load_info','profile.user_id = canteen_personal_load_info.cpli_user_id', 'left');
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type', 5);
        $this->db->like('lastname', $value, 'both');
        $q = $this->db->get();
        return $q->result();
    }

    function display_all() {
        $query = $this->db->get('canteen_dashboard_menu_buttons');
        $query = $query->result();
        return $query;
    }
    
    function allCategory(){
        $query = $this->db->get('canteen_menu_categories');
        $data1 = $query->result();
        $data2 = $this->allItems();
        return array('cat' => $data1, 'item' => $data2);
    }

    function loadItems($cat_id, $bld=NULL) {
        $this->db->where('serve_option',($bld==NULL?0:$bld));
        $this->db->where('canteen_item_cat', $cat_id);
        $query = $this->db->get('canteen_items');
        return $query->result();
    }
    
    function removeItem($item_id)
    {
        $details = array(
            'serve_option' => 0,
            'shortcut_key' => ''
        );
        $this->db->where('canteen_item_id', $item_id);
        if($this->db->update('canteen_items', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function addItem($name,$quantity,$price,$wholesale){
        $detail = array('total_quantity' => $quantity, 'canteen_item_price' => $price, 'canteen_wsprice' => $wholesale);
        $query = $this->db->where("canteen_item_name",$name);
        $query = $this->db->update('canteen_items', $detail);
        return $query;
    }
    
    function addProduct($name,$price,$category,$quantity){
        $data = array('canteen_item_name' => $name,
            'canteen_item_price' => $price,
            'total_quantity' => $quantity,
            'canteen_item_cat' => $category
                );
        $success = $this->db->insert('canteen_items', $data);
        return $success;
    }
    
    function saveTransaction($column)
    {
        $result = $this->db->insert_batch('canteen_transaction_rec', $column);
        if($result):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function saveTransactions($data1,$data2,$data3,$data4) {
        $theDate = date('F d,Y @ h:i a');
        $column = array();
        $count = count(json_decode($data1));
        $final = json_decode($data1);
        $transNum = $final[0][5];

        for ($x = 0; $x < $count; $x++) {
            $details = array(
                'item_quantity' => $final[$x][1],
                'item_price_total' => $final[$x][2],
                'item_id' => $final[$x][3],
                'transaction_num' => $final[$x][5]
            );
            array_push($column, $details);
            
            $quantity = $this->updateQuantity($final[$x][1],$final[$x][3],$final[$x][4]);
            
        }
        
        $result = $this->db->insert_batch('canteen_transaction_rec', $column);
        
        $query2 = array(
            'transaction_date' => $theDate,
            'transact_total' => $data4,
            'customer_cash' => $data2,
            'customer_change' => $data3,
            'transact_num' => $transNum
        );
        
        $result2 = $this->db->insert('canteen_transaction', $query2);
        
        if($result && $result2 && $quantity){
            return "success";
        } else {
            return "failed";
        }
        
       // return $result2; 
      //return $quantity;
    }
    
    function updateQuantity($quantity,$id,$profit){
        $query = $this->db->select('total_quantity,canteen_item_price,item_sold,item_sales,total_profit');
        $query = $this->db->where('canteen_item_id', $id);
        $query = $this->db->get('canteen_items');
        $result = $query->result();
        $price = $result[0]->item_sales + ($result[0]->canteen_item_price * $quantity);
        $itemprofit = $result[0]->total_profit + $profit;
        
        $sold = $result[0]->item_sold + $quantity;
        $final_result = $result[0]->total_quantity - $quantity;
        $data = array('total_quantity' => $final_result, 'item_sold' => $sold,'item_sales' => $price, 'total_profit' => $itemprofit);
        $query2 = $this->db->where('canteen_item_id',$id);
        $query2 = $this->db->update('canteen_items',$data);
        return $query2;
        return $final_result;
    }

}
