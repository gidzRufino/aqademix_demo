<?php
    // foreach($settings as $set){
    //     $sy = $set->school_year;
    // }
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>

<script type="text/javascript">
      $(function(){
      $("#accountsort").tablesorter({debug: true});
      $("#transort").tablesorter({debug: true});
  });  
</script>

<div class="clearfix row" style="margin:0;">

  <div class="panel panel-primary" style="margin-top: 15px;">
    <div class="panel-heading"><b>Finance Management Reports</b></div>
    <div class="panel-body">
      <div class="alert alert-success ">
        <strong>Hello!</strong> Select the school year to generate the desired report. 
        <div class="span3 pull-right" style="margin-top: -4px;">
          <select onclick="get_sy()" tabindex="-1" id="search_sy" style="width:225px;" >   
            <option>Select School Year</option>
              <?php foreach ($sfinSY as $sy){$id = $sy->sy_id; $sy = $sy->school_year; ?>  
            <option value="<?php echo $id; ?>"><?php echo $sy ?></option>
              <?php } ?> 
          </select>
        </div>
      </div>

  <!-- <div class="row" style="margin-top: 20px;"> -->


      <?php if ($this->uri->segment(3)!=''){ 

        $sy_id = $getsy->sy_id;

      ?>
    <!-- <div class="row"> -->
      <div class=""> 

        <div class="panel panel-info" style="margin-top: 15px;">
          <div class="panel-heading">
            <div class="btn-group btn-group-justified">
              <div class="btn-group">
                <button type="button" class="btn btn-info"  data-toggle="tab" data-target="#tab1"><b>Collection Report per Month</b></button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-info" data-toggle="tab" data-target="#tab2"><b>Collection Report per Account</b></button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-info" data-toggle="tab" data-target="#tab3"><b>Transaction lists</b></button>
              </div>
            </div>  
          </div>
          <div class="panel-body">
<!--  -->

         <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="row" style="margin-left: 0px;" >                
            <div class=" ">
              <table class="table table-condensed table-bordered" style="width:98%;">
                <tr >
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold;">Month</td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold;">Collected</td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold;">Expected</td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold;">Balance</td>
                </tr>
                  
                <?php
                  $tot_collected = 0;
                  $tot_expected = 0;
                  $tot_balance = 0;
                  $tbalance = 0;
                  for ($monthRun=1; $monthRun <= 12; $monthRun++) { 
                    switch ($monthRun) {
                   case '1':  
                        $real_month = 4;
                        $tmonth = 'April';
                        break;
                      case '2':
                        $real_month = 5;
                        $tmonth = 'May';
                        break;
                      case '3':
                        $real_month = 6;
                        $tmonth = 'June';
                        break;
                      case '4':
                        $real_month = 7;
                        $tmonth = 'July';
                        break;
                      case '5':
                        $real_month = 8;
                        $tmonth = 'August';
                        break;
                      case '6':
                        $real_month = 9;
                        $tmonth = 'September';
                        break;
                      case '7':
                        $real_month = 10;
                        $tmonth = 'October';
                        break;
                      case '8':
                        $real_month = 11;
                        $tmonth = 'November';
                        break;
                      case '9':
                        $real_month = 12;
                        $tmonth = 'December';
                        break;
                      case '10':
                        $real_month = 1;
                        $tmonth = 'January';
                        break;
                      case '11':
                        $real_month = 2;
                        $tmonth = 'February';
                        break;
                      case '12':
                        $real_month = 3;
                        $tmonth = 'March';
                        break;

                    }
                    $tAmount = 0;
                    $ml = 8;
                    
                    foreach ($showtrans as $trans) {
                      $tdate = $trans->tdate;
                      $dmonth = strchr($tdate,"-",true);
                      $dyear = strchr($tdate,"-",false);

                      $sdmonth = strchr($tdate," ",true);
                      $sdyear = strchr($tdate,",",false);
                    
                      if ($sdmonth==$tmonth || $dmonth==$real_month){
                        $trans_Amount = $trans->tcredit;
                        $tAmount = $tAmount + $trans_Amount;       
                      }
                      
                    } 
                    if ($tAmount!=0){
                      $displayAmount = 'PhP '.number_format($tAmount, 2, '.', ',');
                    } else {
                      $displayAmount = '-';
                    }
                    
                    $tot_collected = $tot_collected + $tAmount;
                    $st_sy = $getsy->school_year;
                    $st_sy_a = substr($st_sy, 0, 4);
                    $st_sy_b = substr($st_sy, 5, 4);

                    if($monthRun>=$ml){
                      $sy_stamp = $st_sy_b;
                    }else{
                      $sy_stamp = $st_sy_a;
                    }

                ?>

                <tr>
                  <th class="bg-warning" style="text-align:center;"><?php echo $tmonth.' '.$sy_stamp // Month name ?></th>
                  <td class="bg-info" style="text-align:center;"><?php echo $displayAmount // total amount collected ?></td>

              <?php 
                $srec = '';
                $tot_sid_1 = 0;
                $tot_sid_2 = 0;
                $tot_sid_3 = 0;
                $tot_sid_4 = 0;
                $tot_sid_5 = 0;
                if ($tmonth=='April' || $tmonth=='May'){
                  $tinit_amount = '-';
                  $tbalance = '-';
                }else{
                  $init_amount = 0;
                  $tinit_amount = '-';
                  $tcount = 0;
                  $genPlan = 1;
                  // $tbalance = ''; 
                  $xtra_charge = 0;

                  foreach ($sTransaction as $tc) { // additional charges >> extra charges
                    $cdate = $tc->tdate;
                    $xsy = $tc->sy_id;
                    $tc_month = strchr($cdate," ",true);
                    if($tc_month==$tmonth && $sy_id==$xsy){
                      $xtra_charge = $xtra_charge + $tc->tcharge;
                    }
                  }               

                  foreach ($sAccounts as $cAccounts) {  // for every accounts added together
                    $check_level = $cAccounts->grade_level_id;
                    $check_plan = $cAccounts->plan_id;
                    $check_id = $cAccounts->stud_id;
                    if ($check_plan!=null && $check_plan!=11){ // not including scholars
                    foreach ($sInitials as $sInit) {
                      $init_level = $sInit->level_id;
                      $init_plan = $sInit->plan_id;
                      $init_sched_id = $sInit->schedule_id;
                      $init_sy = $sInit->sy_id;
                      $init_ch_cr = $sInit->ch_cr;

                      if(($check_level==$init_level && $check_plan==$init_plan && $sy_id==$init_sy) || ($check_level==$init_level && $init_plan==$genPlan && $sy_id==$init_sy)){
                        if($init_sched_id==1 && $init_ch_cr==0){
                          $tcount = $tcount + 1;
                          $cinit_amount = $sInit->item_amount;
                          // $srec = $srec.' + '.$cinit_amount;
                          $tot_sid_1 = ($tot_sid_1 + $cinit_amount);
                          // $tot_sid_1 = $init_amount;
                        }elseif($init_sched_id==2 && $init_ch_cr==0){
                          if ($tmonth=='August' || $tmonth=='October' || $tmonth=='December' || $tmonth=='February'){
                            $tcount = $tcount + 1;
                            $cinit_amount = $sInit->item_amount;
                            $tot_sid_2 = $tot_sid_2 + $cinit_amount;
                            // $srec = $srec.' + '.$cinit_amount;
                          }
                        }elseif ($init_sched_id==3 && $init_ch_cr==0){
                          if ($tmonth=='July' || $tmonth=='November'){
                            $tcount = $tcount + 1;
                            $cinit_amount = $sInit->item_amount;
                            $tot_sid_3 = $tot_sid_3 + $cinit_amount;
                            // $srec = $srec.' + '.$cinit_amount;
                          } 
                        }elseif ($init_sched_id==4 && $init_ch_cr==0) {
                          if ($tmonth=='June'){
                          $tcount = $tcount + 1;
                          $cinit_amount = $sInit->item_amount;
                          $tot_sid_4 = $cinit_amount + $tot_sid_4;
                          }
                        }elseif ($init_sched_id==5 && $init_ch_cr==0) {
                          if ($tmonth=='April' || $tmonth=='May'){
                          $tcount = $tcount + 1;
                          $cinit_amount = $sInit->item_amount;
                          $tot_sid_5 = $init_amount; 
                          }  
                        }  
                      }
                    } } // sInitials and scholars
                  }
                  
                    $init_amount = ($tot_sid_1/10)+($tot_sid_2/4)+($tot_sid_3/2)+($tot_sid_4)+($tot_sid_5/2)+$xtra_charge;
                    $tot_expected = $tot_expected + $init_amount;
                    $tinit_amount = 'PhP '.number_format($init_amount, 2, '.', ',');
                    $tbalance = $init_amount - $tAmount;
                    $tot_balance = $tot_balance + $tbalance;
                    $tbalance = 'PhP '.number_format($tbalance, 2, '.', ',');

                    // test this
                    // $mo = $tot_sid_1/10;
                    // $mo = $mo .' =>'.$srec;
                    // $qu = $tot_sid_2/4;
                    // $sem = $tot_sid_3/2;
                    // $yer = $tot_sid_4;
                    // $sum = $tot_sid_5/2;
                }
                ?>

                <!-- <td class="bg-success" style="text-align:center;"><?php echo $tinit_amount.' (monthly:'.$mo.' quarter: '.$qu.' semester:'.$sem.' year:'.$yer.' summer:'.$sum.'extra:'.$xtra_charge; ?></td> -->
                <td class="bg-success" style="text-align:center;"><?php echo $tinit_amount ?></td>
                
                <?php 
                  $check_neg = substr($tbalance, 4, 1);
                  if ($check_neg=='-'){ ?>

                  <td class="bg-danger" style="text-align:center;"><?php echo $tbalance // expected balance ?></td>                    
                                    
                <?php }else{ ?>
                
                  <td class="bg-danger" style="text-align:center;color: red;"><?php echo $tbalance // expected balance ?></td>

                <?php } ?>
                  
                </tr>

              <?php } 
                $tot_collected = 'PhP '.number_format($tot_collected, 2, '.', ',');
                $tot_expected = 'PhP '.number_format($tot_expected, 2, '.', ',');
                $tot_balance = 'PhP '.number_format($tot_balance, 2, '.', ',');
              ?>

                <tr>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold; color: yellow">T O T A L</td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold; color: yellow"><?php echo $tot_collected ?></td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold; color: yellow"><?php echo $tot_expected ?></td>
                  <td class="bg-primary" style="text-align:center;font-size: 15px; font-weight: bold; color: yellow"><?php echo $tot_balance ?></td>                    
                </tr>
                
              </table>
            </div>       
            <br /><br /><br />
          </div>
        </div>
        <!-- <div class="tab-content"> -->
          <div class="tab-pane" id="tab2">
            <!-- <div class="row"> -->
            <!-- starts here -->
              <div class="" style="overflow-y:scroll; height: 400px;">
                <table id="accountsort" class="tablesorter table table-striped">
                  <thead style="background:#E6EEEE;">
                  <tr>
                    <th class="span2" style="text-align:center">Avatar</th>
                    <th class="span2" style="text-align:center">Account Name</th>
                    <th class="span2" style="text-align:center">Level</th>
                    <th class="span2" style="text-align:center">Plan</th>
                    <th class="span2" style="text-align:center">Total Charge</th>
                    <th class="span2" style="text-align:center">Total Credit</th>
                    <th class="span2" style="text-align:center">Total Balance</th>
                    <th class="span2" style="text-align:center">Balance Due</th>
                  </tr>
                  </thead>

                <?php 

                $bt_charge = 0;
                    $bt_credit = 0;
                    $bt_balance = 0;
                    $bt_balance_due = 0;

                foreach ($accountz as $az) {
                    $rolling = '';
                    $az_level = $az->grade_level_id;
                    $az_sy = $az->sy_id;

                    if ($sy_id==$az_sy){

                        // if($az_level==$our_level){
                        $lname = $az->lastname;
                        $fname = $az->firstname;
                        $mname = $az->middlename;
                        $avatari = $az->avatar;
                        $my_name = $lname.', '.$fname.' '.$mname;
                        $my_grade = $az->level;

                        $stud_id = $az->stud_id;
                        $tcharge = 0;
                        $tcredit = 0;
                        $istCharge = 0;
                        $istCredit = 0;
                        $stPlanGen = 1;
                        $stLevel_id = $az_level;
                        $stPlan_id = $az->plan_id;
                        $plan_name = $az->plan_description;

                    if ($stPlan_id!=null && $stPlan_id!=11){ // not null payment plan and full scholar code

                    foreach ($initialLevel as $ist){ 
                        $ist_sy = $ist->sy_id;

                      if($ist->level_id==$stLevel_id && $ist->plan_id==$stPlan_id && $sy_id==$ist_sy || $ist->level_id==$stLevel_id && $ist->plan_id==$stPlanGen && $sy_id==$ist_sy){

                        if ($ist->ch_cr==0) {
                          $istCharge = $ist->item_amount;
                          $istCredit = 0;
                          $tcharge = $tcharge + $istCharge;
                          $dis_charge = 'PhP '.number_format($istCharge,2);
                          $dis_credit = '-';
                        }elseif ($ist->ch_cr==1) {
                          $istCharge = 0;
                          $istCredit = $ist->item_amount;
                          $tcredit = $tcredit + $istCredit;
                          $dis_charge = '-';
                          $dis_credit = 'PhP '. number_format($istCredit,2);
                  
                  } } } } // $stPlan_id!=null

                  foreach ($sTransaction as $st){ if($st->stud_id==$stud_id && $sy_id==$st->sy_id){ 

                    if($st->charge_credit==1){ 
                      $scredit=$st->d_credit;
                      $tcredit=$tcredit+$scredit; 
                    }elseif($st->charge_credit==0){ 
                      $scharge=$st->d_charge;
                      $tcharge=$tcharge+$scharge; 
                  
                    } } } //$st->charge_credit
                    
                    $tbalance = $tcharge - $tcredit; 

                    $itot_charge = number_format($tcharge,2);
                    $itot_credit = number_format($tcredit,2);
                    $itot_balance = number_format($tbalance,2);
                    $tot_balance_due = 0;

                //-------------------------------------------------------------------------->>>>>>

                    $tbalance_due = 0;
                    $ar_itemChoice = array();
                    $ar_balance = array();
                    $ar_index = 0;
                    $ar = 0;
                    $cID = 0;
                    $stPlanGen = 1;

                    // print_r($initialLevel);

                    if ($stPlan_id!=null && $stPlan_id!=11 ){ // not null payment plan and full scholar code

                    foreach ($initialLevel as $iL) {
                      $iL_sy = $iL->sy_id;
                        if($iL->level_id==$stLevel_id && $iL->plan_id==$stPlan_id && $sy_id==$iL_sy || $iL->level_id==$stLevel_id && $iL->plan_id==$stPlanGen && $sy_id==$iL_sy ){
                        $cID += 1; 

                        $ar += 1;
                        $ar_index = $ar - 1;
                        $ar_itemChoice[$ar_index] = $iL->item_description;

                        $init_item_id = $iL->item_id;
                        $stCharge = 0;
                        $stCredit = 0;
                        $monthNow = date('n');
                        foreach ($sTransaction as $sBal) {
                          if($sBal->stud_id==$stud_id && $sy_id==$sBal->sy_id){ 
                            if($sBal->item_id==$init_item_id){
                              if ($sBal->charge_credit==0) {
                                $ssCharge = $sBal->d_charge; // if there is an existing amount
                                $stCharge = $stCharge + $ssCharge;
                              }elseif($sBal->charge_credit==1) {
                                $ssCredit = $sBal->d_credit;
                                $stCredit = $stCredit + $ssCredit;
                        } } } }  
                        
                        $tAmount = $iL->item_amount; 
                        $stBalance = $tAmount - $stCredit; 
                        $tfreq = $iL->schedule_id;

                        if($tfreq==1){
                          $tmBalance = $tAmount/10;
                        }elseif($tfreq==2){
                          $tmBalance = $tAmount/4;
                        }elseif($tfreq==3){
                          $tmBalance = $tAmount/2;
                        }elseif($tfreq==4){
                          $tmBalance = $tAmount;
                        }elseif($tfreq==5){
                          $tmBalance = $tAmount/2;
                        }


                        switch ($monthNow) {
                          case '1':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'January';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '2':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '3':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'March';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '4':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'April';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '5':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'May';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'February';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '6':
                            if($tfreq==1){  
                              $balance_due = $tAmount -($tmBalance*9) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*3) - $stCredit;
                              $due_date = 'August';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '7':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*8) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*3) - $stCredit;
                              $due_date = 'August';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '8':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*7) - $stCredit;
                              $due_date = 'August';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*3) - $stCredit;
                              $due_date = 'August';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '9':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*6) - $stCredit;
                              $due_date = 'September';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'October';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '10':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*5) - $stCredit;
                              $due_date = 'October';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'October';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'July';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '11':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*4) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'December';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          case '12':
                            if($tfreq==1){
                              $balance_due = $tAmount -($tmBalance*3) - $stCredit;
                              $due_date = 'December';
                            }elseif($tfreq==2){
                              $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                              $due_date = 'December';
                            }elseif($tfreq==3){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'November';
                            }elseif($tfreq==4){
                              $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                              $due_date = 'June';
                            }elseif($tfreq==5){
                              $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                              $due_date = 'April';
                            }
                            break;
                          default:
                            $balance_due = $stBalance;
                            break;
                        }
                        $tbalance_due = $tbalance_due + $balance_due;
                        $ar_balance[$ar_index] = $balance_due;

                        $bdue = number_format($balance_due, 2);
                              
                    }}} 
                    
                    foreach ($showItems as $showitems) {
                        $itemz_id = $showitems->item_id;
                        $item_name = $showitems->item_description;
                        $charge_t = 0;
                        $credit_t = 0;

                        $one_item_pointer = 1; // to check one item only
                        foreach ($show_extra as $se) {
                            $se_item = $se->item_id;
                            $se_id = $se->stud_id;
                            if ($itemz_id==$se_item && $se_id==$stud_id && $one_item_pointer==1) {
                              $one_item_pointer = $one_item_pointer + 1;
                                foreach ($tdetails as $td) {
                                    $td_id = $td->stud_id;
                                    $td_item = $td->item_id;
                                    if($itemz_id==$td_item && $td_id==$stud_id){
                                        $charge_t = $charge_t + $td->d_charge;
                                        $credit_t = $credit_t + $td->d_credit;
                                    }
                                }
                                $total_balance = $charge_t - $credit_t;
                                $total_bdue = number_format($total_balance, 2);
                                $itemz = $item_name;
                                $tbalance_due = $tbalance_due + $total_balance;

                            }
                        }
                    }

                    $tot_balance_due = number_format($tbalance_due, 2);


                    $bt_charge = $bt_charge + $tcharge;
                    $bt_credit = $bt_credit + $tcredit;
                    $bt_balance = $bt_balance + $tbalance;
                    $bt_balance_due = $bt_balance_due + $tbalance_due;

                    ?>
                  <tr class="info">
                    <!-- <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/s8347h/'.base64_encode($stud_id)) ?>"><?php echo $stud_id; ?></a></td> -->
                    <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/s8347h/'.base64_encode($stud_id).'/'.base64_encode($sy_id)) ?>"><img alt="image not available." src="<?php echo base_url()?>uploads/<?php echo $avatari;?>" style=" top:10px; left: 5px; height:50px;"  class="img-circle"/></a></td>
                    <td class="span2" style="text-align:center"><?php echo $my_name ?></td>
                    <td class="span2" style="text-align:center"><?php echo $my_grade ?></td>
                    <td class="span2" style="text-align:center"><?php echo $plan_name ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_charge ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_credit ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_balance ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tot_balance_due ?></td>
                  </tr>

                  <?php
                      // } //forloop
                      // } // if($az_level==$our_level)
                  }} // foreach ($accountz as $az) 

                  ?>
                                    
                </table>
                
                  <?php } ?>

         <!--        <table class="table table-striped">
                  <!-- <thead style="background:#E6EEEE;">
                  <tr>
                    <th colspan="4" style="text-align:right;"><span style="color:black; margin:3px 0;">T O T A L </span></th>
                    <th class="span2" style="text-align:center"><?php echo $bt_charge ?></th>
                    <th class="span2" style="text-align:center"><?php echo $bt_credit ?></th>
                    <th class="span2" style="text-align:center"><?php echo $bt_balance ?></th>
                    <th class="span2" style="text-align:center"><?php echo $bt_balance_due ?></th>
                  </tr>
                </table> -->

                <br /><br /><br /><br />

            <!-- ends here -->
            </div>
            <!--  -->

            <!--  -->
          <!-- </div> -->
        </div>
        <div class="tab-pane" id="tab3">
          <!-- <div class="row"> -->
            <!-- starts here -->
            <?php if ($this->uri->segment(3)!=''){  ?>
            <div class=""style="overflow-y:scroll; height: 400px;">
              <table id="transort" class="tablesorter table table-striped table-bordered">
                <thead style="background:#E6EEEE;">
                <tr>
                  <th class="span2" style="text-align:center">Transaction Number </th>
                  <th class="span2" style="text-align:center">Reference Number</th>
                  <th class="span2" style="text-align:center">Account Name</th>
                  <th class="span2" style="text-align:center">Account ID Number</th>
                  <th class="span2" style="text-align:center">Amount Received</th>
                  <th class="span2" style="text-align:center">Date</th>
                  <th class="span2" style="text-align:center">Transaction Time</th>
                </tr>
                </thead>
                
                  <?php 
                
                  foreach ($translist as $tl){ 

                    $tl_sy = $tl->sy_id;
                    $stud_id = $tl->stud_id;
                    $tl_transid = $tl->trans_id;
                    $tl_ref = $tl->ref_number;
                    $tl_name = $tl->lastname.', '.$tl->firstname.' '.$tl->middlename;
                    $tl_amount = $tl->tcredit;
                    $tl_amountf = number_format($tl_amount, 2);
                    $tl_refnumber = $tl->trans_id;
                    $tl_hour_base = substr($tl_refnumber, 6, 2);
                    $tl_minute = substr($tl_refnumber, 8, 2);
                    $tl_second = substr($tl_refnumber, 10, 2);
                      if ($tl_hour_base>=13){
                        $tl_hour = $tl_hour_base - 12;
                        $tl_time = $tl_hour.':'.$tl_minute.':'.$tl_second.' pm';
                      }else{
                        $tl_hour = $tl_hour_base;
                        $tl_time = $tl_hour.':'.$tl_minute.':'.$tl_second.' am';
                      }
                    
                    if ($sy_id==$tl_sy && $tl_amount!=0){

                  ?>
                  <tr>
                    <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/actz/'.base64_encode($stud_id).'/'.base64_encode($sy_id)) ?>"><?php echo $tl->trans_id; ?></a></td>
                    <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/actz/'.base64_encode($stud_id).'/'.base64_encode($sy_id)) ?>"><?php echo $tl->ref_number; ?></a></td>
                    <td class="span2" style="text-align:center"><?php echo $tl_name; ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tl->stud_id; ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tl_amountf; ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tl->tdate; ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tl_time; ?></td>
                  </tr>

                  <?php }}} // if sy_id=tl_sy   foreach translist  segment(3) ?>
                
              </table>
              <br /><br /><br /><br />
            </div>
          <!-- </div> -->
        </div>
      </div>
