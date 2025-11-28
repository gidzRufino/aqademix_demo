<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
//===========================================
// by: cyrus y. rufino 
// Canaan Software Solutions
//===========================================
class Financemanagement extends MX_Controller {

    public function __construct() {
            parent::__construct();
            $this->load->library('Pdf');
            //$this->load->library('form_validation');
            //$this->form_validation->CI =& $this;
            $this->load->model('financemanagement_model');
            //$this->load->library('pagination');
    }

  // data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),  => on post add to js


// private $general_school_year = 2; $sy_id = 2; // 2014-2015


// ================================== test start

  public function testsend()
  {
    $me = $this->uri->segment(3);
    $data['showItems'] = $me;
      $data['main_content'] = 'test/show';
      $data['modules'] = 'financemanagement';
      echo Modules::run('financemanagement/main_content', $data); 
  }

  public function test()
  {
    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php  
    }else{
      $data['testme'] = $this->financemanagement_model->test_getPlanDescription();
      $data['main_content'] = 'test/test';
      $data['modules'] = 'financemanagement';
      // echo Modules::run('financemanagement/finance_content', $data);
      echo Modules::run('templates/main_content', $data);
  
  }}

// ================================== test end

function html_header()
{
    $this->load->view('pos/header');
}

function main_content($data)
{
    $this->load->view('pos/main_content', $data);
}

function html_footer()
{
    $this->load->view('pos/footer');
}

function yearConverter($sy_id)
{
     if ($sy_id == 2){
            $sy = 2014;
        }else if ($sy_id == 3){
            $sy = 2015;
        }else if ($sy_id == 4){
            $sy = 2016;
        }else if ($sy_id == 5){
            $sy = 2017;
        }else if ($sy_id == 6){
            $sy = 2018;
        }else{
            $sy = NULL;
        }
    return $sy;
}

public function index()
{
    if(!$this->session->userdata('is_logged_in')){
            ?>
                 <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                 </script>
            <?php
            
         }else{
            $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
            $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
            $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
            $data['showPlan'] = $this->financemanagement_model->showfinPlan();
            $data['showItems'] = $this->financemanagement_model->showfinItems();
            $data['main_content'] = 'default';
            $data['modules'] = 'financemanagement';
            // echo Modules::run('financemanagement/finance_content', $data);
            echo Modules::run('templates/main_content', $data);
         }
}

function pos($user_id=null)
{
  $seg = $this->uri->segment(3);
  $val = $this->uri->segment(4);
  if(!$this->session->userdata('is_logged_in')){
    ?>
      <script type="text/javascript">
        document.location = "<?php echo base_url()?>"
      </script>
    <?php
  }else{
    if($seg!=''){
      $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
      $data['searched_student'] = Modules::run('registrar/getSingleStudent', base64_decode($user_id));
      $data['finance_plan'] = $this->financemanagement_model->getPlanDescription_sy(base64_decode($user_id), base64_decode($val));
      // $data['finance_plan'] = $this->financemanagement_model->getPlanDescription(base64_decode($user_id));
      // $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa(base64_decode($user_id));
      $data['show_extra'] = $this->financemanagement_model->show_fin_extra(base64_decode($user_id));
      $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa_sy(base64_decode($user_id), base64_decode($val));
      $data['show_extra'] = $this->financemanagement_model->show_fin_extra_sy(base64_decode($user_id), base64_decode($val));
      $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudents(base64_decode($user_id), base64_decode($val));

      $data['default_sy'] = $this->financemanagement_model->showsetsy();
      // $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
      $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
      $data['showPlan'] = $this->financemanagement_model->showfinPlan();
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['main_content'] = 'pos/pos';
      $data['modules'] = 'financemanagement';
      echo Modules::run('financemanagement/main_content', $data);
    }else{
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['default_sy'] = $this->financemanagement_model->showsetsy();
      $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
      $data['main_content'] = 'pos/pos';
      $data['modules'] = 'financemanagement';
      echo Modules::run('financemanagement/main_content', $data);
    }
  }
}

function calc()
{
  $data['main_content'] = 'calc';
  $data['modules'] = 'financemanagement';
  echo Modules::run('financemanagement/main_content', $data);
}

function finance_content($data)
{
    $this->load->view('finance_content', $data);

}

function get_finance_menus()
{
    $position_id = $this->session->userdata('position_id');
    $data['menus']= $this->financemanagement_model->getMenu($position_id); 
    $this->load->view('finance_nav', $data);
}

public function details($cal=null)
{ // 08-08-2014&09-09-2014
  $sdate = $this->uri->segment(3);
    $st = substr($sdate,0,10);
    $fn = substr($sdate,11,21);
  if ($sdate!=''){
    $data['sdetail'] = $this->financemanagement_model->show_details();
    $data['sitems'] = $this->financemanagement_model->itemlist();
    $data['strans'] = $this->financemanagement_model->showtransaction($st, $fn);
    $data['main_content'] = 'reports/trans_list';
    $data['modules'] = 'financemanagement';
    // echo Modules::run('financemanagement/main_content', $data);
    echo Modules::run('templates/main_content', $data);
  }else{
    $sn = date("m-d-Y");
    $data['sdetail'] = $this->financemanagement_model->show_details();
    $data['sitems'] = $this->financemanagement_model->itemlist();
    $data['strans'] = $this->financemanagement_model->showtransaction($sn, $sn);
    $data['main_content'] = 'reports/trans_list';
    $data['modules'] = 'financemanagement';
    // echo Modules::run('financemanagement/main_content', $data);
    echo Modules::run('templates/main_content', $data);
  }
}

