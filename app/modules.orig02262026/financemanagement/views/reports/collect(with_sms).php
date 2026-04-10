<?php
$is_admin = $this->session->userdata('is_admin');
$userid = $this->session->userdata('user_id');
$stngs=Modules::run('main/getSet');
?>

<div class="clearfix row" style="margin:0;">
<input type="hidden" name="lastEntry" id="school_sname" value="<?php echo $stngs->short_name; ?>"required>
  <div class="panel panel-success"style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 class="text-center panel-title"><b>Generate Collection Notice</b></h3>
    </div>
    <div class="panel-body">
      <div class="center" style="margin-top: 10px;">
        <button name="send_sms" id="send_sms" type="button" data-toggle="modal" class="btn btn-medium bg-primary "><i class="fa fa-paper-plane fa-fw"></i> Send Collection Notice through SMS</button>
        <button name="gen_print" id="gen_print" type="button" data-toggle="modal" class="btn btn-medium bg-primary "><i class="fa fa-newspaper-o fa-fw"></i> Generate Printable Collection Notice</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="collapse" data-toggle="collapse" id="send_sms_notification">
      <div class="panel panel-success"style="margin-top: 15px;">
        <div class="panel-heading text-center">
          <h3 class="text-center panel-title"><b>Broadcast SMS Collection Notice</b></h3>
        </div>
        <div class="panel-body">
          <div class="col-md-4 well well-small offset1" style="height: 175px;">
            <div class="col-md-12">
              <div class="control-group pull-left">
                <label class="control-label" for="duedate">Set Due Date for collection</label>
                <div class="input-group">
                  <input style="width: 190px;" name="duedate" type="text" class="form-control" data-date-format="mm-dd-yyyy" id="duedate" placeholder="Collection Due Date" required>
                  <span class="input-group-btn">
                    <button class="btn btn-default" id="calen" onclick="$('#duedate').focus()" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="control-group pull-left" style="margin-top: 15px;">
                <label class="control-label" >Send SMS Collection Notice to</label>
                <div class="controls">
                  <select onclick="destination()" tabindex="-1" id="select_destination" style="width:225px;" >   
                    <option>Select Destination</option>
                    <option value="1">All Year Level</option>
                    <option value="2">Specific Level</option>
                    <option value="3">Specific Account</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12" style="display:none;"> <!-- style="display:none;" -->
              <table class="table table-hover table-responsive table-condensed"> 
                <tr class="info">
                  <th class="span2" style="text-align:center">Account Name</th>
                  <th class="span2" style="text-align:center">Level</th>
                  <th class="span2" style="text-align:center">Total Charge</th>
                  <th class="span2" style="text-align:center">Total Credit</th>
                  <th class="span2" style="text-align:center">Total Balance</th>
                  <th class="span2" style="text-align:center">Balance Due</th>
                  <th class="span2" style="text-align:center">Father Contact</th>
                  <th class="span2" style="text-align:center">Mother Contact</th>
                </tr>

                <?php
                $tbalance_due = 0;
                $tdifference = 0;
                $total_bdue = 0;
                $ac_count = 0;

                foreach ($accountz as $az) {
                    $ac_count = $ac_count + 1;
                    $rolling = '';
                    $az_level = $az->grade_level_id;
                    // if($az_level==$our_level){
                        $lname = $az->lastname;
                        $fname = $az->firstname;
                        $mname = $az->middlename;
                        $my_name = $lname.', '.$fname.' '.$mname;
                        $my_grade = $az->level;

                        $stud_id = $az->user_id;
                        $tcharge = 0;
                        $tcredit = 0;
                        $istCharge = 0;
                        $istCredit = 0;
                        $stPlanGen = 1;
                        $stLevel_id = $az_level;
                        $stPlan_id = $az->plan_id;
                        $parent_id = $az->parent_id;
                        $mother_number = 0;
                        $father_number = 0;

                        foreach ($get_mother as $gmom) {
                          $gm_id = $gmom->parent_id;
                          if ($gm_id==$parent_id) {
                            $mother_number = $gmom->cd_mobile;
                          }
                        }
                        foreach ($get_father as $gpop) {
                          $gp_id = $gpop->parent_id;
                          if ($gp_id==$parent_id) {
                            $father_number = $gpop->cd_mobile;
                          }          
                        }

                    if ($stPlan_id!=null && $stPlan_id!=11){ // not null payment plan and full scholar code

                    foreach ($initialLevel as $ist){ 

                      if($ist->level_id==$stLevel_id && $ist->plan_id==$stPlan_id || $ist->level_id==$stLevel_id && $ist->plan_id==$stPlanGen){

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

                  foreach ($sTransaction as $st){ if($st->stud_id==$stud_id){ 

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
                        if($iL->level_id==$stLevel_id && $iL->plan_id==$stPlan_id || $iL->level_id==$stLevel_id && $iL->plan_id==$stPlanGen){
                        $cID += 1; 

                        $ar += 1;
                        $ar_index = $ar - 1;
                        $ar_itemChoice[$ar_index] = $iL->item_description;
                        $init_item_id = $iL->item_id;
                        $stCharge = 0;
                        $stCredit = 0;
                        $monthNow = date('n');
                        foreach ($sTransaction as $sBal) {
                          if($sBal->stud_id==$stud_id){ 
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

                    ?>

                  <tr class="info">
                    <td class="span2" style="text-align:center" id="an<?php echo $ac_count ?>"><?php echo $my_name ?></td>
                    <td class="span2" style="text-align:center" id="ag<?php echo $ac_count ?>"><?php echo $my_grade ?></td>
                    <td class="span2" style="text-align:center" id="acharge<?php echo $ac_count ?>"><?php echo $itot_charge ?></td>
                    <td class="span2" style="text-align:center" id="acredit<?php echo $ac_count ?>"><?php echo $itot_credit ?></td>
                    <td class="span2" style="text-align:center" id="atbalance<?php echo $ac_count ?>"><?php echo $itot_balance ?></td>
                    <td class="span2" style="text-align:center" id="tbd<?php echo $ac_count ?>"><?php echo $tot_balance_due ?></td>

                    <td class="span2" style="text-align:center" id="pa<?php echo $ac_count ?>"><?php echo $father_number ?></td>
                    <td class="span2" style="text-align:center" id="ma<?php echo $ac_count ?>"><?php echo $mother_number ?></td>
                  </tr>

                    <?php

                          // } //forloop
                          // } // if($az_level==$our_level)
                      } // foreach ($accountz as $az) 

                    ?>       
                
                <input type="hidden" name="last_count" id="last_count" value="<?php echo $ac_count ?>" required>
              </table>
            </div>  <!-- span12 for the table -->
          </div>
          <div class="col-md-8" style="height: 250px; margin-top: 20px;">
            <div class="sms_default">
              <div class="bg-success" style="border-radius: 6px; font-size: 18px;line-height: 30px; padding: 30px;">
                <p style="text-align:center; font-weight: bold; color:green; ">" It is appropriate to send only one SMS collection notice a month or examination week. Too much sms notification may aggravate sms receipients. "</p>
              </div>
            </div>
            <div class="sms_all"  style="display:none">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <p style="margin-left: 20px;"><b style="margin-right: 5px;">SEND TO</b><input name="all" type="text" style="text-align:center;" value="All Grade Level"disabled>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-2">
                  <p class="pull-right"><b>SAMPLE MESSAGE</b></p>
                </div>
                <div class="col-md-6 well well-small">
                  <p><?php echo $stngs->short_name; ?> SMS: Juan Dela Cruz has an active balance of PhP 5000.00. Please Settle this on or before <a href="" id="cald1"></a>. Thanks</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 pull-right" style="margin-right: 70px;">
                  <button onclick="send_all()" type="button" class="btn btn-success btn-sm">Send</button>
                  <button onclick="cancel()" type="button" class="btn btn-danger btn-sm">Cancel</button>
                </div>
              </div>
            </div>
            <div class="sms_level" style="display:none">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <p style="margin-left: 20px;"><b style="margin-right: 5px;">SEND TO</b>
                    <select onclick="destination()" tabindex="-1" id="selected_level" style="width:225px; " >   
                      <option>Select Destination</option>

                        <?php foreach ($get_level as $gl) {
                          $id = $gl->grade_id; ?>  

                        <option value="<?php echo $gl->level; ?>"><?php echo $gl->level; ?></option>
                        
                        <?php } ?> 

                    </select>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-2">
                  <p class="pull-right"><b>SAMPLE MESSAGE</b></p>
                </div>
                <div class="col-md-6 well well-small">
                  <p><?php echo $stngs->short_name; ?> SMS: Juan Dela Cruz has an active balance of PhP 5000.00. Please Settle this on or before <a href="" id="cald2"></a>. Thanks</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 pull-right" style="margin-right: 70px;">
                  <button onclick="send_level()" type="button" class="btn btn-success btn-sm">Send</button>
                  <button onclick="cancel()" type="button" class="btn btn-danger btn-sm">Cancel</button>
                </div>
              </div>
            </div>
            <div class="sms_account" style="display:none">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <p style="margin-left: 20px;"><b style="margin-right: 5px;">SEND TO</b><select onclick="destination()" tabindex="-1" id="selected_account" style="width:225px; " >   
                      <option>Select Destination</option>

                        <?php
                        foreach ($students->result() as $st) {
                          $id = $st->uid;
                          $clname = $st->lastname;
                          $cfname = $st->firstname;
                          $cname = $clname . ', ' . $cfname;
                          ?>  

                        <option value="<?php echo $cname; ?>"><?php echo $st->lastname . ',&nbsp;' .$st->firstname; ?></option>

                      <?php } ?> 

                    </select>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-2">
                  <p class="pull-right"><b>SAMPLE MESSAGE</b></p>
                </div>
                <div class="col-md-6 well well-small">
                  <p><?php echo $stngs->short_name; ?> SMS: Juan Dela Cruz has an active balance of PhP 5000.00. Please Settle this on or before <a href="" id="cald3"></a>. Thanks</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 pull-right" style="margin-right: 70px;">
                  <button onclick="send_account()" type="button" class="btn btn-success btn-sm"> Send</button>
                  <button onclick="cancel()" type="button" class="btn btn-danger btn-sm">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function() {
    $('#duedate').datepicker();
    $("#select_destination").select2();
    $("#selected_all").select2();
    $("#selected_level").select2();
    $("#selected_account").select2();

  });

  $("#send_sms").click(function()
  {
    $('#send_sms_notification').collapse('show');
    $('#print_notification').collapse('hide');
  });

  $("#gen_print").click(function()
  {
    document.location = '<?php echo base_url()?>financemanagement/collect/print_soa/'
  });

  function send_all()
  {
    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')
    var sa_sname = document.getElementById('school_sname').value;
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var detail_container = document.getElementById('trans_details');

    for (dcounter = 1; dcounter <= lastcount; dcounter++) {
      var run_name = 'an' + dcounter;
      var run_balance = 'tbd' + dcounter;
      var run_mother = 'ma' + dcounter;
      var run_father = 'pa' + dcounter;

      var a_name = document.getElementById(run_name).innerHTML;
      var a_mother = document.getElementById(run_mother).innerHTML;
      var a_father = document.getElementById(run_father).innerHTML;
      var a_balance = document.getElementById(run_balance).innerHTML;

      if (a_mother) {
        var a_number = a_mother;
      } else {
        if (a_father) {
          var a_number = a_father;
        } else {
          var a_number = 'none'
        }
      }

      if (a_number != 'none') {
        var numlength = a_number.length;
        if (numlength >= 11) {
          var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
          sendMessage(msg, a_number, 'send');

          // var msg_entry = document.createElement('input');           // msg_entry.type = 'text';           // msg_entry.name = 'msg_entry';          // msg_entry.value = 'sendMessage(' + msg + '| Number: ' + a_number + ', send)'          // trans_details.appendChild(msg_entry);

        }
      }
    }

    $('#secretContainer').hide()

    alert('Collection Notice succesfully sent to All Year Level. The receipients may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');
  }

  function send_level()
  {
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var clevel = document.getElementById('selected_level').value;
    var detail_container = document.getElementById('trans_details');
    var sa_sname = document.getElementById('school_sname').value;
    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')

    // alert(clevel);

    if (clevel != 'Select Destination') {

      for (dcounter = 1; dcounter <= lastcount; dcounter++) {
        // alert(dcounter);
        var run_name = 'an' + dcounter;
        var run_level = 'ag' + dcounter;
        var run_balance = 'tbd' + dcounter;
        var run_mother = 'ma' + dcounter;
        var run_father = 'pa' + dcounter;

        var a_name = document.getElementById(run_name).innerHTML;
        var a_level = document.getElementById(run_level).innerHTML;
        var a_mother = document.getElementById(run_mother).innerHTML;
        var a_father = document.getElementById(run_father).innerHTML;
        var a_balance = document.getElementById(run_balance).innerHTML;

        if (a_level == clevel) {

          if (a_mother) {
            var a_number = a_mother;
          } else {
            if (a_father) {
              var a_number = a_father;
            } else {
              var a_number = 'none'
            }
          }

          if (a_number != 'none') {
            var numlength = a_number.length;
            if (numlength >= 11) {

              var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
              sendMessage(msg, a_number, 'send');

              // alert(msg);
            }
          }
        }
      }

      $('#secretContainer').hide()
      alert('Collection Notice succesfully sent to ' + clevel + '. Receipients may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');

    } else {
      alert('Please select year level to send notification to and press send.')
    }
  }


  function send_account()
  {
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var caccount = document.getElementById('selected_account').value;
    var detail_container = document.getElementById('trans_details');
    var sa_sname = document.getElementById('school_sname').value;

    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')
    // alert(clevel);

    if (caccount != 'Select Destination') {

      for (dcounter = 1; dcounter <= lastcount; dcounter++)
      {
        var run_name = 'an' + dcounter;
        var run_balance = 'tbd' + dcounter;
        var run_mother = 'ma' + dcounter;
        var run_father = 'pa' + dcounter;

        var a_name = document.getElementById(run_name).innerHTML;
        var a_mother = document.getElementById(run_mother).innerHTML;
        var a_father = document.getElementById(run_father).innerHTML;
        var a_balance = document.getElementById(run_balance).innerHTML;

        if (a_name == caccount) {

          if (a_mother) {
            var a_number = a_mother;
          } else {
            if (a_father) {
              var a_number = a_father;
            } else {
              var a_number = 'none'
            }
          }

          if (a_number != 'none') {
            var numlength = a_number.length;
            if (numlength >= 11) {

              var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
              alert(msg);
              sendMessage(msg, a_number, 'send');
            }
          }
        }
      }

      $('#secretContainer').hide()
      alert('Collection Notice succesfully sent to the guardian / parent of ' + caccount + '. The receipient may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');

    } else {
      alert('Please select year level to send notification to and press send.')
    }
  }



  function destination()
  {
    var dest_value = document.getElementById('select_destination').value;
    var ddate = document.getElementById('duedate').value;

    if (ddate != '') {
      document.getElementById('cald1').innerHTML = ddate;
      document.getElementById('cald2').innerHTML = ddate;
      document.getElementById('cald3').innerHTML = ddate;

      if (dest_value == 1) {
        $(".sms_all").show();
        $(".sms_level").hide();
        $(".sms_account").hide();
        $(".sms_default").hide();
      } else if (dest_value == 2) {
        $(".sms_all").hide();
        $(".sms_level").show();
        $(".sms_account").hide();
        $(".sms_default").hide();
      } else if (dest_value == 3) {
        $(".sms_all").hide();
        $(".sms_level").hide();
        $(".sms_account").show();
        $(".sms_default").hide();
      }

    } else {
      $('#select_destination').prop('selectedIndex', 0);
      alert('Please enter collection date and repick send to choice.');

    }
  }

  function cancel()
  {
    $(".sms_all").hide();
    $(".sms_level").hide();
    $(".sms_account").hide();
    $(".sms_default").show();
    $('#select_destination').prop('selectedIndex', 0);
    document.getElementById('select_destination').value = '';
    document.getElementById('duedate').value = '';
  }


</script>
