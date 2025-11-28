<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Librarymodule extends MX_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->library('Pdf');
      $this->load->model('librarymodule_model');
   }

//  always change $sy_id to corresponding school year eg. sy_id = 5 for sy 2017-2018
  	public function index()
  	{

    	if(!$this->session->userdata('is_logged_in')){
        ?>
            <script type="text/javascript">
            	document.location = "<?php echo base_url()?>"
            </script>
        	<?php

    	}else{
        $data['borrowed_items'] = $this->librarymodule_model->borrowed_items();
        $data['entrance'] = $this->librarymodule_model->attendance_now();
        // $data['bk_lib_general'] = $this->librarymodule_model->display_bk_general_inventory();
        $data['bk_lib_general'] = $this->librarymodule_model->display_lib_general_com();
	      $data['main_content'] = 'default';
	      $data['modules'] = 'librarymodule';
	      echo Modules::run('templates/main_content', $data);

    	}
  	}

    function search()
    {
      $data['main_content'] = 'forms/search';
      $data['modules'] = 'librarymodule';
      echo Modules::run('templates/main_content', $data);
    }

    function searchnow()
    {
      $result = '';
      $query = '';
      if($this->input->post('query'))
      {
        $query = $this->input->post('query');
      }
      $data = $this->librarymodule_model->search_data($query);
      $nums = $data->num_rows();
      if ($nums>1) {
        $i = 'items';
      }else{
        $i = 'item';
      }
      $result .= '
        <script type="text/javascript">
        $(".table").tablesorter({debug: true});
        </script>
        <h4>Search Result: '.$nums.' '.$i.' found</h4>
        <div class="table-responsive">
          <table id="sresult" class="table tablesorter table-bordered table-striped">
            <thead>
            <tr onclick="run(88)">
              <th class="text-center">Title</th>
              <th class="text-center">Author</th>
              <th class="text-center">Description</th>
              <th class="text-center">Topical Terms</th>
            </tr>
            </thead>
      ';
      if ($data->num_rows() >0) {
        foreach ($data->result() as $row) {
          $result .= '
            <tr>
              <td class="text-center"><a href="books/'.base64_encode($row->gb_id).'">'.$row->gb_title.'</a></td>
              <td class="text-center">'.$row->gb_author.'</td>
              <td class="text-center">'.$row->gb_remarks.'</td>
              <td class="text-center">'.$row->gb_topical_terms.'</td>
            </tr>
          ';
        }
      }else{
        $result .= '
          <tr>
            <td colspan="4" class="text-center">No Data Found</td>
          </tr> 
        ';
      }
      $result .= '</table>
      </div>
      <script type="text/javascript">
      function run(msg)
        {
          alert(msg);
        }
        </script>
      ';
      echo json_encode(array(
        'result' => $result,
        )
      );

    }

    function getborrowed()
    {
      $bfrom = $this->input->post('sfrom');
      $bto = $this->input->post('sto');
      $data['brecords'] = $this->librarymodule_model->get_brecords($bfrom, $bto);

    }

   function cover_upload($gb_id)
   {
      $data['gb_id'] = $gb_id;
      $this->load->view('upload_cover', $data);

      echo json_encode(array(
        'data' => $data,
        'counts' => $nums,
      )
    );

   }

   function item_list()
   {
      if(!$this->session->userdata('is_logged_in')){
        ?>
            <script type="text/javascript">
               document.location = "<?php echo base_url()?>"
            </script>
         <?php

      }else{
         $ur = $this->uri->segment(3);
         if ($ur) {
           $cat = $ur;
         }else{
          $cat = null;
         }
         $data['bk_general'] = $this->librarymodule_model->display_bk_general_inventory();
         $data['bk_status'] = $this->librarymodule_model->lib_status();
         // $data['bk_general'] = $this->librarymodule_model->display_general_list($cat);
         // $data['bk_category'] = $this->librarymodule_model->display_category();
         // $data['bk_item'] = $this->librarymodule_model->display_item_list();
         $data['main_content'] = 'forms/inv-check';
         $data['modules'] = 'librarymodule';
         echo Modules::run('templates/main_content', $data);
      }
   }

   function inventory()
   {
      if(!$this->session->userdata('is_logged_in')){
        ?>
            <script type="text/javascript">
               document.location = "<?php echo base_url()?>"
            </script>
         <?php

      }else{
         $ur = $this->uri->segment(3);
         if ($ur) {
           $cat = $ur;
         }else{
          $cat = null;
         }
         $data['bk_general'] = $this->librarymodule_model->display_general_list($cat);
         $data['bk_category'] = $this->librarymodule_model->display_category();
         $data['bk_item'] = $this->librarymodule_model->display_item_list();
         $data['main_content'] = 'forms/inventory';
         $data['modules'] = 'librarymodule';
         echo Modules::run('templates/main_content', $data);
      }
   }

   function upload_now()
   {
      $location = $this->input->post('location');
      $id = $this->input->post('id');
      $config['file_name'] = $id;
      $config['upload_path'] = 'uploads';
      $config['overwrite'] = TRUE; 
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size']  = '500';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';
      $this->load->library('upload', $config);
      $this->upload->initialize($config);


      if ( ! $this->upload->do_upload())
      {
         $error = array('error' => $this->upload->display_errors());
         ?>
            <script>
               alert('<?php echo $error['error'] ?>');
               document.location="<?php echo base_url().$location?>";
            </script>    
         <?php
      }
      else
      {
         $img_data = $this->upload->data();
         $ext = $img_data['file_ext'];
         $this->librarymodule_model->set_image($id,$id.$ext);
         ?>
         <script>
            alert('upload successfully');
            document.location="<?php echo base_url().$location?>";
         </script>    
         <?php
      }
   }

   public function activate_profile()
   {
      if(!$this->session->userdata('is_logged_in')){
        ?>
          <script type="text/javascript">
            document.location = "<?php echo base_url() ?>"
          </script>
        <?php
      }else{
         $eu_id = base64_decode($this->uri->segment(3));
         $query = $this->librarymodule_model->getprofile($eu_id);
         if ($query->num_rows()==0) {
            $eu_status = "active";
            $sendResult = $this->librarymodule_model->saveAccount($eu_id, $eu_status);
            $msg = "Library account created....";
            $status = 1;
         }else{
            $msg = "Account already exist... ";
            $status = 0;
         }
         $sl = $this->librarymodule_model->show_profile($eu_id);
         $sname = $sl->lastname.', '.$sl->firstname;
         echo json_encode(array(
            'name'      => $sname,
            'msg'       => $msg,
            'status'    => $status,
            )
         );  
      }
   }

   public function emergency_contact()
   {
      if(!$this->session->userdata('is_logged_in')){
        ?>
          <script type="text/javascript">
            document.location = "<?php echo base_url() ?>"
          </script>
        <?php
      }else{
         $data['student_profile'] = $this->librarymodule_model->search_student();
         $data['ec_profile'] = $this->librarymodule_model->search_ec();
         $data['main_content'] = 'emergency_contact';
         $data['modules'] = 'librarymodule';
         // echo Modules::run('financemanagement/main_content', $data);
         echo Modules::run('templates/main_content', $data);
      } 
   }

    public function show_account()
    {
      if(!$this->session->userdata('is_logged_in')){
        ?>
          <script type="text/javascript">
            document.location = "<?php echo base_url() ?>"
          </script>
        <?php
      }else{
        $eu_id = $this->uri->segment(3);
        // $sy_id = 5; // School year code (eg. 3 = School year 2015-2016)
        $sy = $this->librarymodule_model->show_sy();
        $sy_now = $sy->school_year;
        $sy_id = $sy_now - 2012;
        $data['account_info'] = $this->librarymodule_model->show_account_info(base64_decode($eu_id));
        $data['account_history'] = $this->librarymodule_model->show_account_transactions(base64_decode($eu_id), $sy_id);
        $data['account_visits'] = $this->librarymodule_model->show_account_visits(base64_decode($eu_id), $sy_id);
        $data['bk_lib_general'] = $this->librarymodule_model->display_bk_general_inventory();
        $data['main_content'] = 'eu_account';
        $data['modules'] = 'librarymodule';
        echo Modules::run('templates/main_content', $data);
      }
    }

    public function save_account()
    {
      $eu_id = base64_decode($this->input->post('u_id'));
      $eu_status = "active";

      $sendResult = $this->librarymodule_model->saveAccount($eu_id, $eu_status);
    }

    public function new_account()
    {

      if(!$this->session->userdata('is_logged_in')){
      ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url() ?>"
        </script>

      <?php

      }else{
        
        $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
        $data['fns'] = $this->librarymodule_model->display_fns();
        $data['search_parent'] = $this->librarymodule_model->display_parent();
        $data['display_users'] = $this->librarymodule_model->display_eu_accounts();
        $data['main_content'] = 'forms/new_account';
        $data['modules'] = 'librarymodule';
        echo Modules::run('templates/main_content', $data);

      }  
    }

    public function item()
    {
      if(!$this->session->userdata('is_logged_in')){
     
      ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url() ?>"
        </script>

      <?php

      }else{
        $item_id = base64_decode($this->uri->segment(3));
        $gen_id = base64_decode($this->uri->segment(4));
        $data['item_info'] = $this->librarymodule_model->display_a_book($item_id);
        $data['item_history'] = $this->librarymodule_model->show_item_transactions($item_id);
        $data['gen_item'] = $this->librarymodule_model->display_items_bygen($gen_id);
        $data['bk_status'] = $this->librarymodule_model->lib_status();
        $data['bk_publication'] = $this->librarymodule_model->lib_publication();
        $data['bk_shelf'] = $this->librarymodule_model->display_shelf();
        $data['main_content'] = 'item_info';
        $data['modules'] = 'librarymodule';
        echo Modules::run('templates/main_content', $data);
    }
  }

    public function author()
    {
      if(!$this->session->userdata('is_logged_in')){
     
      ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url() ?>"
        </script>

      <?php

      }else{
        $auth_id = base64_decode($this->uri->segment(3));
        $data['author'] = $this->librarymodule_model->display_author($auth_id);
        $data['abooks'] = $this->librarymodule_model->display_abook($auth_id);
        $data['main_content'] = 'about_author';
        $data['modules'] = 'librarymodule';
        echo Modules::run('templates/main_content', $data);
    }
  }

  	public function books()
  	{
  		$url1 = $this->uri->segment(3);
  		if(!$this->session->userdata('is_logged_in')){
	  	
      	?>
	  			<script type="text/javascript">
	  				document.location = "<?php echo base_url() ?>"
	  			</script>
	  		<?php
      
      }else if($url1!="" && $url1!="i" && $url1!="b"){
        $data['bk'] = $this->librarymodule_model->display_bk_general(base64_decode($url1));
        $data['info_graphic'] = $this->librarymodule_model->show_item_infographics(base64_decode($url1));
        $data['bk_status'] = $this->librarymodule_model->lib_status();
        $data['bk_inventory'] = $this->librarymodule_model->display_bk_general_inventory();
        $data['bk_general'] = $this->librarymodule_model->display_general_list();
        $data['bk_item'] = $this->librarymodule_model->display_item_list();
        $data['bk_category'] = $this->librarymodule_model->display_category();
        $data['bk_author'] = $this->librarymodule_model->display_authors();
        $data['bk_dewey'] = $this->librarymodule_model->display_dewey();
        $data['bk_display'] = $this->librarymodule_model->display_bks_bygen(base64_decode($url1));
        $data['main_content'] = 'book_title';
        $data['modules'] = 'librarymodule';
        echo Modules::run('templates/main_content', $data);
	  	}else{
	  		$data['bk_lib_general'] = $this->librarymodule_model->display_lib_general_com();
	  		$data['bk_display_dewey'] = $this->librarymodule_model->display_dewey_gen();
        $data['bk_dewey'] = $this->librarymodule_model->display_dewey();
        $data['bk_topical_terms'] = $this->librarymodule_model->display_tt();
	  		$data['bk_dewey_category'] = $this->librarymodule_model->display_dewey_category();
       	$data['bk_category'] = $this->librarymodule_model->display_category();
       	$data['bk_status'] = $this->librarymodule_model->lib_status();
       	$data['bk_inventory'] = $this->librarymodule_model->display_bk_general_inventory();
        $data['bk_general'] = $this->librarymodule_model->display_general_list();
        $data['bk_item'] = $this->librarymodule_model->display_item_list();
       	$data['bk_publication'] = $this->librarymodule_model->lib_publication();
	  		$data['bk_dewey'] = $this->librarymodule_model->display_dewey();
	  		$data['bk_shelf'] = $this->librarymodule_model->display_shelf();
	  		$data['bk_author'] = $this->librarymodule_model->display_authors();
	  		$data['main_content'] = 'books';
	  		$data['modules'] = 'librarymodule';
	  		echo Modules::run('templates/main_content', $data);
	  	}
  	}

  	public function accounts()
  	{
  		
  		if(!$this->session->userdata('is_logged_in')){
	  		?>
	  			<script type="text/javascript">
	  				documnet.location = "<?php echo base_url() ?>"
	  			</script>
	  		<?php
	  	}else{
        $data['eu_accounts'] = $this->librarymodule_model->display_accounts();
	  		$data['main_content'] = 'accounts';
	  		$data['modules'] = 'librarymodule';
	  		echo Modules::run('templates/main_content', $data);
	  	}
  	}

  	public function lend()
  	{
  		
  		if(!$this->session->userdata('is_logged_in')){
	  		?>
	  			<script type="text/javascript">
	  				documnet.location = "<?php echo base_url() ?>"
	  			</script>
	  		<?php
	  	}else{
        $data['eu_accounts'] = $this->librarymodule_model->display_accounts();
        // $data['bk_lib_general'] = $this->librarymodule_model->display_lib_general_com();
        $data['bk_lib_general'] = $this->librarymodule_model->display_bk_general_inventory();
	  		$data['main_content'] = 'lend';
	  		$data['modules'] = 'librarymodule';
	  		echo Modules::run('templates/main_content', $data);
	  	}
  	}

    public function edit_gitem()
    {
      $gb_id = $this->input->post('gb_id');
      $items = array(
        'gb_title' => $this->input->post('book_title'),
        'gb_sub_title' => $this->input->post('book_sub_title'),
        'gb_author' => $this->input->post('bk_author'),
        'gb_co_author' => $this->input->post('bk_other_auth'),
        'gb_sor' => $this->input->post('bk_sor'),
        'gb_series_statement' => $this->input->post('bk_ss'),
        'gb_volume' => $this->input->post('bk_volume'),
        'gb_dw' => $this->input->post('bk_dewey'),
        'gb_ca_id' => $this->input->post('bk_category'),
        'gb_remarks' => $this->input->post('bk_remarks'),
        'gb_topical_terms' => $this->input->post('bk_tt'),
        );
      $this->librarymodule_model->edit_gb($items, $gb_id);
//      Modules::run('web_sync/updateSyncController', 'lib_general', 'gb_id', $gb_id, 'update', 6);
    }

    public function edit_item()
    {
      $item_id = base64_decode($this->input->post('ext1'));
      $mode = $this->uri->segment(3);
      // $testi = 'weh';
      if ($mode=='i_s') {
        // $testi = 'nothing else single';
        date_default_timezone_set('Asia/Manila');
        $sy = $this->librarymodule_model->show_sy();
        $sy_now = $sy->school_year;
        $sy_id = $sy_now - 2012;
        $tr_id = date("ymdHi-s");
        $tr_st_id = $this->input->post('bk_status');
        $tr_bk_id = $item_id;
        $tr_date = date("F d, Y (H:i)");
        $tr_staff_id = $this->session->userdata('employee_id');
        $tr_eu_id = $this->session->userdata('user_id');
        $tr_due_date = "";
        $tr_flag = "0";
        $tr_sy_id = $sy_id;
        $tr_remarks = "Item information edited";
        
        $tr_id_now = $this->librarymodule_model->save_new_bk_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_remarks);
//        Modules::run('web_sync/updateSyncController', 'lib_transaction', 'tr_id', $tr_id, 'create', 6);

        $data = array(
          'bk_pub_id' => $this->input->post('bk_publisher'),
          // 'bk_pub_date' => $this->input->post('bk_date_pub'),
          'bk_st_id' => $this->input->post('bk_status'),
          'bk_st_date' => date('Y-m-d'),
          'bk_serial_num' => $this->input->post('bk_serial'),
          'bk_call_number' => $this->input->post('bk_call_number'),
          'bk_media_type' => $this->input->post('bk_media'),
          'bk_rfid' => $this->input->post('bk_rfid'),
          'bk_cost_price' => $this->input->post('bk_cost_price'),
          'bk_date_acquired' => $this->input->post('bk_date_acquired'),
          'bk_edition' => $this->input->post('bk_edition'),
          'bk_copyright_yr' => $this->input->post('bk_copyright'),
          'bk_isbn' => $this->input->post('bk_isbn'),
          'bk_shelf_id' => $this->input->post('bk_shelf'),
          'bk_fn_id' => $this->input->post('bk_fine'),
          'bk_borrow_days' => $this->input->post('bk_brw_days'),
          'bk_physical_desc' => $this->input->post('bk_pdesc'),
          'bk_source' => $this->input->post('bk_acq_source'),
          'bk_tr_id' => $tr_id_now,
        );
        $this->librarymodule_model->edit_bk($data, $item_id);
//        Modules::run('web_sync/updateSyncController', 'lib_book', 'bk_id', $item_id, 'update', 6); 

      }else if ($mode=='i_m') {
        // $testi = 'many packyaw';
        $icount = $this->input->post('icount');
        $base_id = $this->input->post('base_ext');
        $icount = $icount + 1;
        $gb_id = $this->input->post('gb_id');
        $gb_info = $this->librarymodule_model->get_gb_items($gb_id);
        foreach ($gb_info as $gi) {
          $itemid = $gi->bk_id;
          date_default_timezone_set('Asia/Manila');
          $sy = $this->librarymodule_model->show_sy();
          $sy_now = $sy->school_year;
          $sy_id = $sy_now - 2012;
          $tr_id = date("ymdHi-s");
          $tr_st_id = $this->input->post('bk_status');
          $tr_bk_id = $itemid;
          $tr_date = date("F d, Y (H:i)");
          $tr_staff_id = $this->session->userdata('employee_id');
          $tr_eu_id = $this->session->userdata('user_id');
          $tr_due_date = "";
          $tr_flag = "0";
          $tr_sy_id = $sy_id;
          $tr_remarks = "Item information edited";
          
          $tr_id_now = $this->librarymodule_model->save_new_bk_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_remarks);
//          Modules::run('web_sync/updateSyncController', 'lib_transaction', 'tr_id', $tr_id, 'create', 6);

          $data = array(
            'bk_pub_id' => $this->input->post('bk_publisher'),
            // 'bk_pub_date' => $this->input->post('bk_date_pub'),
            'bk_st_id' => $this->input->post('bk_status'),
            'bk_st_date' => date('Y-m-d'),
            'bk_serial_num' => $this->input->post('bk_serial'),
            'bk_call_number' => $this->input->post('bk_call_number'),
            'bk_media_type' => $this->input->post('bk_media'),
            'bk_rfid' => $this->input->post('bk_rfid'),
            'bk_cost_price' => $this->input->post('bk_cost_price'),
            'bk_date_acquired' => $this->input->post('bk_date_acquired'),
            'bk_edition' => $this->input->post('bk_edition'),
            'bk_copyright_yr' => $this->input->post('bk_copyright'),
            'bk_isbn' => $this->input->post('bk_isbn'),
            'bk_shelf_id' => $this->input->post('bk_shelf'),
            'bk_fn_id' => $this->input->post('bk_fine'),
            'bk_borrow_days' => $this->input->post('bk_brw_days'),
            'bk_physical_desc' => $this->input->post('bk_pdesc'),
            'bk_source' => $this->input->post('bk_acq_source'),
            'bk_tr_id' => $tr_id_now,
          );
          $this->librarymodule_model->edit_bk($data, $itemid);
//          Modules::run('web_sync/updateSyncController', 'lib_book', 'bk_id', $itemid, 'update', 6); 
        }
      }

      echo json_encode(array(
        // 'messi' => $testi,
        )
      );

    }

    public function update_status()
    {
      date_default_timezone_set('Asia/Manila');
      $sy = $this->librarymodule_model->show_sy();
      $sy_now = $sy->school_year;
      $sy_id = $sy_now - 2012;
      $tr_id = date("ymdHi-s");
      $tr_st_id = $this->input->post('tr_st_id');
      $tr_bk_id = $this->input->post('tr_bk_id');
      $tr_date = date("F d, Y (H:i)");
      $tr_staff_id = $this->session->userdata('employee_id');
      $tr_eu_id = $this->session->userdata('user_id');
      $tr_due_date = "";
      $tr_flag = "0";
      $tr_sy_id = $sy_id;
      $tr_remarks = "Item checked";
      
      $sendResult = $this->librarymodule_model->save_new_bk_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_remarks);