public function mystudents()
{
  if(!$this->session->userdata('is_logged_in')){
    ?>
      
      <script type="text/javascript">
        document.location = "<?php echo base_url() ?>"
      </script>

    <?php
  
  } else {
    $sy_now = $this->session->userdata('school_year');
      if ($sy_now == 2014){
            $sy_id = 2;
        }else if ($sy_now == 2015){
            $sy_id = 3;
        }else if ($sy_now == 2016){
            $sy_id = 4;
        }else if ($sy_now == 2017){
            $sy_id = 5;
        }else if ($sy_now == 2018){
            $sy_id = 6;
        }
        $data['school'] = $sy_id;

      $data['accountz'] = $this->financemanagement_model->showfinParentAccount($this->session->userdata('school_year'), $this->session->userdata('user_id'));
      $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
      $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['show_extra'] = $this->financemanagement_model->show_added_charge();
      $data['tdetails'] = $this->financemanagement_model->show_trans_details();
      $data['main_content'] = 'parent/mystudents';
      $data['modules'] = 'financemanagement';
      echo Modules::run('templates/main_content', $data);
      
  }
}

public function msa()
{
  if(!$this->session->userdata('is_logged_in')){
    ?>
      
      <script type="text/javascript">
        document.location = "<?php echo base_url() ?>"
      </script>

    <?php
  
  } else {
    $user_id = $this->uri->segment(3);
    $syid = $this->uri->segment(4);
    $data['finance_plan'] = $this->financemanagement_model->getPlanDescription_sy(base64_decode($user_id), base64_decode($syid));
    $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa_sy(base64_decode($user_id), base64_decode($syid));
    $data['show_extra'] = $this->financemanagement_model->show_fin_extra_sy(base64_decode($user_id), base64_decode($syid));
    $data['searched_student'] = $this->financemanagement_model->getstudentaccount(base64_decode($user_id), base64_decode($syid));
    $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
    $data['default_sy'] = $this->financemanagement_model->showsetsy();
    $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudents(base64_decode($user_id), base64_decode($syid));
    $data['check_plan'] = $this->financemanagement_model->checkfinAccounts(base64_decode($user_id));
    $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
    $data['showPlan'] = $this->financemanagement_model->showfinPlan();
    $data['showItems'] = $this->financemanagement_model->showfinItems();
    $data['show_sy'] = $this->financemanagement_model->showfinSY();
    $data['main_content'] = 'parent/student_account';
    $data['modules'] = 'financemanagement';
    echo Modules::run('templates/main_content', $data);
  }
}

