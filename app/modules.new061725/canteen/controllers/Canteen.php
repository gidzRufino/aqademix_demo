<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Canteen extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('canteen_model');
        
    
    }
    
    function getProductDetails($id)
    {
        $p = $this->canteen_model->getProducts($id);
        echo json_encode(array('item_id'=>$p->row()->canteen_item_id, 'price'=> $p->row()->canteen_item_price,'quantity'=>$p->row()->total_quantity,'item_name'=>$p->row()->canteen_item_name));
    }
    
    function updateProduct()
    {
        $item_id = $this->input->post('item_id');
        $item_quantity = $this->input->post('item_quantity');
        $item_price = $this->input->post('item_price');
        $serve_option = $this->input->post('serve_option');
        $key_assign = $this->input->post('key_assign');
        
        $details = array(
            'total_quantity' => $item_quantity,
            'canteen_item_price' => $item_price,
            'serve_option'      => $serve_option,
            'shortcut_key'      => $key_assign
        );
        
        $result = $this->canteen_model->updateProduct($item_id, $details);
        if($result):
            $products = $this->getProducts();
            $i = 1;
            foreach ($products->result() as $p): 
         
            ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $p->canteen_item_name ?></td>
                <td class='text-right'><?php echo number_format($p->canteen_item_price, 2, ".", ",") ?></td>
                <td><?php echo $p->item_left ?></td>
                <td><?php echo $p->item_sold ?></td>
            </tr>
            <?php endforeach;
        endif;
    }
    
    function sales($from=NULL, $to=NULL)
    {
        if($this->session->userdata('position_id')==1 || $this->session->userdata('position_id') >= 60 && $this->session->userdata('position_id') <= 65 ):
            $data['sales'] = $this->canteen_model->getSales($from, $to);
            $data['main_content'] = 'sales';
            $data['modules'] = 'canteen';
            echo Modules::run('templates/canteen_content', $data);
        else:
            redirect(base_url('main/dashboard'));
        endif;
    }
    
    function getSales($from=NULL, $to=NULL)
    {
        $data['sales'] = $this->canteen_model->getSalesPerItem($from, $to);
        $this->load->view('sales_table', $data);
    }
    
    function getItemPerDay($date, $item_id)
    {
        $items = $this->canteen_model->getItemPerDay($date, $item_id);
        return $items;
    }
    
    function printSales($from=NULL, $to=NULL)
    {
        $this->load->library('pdf');
        $data['sales'] = $this->canteen_model->getSalesPerItem($from, $to);
        $this->load->view('reports/printSalesReport', $data);
    }
    
    function viewTransactions()
    {
        $user_id = $this->input->post('user_id');
        $transaction = $this->canteen_model->viewTransaction($user_id);
        $i = 1;
        $total = 0;
        foreach($transaction as $tr):
            $total += ($tr->item_quantity * $tr->item_price);
        ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $tr->transaction_num ?></td>
                <td><?php echo $tr->canteen_item_name ?></td>
                <td><?php echo number_format(($tr->item_quantity * $tr->item_price), 2, '.', ',') ?></td>
                <td><?php echo date('F d, Y', strtotime($tr->transaction_date)) ?></td>
            </tr>
        <?php
        endforeach;
        echo '<tr><td><strong>Total</strong></td><td  colspan="2"></td><td><strong>'. number_format($total, 2, ".", ',').'</strong><span class="small"> Php</span></td><td></td></tr>';
        
    }
    
    function deductLoad($user_id, $amount)
    {
        $result = json_decode($this->canteen_model->deductLoad($user_id, $amount));
        if($result->status):
            Modules::run('web_sync/updateSyncController', 'canteen_personal_load_info', 'cpli_id', $result->id, 'update', 1);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveCanteenTransaction()
    {
        $user_id = $this->input->post('user_id');
        $cash = $this->input->post('cash');
        $change = $this->input->post('change');
        $total = $this->input->post('total');
        $trans_id = $this->input->post('trans_id');
        
        $details = array(
            'customer_id'       => $user_id,
            'employee_id'       => $this->session->userdata('user_id'),
            'transact_total'    => $total,
            'customer_cash'     => $cash,
            'customer_change'  => $change,
            'transact_num'     => $trans_id
        );
        $result = json_decode($this->canteen_model->saveCanteenTransaction($details));
        if($result->status):
            $this->deductLoad($user_id, $cash);
        else:
            
        endif;
    }
            
    function creditStudent()
    {
        $value = $this->input->post('value');
        $student = $this->canteen_model->creditStudent($value);
        echo json_encode(array(
            'lastname' => $student->lastname, 
            'firstname' => $student->firstname, 
            'avatar' => $student->avatar, 
            'user_id' => $student->user_id,
            'load'      => number_format($student->cpli_load, 2,'.',',')
             )       
        );
    }
    
    function saveLoad()
    {
        $user_id = $this->input->post('user_id');
        $loadAmount = $this->input->post('loadAmount');
        $budget = $this->input->post('budget');
        $reload = $this->input->post('reload');
        
        
        if($this->canteen_model->saveLoad($loadAmount, $user_id, $budget, $reload)):
            echo 'Successfully Loaded';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }
    
    function scanStudent()
    {
        $value = $this->input->post('value');
        $student = $this->canteen_model->scanStudent($value);
        echo json_encode(array('lastname' => $student->lastname, 'firstname' => $student->firstname, 'avatar' => $student->avatar, 'user_id' => $student->user_id, 'load' => number_format($student->cpli_load, 2,'.',',')));
            
    }
    
    function searchStudent()
    {
        $value = $this->input->post('value');
        $student = $this->canteen_model->searchStudent($value);
        ?>
        <ul>
          <?php
          foreach($student as $s):
              
          $load = number_format($s->cpli_load, 2,'.',',');
          $name = strtoupper($s->firstname.' '.$s->lastname);
          ?>
          <li onclick='$("#userId").val("<?php echo $s->user_id ?>"),$("#inputStudent").val(this.innerHTML),$("#name").html(this.innerHTML),
                   $("#profile").show(), $("#loadBalance").html("<?php echo $load ?>"), 
                   $("#profileImage").attr("src","<?php echo base_url().'uploads/'.$s->avatar ?>"), $("#studentSearch").hide(), $("#searchControls").hide(), $("#refill").attr("refill_load","<?php echo $s->cpli_refill_reminder ?>")
                   $("#budget").attr("placeholder","<?php echo $s->cpli_daily_limit ?>"), checkRefill("<?php echo $s->cpli_load ?>","<?php echo $s->cpli_refill_reminder ?>")'><?php echo $name ?></li>
          <?php  
          endforeach;
          ?>
          </ul>
        <?php    
    }
    
    
    function accounts()
    {
        if($this->session->userdata('position_id')==1 || $this->session->userdata('position_id') >= 60 && $this->session->userdata('position_id') <= 65 || $this->session->userdata('is_admin')):
            $data['main_content'] = 'canteen_accounts';
            $data['modules'] = 'canteen';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect(base_url('main/dashboard'));
        endif;    
    }

    function index() {
        if($this->session->userdata('position_id')==1 || $this->session->userdata('position_id') >= 60 && $this->session->userdata('position_id') <= 65 || $this->session->userdata('is_admin') ):
            $data['title'] = 'Admin Dashboard';
            $data['main_content'] = 'canteen_dashboard';
            $data['modules'] = 'canteen';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect(base_url('main/dashboard'));
        endif;    
        
    }
    
    function pos(){
        if($this->session->userdata('position_id')==1 || $this->session->userdata('position_id') >= 60 && $this->session->userdata('position_id') <= 65 || $this->session->userdata('is_admin') ):
            $data['title'] = 'Point of Sales';
            $data['main_content'] = 'pos';
            $data['modules'] = 'canteen';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect('main/dashboard');
        endif;    
    }
    
    function products(){
        if($this->session->userdata('position_id')==1 || $this->session->userdata('position_id') >= 60 && $this->session->userdata('position_id') <= 65 || $this->session->userdata('is_admin')):
            $data['category'] = $this->canteen_model->getCategories();
            $data['products'] = $this->canteen_model->getProducts();
            $data['main_content'] = 'product_display';
            $data['modules'] = 'canteen';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect('main/dashbard');
        endif;
    }
    
    function displayAll() {

        $result = $this->canteen_model->display_all();

        echo json_encode($result);
    }
    
    function all_category(){
        $result = $this->canteen_model->allCategory();
        echo json_encode($result);
    }
    
    function loadJsonItems($item_id, $bldy)
    {
        if($item_id==1):
            $breakfast = date('H:i:s',strtotime("04:00:00"));
            $lunch = date('H:i:s',strtotime("11:00:00"));
            $dinner = date('H:i:s',strtotime("16:00:00"));
            if($bldy!=""):
                switch ($bldy):
                    case 1:
                        $b = 'Selected="selected"';
                    break;
                    case 2:
                        $l = 'Selected="selected"';
                    break;
                    case 3:
                        $d = 'Selected="selected"';
                    break;
                
                endswitch;
            else:    
                if(date('H:i:s')>$breakfast && date('H:i:s') < $lunch){
                    $b = 'Selected="selected"';
                    $l = '';
                    $d = '';
                    $bld = 1;
                 }elseif(date('H:i:s')>$lunch && date('H:i:s')< $dinner)
                 {
                    $b = '';
                    $l = 'Selected="selected"';
                    $d = '';
                    $bld=2;
                 }elseif(date('H:i:s')>$dinner)
                 {
                    $b = '';
                    $l = '';
                    $d = 'Selected="selected"';
                    $bld=3;
                 }
                
            endif;
            $data['result'] = $this->canteen_model->loadItems($item_id, ($bldy!=""?$bldy:$bld));
        else:
            $data['result'] = $this->canteen_model->loadItems($item_id);
        endif;
        
        echo json_encode($data['result']);
    }
    
    function loadItems($item_id, $bldy){
        if($item_id==1):
            $breakfast = date('H:i:s',strtotime("04:00:00"));
            $lunch = date('H:i:s',strtotime("11:00:00"));
            $dinner = date('H:i:s',strtotime("16:00:00"));
            if($bldy!=""):
                switch ($bldy):
                    case 1:
                        $b = 'Selected="selected"';
                    break;
                    case 2:
                        $l = 'Selected="selected"';
                    break;
                    case 3:
                        $d = 'Selected="selected"';
                    break;
                
                endswitch;
            else:    
                if(date('H:i:s')>$breakfast && date('H:i:s') < $lunch){
                    $b = 'Selected="selected"';
                    $l = '';
                    $d = '';
                    $bld = 1;
                 }elseif(date('H:i:s')>$lunch && date('H:i:s')< $dinner)
                 {
                    $b = '';
                    $l = 'Selected="selected"';
                    $d = '';
                    $bld=2;
                 }elseif(date('H:i:s')>$dinner)
                 {
                    $b = '';
                    $l = '';
                    $d = 'Selected="selected"';
                    $bld=3;
                 }
                
            endif;
            $data['bld'] = $bld;
            $data['b'] = $b;
            $data['l'] = $l;
            $data['d'] = $d;
            $data['result'] = $this->canteen_model->loadItems($item_id, ($bldy!=""?$bldy:$bld));
        else:
            $data['result'] = $this->canteen_model->loadItems($item_id);
        endif;
        $this->load->view('loadedItems', $data);
    }
    
    function removeItem($item_id, $bldy)
    {
        $remove = $this->canteen_model->removeItem($item_id);
        if($remove):
            $this->loadItems($item_id, $bldy);
        endif;
    }
    
    function add_item(){
        $name = $this->input->post('itemName');
        $quantity = $this->input->post('itemQuantity');
        $price = $this->input->post('itemPrice');
        $wholesale = $this->input->post('wholeSale');
        
        $query = $this->canteen_model->addItem($name,$quantity,$price,$wholesale);
        echo json_encode($query);
    }
    
    function saveTransaction()
    {
        $option = $this->input->post('option');
        $user_id = $this->input->post('user_id');
        $transaction = $this->input->post('transaction');
        $trans_num = $this->input->post('trans_num');
        $total = $this->input->post('total');
        $column = array();
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);
        
        for ($x = 0; $x < $count; $x++) {
            
            $items = explode('_', $final[$x]);
            
            $details = array(
                'item_id'           => $items[0],
                'item_quantity'     => $items[1],
                'transaction_num'   => $trans_num,
                'item_price'        => $items[2],
                'customer_id'       => $user_id,
                'cashier_id'        => $this->session->userdata('user_id'),
                'transaction_date'  => date('Y-m-d')
            );
            
            //array_push($column, $details);
            $result = json_decode($this->canteen_model->saveCanteenTransaction($details));
            if($result->status):
                Modules::run('web_sync/updateSyncController', 'canteen_transaction_rec', 'rec_id', $result->id, 'create', 1);
            endif;
        }
            
//        
        if($result->status):
            if($option=='credit'):
                $this->deductLoad($user_id, $total);
            endif;
            echo 'Successfully Saved';
        else:
            echo 'Sorry Something went wrong';
        endif;
    }
    
    
    function save_transactions(){
        $data1 = $this->input->post('newData');
        $data2 = $this->input->post('totalCash');
        $data3 = $this->input->post('totalChange');
        $data4 = $this->input->post('totalTrans');
        
        $result = $this->canteen_model->saveTransaction($data1,$data2,$data3,$data4);
        echo json_encode($result);
    }
    
    function getProducts()
    {
        $products = $this->canteen_model->getProducts();
        return $products;
    }
    
    function add_product(){
        $name = $this->input->post('product');
        $price = $this->input->post('price');
        $category = $this->input->post('category');
        $quantity = $this->input->post('quantity');
        
        $success = $this->canteen_model->addProduct($name,$price,$category,$quantity);
        if($success):
            $products = $this->getProducts();
            $i = 1;
            foreach ($products->result() as $p): 
         
            ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $p->canteen_item_name ?></td>
                <td class='text-right'><?php echo number_format($p->canteen_item_price, 2, ".", ",") ?></td>
                <td><?php echo $p->item_left ?></td>
                <td><?php echo $p->item_sold ?></td>
            </tr>
            <?php endforeach;
        endif;
    }
    
    function test(){
        $test = $this->canteen_model->updateQuantity(2,2);
        echo json_encode($test);
    }

}