//      Modules::run('web_sync/updateSyncController', 'lib_transaction', 'tr_id', $tr_id, 'create', 6);

      // update item's info

      $bk_id = $this->input->post('tr_bk_id');
      $items = array(
        'bk_st_id' => $this->input->post('tr_st_id'),
        'bk_st_date' => date("Y-m-d"),
        'bk_tr_id' => date("ymdHi-s"),
        );
      $this->librarymodule_model->edit_bk($items, $bk_id);
//      Modules::run('web_sync/updateSyncController', 'lib_book', 'bk_id', $bk_id, 'update', 6);

    }

    public function record_lend()
    {

      // record new item transaction

      // $sy_id = 5; // School year code (eg. 3 = School year 2015-2016)
      date_default_timezone_set('Asia/Manila');
      $sy = $this->librarymodule_model->show_sy();
      $sy_now = $sy->school_year;
      $sy_id = $sy_now - 2012;
      $tr_id = date("ymdHi-s");
      $tr_st_id = $this->input->post('tr_st_id');
      $tr_bk_id = $this->input->post('tr_bk_id');
      $tr_date = date("F d, Y (H:i)");
      $tr_staff_id = $this->input->post('tr_staff_id');
      $tr_eu_id = base64_decode($this->input->post('tr_eu_id'));
      $tr_due_date = $this->input->post('tr_due_date');
      $tr_flag = "0";
      $tr_sy_id = $sy_id;
      
      $sendResult = $this->librarymodule_model->save_new_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_due_date, $tr_flag, $tr_sy_id);