public function s8347h($user_id=null)
{
    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php
        
     }else{
         
        $seg = $this->uri->segment(3);
        if ($seg=='print'){
          $seg2 = $this->uri->segment(4);
          $sy_id = $this->uri->segment(5);
          $data['actz_id'] = base64_decode($seg2);
          $data['sy_id'] = base64_decode($sy_id);
          $data['showItems'] = $this->financemanagement_model->showfinItems();
          $data['default_sy'] = $this->financemanagement_model->showsetsy();
          // $data['accountz'] = $this->financemanagement_model->show_account_info();
          $data['accountz'] = $this->financemanagement_model->showfinAccount(base64_decode($sy_id));
          $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
          $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
          $data['show_extra'] = $this->financemanagement_model->show_added_charge();
          $data['school_settings'] = $this->financemanagement_model->school_settings();
          $data['tdetails'] = $this->financemanagement_model->show_trans_details();
          $data['main_content'] = 'reports/actz_soa';
          $data['modules'] = 'financemanagement';
          // echo Modules::run('financemanagement/finance_content', $data);
          echo Modules::run('templates/main_content', $data);

        }elseif($seg=='recalc') {

          $stud_id = $this->uri->segment(4);
          $syid = $this->uri->segment(5);
          $year = $this->yearConverter(base64_decode($syid));
          $data['finance_plan'] = $this->financemanagement_model->getPlanDescription_sy(base64_decode($stud_id), base64_decode($syid));
          $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa_sy(base64_decode($stud_id), base64_decode($syid));
          $data['show_extra'] = $this->financemanagement_model->show_fin_extra_sy(base64_decode($stud_id), base64_decode($syid));
          // $data['searched_student'] = Modules::run('registrar/getSingleStudent', base64_decode($stud_id));
          $data['searched_student'] = $this->financemanagement_model->getstudentaccount(base64_decode($stud_id), base64_decode($syid));
          $data['students'] = Modules::run('registrar/getAllStudentsForExternal', NULL,NULL,NULL,NULL, $year);
          $data['default_sy'] = $this->financemanagement_model->showsetsy();
          $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudents(base64_decode($stud_id), base64_decode($syid));
          $data['check_plan'] = $this->financemanagement_model->checkfinAccounts(base64_decode($stud_id));
          $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
          $data['showPlan'] = $this->financemanagement_model->showfinPlan();
          $data['showItems'] = $this->financemanagement_model->showfinItems();
          $data['show_sy'] = $this->financemanagement_model->showfinSY();

          $data['main_content'] = 'accounts/recalc';
          $data['modules'] = 'financemanagement';
          // echo Modules::run('financemanagement/finance_content', $data);
          echo Modules::run('templates/main_content', $data);

        }else{

          $syid = $this->uri->segment(4);
          $year = $this->yearConverter(base64_decode($syid));
          $data['finance_plan'] = $this->financemanagement_model->getPlanDescription_sy(base64_decode($user_id), base64_decode($syid));
          $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa_sy(base64_decode($user_id), base64_decode($syid));
          $data['show_extra'] = $this->financemanagement_model->show_fin_extra_sy(base64_decode($user_id), base64_decode($syid));
          $data['searched_student'] = $this->financemanagement_model->getstudentaccount(base64_decode($user_id), base64_decode($syid));
          $data['students'] = Modules::run('registrar/getAllStudentsForExternal', NULL,NULL,NULL,NULL, $year);
          $data['default_sy'] = $this->financemanagement_model->showsetsy();
          $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudents(base64_decode($user_id), base64_decode($syid));
          $data['check_plan'] = $this->financemanagement_model->checkfinAccounts(base64_decode($user_id), $year);
          $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
          $data['showPlan'] = $this->financemanagement_model->showfinPlan();
          $data['showItems'] = $this->financemanagement_model->showfinItems();
          $data['show_sy'] = $this->financemanagement_model->showfinSY();
          $data['main_content'] = 'actz';
          $data['syid'] = $syid
;          $data['modules'] = 'financemanagement';
          // echo Modules::run('financemanagement/finance_content', $data);
          echo Modules::run('templates/main_content', $data);

      }
    }
  }

public function report()
{
  if(!$this->session->userdata('is_logged_in')){ 

    ?>
    
      <script type="text/javascript">
        document.location = "<?php echo base_url()?>"
      </script>
      
    <?php
        
  }else{ 

    $data['item_list'] = $this->financemanagement_model->itemlist();
    $data['grade_level'] = $this->financemanagement_model->showgradelevel();
    $data['account_list'] = $this->financemanagement_model->showaccounts();
    $data['add_charge'] = $this->financemanagement_model->showaccountcharges();
    $data['init_list'] = $this->financemanagement_model->showfinInit();
    $data['main_content'] = 'reports/expectedbylevel';
    $data['modules'] = 'financemanagement';
    echo Modules::run('templates/main_content', $data);

  }
}
public function search($user_id=null)
{
    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php
        
     }else{                
        $data['finance_plan'] = $this->financemanagement_model->getPlanDescription($user_id);
        $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa($user_id);
        $data['show_extra'] = $this->financemanagement_model->show_fin_extra($user_id);
        $data['searched_student'] = Modules::run('registrar/getSingleStudent', $user_id);
        $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
        $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
        $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
        $data['showPlan'] = $this->financemanagement_model->showfinPlan();
        $data['showItems'] = $this->financemanagement_model->showfinItems();
        $data['main_content'] = 'default';
        $data['modules'] = 'financemanagement';
        // echo Modules::run('financemanagement/finance_content', $data);
            echo Modules::run('templates/main_content', $data);
    }
}