<!--  -->
          </div>
        </div>  
      </div>
    </div>
    <!-- Table -->
    <table class="table">
      ...
    </table>
  </div>
</div>



<script type="text/javascript">

  function get_sy()
  {
    var syid = document.getElementById("search_sy").value;
    var voptions = 'Select School Year'
    if (syid==voptions){
      document.location = '<?php echo base_url()?>financemanagement/reports/'   
    }else{
      document.location = '<?php echo base_url()?>financemanagement/reports/'+syid   
    }
    var sd = document.getElementById('sy_dummy').value;

  }

$('#reptabs a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
  
  

$(document).ready(function() {
  $("#search_sy").select2();
});

function selectSY()
{
  var sy = document.getElementById('selectSY').innerHTML;
  alert(sy);
}

function convertNumber(sNumber) 
  {
    //Seperates the components of the number
    var n= sNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
  }

  function numberConverted(svariable)
  {
    var cNumber = svariable.replace(/\,/g,'');
    cNumber = parseFloat(cNumber);
    if (isNaN(cNumber) || !cNumber ){ 
      cNumber = 0;
    }
    return cNumber;
  }


</script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/js/flotr2/lib/excanvas.js"></script><![endif]
<script src="<?php echo base_url(); ?>assets/js/flotr2/flotr2.js"></script>
<script src="<?php echo base_url(); ?>assets/js/flotr2/lib/prototype.s"></script>

<script type="text/javascript">
  (function () {

    var
      container = document.getElementById('container'),
      start = (new Date).getTime(),
      data, graph, offset, i;

    // Draw a sine curve at time t
    function animate (t) {

      data = [];
      offset = 2 * Math.PI * (t - start) / 10000;

      // Sample the sine function
      for (i = 0; i < 4 * Math.PI; i += 0.2) {
        data.push([i, Math.sin(i - offset)]);
      }

      // Draw Graph
      graph = Flotr.draw(container, [ data ], {
        yaxis : {
          max : 2,
          min : -2
        }
      });

      // Animate
      setTimeout(function () {
        animate((new Date).getTime());
      }, 50);
    }

    animate(start);
  })();
</script> -->