//      Modules::run('web_sync/updateSyncController', 'lib_transaction', 'tr_id', $tr_id, 'create', 6);

      // update item's info

      $bk_id = $this->input->post('tr_bk_id');
      $items = array(
        'bk_st_id' => $this->input->post('tr_st_id'),
        'bk_st_date' => $this->input->post('bk_st_date'),
        'bk_tr_id' => date("ymdHi-s"),
        );
      $this->librarymodule_model->edit_bk($items, $bk_id);
//      Modules::run('web_sync/updateSyncController', 'lib_book', 'bk_id', $bk_id, 'update', 6);

      // update user's info

      $eu_id = base64_decode($this->input->post('tr_eu_id'));
      $user = array(
        'eu_borrows' => $this->input->post('eu_borrows'),
        'eu_return_count' => $this->input->post('eu_lend_count'),
      );

      $this->librarymodule_model->edit_lib_entity_user($user, $eu_id);
//      Modules::run('web_sync/updateSyncController', 'lib_entity_user', 'eu_id', $eu_id, 'update', 6); 

    }

      // =======saving=======
      // $stud_id = $this->input->post('stud_id');
      //       $plan_id = $this->input->post('selPlan');
      //       $sy_id = $this->input->post('sy_id');
      //       $sendResult = $this->financemanagement_model->saveAccountPlan($stud_id, $plan_id, $sy_id);
      //       Modules::run('web_sync/updateSyncController', 'fin_accounts', 'accounts_id', $sendResult, 'create', 6);
      // ===========edit===============
      // $plan_id = $this->input->post('plan_id');
      // $items = array(
      //     'plan_description' => $this->input->post('nwPlanName'),
      // );
      // $this->financemanagement_model->editplan($items, $plan_id);
      // Modules::run('web_sync/updateSyncController', 'fin_plan', 'plan_id', $plan_id, 'update', 6);

    public function return_item()
    {
      date_default_timezone_set('Asia/Manila');
        $tr_id = $this->input->post('tr_id');
        $trans = array(
            'tr_ret_date' => $this->input->post('tr_ret_date'),
            'tr_st_id' => $this->input->post('bk_st_id'),
            'tr_flag' => $this->input->post('tr_flag'),
            'tr_remarks' => $this->input->post('tr_remarks'),
            'tr_staff_id' => $this->input->post('tr_staff_id'),
        );

        $this->librarymodule_model->edit_lib_transaction($trans, $tr_id);
//        Modules::run('web_sync/updateSyncController', 'lib_transaction', 'tr_id', $tr_id, 'update', 6);

        $bk_id = $this->input->post('tr_bk_id');
        $book = array(
            'bk_st_id' => $this->input->post('bk_st_id'),
            'bk_st_date' => $this->input->post('tr_ret_date'),
            'bk_tr_id' => $this->input->post('tr_id'),
        );

        $this->librarymodule_model->edit_lib_book($book, $bk_id);
//        Modules::run('web_sync/updateSyncController', 'lib_book', 'bk_id', $bk_id, 'update', 6);

        $eu_id = $this->input->post('eu_id');
        $user = array(
            'eu_return_count' => $this->input->post('eu_return_count'),
        );

        $this->librarymodule_model->edit_lib_entity_user($user, $eu_id);
//        Modules::run('web_sync/updateSyncController', 'lib_entity_user', 'eu_id', $eu_id, 'update', 6);

    }

  	public function report()
  	{
  		
  		if(!$this->session->userdata('is_logged_in')){
	  		?>
	  			<script type="text/javascript">
	  				documnet.location = "<?php echo base_url() ?>"
	  			</script>
	  		<?php
	  	}else{
        $url1 = $this->uri->segment(3);
        if ($url1=='b') {
          // $bfrom = $this->uri->segment(4);
          // $bto = $this->uri->segment(5);
          // if ($bfrom) {
          //    $bfrom = $bfrom;
          // }else{
          //    $bfrom = date('Y-m-d', strtotime('-2 Months'));
          // }
          // if ($bto) {
          //    $bto = $bto;
          // }else{
          //    $bto = date('Y-m-d');
          // }
          $data['brecords'] = $this->librarymodule_model->get_brecords();
          // $data['brecords'] = $this->librarymodule_model->get_brecords($bfrom, $bto);
        }
        // print_r($bfrom);
	  		$data['main_content'] = 'report';
	  		$data['modules'] = 'librarymodule';
	  		echo Modules::run('templates/main_content', $data);
	  	}
  	}

  	public function settings()
  	{
  		
  		if(!$this->session->userdata('is_logged_in')){
	  		?>
	  			<script type="text/javascript">
	  				documnet.location = "<?php echo base_url() ?>"
	  			</script>
	  		<?php
	  	}else{
         $data['students'] = $this->librarymodule_model->student_list();
	  		$data['main_content'] = 'settings';
	  		$data['modules'] = 'librarymodule';
	  		echo Modules::run('templates/main_content', $data);
	  	}
  	}

  	public function save_book()
  	{
  		$check = $this->uri->segment(4);

  		if ($check=="new") {
  			$gb_id = $this->input->post('gb_id');
       	$gb_title = $this->input->post('book_title');
        $gb_sub_title = $this->input->post('book_sub_title');
       	$gb_auth = $this->input->post('bk_author');
        $gb_other_auth = $this->input->post('bk_other_auth');
        $gb_ss = $this->input->post('bk_ss');
        $gb_sor = $this->input->post('bk_sor');
       	$gb_volume = $this->input->post('bk_volume');
       	$gb_dw = $this->input->post('bk_dewey');
        $gb_tt = $this->input->post('bk_tt');
       	$gb_ca_id = $this->input->post('bk_category');
       	$gb_remarks = $this->input->post('bk_remarks');

       	$sendResult = $this->librarymodule_model->save_new_genbook($gb_ss, $gb_other_auth, $gb_id, $gb_title, $gb_sub_title, $gb_auth, $gb_sor, $gb_volume, $gb_dw, $gb_ca_id, $gb_remarks, $gb_tt);

       	$gbook_id = $this->input->post('gb_id');

  		}else if($check=="old"){

  			$gbook_id = $this->input->post('ebk_prop');

  		}  		 

     	 $copies = $this->uri->segment(3);

     	for ($i=1; $i<=$copies; $i++){
     		date_default_timezone_set('Asia/Manila');
     		$id = date("ymdHis")."-".$i;
     		$bk_id = $id;
      		$bk_gb_id = $gbook_id;
          $bk_call_number = $this->input->post('bk_call_number');
          $bk_access_number = $this->input->post('bk_access_number');
          $bk_extent = $this->input->post('bk_extent');
        	$bk_pub_id = $this->input->post('bk_publisher');
        	$bk_pub_date = $this->input->post('bk_date_pub');
        	$bk_serial_num = $this->input->post('bk_serial');
        	$bk_rfid = $this->input->post('bk_rfid');
          $bk_copyright = $this->input->post('bk_copyright');
        	$bk_st_id = $this->input->post('bk_status');
        	$bk_st_date = date("m/d/y");
        	$bk_cost_price = $this->input->post('bk_cost_price');
        	$bk_date_acquired = $this->input->post('bk_date_acquired');
       	$bk_edition = $this->input->post('bk_edition');
       	$bk_isbn = $this->input->post('bk_isbn');
        $bk_dimension = $this->input->post('bk_dimension');
       	$bk_shelf_id = $this->input->post('bk_shelf');
       	$bk_fn_id = $this->input->post('bk_fine');
       	$bk_borrow_days = $this->input->post('bk_brw_days');
       	$bk_physical_desc = $this->input->post('bk_pdesc');
       	$bk_source = $this->input->post('bk_acq_source');
       	$bk_tr_id = date("ymdHi-s")."".$i;
       	$sendResult = $this->librarymodule_model->save_new_book($bk_id, $bk_gb_id, $bk_call_number, $bk_access_number, $bk_extent, $bk_pub_id, $bk_pub_date, $bk_serial_num, $bk_rfid, $bk_copyright, $bk_st_id, $bk_st_date, $bk_cost_price, $bk_date_acquired, $bk_edition, $bk_isbn, $bk_dimension, $bk_shelf_id, $bk_fn_id, $bk_borrow_days, $bk_physical_desc, $bk_source, $bk_tr_id);

       	$tr_id = date("ymdHi-s")."".$i;
       	$tr_st_id = $this->input->post('bk_status');
       	$tr_bk_id = $id;
       	$tr_date = date("F d, Y (H:i)");
       	$tr_staff_id = $this->input->post('u_id');
       	$tr_eu_id = 1; // system account
       	$tr_remarks = 'Initial setup';
       	$sendResult = $this->librarymodule_model->save_new_bk_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_remarks);
           
	    }
  	}

  	function save_new_author()
  	{
  		$au_name = $this->input->post('bk_author_name');
  		$au_address = $this->input->post('bk_author_address');
  		$au_website = $this->input->post('bk_author_web');
  		$au_email = $this->input->post('bk_author_email');
  		$sendResult = $this->librarymodule_model->save_new_author($au_name, $au_address, $au_website, $au_email);
      echo $sendResult;
  	}

    function save_new_sor()
    {
      $au_name = $this->input->post('bk_author_name');
      $au_address = $this->input->post('bk_author_address');
      $au_website = $this->input->post('bk_author_web');
      $au_email = $this->input->post('bk_author_email');
      $sendResult = $this->librarymodule_model->save_new_author($au_name, $au_address, $au_website, $au_email);
      echo $sendResult;
    }

    function save_new_dds()
    {
      $bk_dds_code = $this->input->post('bk_dds_code');
      $bk_dds_desc = $this->input->post('bk_dds_desc');
      $bk_deweys = $this->input->post('bk_deweysi');
      $sendResult = $this->librarymodule_model->save_new_dds($bk_dds_code, $bk_dds_desc, $bk_deweys);
      echo $sendResult;
    }

    function save_new_tt()
    {
      $bk_tt = $this->input->post('bk_tt');
      $sendResult = $this->librarymodule_model->save_new_tt($bk_tt);
      echo $sendResult;
    }

  	function save_new_publication()
  	{
  		$pb_name = $this->input->post('bk_publication');
  		$pb_address = $this->input->post('bk_publication_address');
  		$pb_contactnum = $this->input->post('bk_publication_contactnum');
  		$pb_contactperson = $this->input->post('bk_publication_contactperson');
  		$pb_web = $this->input->post('bk_publication_web');
  		$pb_email = $this->input->post('bk_publication_email');
  		$sendResult = $this->librarymodule_model->save_new_publication($pb_name, $pb_address, $pb_contactnum, $pb_contactperson, $pb_web, $pb_email);
      echo $sendResult;
  	}

    
  
   function save_entrance_in($eu_id, $time_in, $sy_id, $date)
   {
      $id = $this->library_model->save_entrance_in($eu_id, $time_in, $sy_id, $date);
//      Modules::run('web_sync/updateSyncController', 'lib_entrance', 'en_id', $id, 'create', 3);
      return $id;
   }

   function scan()
   {
      $data['news'] = Modules::run('messaging/getAnnouncement', 1);
      $data['settings'] = Modules::run('main/getSet');
      $this->load->view('login/scan', $data);
   }    


   function scanrfid()
   {
      // print_r("What is the meaning of this?");
      $rfid = $this->input->post('id');
      $user_info = $this->librarymodule_model->get_user_info($rfid);                             
      // capture unregistered ID
      if ($user_info) {
         $eu_id = $user_info->user_id;
         $prev_time = $user_info->eu_tot_time;
      }else{
         $eu_id = "";
      }
      
      $user_id = $eu_id; 
      $search_account = $this->librarymodule_model->getprofile($eu_id); 
      
      date_default_timezone_set('Asia/Manila');
      $time_now = date('h:i a');
      // $sy_id = 5; // 15-16 = 3
      $sy = $this->librarymodule_model->show_sy();
      $sy_now = $sy->school_year;
      $sy_id = $sy_now - 2012;
      $date_now = date('Y-m-d');
      $time_stamp = date('ndHis');
      $time_hour = date('H');
      $time_min = date('i');
      $msg = "";
      $print_status = "";

      if($search_account->num_rows()>0){ // if account exist

         // check the last recorded status of the user
         $lstatus = $user_info->eu_ent_stat; // in or out
         $ltime_stamp = $user_info->eu_last_timestamp; // timestamp ndHis

         if($ltime_stamp!=0 || $ltime_stamp!="" | $ltime_stamp!=NULL){  // checking last time stamp if empty
            $time_dif = $time_stamp - $ltime_stamp;
         }else{
            $time_dif = 100;  // if empty assign 1 minute to time_diff
         }

         if($lstatus==0 || $lstatus=="" || $lstatus==NULL){  // if status is out or no record

            // check if previous scan is within 1 minute
            if($time_dif>=100){
               
               // create new transaction for the user
               $trans_id = $this->librarymodule_model->save_entrance_in($eu_id, $time_now, $date_now, $sy_id);

//               Modules::run('web_sync/updateSyncController', 'lib_entrance', 'en_id', $trans_id, 'create', 6);

               // update user's information entrance status to in
               $en_stat = 1;  // status in
               
               $user = array(
                   'eu_ent_id' => $trans_id,
                   'eu_ent_stat' => $en_stat,
                   'eu_last_timestamp' => $time_stamp,
                   'eu_lhour' => $time_hour,
                   'eu_lmin' => $time_min,
               );

               $this->librarymodule_model->edit_lib_entity_user($user, $eu_id);
//               Modules::run('web_sync/updateSyncController', 'lib_entity_user', 'eu_id', $eu_id, 'update', 6);

               $check_in = 'check_in_on.png';
               
               $lastname = $user_info->lastname;
               $firstname = $user_info->firstname;
               $avatari = $user_info->avatar;
               $status = TRUE;
               $print_status = "IN";

               if($user_info->avatar!=""):
                  $avatar = base_url().'uploads/'.$avatari;
               else:
                  $avatar = base_url().'uploads/noImage.png';
               endif;

            }else{
               
               $status = FALSE;
               $msg = 'Wait! You have just scanned your ID. Please try again later.';
               $check_in = '';
               $check_out = ''; 
               $lastname = '';   
               $firstname = '';   
               $rfid = '';
               $user_id = "";

            }

         }else if($lstatus==1){

            $ltrans_id = $user_info->eu_ent_id; // fetch last transaction number recorded
            // check if previous scan is within 1 minute
            if($time_dif>=100){

               // calculate time-in -> time-out and save on total time
               $lthour = $user_info->eu_lhour;
               $ltmin = $user_info->eu_lmin;
               $thour = $time_hour - $lthour;
               $tmin = $time_min - $ltmin;
               $tot_time = $tmin + $thour * 60;
               $time_count = $prev_time + $tot_time;


               // update the last transaction number fetched
               $ent = array(
                  'en_time_out' => $time_now,
                  'en_date_out' => $date_now,
                  'en_time_total' => $tot_time,
                  // 'en_date' => $date_now,
               );
               $this->librarymodule_model->save_entrance_out($ent, $ltrans_id);
//               Modules::run('web_sync/updateSyncController', 'lib_entrance', 'en_id', $ltrans_id, 'update', 6);

               // update the user's information entrance status to out
               $en_stat = 0;  // status out  
               $user = array(
                   'eu_ent_id' => $ltrans_id,
                   'eu_ent_stat' => $en_stat,
                   'eu_last_timestamp' => $time_stamp,
                   'eu_tot_time' => $time_count,
               );
               $this->librarymodule_model->edit_lib_entity_user($user, $eu_id);
//               Modules::run('web_sync/updateSyncController', 'lib_entity_user', 'eu_id', $eu_id, 'update', 6);

               $check_in = 'check_out_on.png';

               $lastname = $user_info->lastname;
               $firstname = $user_info->firstname;
               $avatari = $user_info->avatar;
               $status = TRUE;
               $print_status = "OUT";
               if($user_info->avatar!=""):
                  $avatar = base_url().'uploads/'.$avatari;
               else:
                  $avatar = base_url().'uploads/noImage.png';
               endif;

            }else{

               $status = FALSE;
               $msg = 'Wait! You have just scanned your ID. Please try again later.';
               $check_in = '';
               $check_out = ''; 
               $lastname = 'TryMe';   
               $firstname = '';   
               $rfid = '';
               $user_id = "";
               $avatar = base_url().'uploads/noImage.png';
            }
         }

      }else{ // if($user_info->num_rows()>0){ 

         $status = FALSE;
         $msg = 'Sorry, your ID is not yet registered.';
         $check_in = '';
         $check_out = ''; 
         $lastname = 'Registered';   
         $firstname = 'Not';   
         $rfid = '';
         $user_id = "";
         $avatar = base_url().'uploads/noImage.png';
     
      }
     
      echo json_encode(array(
            'check_in'      => base_url().'images/'.$check_in,
            // 'check_out'     => base_url().'images/'.$check_out,
            'lastname'      => $lastname,
            'firstname'     => $firstname,
            'id'            => $user_id,
            'rfid'          => $rfid,
            'status'        => $status,
            'msg'           => $msg,
            'avatar'        => $avatar,
            'print_status'  => $print_status,
            // 'textmsg'       => $textMsg,
            // 'send'          => $send,
            // 'contact'       => $number,
         )
      );
   }
   

}