public function collect()
  {
    
    if(!$this->session->userdata('is_logged_in')){ ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url()?>"
        </script>
    
    <?php

    }else{
        $sy_id = 5;
        $seg = $this->uri->segment(3);
        if ($seg == 'print_soa'){

            $glevel = $this->uri->segment(4);
            $ndate = $this->uri->segment(5);
            $xdate = $this->uri->segment(6);
            $madvance = $this->uri->segment(7); // month advance

            if ($glevel!=''){

              if($glevel=='el'){

                $data['clevel'] = $ndate;
                $data['cdate'] = $xdate;
                $data['madvance'] = $madvance;
                $data['showItems'] = $this->financemanagement_model->showfinItems();
                // $data['accountz'] = $this->financemanagement_model->show_account_info();
                $data['accountz'] = $this->financemanagement_model->showfinAccount($sy_id);
                $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
                $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
                $data['show_extra'] = $this->financemanagement_model->show_added_charge();
                $data['school_settings'] = $this->financemanagement_model->school_settings();
                $data['tdetails'] = $this->financemanagement_model->show_trans_details();
                $data['showsetsy'] = $this->financemanagement_model->showsetsy();
                $data['main_content'] = 'reports/collect_notice_long';
                $data['modules'] = 'financemanagement';
                // echo Modules::run('financemanagement/finance_content', $data);
                echo Modules::run('templates/main_content', $data);

              }else{

                $data['clevel'] = $glevel;
                $data['cdate'] = $ndate;
                $data['madvance'] = $xdate;
                $data['showItems'] = $this->financemanagement_model->showfinItems();
                // $data['accountz'] = $this->financemanagement_model->show_account_info();
                $data['accountz'] = $this->financemanagement_model->showfinAccount($sy_id);
                $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
                $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
                $data['show_extra'] = $this->financemanagement_model->show_added_charge();
                $data['school_settings'] = $this->financemanagement_model->school_settings();
                $data['tdetails'] = $this->financemanagement_model->show_trans_details();
                $data['showsetsy'] = $this->financemanagement_model->showsetsy();
                $data['main_content'] = 'reports/collect_notice';
                $data['modules'] = 'financemanagement';
                // echo Modules::run('financemanagement/finance_content', $data);
                echo Modules::run('templates/main_content', $data);

              }

            }else{

              $data['get_level'] = $this->financemanagement_model->showgradelevel();
              $data['main_content'] = 'reports/print_collect';
              $data['modules'] = 'financemanagement';
              // echo Modules::run('financemanagement/finance_content', $data);
              echo Modules::run('templates/main_content', $data);

            }

        }elseif ($seg == ''){
            $data['showItems'] = $this->financemanagement_model->showfinItems();
            $data['accountz'] = $this->financemanagement_model->showfinAccounts(); // show_account_info();
            $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
            $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
            $data['show_extra'] = $this->financemanagement_model->show_added_charge();
            $data['tdetails'] = $this->financemanagement_model->show_trans_details();
            $data['get_accounts'] = $this->financemanagement_model->showfinAccounts();
            $data['get_mother'] = $this->financemanagement_model->get_parent_mother();
            $data['get_father'] = $this->financemanagement_model->get_parent_father();
            $data['get_level'] = $this->financemanagement_model->showgradelevel();
            $data['get_init'] = $this->financemanagement_model->showfinInit();
            $data['get_cc'] = $this->financemanagement_model->show_cc();
            $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
            $data['get_added_charge'] = $this->financemanagement_model->show_added_charge();
            $data['main_content'] = 'reports/collect';
            $data['modules'] = 'financemanagement';
            // echo Modules::run('financemanagement/finance_content', $data);
            echo Modules::run('templates/main_content', $data);
        }
    }
  }  
  public function void($trans_id=null)  
  {
    
    if(!$this->session->userdata('is_logged_in')){ ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url()?>"
        </script>
    
    <?php

    }else{
    
      $data['get_accounts'] = $this->financemanagement_model->showfinAccounts();
      $data['tlookup'] = $this->financemanagement_model->show_trans_detail(base64_decode($trans_id));
      $data['tdetails'] = $this->financemanagement_model->show_trans_details();
      $data['transactions'] = $this->financemanagement_model->showtransactions();
      $data['main_content'] = 'forms/void';
      $data['modules'] = 'financemanagement';
      // echo Modules::run('financemanagement/finance_content', $data);
      echo Modules::run('templates/main_content', $data);

    }
  }

  public function actz($stu_id=null)
  {

    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php

    }else{

      // $data['main_content'] = 'pos';
      $data['finance_plan'] = $this->financemanagement_model->getPlanDescription(base64_decode($stu_id));
      $data['itemized_soa'] = $this->financemanagement_model->show_itemized_soa(base64_decode($stu_id));
      $data['show_extra'] = $this->financemanagement_model->show_fin_extra(base64_decode($stu_id));
      $data['searched_student'] = Modules::run('registrar/getSingleStudent', base64_decode($stu_id));
      $data['students'] = Modules::run('registrar/getAllStudentsForExternal');
      $data['sTransaction'] = $this->financemanagement_model->showfinHistoryPerStudent();
      $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
      $data['showPlan'] = $this->financemanagement_model->showfinPlan();
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['show_sy'] = $this->financemanagement_model->showfinSY();
      $data['default_sy'] = $this->financemanagement_model->showsetsy();
      $data['main_content'] = 'actz';
      $data['modules'] = 'financemanagement';
      echo Modules::run('templates/main_content', $data);

    }
  }

  public function plans()
  {
    if(!$this->session->userdata('is_logged_in')) {
      ?>

        <script type="text/javascript">
          document.location = "<?php echo base_url() ?>"
        </script>

      <?php
    }else{
      $syid = $this->uri->segment(3);
      $stid = $this->uri->segment(4);
      $data['studentAccountID'] = base64_decode($stid);
      $data['splan_desc'] = $splan_desc;
      // $data['initialLevel'] = $initialLevel;
      $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel(); 
      // $data['showPlan'] = $showPlan; 
      $data['showPlan'] = $this->financemanagement_model->showfinPlan();
      // $data['showItems'] = $showItems; 
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['sy_now'] = $sy_now;
      $this->load->view('change_plan', $data); 

      $data['main_content'] = 'accounts/act_plan';
      $data['modules'] = 'financemanagement';
      echo Modules::run('templates/main_content', $data);
      
    }
  }

  public function reports($sy_id=null)
  {

    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php
        
      }else{
      $data['main_content'] = 'reports';
      $data['get_accounts'] = $this->financemanagement_model->showfinAccount($sy_id);
      $data['get_init'] = $this->financemanagement_model->showfinInit();
      $data['get_cc'] = $this->financemanagement_model->show_cc();
      $data['get_added_charge'] = $this->financemanagement_model->show_added_charge();
      $data['sTransaction'] = $this->financemanagement_model->showfinTransaction($sy_id);
      $data['showtrans'] = $this->financemanagement_model->showtransactionsy($sy_id);
      $data['sAccounts'] = $this->financemanagement_model->showfinAccountz($sy_id);
      
      $data['sInitials'] = $this->financemanagement_model->showfinInit(); 
      $data['sProfile'] = $this->financemanagement_model->showfinProfile();
      $data['sfinSY'] = $this->financemanagement_model->showfinSY();
      $data['getsy'] = $this->financemanagement_model->get_sy($sy_id);
      $data['showItems'] = $this->financemanagement_model->showfinItems();
      $data['accountz'] = $this->financemanagement_model->showfinAccount($sy_id);
      
      $data['initialLevel'] = $this->financemanagement_model->showfinInitialPerLevel();
      
      $data['show_extra'] = $this->financemanagement_model->show_added_charge();
      $data['tdetails'] = $this->financemanagement_model->show_trans_details();
      $data['translist'] = $this->financemanagement_model->showtransactiondetails();
     }

     // $this->load->view('includes/finance' , $data);
     $data['modules'] = 'financemanagement';
     // echo Modules::run('financemanagement/finance_content', $data);
      echo Modules::run('templates/main_content', $data);

  }


  function showfinAccount($sy_id)
  {
    $accountz = $this->financemanagement_model->showfinAccount($sy_id);
    return $accountz;
  }
  function showfinParentAccount($school_year=NULL, $user_id=NULL)
  {
    $accountz = $this->financemanagement_model->showfinParentAccount($school_year, $user_id);
    return $accountz;
  }

  function showfinInitialPerLevel()
  {
    $initialLevel = $this->financemanagement_model->showfinInitialPerLevel();
    return $initialLevel;
  }

  function showfinTransaction($sy_id=NULL)
  {
    $sTransaction = $this->financemanagement_model->showfinTransaction($sy_id);
    return $sTransaction;
  }

  function showfinHistoryPerStudent()
  {
    $sTransaction = $this->financemanagement_model->showfinHistoryPerStudent();
    return $sTransaction;
  }
  
  function showfinItems()
  {
    $showItems = $this->financemanagement_model->showfinItems();
    return $showItems;
  }

  function show_added_charge()
  {
    $show_extra = $this->financemanagement_model->show_added_charge();
    return $show_extra;
  }
  
  function show_trans_details()
  {
    $tdetails = $this->financemanagement_model->show_trans_details();
    return $tdetails;
  }

  public function config($sy_id=null)
  {
    if(!$this->session->userdata('is_logged_in')){
      ?>
      
       <script type="text/javascript">
          document.location = "<?php echo base_url()?>"
       </script>
      
      <?php
          
      }else{
        $eid = $this->uri->segment(3);
        $initPlan = $this->financemanagement_model->getInitPlan($eid);
        if ($eid=='del'){
          $did = $this->uri->segment(4);
          $iPlan = $this->financemanagement_model->getInitPlan($did);
          if ($did != ''){
            $data['delInitResult'] = $this->financemanagement_model->getInitPlan($did);
            $data['main_content'] = 'delplan';
        } else {                        
            $data['main_content'] = 'config';
          }
        } elseif ($eid == 'edit'){
          $did = $this->uri->segment(4);
          $data['editInitResult'] = $this->financemanagement_model->getInitPlan($did);
          $data['school_year'] = $this->financemanagement_model->showfinSY();
          $data['set_sy'] = $this->financemanagement_model->showsetsy();
          $data['main_content'] = 'editplan';
        } elseif ($eid == 'print') {
          // $did = $this->uri->segment(4);
          $data['getLevel'] = $this->financemanagement_model->getfinGradeLevel();
          $data['showInitsy'] = $this->financemanagement_model->showfinInitsy(base64_decode($sy_id));
          $data['showItems'] = $this->financemanagement_model->showfinItems();
          $data['sfrequency'] = $this->financemanagement_model->showfinFrequency();
          $data['school_year'] = $this->financemanagement_model->showfinSY();
          $data['showPlan'] = $this->financemanagement_model->showfinPlan();
          $data['main_content'] = 'reports/fin_config';
          $data['modules'] = 'financemanagement';
          echo Modules::run('templates/main_content', $data);
        
        } else {                        
          $data['main_content'] = 'config';
        }     
          $data['showinitperyear'] = $this->financemanagement_model->showfinInitialperyear(base64_decode($sy_id));
          $data['set_sy'] = $this->financemanagement_model->showsetsy(); 
          $data['getLevel'] = $this->financemanagement_model->getfinGradeLevel();
          $data['sfrequency'] = $this->financemanagement_model->showfinFrequency();
          $data['showInit'] = $this->financemanagement_model->showfinInit();
          $data['showInitsy'] = $this->financemanagement_model->showfinInitsy(base64_decode($sy_id));
          $data['school_year'] = $this->financemanagement_model->showfinSY();
          $data['showItems'] = $this->financemanagement_model->showfinItems();
          $data['showDept'] = $this->financemanagement_model->showfinDept();
          $data['showPlans'] = $this->financemanagement_model->showfinPlan();
          $data['get_sy'] = $this->financemanagement_model->get_sy(base64_decode($sy_id));
          
          // $data['showCD'] = $this->financemanagement_model->showfinDeptCat();
          $data['showPlan'] = $this->financemanagement_model->showfinPlan();//showsetsy
      }
          //$data['main_content'] = 'default';
          $data['modules'] = 'financemanagement';
          // echo Modules::run('financemanagement/finance_content', $data);
          echo Modules::run('templates/main_content', $data);
  }

  public function showCategory()
  {
      $deptID = $this->uri->segment(3);
      $showCateg = $this->financemanagement_model->showfinCateg($deptID);
      foreach($showCateg as $showCateg){
      ?>
          <option value = "<?php echo $showCateg->category_id ?>"> <?php echo $showCateg->category_name ?> </option>
      <?php 
      }
  }

  public function saveCategory()
  {
      $dept = $this->input->post('deptID');
      $cat_description = $this->input->post('inputDescription');
      $cat_amount = $this->input->post('inputAmount');

      $sendResult = $this->financemanagement_model->saveCategory($dept, $cat_description, $cat_amount);

  }

  public function saveNewItem()
  {
      $item_description = $this->input->post('nwItemName');
      $dept_id = $this->input->post('nwDept');
      $sendResult = $this->financemanagement_model->saveNewItem($item_description, $dept_id);
//      Modules::run('web_sync/updateSyncController', 'fin_items', 'item_id', $sendResult, 'create', 6);      
      ?>
           <script type="text/javascript">
              document.location = "<?php echo base_url()?>"
           </script>
      <?php
      

  }


  public function saveNewDept()
  {
      $dept_name = $this->input->post('nwDeptName');
      $sendResult = $this->financemanagement_model->saveNewDepartment($dept_name);
//      Modules::run('web_sync/updateSyncController', 'fin_department', 'dept_id', $sendResult, 'create', 6);

      $logDate = $this->input->post('delogdate');
      $logaccount = $this->input->post('delogaccount');
      $logremarks = $this->input->post('delogremarks');

      $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//      Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);
  }

  public function saveEditDept()
  {
      $dept_id = $this->input->post('odept_id');
      $items = array(
          'dept_description' => $this->input->post('nwDeptName'),
      );
      
      $this->financemanagement_model->editdepartment($items, $dept_id);
//      Modules::run('web_sync/updateSyncController', 'fin_department', 'dept_id', $dept_id, 'update', 6);

      $logDate = $this->input->post('delogdate');
      $logaccount = $this->input->post('delogaccount');
      $logremarks = $this->input->post('delogremarks');

      $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);
