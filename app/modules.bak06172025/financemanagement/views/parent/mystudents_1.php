<?php
    
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   $syurl = $this->uri->segment(4);
   if ($syurl!='') {
     $sy_now = base64_decode($syurl);
   }else{
    $sy_now = $default_sy->value; // default year
   }
?>

<div class="clearfix" style="margin: 0px;">
  <div class="panel panel-default" style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 class="panel-title">
        <b>My Student's Accounts</b>
      </h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-condensed table-bordered">
            <tr>
              <th class="bg-primary" style="text-align:center;">Avatar</th>
              <th class="bg-primary" style="text-align:center;">ID Number</th>
              <th class="bg-primary" style="text-align:center;">Name</th>
              <th class="bg-primary" style="text-align:center;">Level</th>
              <th class="bg-primary" style="text-align:center;">Total Charge</th>
              <th class="bg-primary" style="text-align:center;">Total Credit</th>
              <th class="bg-primary" style="text-align:center;">Balance</th>
              <th class="bg-primary" style="text-align:center;">Balance Due</th>
            </tr>
            <tr>
              
                    <?php

                    $bt_charge = 0;
                    $bt_credit = 0;
                    $bt_balance = 0;
                    $bt_balance_due = 0;
                    $sy_id = $school;
                    $total_display = 0;
                    $m_tcharge = 0;
                    $m_tcredit = 0;
                    $m_tbalance = 0;
                    $m_tbdue = 0;

                foreach ($accountz as $az) {
                    $rolling = '';
                    // $az_level = $az->grade_level_id;
                    $az_level = $az->grade_id;
                    $az_sy = $az->sy_id;

                    // if ($sy_id==$az_sy){

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

                    if($st->charge_credit==1 && $sy_id==$st->sy_id){ 
                      $scredit=$st->d_credit;
                      $tcredit=$tcredit+$scredit; 
                    }elseif($st->charge_credit==0 && $sy_id==$st->sy_id){ 
                      $scharge=$st->d_charge;
                      $tcharge=$tcharge+$scharge; 
                  
                    } } } //foreach ($sTransaction as $st){ if($st->stud_id==$stud_id && $sy_id==$st->sy_id){ 
                    
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
                        } } } }  // foreach ($sTransaction as $sBal) {
                        
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
                                    if($itemz_id==$td_item && $td_id==$stud_id && $td->sy_id==$sy_id){
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
                    $total_display = $total_display + $tbalance_due; 


                    $m_tcharge = $m_tcharge + $tcharge;
                    $m_tcredit = $m_tcredit + $tcredit;
                    $m_tbalance = $m_tbalance + $tbalance;
                    $m_tbdue = $m_tbdue + $tbalance_due;

                  ?>
                  <tr class="info">
                    <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/msa/'.base64_encode($stud_id).'/'.base64_encode($sy_id)) ?>"><img alt="image not available." src="<?php echo base_url()?>uploads/<?php echo $avatari;?>" style=" top:10px; left: 5px; height:50px;"  class="img-circle"/></a></td>
                    <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/msa/'.base64_encode($stud_id).'/'.base64_encode($sy_id)) ?>"><?php echo $stud_id; ?></a></td>         
                    <td class="span2" style="text-align:center"><?php echo $my_name ?></td>
                    <td class="span2" style="text-align:center"><?php echo $my_grade ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_charge ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_credit ?></td>
                    <td class="span2" style="text-align:center"><?php echo $itot_balance ?></td>
                    <td class="span2" style="text-align:center"><?php echo $tot_balance_due ?></td>
                  </tr>
                  <?php

                      // } //forloop
                      // } // if($az_level==$our_level)
                  } // foreach ($accountz as $az) 

                  ?>
                  <tr class="info">
                    <th colspan="4" style="text-align:right;"><span style="color:black; margin:3px 0;">T O T A L </span></th>
                    <th style="text-align:center"><?php echo number_format($m_tcharge, 2) ?></th>
                    <th style="text-align:center"><?php echo number_format($m_tcredit, 2) ?></th>
                    <th style="text-align:center"><?php echo number_format($m_tbalance, 2) ?></th>
                    <th style="text-align:center"><?php echo number_format($m_tbdue, 2) ?></th>
                  </tr>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