//      Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }

  public function editItem()
  {
      $item_id = $this->input->post('item_id');
      $items = array(
          'item_description' => $this->input->post('nwItemName'),
          'dept_id' => $this->input->post('nwDept'),
      );
      
      $this->financemanagement_model->edititems($items, $item_id);
//      Modules::run('web_sync/updateSyncController', 'fin_items', 'item_id', $item_id, 'update', 6);

      $logDate = $this->input->post('delogdate');
      $logaccount = $this->input->post('delogaccount');
      $logremarks = $this->input->post('delogremarks');

      $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);
//      Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);
  }

  public function editplan()
  {
      $plan_id = $this->input->post('plan_id');
      $items = array(
          'plan_description' => $this->input->post('nwPlanName'),
      );
      
      $this->financemanagement_model->editplan($items, $plan_id);
//      Modules::run('web_sync/updateSyncController', 'fin_plan', 'plan_id', $plan_id, 'update', 6);

      $logDate = $this->input->post('delogdate');
      $logaccount = $this->input->post('delogaccount');
      $logremarks = $this->input->post('delogremarks');

      $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);
//      Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }

  public function saveAccountPlan()
  {
      $stud_id = $this->input->post('stud_id');
      $plan_id = $this->input->post('selPlan');
      $sy_id = $this->input->post('sy_id');

      $sendResult = $this->financemanagement_model->saveAccountPlan($stud_id, $plan_id, $sy_id);

//      Modules::run('web_sync/updateSyncController', 'fin_accounts', 'accounts_id', $sendResult, 'create', 6);

  }


  public function void_transaction()
  {
    $void_count = $this->input->post('last_void');

    for ($i=1; $i<=$void_count; $i++){
    $void_detail_id = $this->input->post('detail_id'.$i);
    $sendResult = $this->financemanagement_model->void_transaction_detials($void_detail_id);
    
//    Modules::run('web_sync/updateSyncController', 'fin_detail', 'detail_id', $void_detail_id, 'delete', 6);    

    }

    $vtrans_id = $this->input->post('vtrans_id');
    $sendResult = $this->financemanagement_model->void_transaction($vtrans_id);

//    Modules::run('web_sync/updateSyncController', 'fin_transaction', 'trans_id', $vtrans_id, 'delete', 6);
    
    $logDate = $this->input->post('elogdate');
    $logaccount = $this->input->post('elogaccount');
    $logremarks = $this->input->post('elogremarks');

    $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//    Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }

  public function saveTransaction()
  {
      $entries = $this->input->post('endEntry');

      // $uri3 = $this->uri->segment(3);

      for ($i=1; $i<=$entries; $i++){

          $trans_ID = base64_decode($this->input->post('sysGenRef'));
          $item_ID = $this->input->post('itemID'.$i);
          $fin_amount = $this->input->post('dAmount'.$i);
          $charge_credit = $this->input->post('scharge_credit'.$i);
          $sy_id = $this->input->post('sy_id');

          $sendResult = $this->financemanagement_model->saveTransactionDetail($trans_ID, $item_ID, $fin_amount, $charge_credit, $sy_id);    
//          Modules::run('web_sync/updateSyncController', 'fin_detail', 'detail_id', $sendResult, 'create', 6);

      }

      $trans_ID = base64_decode($this->input->post('trans_iden'));
      $ref_number = $this->input->post('ptreferrence');
      $stud_id = $this->input->post('studID');
      $tdate = $this->input->post('tDate');
      $tcashier = $this->input->post('userID');
      $tcharges = $this->input->post('scharge');
      $tcredits = $this->input->post('scredit');
      $tremarks = $this->input->post('ptRemark');
      $detail_transID = base64_decode($this->input->post('sysGenRef')); 
      $sy_id = $this->input->post('sy_id');

      $transnum = $trans_ID;

      $sendResult = $this->financemanagement_model->savePayTransaction($trans_ID, $ref_number, $stud_id, $tdate, $tcashier, $tcharges, $tcredits, $tremarks, $sy_id);
//      Modules::run('web_sync/updateSyncController', 'fin_transaction', 'trans_id', $trans_ID, 'create', 6);

      // $this->print_to_or($transnum);

  }

  public function pay_confirm($transnum=null)
  { 
    if(!$this->session->userdata('is_logged_in')){
        ?>
             <script type="text/javascript">
                document.location = "<?php echo base_url()?>"
             </script>
        <?php
    }else{

      $syid = $this->uri->segment(4);
      $user_id = $this->uri->segment(5);

      if ($syid=='print'){
        $user_id = $this->uri->segment(5);
        $sy_id = $this->uri->segment(6);
        $trans_num = $this->uri->segment(3);
        $data['get_accounts'] = $this->financemanagement_model->getstudentaccount(base64_decode($user_id), base64_decode($sy_id));        
        $data['tlookup'] = $this->financemanagement_model->show_trans_detail(base64_decode($trans_num));
        $data['tdetails'] = $this->financemanagement_model->show_trans_details();
        $data['transactions'] = $this->financemanagement_model->showtransactions();
        $data['main_content'] = 'pos/print_pos';
        $data['modules'] = 'financemanagement';
        echo Modules::run('financemanagement/main_content', $data);

      }else{

        $data['get_accounts'] = $this->financemanagement_model->getstudentaccount(base64_decode($user_id), base64_decode($syid));
        $data['tlookup'] = $this->financemanagement_model->show_trans_detail(base64_decode($transnum));
        $data['tdetails'] = $this->financemanagement_model->show_trans_details();
        $data['transactions'] = $this->financemanagement_model->showtransactions();
        // $data['main_content'] = 'pos/print_pos';
        $data['main_content'] = 'pos/pay_confirm';
        $data['modules'] = 'financemanagement';
        echo Modules::run('financemanagement/main_content', $data);
     
      }
    }
  }

  public function savePaymentItems()
  {
      $level_id = $this->input->post('itID');
      $item_id = $this->input->post('itSelItem');
      $item_amount = $this->input->post('itAmount');
      $sched_id = $this->input->post('itSched');
      $sy_id = $this->input->post('itSY');
      $imp_date = $this->input->post('itImpDate');
      $ch_cr = $this->input->post('itChCr');
      $it_plan = $this->input->post('itPlan');

      $sendResult = $this->financemanagement_model->saveFinInitial($level_id, $item_id, $item_amount, $sched_id, $sy_id, $imp_date, $ch_cr, $it_plan);

//      Modules:: run('web_sync/updateSyncController', 'fin_initial', 'init_id', $sendResult, 'create', 6);


    $logDate = $this->input->post('npelogdate');
    $logaccount = $this->input->post('npelogaccount');
    $logremarks = $this->input->post('npelogremarks');

    $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//    Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }

  public function recalc_now()
  {

    $stud_id = base64_decode($this->input->post('stud_id'));
    $sy_id = base64_decode($this->input->post('sy_id'));
    $balance = $this->input->post('rem_balance');

    $sendResult = $this->financemanagement_model->saveRecalc($stud_id, $sy_id, $balance);

//    Modules::run('web_sync/updateSyncController', 'fin_account_summary', 'id', $sendResult, 'create', 6);
  }

  public function savePLan()
  {
      $plan_desc = $this->input->post('nwPlanName');
      $sendResult = $this->financemanagement_model->savefinPLan($plan_desc);

      $logDate = $this->input->post('pelogdate');
      $logaccount = $this->input->post('pelogaccount');
      $logremarks = $this->input->post('pelogremarks');

      $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//      Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }

  public function addCharge()
  {
      $ac_transID = $this->input->post('ac_transID');
      $ac_itemID = $this->input->post('ac_itemID');
      $ac_amount = $this->input->post('ac_amount');
      $ac_cc = $this->input->post('ac_cc');
      // $stud_id = $this->input->post('a_studID');

      $trans_ID = $this->input->post('ac_transID');
      $ref_number = $this->input->post('ac_ptreferrence');
      $stud_id = base64_decode($this->input->post('a_studID'));
      $tdate = $this->input->post('ac_tDate');
      $tcashier = $this->input->post('ac_userID');
      $tcharges = $this->input->post('ac_amount');
      $tcredits = $this->input->post('ac_scredit');
      $tremarks = $this->input->post('ac_ptremarks');
      $sy_id = $this->input->post('sy_id');
      
      $stg_fin_extra_id = $this->financemanagement_model->save_extra_charge($stud_id, $ac_itemID, $ac_amount);
      $stg_fin_detail_id = $this->financemanagement_model->saveAddCharge($ac_transID, $ac_itemID, $ac_amount, $ac_cc, $sy_id);
      $stg_fin_transaction_id = $this->financemanagement_model->savePayTransaction($trans_ID, $ref_number, $stud_id, $tdate, $tcashier, $tcharges, $tcredits, $tremarks, $sy_id);
 
//      Modules::run('web_sync/updateSyncController', 'fin_extra', 'extra_id', $stg_fin_extra_id, 'create', 6);
//      Modules::run('web_sync/updateSyncController', 'fin_detail', 'detail_id', $stg_fin_detail_id, 'create', 6);
//      Modules::run('web_sync/updateSyncController', 'fin_transaction', 'trans_id', $stg_fin_transaction_id, 'create', 6);

  }

  public function saveDiscount()
  {
      $trans_ID = $this->input->post('transID');
      $discount_amount = $this->input->post('dAmount');

      $sendResult = $this->financemanagement_model->saveTransactionDiscount($trans_ID, $discount_amount);

//      Modules::run('web_sync/updateSyncController', 'fin_discount', 'discount_ID', $sendResult, 'create', 6);
  }

  public function setFinCategory()
  {
      $data['main_content'] = 'financemanagement/confmcategory';
      $data['fin_category'] = $this->financemanagement_model->showCategory(); 
      $this->load->view('includes/finance' , $data);
  }

  public function showfinHistory()
  {
      $data['main_content'] = 'financemanagement/confmcategory';

  }

  public function saveEditPlan()
  {
      $accounts_id = $this->input->post('input_planAccountID');
      $items = array(
          'stud_id' => $this->input->post('inputplan_studID'),
          'plan_id' => $this->input->post('inputplanID'),
      );

      $this->financemanagement_model->editAccountPlan($items, $accounts_id);

//      Modules::run('web_sync/updateSyncController', 'fin_accounts', 'accounts_id', $accounts_id, 'update', 6);

  }

  public function saveEditItemPlan()
  {
    $initID = $this->input->post('edititID');
    $items = array(
        'level_id' => $this->input->post('editLvl'),
        'item_id' => $this->input->post('edititSelItem'),
        'item_amount' => $this->input->post('edititAmount'),
        'schedule_id' => $this->input->post('editSched'),
        'sy_id' => $this->input->post('editSY'),
        'implement_date' => $this->input->post('editImpDate'),
        'ch_cr' => $this->input->post('edititChCr'),
        'plan_id' => $this->input->post('edititPlan'),
    );

    $this->financemanagement_model->editItemPlan($items, $initID);

//    Modules::run('web_sync/updateSyncController', 'fin_initial', 'init_id', $initID, 'update', 6);

    $logDate = $this->input->post('elogdate');
    $logaccount = $this->input->post('elogaccount');
    $logremarks = $this->input->post('elogremarks');

    $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//    Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

    config();

  }

  public function delItemPlan()
  {
    $initID = $this->input->post('delitID');
    $sendResult = $this->financemanagement_model->delItemPlan($initID);

//    Modules::run('web_sync/updateSyncController', 'fin_initial', 'init_id', $initID, 'delete', 6);

    $logDate = $this->input->post('elogdate');
    $logaccount = $this->input->post('elogaccount');
    $logremarks = $this->input->post('elogremarks');

    $sendResult = $this->financemanagement_model->saveLogs($logDate, $logaccount, $logremarks);

//    Modules::run('web_sync/updateSyncController', 'fin_logs', 'log_id', $sendResult, 'create', 6);

  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */