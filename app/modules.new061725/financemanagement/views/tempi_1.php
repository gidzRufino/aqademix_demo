<?php
    
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   
?>

<div class="clearfix row" style="margin:0;">
  <div class="row">
    <div >
      <div class="row-fluid contentHeader sticky" style="background: #FFF; z-index: 2000">
          <div class="pull-left span4" style="margin-top: 10px">
            <h3>Finance Management</h3>
          </div>
          <div class="pull-right span3" style="margin-top: 25px;">
            <select onclick="getStudent()" tabindex="-1" id="searchingStudents" style="width:225px;" >   
               <option>Search by Family Name</option>
                  <?php foreach ($students->result() as $st){$id = $st->uid; ?>  
                <option value="<?php echo $id; ?>"><?php echo $st->lastname.',&nbsp;'.$st->firstname; ?></option>
                  <?php } ?> 
            </select>
          </div>
      </div>
    </div>
  </div>
  <div class="row">

    
<?php if ($this->uri->segment(3)!=''){  ?>

<div class="well well-small" >
  <div class="row">
    <div class="span1 pull-left">
      
      <?php   
      
        $image = $searched_student->avatar;
      
      ?>
      
      <img alt="Upload Image Here" src="<?php echo base_url()?>uploads/<?php echo $image;?>" style=" top:10px; left: 5px; width:70px; height:70px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-circle"/>
      
      <?php } ?>

    </div>
    <div class="span4 pull-left" style="padding-top:5px;">
      
      <?php 
     
        if ($this->uri->segment(3)!=''){
          $student_full_name = "";
          $student_full_name = $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname; 
          $student_level_section = $searched_student->level ." / ".$searched_student->section;
          $student_id = $searched_student->user_id;
          $slevelID = $searched_student->grade_level_id;
          $splan = $finance_plan->plan_description;
          $studentAccountID = $finance_plan->accounts_id;
          $student_planID = $finance_plan->plan_id;
      ?>               
      
      <h5 style="color:black; margin: 0 0 0 0px;">Name: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h5>
      <h6 style="color:black; margin: 0 0 0 0px;">Student ID: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->user_id;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Grade Level: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->level;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Section: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->section;?></span> </h6>
      <h6 style="color:black; margin: 0 0 0 0px;">Payment Plan: &nbsp;<span id="planName" style="color:#BB0000;"><?php echo $splan;?></span> </h6>
      

    </div>
    <div class="span3 pull-right">
      
      <?php } if ($this->uri->segment(3)!=''){ ?>
      
      <h5 style="color:#379EBC; margin:3px 0;">Account Summary</h5>
      <h6 style="margin: 0 0 0 20px;">Total Charge: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltcharge"></span></h6>
      <h6 style="margin: 0 0 0 20px;">Total Credit: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltcredit"></span></h6>
      <h6 style="margin: 0 0 0 20px;">Total Balance: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltbalance"></span></h6>    
      <h6 style="margin: 0 0 0 20px;">Balance Due: &nbsp; <span style="color:#BB0000;">PhP &nbsp;</span><span style="color:#BB0000;" id="ltbalance_due"></span></h6>    

      <?php } ?>

    </div>
  </div>
</div>
    
  </div>
  
  <?php if ($this->uri->segment(3)!=''){ ?>
  
  <div class="row collapse" data-toggle="collapse" id="accountHistory">
    <div class="">
      <ul class="nav nav-tabs nav-justified" id="finTab">
        <li class="active"><a href="#accountDetail" style="color:black;">Account History</a></li>
        <li><a href="#itemizedSOA" style="color:black;">Itemized Statement of Account</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="accountDetail">
          <div class="">
            <div class="row" style="margin-bottom: 10px;"> 
              
              <?php } ?>
              <?php if ($this->uri->segment(3)!=''){ ?>
              
              <div class="span2 pull-left">
<!--                <h4>Account History</h4>-->
              </div>
              <div class="span1 pull-right"> 
              </div>
              <div class="span5 pull-right">
                <span class="pull-right">
                  <button onclick="showVoid()" type="button" class="btn btn-danger btn-mini"><i class="icon-fire icon-white"></i> Void Transaction</button>
                  <button onclick="showPay()" type="button" class="btn btn-success btn-mini"><i class="icon-shopping-cart icon-white"></i> Pay Now!</button>
                  <button type="button" onclick="createMe()" class="btn btn-info btn-mini"><i class="icon-user icon-white"></i> Customize Account</button>
                </span>
              </div>
              
              <?php } ?>
            
            </div>
            <div class=""> <!--row-->
              <div class=""> 
            
                <?php if ($this->uri->segment(3)!=''){ ?>

                <table class="table table-hover table-responsive table-condensed"> <!-- table-condensed -->
                  <tr class="info">
                    <th class="span2" style="text-align:center">Date</th>
                    <th class="span2" style="text-align:center">Control # | Ref #</th>
                    <th class="span2" style="text-align:center">Description</th>
                    <th class="span2" style="text-align:center">Charges</th>
                    <th class="span2" style="text-align:center">Credit</th>
                    <th class="span2" style="text-align:center">Remarks</th>
                  </tr>
                  <?php
                    $stud_id = $searched_student->user_id;
                    $tcharge = 0;
                    $tcredit = 0;
                    $istCharge = 0;
                    $istCredit = 0;
                    $stPlanGen = 1;
                    $stLevel_id = $searched_student->grade_level_id;
                    $stPlan_id = $finance_plan->plan_id;

                    if ($stPlan_id!=null && $stPlan_id!=11){ // not null payment plan and full scholar code

                    foreach ($initialLevel as $ist){ 

                      if($ist->level_id==$stLevel_id && $ist->plan_id==$stPlan_id || $ist->level_id==$stLevel_id && $ist->plan_id==$stPlanGen){ ?>

                  <tr class="info">
                    <td style="text-align:center;"><?php echo $ist->implement_date?></td> 
                    <td style="text-align:center;">Initial</td>        
                    <td style="text-align:center;"><?php echo $ist->item_description ?></td>        

                  <?php

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
                  }

                  ?>

                    <td style="text-align:center;"><?php echo $dis_charge ?></td>        
                    <td style="text-align:center;"><?php echo $dis_credit ?></td> 
                    <td style="text-align:center;"> - </td>
                  </tr>

                  <?php } } }

                    foreach ($sTransaction as $st){ if($st->stud_id==$stud_id){ 

                  ?>

                  <tr class="info">
                    <td style="text-align:center;"><?php echo $st->tdate ?></td>
                    <td style="text-align:center;"><?php echo $st->ref_number ?> | <?php echo $st->trans_id ?></td>
                    <td style="text-align:center;"><?php echo $st->item_description ?></td>  

                  <?php if($st->charge_credit==1){ 
                    $scredit=$st->d_credit;
                    $tcredit=$tcredit+$scredit; 
                  ?>

                    <td style="text-align:center;"> - </td>
                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_credit,2) ?></td>

                  <?php } elseif($st->charge_credit==0){ 
                    $scharge=$st->d_charge;
                    $tcharge=$tcharge+$scharge; 
                  ?>

                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_charge,2) ?></td>
                    <td style="text-align:center;"> - </td>

                  <?php } if($st->tremarks==""){ ?> 

                    <td style="text-align:center;"> - </td>
                    
                  <?php }else{ ?>
                    
                    <td style="text-align:center;"><?php echo $st->tremarks ?></td>
                    
                      <?php } ?>
                    
                  </tr>                   

                    <?php } } ?>
                    <?php $tbalance = $tcharge - $tcredit; ?>

                  <tr>
                    <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">T O T A L </span></th>
                    <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcharge,2) ?></span></th>
                    <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcredit,2) ?></span></th>
                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">TOTAL BALANCE</span></th>
                    <th colspan="2" style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tbalance,2) ?></span></th>
                    <th></th>
                  </tr>
                </table>
                <input type="hidden" name="htcharge" id="htcharge" value="<?php echo number_format($tcharge,2) ?>" required>
                <input type="hidden" name="htcredit" id="htcredit" value="<?php echo number_format($tcredit,2) ?>" required>
                <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance,2) ?>" required>
                
                <?php } ?>

              </div>
            </div>
            <div class="row">
              <div class="">
                <?php if ($this->uri->segment(3)!=''){ ?>
                <div class="span1 pull-right"> 
                </div>
                <div class="span5 pull-right">
                  <span class="pull-right">
                    <button onclick="showVoid()" type="button" class="btn btn-danger btn-mini"><i class="icon-fire icon-white"></i> Void Transaction</button>
                    <button onclick="showPay()" type="button" class="btn btn-success btn-mini"><i class="icon-shopping-cart icon-white"></i> Pay Now!</button>
                    <button type="button" onclick="createMe()" class="btn btn-info btn-mini"><i class="icon-user icon-white"></i> Customize Account</button>
                  </span>
                  <?php } ?>
                </div>
              </div>
              <br /><br /><br /><br /><br /><br />
            </div> 
            <div class="row">
              &nbsp;
            </div>
          </div>  
        </div>

    <?php if ($this->uri->segment(3)!=''){ ?>

        <div class="tab-pane" id="itemizedSOA" >
          <div class="row" style="margin-bottom: 10px;">
            <div class="">
              <div class="span4 pull-left">
<!--            <h4>Itemized Statement of Account</h4>-->
              </div>
              <div class="span4 pull-right">
                <span class="pull-right">
                  <button onclick="showPay()" type="button" class="btn btn-success btn-mini"><img src="<?php echo base_url(); ?>images/finshop.png"> Pay Now!</button>
                  <button type="button" onclick="createMe()" class="btn btn-info btn-mini"><img src="<?php echo base_url(); ?>images/image_white.png"> Customize Account</button>
                </span>
              </div>
            </div>
          </div>
          <div class="">
            <div class="">
              
              <table class="table table-hover table-responsive table-condensed">
                <tr class="info">
                  <th class="span2" style="text-align:center">Item</th>
                  <th class="span2" style="text-align:center">Charge</th>
                  <th class="span2" style="text-align:center">Credit</th>
                  <th class="span2" style="text-align:center">Balance</th>
                  <th class="span2" style="text-align:center">Balance Due</th>
                  <th class="span2" style="text-align:center">Frequency</th>
                  <th class="span2" style="text-align:center">Due Date</th>
                </tr>

                <?php 
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

                ?>  

                  <tr class="info">
                                    
                    <?php 

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
                      ?>
                      <td style="text-align:center;" id="item<?php echo $cID ?>"><?php echo $iL->item_description ?></td>
                      <?php
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
                    ?>

                    <td style="text-align:center;"><?php echo number_format($tAmount,2)?></td>
                    <td style="text-align:center;"><?php echo number_format($stCredit,2) ?></td>
                    <td style="text-align:center;"><?php echo number_format($stBalance,2) ?></td>
                    <td style="text-align:center;" id="bDue<?php echo $cID ?>"><?php echo number_format($balance_due,2) ?></td>
                    <td style="text-align:center;"><?php echo $iL->schedule_description ?></td>
                    <td style="text-align:center;"><?php echo $due_date." ". date('Y') ?></td>
                  </tr>

                  <?php }}} 
                   // print_r($show_extra) ;                 
                   foreach ($show_extra as $i_soa) {
                    if ($i_soa->total_charge!=0){
                      $ar += 1;
                      $cID += 1;
                      $ar_index = $ar - 1;
                      $ar_itemChoice[$ar_index] = $i_soa->item_description;

                  ?>
                  
                  <tr class="info">
                    <td style="text-align:center;" id="item<?php echo $cID ?>"><?php echo $i_soa->item_description ?></td>
                    <td style="text-align:center;" ><?php echo number_format($i_soa->total_charge, 2) ?></td>
                    <td style="text-align:center;" ><?php echo number_format($i_soa->total_credit, 2) ?></td>

                  <?php 

                    $tot_credit = $i_soa->total_credit;
                    $tot_charge = $i_soa->total_charge;
                    $total_balance = $tot_charge-$tot_credit;

                  ?>

                    <td style="text-align:center;" ><?php echo number_format($total_balance, 2) ?></td>
                    <td style="text-align:center;" id="bDue<?php echo $cID ?>"><?php echo number_format($total_balance, 2) ?></td>
                    <td style="text-align:center;">On Post</td>
                    <td style="text-align:center;">A S A P</td>
                  </tr>


                  <?php 

                    $tbalance_due = $tbalance_due + $total_balance;

                  } } ?>

              </table>
              <input type="hidden" name="balance_due" id="balance_due" value="<?php echo number_format($tbalance_due,2) ?>" required>
              <input type="hidden" name="pointID" id="pointID" value="<?php echo $cID ?>" required>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

  <?php } ?>
  <?php if ($this->uri->segment(3)!=''){ ?>

  <div class="row">
    <div id="create_pay" class="span12 collapse in" data-toggle="collapse" data-parent="#accountHistory">
  
      <?php 
        if($splan==''){ // <!-- check if an account already exist --> 
          $plan_exist = 'no'; // <!-- if account does not exist --> 
      ?>
  
      <div class="row">
        <div class="span12">
          <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Heads Up!</strong> This account was not enrolled to any existing Plan. Select the desired Plan below and save it.
          </div>
        </div>
      </div>
      <div class="">
        <div class="">
          <table class="table table-hover table-responsive table-condensed"> 
            <tr class="info">
              <th class="span2" style="text-align:center">Plan Description</th>
              <th class="span2" style="text-align:center">Item</th>
              <th class="span2" style="text-align:center">Total Amount</th>
              <th class="span2" style="text-align:center">Monthly</th>
            </tr>
  
            <?php
              $planChoice = array();
              $planPointer = 1;
              $general_amount = 0;
              $planandgeneral_amount = 0;
              $generalMonthly_amount = 0;
              $planandgeneral_monthlyamount = 0;
              foreach ($showPlan as $sPlan) {  
                $addAmount = 0;
                $addmPayment = 0;             
                $planExist = 0;
                $splanID = $sPlan->plan_id;
                $mPayment = 0; 

                foreach ($initialLevel as $iLevel) {
                  
                  if($iLevel->level_id==$stLevel_id && $iLevel->plan_id==$splanID){
                    $plan_itemID = $iLevel->item_id;
                    $planExist = 1;
                    $planItemAmount = $iLevel->item_amount;
                    $addAmount = $addAmount + $planItemAmount;
                    $splan_name = $sPlan->plan_description;
                    $splan_id = $sPlan->plan_id;
                    foreach ($showItems as $sItems){
                      if($sItems->item_id==$plan_itemID){
                        $planItemDescription = $sItems->item_description;
                      }
                    }
                    if($iLevel->schedule_id==1){
                      $mPayment = $planItemAmount/10; //monthly payment
                      $addmPayment = $addmPayment + $mPayment;
                      $mPayment = number_format($mPayment,2);
                    }else{
                      $mPayment = '-';
                    }
            ?>

            <tr>
              <td class="span2" style="text-align:center"><?php echo $splan_name ?></td>
              <td class="span2" style="text-align:center"><?php echo $planItemDescription ?></td>
              <td class="span2" style="text-align:center"><?php echo number_format($planItemAmount,2) ?></td>
              <td class="span2" style="text-align:center"><?php echo $mPayment ?></td>
            </tr>
            
            <?php }} if($planExist==1){ ?>
            
            <tr>
            
              <?php if($splan_name=='General'){ 
                $general_amount = $addAmount;
                $generalMonthly_amount = $addmPayment;
              ?>
            
              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b>Total General charge add-on for all Plans</b></td>  
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?></b></td>
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?></b></td>

              <?php }else{ 
                $planChoice[$splan_id] = $splan_name; 
                $planPointer = $planPointer + 1;
                $planandgeneral_amount = $general_amount + $addAmount;
                $planandgeneral_monthlyamount = $generalMonthly_amount + $addmPayment;

              ?>
            
              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b> Overall TOTAL for &nbsp;<?php echo $splan_name ?></b>&nbsp;<i><span style="color:#BB0000;">(with General charges)</span></i></td>  
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_amount,2)?>)</span></i></td>
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_monthlyamount,2)?>)</span></i></td>
              <!-- <td colspan ="2"></td> -->
            </tr>
         
            <?php }}} ?>
         
          </table>            
        </div>
      </div>  
      <div class="row">
        <form id="saveplanform" action="" method="post">
        <div class="">
          <div class="alert alert-info alert-dismissable" style="padding-bottom:32px;">
            <div class="pull-right">
              <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $student_id ?>" required>
              <span>
                <select name="selectPlan" tabindex="-1" id="selectPlan" class="span2">
                 <option value="" selected="selected">Select a plan</option>
         
                 <?php
                   foreach($planChoice as $key => $value){
                      echo '<option value="'.$key.'">'.$value.'</option>';
                  } ?>
                  <option value="11" >Full Scholar</option> // full scholar code check db
                </select>&nbsp;
                <button id="savePlanBtn" data-toggle="modal" onclick="savePlan()" aria-hidden="true" class="btn btn-small btn-success">Save Plan</button>&nbsp;<button onclick="closePay()" type="button" data-toggle="modal" class="btn btn-danger btn-small">Cancel</button>
              </span> 
            </div>
          </div>
        </div>
        </form>
      </div>
      
      <?php }else{ $plan_exist = 'yes'; ?> <!-- if account exist  //   show present (B)  // item description / total Amount / Frequency / Amount -->
      
      <div class="row">
        <div class="span12">
          <h3>Account Details</h3>
          <div class="row">
            <div class="span12">
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Heads Up!</strong> Added charges will not be reflected here. Please check the account history instead.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="span12">
              <table class="table table-hover table-responsive table-condensed"> 
                <tr class="info">
                  <th class="span2" style="text-align:center">Plan Description</th>
                  <th class="span2" style="text-align:center">Item Description</th>
                  <th class="span2" style="text-align:center">Total Amount</th>
                  <th class="span2" style="text-align:center">Payment Frequency (PF)</th>
                  <th class="span2" style="text-align:center">Amount per PF</th>  <!-- /month, /quarter, on enrolment -->
                </tr>

             <?php 
              $student_planID = $finance_plan->plan_id;
              $splan = $finance_plan->plan_description;
              $general_planID = 1;
              $addAmount = 0;
              $addmPayment = 0;             
              $mPayment = 0; 
              if ($stPlan_id!=null && $stPlan_id!=11){
              foreach ($initialLevel as $iLevel) {
                if($iLevel->level_id==$stLevel_id && ($iLevel->plan_id==$student_planID || $iLevel->plan_id==$general_planID)){
                  $plan_itemID = $iLevel->item_id;
                  $planItemAmount = $iLevel->item_amount;
                  $splanItemAmount = number_format($planItemAmount,2);
                  $addAmount = $addAmount + $planItemAmount;
                  $splan_name = $iLevel->plan_description;
                  $splan_schedule = $iLevel->schedule_description;
                  $splan_item_description = $iLevel->item_description;
                  if($iLevel->schedule_id==1){
                    $mPayment = $planItemAmount/10; //monthly payment
                    $addmPayment = $addmPayment + $mPayment;
                    $mPayment = number_format($mPayment,2);
                  }elseif($iLevel->schedule_id==2){
                    $mPayment = $planItemAmount/4; //quarter payment
                    $addmPayment = $addmPayment + $mPayment;
                    $mPayment = number_format($mPayment,2);
                  }else{
                    $mPayment = $planItemAmount;
                    $mPayment = number_format($mPayment,2);
                  } 
            ?>

                <tr class="info">
                <td class="span2" style="text-align:center"><?php echo $splan_name ?></td>
                <td class="span2" style="text-align:center"><?php echo $splan_item_description ?></td>
                <td class="span2" style="text-align:center"><?php echo $splanItemAmount ?></td>
                <td class="span2" style="text-align:center"><?php echo $splan_schedule ?></td>
                <td class="span2" style="text-align:center"><?php echo $mPayment ?></td>  <!-- /month, /quarter, on enrolment -->
              </tr>

              <?php } } } ?>
            
              </table>
            </div>  
          </div>
          <div class="row">
            <div class="span4 pull-right">
              <span>
                <button onclick="openaddCharge()" type="button" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> add charge</button>
                <button onclick="changePlan()" type="button" class="btn btn-primary btn-mini"><i class="icon-cog icon-white"></i> change plan</button>
                <button onclick="closePay()" type="button" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i> close</button>
              </span>
            </div>
          </div>
        </div>        
      </div>
      
      <?php }?>

    </div>
  </div>

  <?php } ?>
  <?php if ($this->uri->segment(3)!=''){ ?>
  <div class="row">
    <div id="change_plan" class="span12 collapse in" data-toggle="collapse" data-parent="#accountHistory">
      <div class="row">
        <div class="span12 offset1">
          <div class="alert alert-error alert-dismissable" style="margin-top: 5px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning!!! </strong>This account was currently enrolled to <strong><?php echo $splan; ?></strong>. Select the desired plan below if you wish to change it.
          </div>
        </div>
      </div>
      <div class="row">
        <div class="offset1">
          <table class="table table-hover table-responsive table-condensed"> 
            <tr class="info">
              <th class="span2" style="text-align:center">Plan Description</th>
              <th class="span2" style="text-align:center">Item</th>
              <th class="span2" style="text-align:center">Total Amount</th>
              <th class="span2" style="text-align:center">Monthly</th>
            </tr>
  
            <?php
              $planChoice = array();
              $planPointer = 1;
              $general_amount = 0;
              $planandgeneral_amount = 0;
              $generalMonthly_amount = 0;
              $planandgeneral_monthlyamount = 0;
              foreach ($showPlan as $sPlan) {  
                $addAmount = 0;
                $addmPayment = 0;             
                $planExist = 0;
                $splanID = $sPlan->plan_id;
                $mPayment = 0; 

                foreach ($initialLevel as $iLevel) {
                  
                  if($iLevel->level_id==$stLevel_id && $iLevel->plan_id==$splanID){
                    $plan_itemID = $iLevel->item_id;
                    $planExist = 1;
                    $planItemAmount = $iLevel->item_amount;
                    $addAmount = $addAmount + $planItemAmount;
                    $splan_name = $sPlan->plan_description;
                    $splan_id = $sPlan->plan_id;
                    foreach ($showItems as $sItems){
                      if($sItems->item_id==$plan_itemID){
                        $planItemDescription = $sItems->item_description;
                      }
                    }
                    if($iLevel->schedule_id==1){
                      $mPayment = $planItemAmount/10; //monthly payment
                      $addmPayment = $addmPayment + $mPayment;
                      $mPayment = number_format($mPayment,2);
                    }else{
                      $mPayment = '-';
                    }
            ?>

            <tr>
              <td class="span2" style="text-align:center"><?php echo $splan_name ?></td>
              <td class="span2" style="text-align:center"><?php echo $planItemDescription ?></td>
              <td class="span2" style="text-align:center"><?php echo number_format($planItemAmount,2) ?></td>
              <td class="span2" style="text-align:center"><?php echo $mPayment ?></td>
            </tr>
            
            <?php }} if($planExist==1){ ?>
            
            <tr>
            
              <?php if($splan_name=='General'){ 
                $general_amount = $addAmount;
                $generalMonthly_amount = $addmPayment;
              ?>
            
              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b>Total General charge add-on for all Plans</b></td>  
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?></b></td>
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?></b></td>

              <?php }else{ 
                $planChoice[$splan_id] = $splan_name; 
                $planPointer = $planPointer + 1;
                $planandgeneral_amount = $general_amount + $addAmount;
                $planandgeneral_monthlyamount = $generalMonthly_amount + $addmPayment;

              ?>
            
              <td colspan="2" style="text-align:right; color:black; margin:3px 0;"><b> Overall TOTAL for &nbsp;<?php echo $splan_name ?></b>&nbsp;<i><span style="color:#BB0000;">(with General charges)</span></i></td>  
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addAmount,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_amount,2)?>)</span></i></td>
              <td class="span2" style="text-align:center;color:black; margin:3px 0;"><b>PhP &nbsp;<?php echo number_format($addmPayment,2) ?>&nbsp;</b><i><span style="color:#BB0000;">(<?php echo number_format($planandgeneral_monthlyamount,2)?>)</span></i></td>
            </tr>
         
            <?php }}} ?>
         
          </table>            
        </div>
      </div>  
      <div class="row">
        <form id="saveEditplanform" action="" method="post">
          <div class="offset1">
            <div class="alert alert-info alert-dismissable" style="padding-bottom:32px;">
              <div class="pull-right">
                <input type="hidden" name="inputplan_studID" id="inputplan_studID" value="<?php echo $student_id ?>" required>
                <input type="hidden" name="input_planAccountID" id="input_planAccountID" value="<?php echo $studentAccountID ?>" required>
                <span>
                  <select name="inputplanID" tabindex="-1" id="inputplanID" class="span2">
                    <option value="" selected="selected">Select a plan</option>
           
                    <?php
                     foreach($planChoice as $key => $value){
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    } ?>
                    <option value="11" >Full Scholar</option> // full scholar code check db
                  </select>&nbsp;
                  <button id="savePlanBtn" data-toggle="modal" onclick="saveEditPlan()" aria-hidden="true" style="margin-bottom: 10px;" class="btn btn-small btn-success"><i class="icon-ok icon-white"></i> Save Plan</button>&nbsp;<button onclick="closePay()" type="button" data-toggle="modal" style="margin-bottom: 10px;" class="btn btn-danger btn-small"><i class="icon-remove icon-white"></i> Cancel</button>
                </span> 
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="span12 offset1">
          <div class="alert alert-error alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning!!! </strong>The administration will be notified if you made changes to this account's plan.
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>
  <?php if ($this->uri->segment(3)!=''){ ?>

<div id="addChargeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div >
    <div class="alert alert-info alert-dismissable" style="margin-bottom: 0px;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <strong style="font-size: x-large;">Create New Charge</strong>
    </div>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="addChargeForm" name="addChargeForm">
      <div class="control-group">
        <div class="row">
          <div class="span1 pull-left" style="margin-right: 15px; width: 80px; height: 80px;">
            
            <a class="" data-toggle="modal" href="#uploadProfile"><img alt="Upload Image Here" style="-moz-border-radius:50%; -webkit-border-radius:50%; border-radius:50%; width:80px; height:80px; border:solid white; z-index:5; position: absolute; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3);    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3)" src="<?php echo base_url().APPPATH;?>uploads/<?php echo $image;?>" /></a>
            
          </div>
          <div>
            <h5>Account Name: <span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h5>
            <h5>Account ID: <span style="color:#BB0000;"><?php echo $student_id ?></span></h5>            
          </div>        
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Select an item</label>
        <div class="controls">
          <select tabindex="-1" id="ac_itemID" name="ac_itemID" style="width:225px;" >   
            <option>Select an Item</option>
                <?php foreach ($showItems as $item_list){ ?>  
            <option value="<?php echo $item_list->item_id; ?>"><?php echo $item_list->item_description; ?></option>
                <?php } ?> 
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Amount of the item</label>
        <div class="controls">
          <input type="text" id="ac_amount" name="ac_amount" placeholder="Enter amount">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Transaction Remarks</label>
        <div class="controls">
          <input type="text" id="ac_ptremarks" name="ac_ptremarks" placeholder="Breif description about the transaction." style="width: 311px;">
        </div>
      </div>
      <div class="hidden-group">
          
          <?php 
            $ac_usrCode = substr($userid, 0,3);
            $ac_sysRef = date("ymdHis") ."-". $ac_usrCode; 
            $ac_tdate = date("F d, Y");
            $ac_refNumber = "SysGen-".$ac_usrCode; 
            $ac_credit = 0;
          ?>        
     
        <input type="hidden" name="ac_transID" id="ac_transID" value="<?php echo $ac_sysRef ?>" required>
        <input type="hidden" name="ac_ptreferrence" id="ac_ptreferrence" value="<?php echo $ac_refNumber ?>" required>
        <input type="hidden" name="a_studID" id="ac_studID" value="<?php echo $searched_student->user_id; ?>" required>
        <input type="hidden" name="ac_tDate" id="ac_tDate" value="<?php echo $ac_tdate ?>" required>
        <input type="hidden" name="ac_userID" id="ac_userID" value="<?php echo $userid ?>" required>
        <input type="hidden" name="ac_scredit" id="ac_scredit" value="<?php echo $ac_credit ?>" required>
        <input type="hidden" name="ac_cc" id="ac_cc" value="<?php echo $ac_credit ?>" required>
        
      </div>
    </form>
    <div class="modal-footer" style="padding-bottom: 0px;">
      <button id="chargeSavebtn" data-dismiss="modal" onclick="addCharge()"class="btn btn-primary btn-mini"><i class="icon-ok icon-white"> </i> Save Charge</button>
      <button class="btn btn-danger btn-mini" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"> </i> Cancel</button>
    </div>
  </div>
</div>

<?php }?>
  <?php if ($this->uri->segment(3)!=''){ ?>

<div class="row">
<div id="payForm" class="collapse in" data-toggle="collapse" data-parent="#accountHistory">
<form id="initialTransaction">
<div id="itemRef" style="display:none;"  >
  <table id="itemRefTable">
    <tr>
      <th>ID</th>
      <th>Item Description</th>
    </tr>

    <?php 
      $numb = 0;
      // foreach($initialLevel as $initLevel){
      foreach($showItems as $initLevel){
      // if($initLevel->level_id == $slevelID){ 
    ?>

    <tr>
    
      <?php $numb = $numb + 1 ?>
    
      <td id="itid<?php echo $numb ?>"><?php echo $initLevel->item_id ?></td>
      <td id="itdesc<?php echo $numb ?>"><?php echo $initLevel->item_description ?></td>
    </tr>

    <?php } ?>

  </table>
  <input type="hidden" name="last_item_number" id="last_item_number" value="<?php echo $numb ?>" required>      
</div>
    <div class="">
      <div class="">
        <div class="alert alert-info alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong>Heads Up!</strong> You can select an item from the drop-down list to add items for payment. 
        </div>
      </div>
    </div>
    <div class="well">
      <div class=""> 
        <div class="">
          <div class="row">
            <div class="span4 pull-left">
              <h3 id="testMe" style="margin-top: 0px;">Payment Transaction</h3>
            </div>
            <div class="pull-right span4" style="margin-top:5px;">
              <select name="selectItems" tabindex="-1" onclick="addPayment()" id="selectItems" class="span3">
                 <option value="" selected="selected">Please select an item</option>
    
                 <?php

                   foreach($ar_itemChoice as $key => $value){
                      echo '<option value="'.$value.'">'.$value.'</option>';
                   } 

                ?>
    
              </select>  
            </div>      
          </div>    
        </div>
      </div>
      <div class="">
        <div class="">
          <div class="">
            <div class="">
              <table id="paymentTable" class="table table-hover table-responsive table-condensed">
                <tr>
                  <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Item Description</th>
                  <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span2">Balance Due</th>
                  <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Allocated Amount</th>
                  <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span1"></th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span2 well well-small">
          <div class="row">
            <div class="span2" >
              <label class="control-label" for="input" style="color:#BB0000;">Discount</label>
              <input type="text" onblur="calcDiscount()" name="ptDiscount" id="ptDiscount" placeholder="N / A" disabled>
            </div>
          </div>  
          <div class="row">
            <div class="span2">
              <label class="control-label" for="input" style="color:#BB0000;">Remarks</label>
              <input type="text" name="ptRemarks" id="ptRemarks" placeholder="Remarks" required>
            </div>
          </div> 
        </div>
        <div class="span2 offset1 well well-small">
          <div class="row">
            <div class="span2" >
              <label class="control-label" for="input" style="color:#BB0000;">Total Amount</label>
              <input type="text" name="pttAmount" id="pttAmount" syle="width: 600px; "placeholder="Total Amount" disabled>
            </div>
          </div>  
          <div class="row">
            <div class="span2">
              <label class="control-label" for="input" style="color:#BB0000;">Amount Tendered</label>
              <input type="text" onblur="calChange()" name="ptAmountTendered" id="ptAmountTendered" placeholder="Amount Tendered" required>
            </div>
          </div> 
        </div>
        <div class="span2 offset1 well well-small">
          <div class="row">
            <div class="span2" >
              <label class="control-label" for="input" style="color:#BB0000;">Referrence Number</label>
              <input type="text" name="ptRefNum" id="ptRefNum" syle="width: 600px;" placeholder="OR / Referrence Number" required>
            </div>
          </div>  
          <div class="row">
            <div class="span2">
              <label class="control-label" for="input" style="color:#BB0000;">Change</label>
              <input type="text" name="ptChange" id="ptChange"  disabled>
            </div>
          </div> 
        </div>
        <div class="span2 offset1 well well-small">
          <div class="row">
            <div class="span2">
              <div class="controls">
                <label class="control-label" for="duedate">Transaction Date</label>
                 <?php $at_tdate = date("F d, Y"); ?>
                 <input name="at_tdate" type="text" data-date-format="mm-dd-yyyy" id="at_tdate" placeholder="<?php echo $at_tdate ?>" required>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="span4 pull-right">
          <span style="padding-left: 65px;"><button onclick="showReceipt()" id="processPayBtn" data-toggle="modal" aria-hidden="true" class="btn btn-small btn-success"><i class="icon-shopping-cart icon-white"></i>Process Payment </button>&nbsp;<button onclick="closePay()" type="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="icon-remove icon-white"></i>Cancel</button></span> 
          <input type="hidden" name="lastEntry" id="lastEntry" value=""required> 
        </div>
      </div>
    </div>
    </form>
  </div>
</div>  

  <?php }else{ ?>

<div class="main_content">
  <div class="span12 offset2" style="margin-top: -100px;">
    <div class="hero-unit">
      <h1>Hi there!</h1>
      <p>Welcome to <b>e-sKwela</b> Finance Manager! You may start by selecting a student from the drop-down list above or access your Finance settings through the Finance Settings link located at the upper left corner of this window. Have a Great day! </p>
      <p>
      <a class="btn btn-primary btn-large">
      Learn more
      </a>
      </p>
    </div>
  </div>
</div>

<?php } ?> 
<?php if ($this->uri->segment(3)!=''){ ?>

<div id="processPay" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">Transaction Summary</h3>
  </div>
  <div class="modal-body">
    <div class="control-group">
      <div class="controls">
        <div class="row">
          <div class="span4 offset1">
            <h5>Name: <span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h5>
            <h5>ID Number: <span style="color:#BB0000;"><?php echo $student_id ?></span></h5>
          </div>
        </div>
        <div class="row">
          <div class="span5" style="margin-left: 50px;">
            <table id="resTable" class="table table-hover table-responsive table-condensed">
              <tr>
                <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Item Description</th>
                <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Allocated Amount</th>
              </tr>
            </table>  
          </div>
        </div>
        <div class="row">
          <div class="span2 offset1">
            <h6>Amount Tendered: </h6>
            <h6 class="control-label" for="input" id="discountRes" style="color:#BB0000;"></h6>
          </div>
          <div class="span2">
            <h6>CHANGE:</h6>
            <h6 class="control-label" for="input" id="changeRes" style="color:#BB0000;"></h6>
          </div>
        </div>
        <div class="row">
           <div class="span5" style="margin-left: 50px;" >
            <div class="alert alert-warning ">
              <strong>Warning!</strong> Press confirm if you think that this is a valid transaction. 
            </div>
          </div>
        </div>
    </div>
  </div>
    <div class="modal-footer">
      <button class="btn" id="cancel_pay" name="cancel_pay" data-dismiss="modal" aria-hidden="true">Cancel</button>
      <button id="saveBtn" data-dismiss="modal" class="btn btn-primary">Confirm</button>
      <div id="resultSection" class="help-block" ></div>
    </div>
  </div>
</div>

<?php }?>


<div id="payNow" class="modal  fade span6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="saveTransaction" action="" method="post">
    <div class="control-group">
      <div class="controls">
      
          <?php 
            $usrCode = substr($userid, 0,3);
            $sysRef = date("ymdHis") ."-". $usrCode; 
            $tdate = date("F d, Y");
          ?>        
      
        <input type="hidden" name="sysGenRef" id="sysGenRef" value="<?php echo $sysRef ?>" required>
        <input type="hidden" name="ptreferrence" id="ptreferrence" required>  
        <input type="hidden" name="studID" id="studID" value="<?php echo $searched_student->user_id ?>" required>
        <!-- <input type="hidden" name="tDate" id="tDate" value="<?php echo $tdate ?>" required> -->
        <input type="hidden" name="tDate" id="tDate"  required>
        <input type="hidden" name="userID" id="userID" value="<?php echo $userid ?>" required>
        <input type="hidden" name="scharge" id="scharge" value="0" required>
        <input type="hidden" name="scredit" id="scredit" required> 
        <input type="hidden" name="ptRemark" id="ptRemark" required> 

      </div>
      <div name="trans_details" id="trans_details">  <!-- detail container -->
        <!-- <input type="hidden" name="transID" id="transID" required>      -->
      </div>
    </div>
  </form>
</div>

<div id="voidtrans" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">Void a transaction</h3>
  </div>
  <div class="modal-body">
    <div class="control-group">
      <div class="controls">
        <div class="row">
           <div class="span6" style="margin-left: 50px;" >
            <div class="alert alert-warning ">
              <p style="text-align:Justify;font-size: 14px;"><strong>Warning!!!</strong> Voided transactions can never be retrieved again. A notification will also be sent to the admin regarding this transaction. If you want to void a transaction, copy the Ref # of the desired transaction to void. Press <strong>Proceed</strong> if you are ready to continue.</p>
            </div>
          </div>
        </div>
    </div>
  </div>
    <div class="modal-footer">
      <button class="btn btn-danger" id="cancel_void" name="cancel_void" data-dismiss="modal" aria-hidden="true">Cancel</button>
      <button id="void_transaction" data-dismiss="modal" class="btn btn-success">Proceed</button>
      <div id="resultSection" class="help-block" ></div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function() {
    $('#at_tdate').datepicker(); 
    $("#inputGender").select2();
    $("#selectItems").select2();
    $("#inputPayment").select2();
    $("#searchingStudents").select2(); 
    $("#ac_itemID").select2();
    $("#inputplanID").select2();
    $("#selectPlan").select2();
    $(".collapse").collapse();
    var jtcharge = document.getElementById("htcharge").value;
    var jtcredit = document.getElementById("htcredit").value;
    var jtbalance = document.getElementById("htbalance").value;
    var jtbalance_due = document.getElementById("balance_due").value;
    document.getElementById('ltcharge').innerHTML = jtcharge;
    document.getElementById('ltcredit').innerHTML = jtcredit;
    document.getElementById('ltbalance').innerHTML = jtbalance;
    document.getElementById('ltbalance_due').innerHTML = jtbalance_due;
  
  $('#finTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })
  });
  
  function getStudent()
  {
    var uid = document.getElementById("searchingStudents").value;
    var voptions = 'Search by Family Name'
    if (uid==voptions){
      document.location = '<?php echo base_url()?>financemanagement/'   
    }else{
      document.location = '<?php echo base_url()?>financemanagement/search/'+uid   
    }
  }

</script> 

<script type="text/javascript">

  $("#saveBtn").click(function() 
  {  

    var url1 = "<?php echo base_url().'financemanagement/saveTransaction' ?>"; // the script where you handle the form input.
    var finRefNum = document.getElementById("ptRefNum").value;  
    document.getElementById("ptreferrence").value = finRefNum; 
    var fintAmount = document.getElementById("pttAmount").value; 
    fintAmount = numberConverted(fintAmount);
    var finDiscount = document.getElementById("ptDiscount").value; 
    var finRemarks = document.getElementById('ptRemarks').value; 
    if(finDiscount=="" || finDiscount==0) 
    {} else{
    finRemarks = 'Discounted with (PhP ' + finDiscount + ') ' + finRemarks;} 
    finDiscount = numberConverted(finDiscount);
    finCredit = fintAmount + finDiscount; 
    finDiscount = convertNumber(finDiscount); 
    document.getElementById("scredit").value = finCredit;
    document.getElementById('ptRemark').value = finRemarks;
    var uid = document.getElementById("searchingStudents").value; 
    var finPointer = document.getElementById("lastEntry").value;
    var lastItemkey = document.getElementById("last_item_number").value;
    for (dcounter =1; dcounter <= finPointer; dcounter++){
      var nifAmount = 'aAmount' + dcounter; 
      var finAmount = document.getElementById(nifAmount).value;  
      finAmount = numberConverted(finAmount); 
    
      var detail_container = document.getElementById('trans_details');
      
      var lEntry = document.createElement('input');
      lEntry.type = 'hidden';
      lEntry.name = 'endEntry';
      lEntry.value = finPointer;
      detail_container.appendChild(lEntry);

      var transInfo = document.createElement('input');
      transInfo.type = 'hidden';
      transInfo.name = 'trans_iden'
      transInfo.id = 'trans_iden'
      transInfo.value = document.getElementById('sysGenRef').value;
      detail_container.appendChild(transInfo);

      var amountInput = document.createElement('input');
      amountInput.type = 'hidden';
      amountInput.name = 'dAmount' + dcounter;
      amountInput.id = 'dAmount' + dcounter;
      amountInput.value = finAmount;
      detail_container.appendChild(amountInput);
      
      var nifItem = 'pItem' + dcounter;  
      var finItem = document.getElementById(nifItem).innerHTML; 
      for(itemz = 1; itemz <= lastItemkey; itemz++){
        var nifDesc = 'itdesc' + itemz;
        var finDesc = document.getElementById(nifDesc).innerHTML;
        
        if(finItem == finDesc){
          var nifID = 'itid' + itemz;
          var finItemID = document.getElementById(nifID).innerHTML;
          var itemInput = document.createElement('input');
          itemInput.type = 'hidden';
          itemInput.name = 'itemID' + dcounter;
          itemInput.id = 'itemID' + dcounter;
          itemInput.value = finItemID;

          detail_container.appendChild(itemInput);
          break;
        }
      }

      var edit_date = document.getElementById('at_tdate').value;
      document.getElementById('tDate').value = edit_date;
      var chargeCredit = document.createElement('input');
      chargeCredit.type = 'hidden';
      chargeCredit.name = 'scharge_credit' + dcounter;
      chargeCredit.id = 'scharge_credit' + dcounter;
      chargeCredit.value = 1;
      detail_container.appendChild(chargeCredit);
    }

    $.ajax({
       type: "POST",
       url: url1,
       data: $("#saveTransaction").serialize(), 
       success: function(data){location.reload();}
    });
    
    alert("Success!!! Transaction already submitted.");

   });

  function addCharge()
  {
    var ac_itemID = document.getElementById('ac_itemID').value;
    if (ac_itemID!="" || ac_itemID!=0)
    {
      var ac_amount = document.getElementById('ac_amount').value;
      if (ac_amount!="" ||ac_amount!=0)
      {
        ac_amount = numberConverted(ac_amount);
        document.getElementById('ac_amount').value = ac_amount;    
        var acharge_url = "<?php echo base_url().'financemanagement/addCharge' ?>";
        $.ajax({
           type: "POST",
           url: acharge_url,
           data: $("#addChargeForm").serialize(), 
           success: function(data){location.reload();}
        });
        alert("Success!!! Charge successfully added.");  
      }else{
        alert("Please enter a valid amount");
      }
    }else{
      alert("Please select an item.");
    }
  }

  function savePlan()
  {
    var plan_url = "<?php echo base_url().'financemanagement/saveAccountPlan' ?>";
    $.ajax({
       type: "POST",
       url: plan_url,
       data: $("#saveplanform").serialize(), 
       success: function(data){location.reload();}
    });
    
    alert("Success!!! The account is now enrolled to a payment plan.");  
  }

  function saveEditPlan()
  {
    var eplan_url = "<?php echo base_url().'financemanagement/saveEditPlan' ?>";
    $.ajax({
       type: "POST",
       url: eplan_url,
       data: $("#saveEditplanform").serialize(), 
       success: function(data){location.reload();}
    });
    
    alert("Success!!! The plan was successfully edited. A notification has also been sent to the administration.");  
    
  }

  function calcDiscount()
  { 
    var entryAmount = 0;
    var lastEntry = document.getElementById("lastEntry").value; // check the last entry value
      for (sPoint = 1; sPoint <= lastEntry; sPoint++)  // adds all the values
      { 
        var entryNum = 'aAmount' + sPoint;
        if(document.getElementById(entryNum)!=null || document.getElementById(entryNum)!=undefined) {
          var entryValue = document.getElementById(entryNum).value;
          var entryValue = entryValue.replace(/\,/g,'');
          entryValue = parseFloat(entryValue);
          entryAmount =  entryAmount + entryValue;
        }
      }
    
    sentryAmount = convertNumber(entryAmount);
    document.getElementById("pttAmount").value = sentryAmount;

    var refDiscount = document.getElementById('ptDiscount').value;
    refDiscount = numberConverted(refDiscount);
    scomputDiscount = entryAmount - refDiscount;
    computDiscount = convertNumber(scomputDiscount);
    document.getElementById('pttAmount').value = computDiscount;
    var tenAmount = document.getElementById('ptAmountTendered').value;
    tenAmount = numberConverted(tenAmount);    
    var changeAmount = tenAmount - scomputDiscount;
    changeAmount = convertNumber(changeAmount);
    document.getElementById('ptChange').value = changeAmount;
  }

  function onUpdate()
  {
    var self = this;
    var selfValue = self.value;
    var entryAmount = 0
    var lastEntry = document.getElementById("lastEntry").value; // check the last entry value
      for (sPoint = 1; sPoint <= lastEntry; sPoint++)  // adds all the values
      { 
        var entryNum = 'aAmount' + sPoint;
        if(document.getElementById(entryNum)!=null || document.getElementById(entryNum)!=undefined) {
          var entryValue = document.getElementById(entryNum).value;
          var entryValue = entryValue.replace(/\,/g,'');
          entryValue = parseFloat(entryValue);
          entryAmount =  entryAmount + entryValue;
        }
      }
    entryAmount = convertNumber(entryAmount);
    document.getElementById("pttAmount").value = entryAmount;
    calChange();
  }
  
  function calChange()
  {
    var computeChange = '0';
    var atReceived = document.getElementById('ptAmountTendered').value;
    atReceived = numberConverted(atReceived);    
    var refAmount = document.getElementById('pttAmount').value;
    refAmount = numberConverted(refAmount);    
    var refDiscount = document.getElementById('ptDiscount').value;
    refDiscount = numberConverted(refDiscount);    
    scomputDiscount = refAmount - refDiscount;
    computDiscount = convertNumber(scomputDiscount);
    document.getElementById('pttAmount').value = computDiscount;

    scomputeChange = atReceived - scomputDiscount;
    concomputeChange = convertNumber(scomputeChange);
    document.getElementById('ptChange').value = concomputeChange;  
  }

  var i = 1;
  var totAmount = '0';
  function addPayment()
  {
    var aDiscount = document.getElementById("ptDiscount").value;
    if (aDiscount == ''){
      aDiscount = '0';
    }
    var pSelect = document.getElementById("selectItems");
    if (pSelect.value == 'Please select an item'){
      alert("please select an item");
      document.getElementById('testMe').innerHTML = document.getElementById("selectItems").value;
    }else if(pSelect.value == 0 || pSelect.value == ''){
      alert("Please Select an Item.");
    }else{
      var psItem = 0;
      var psIndex = 0;
      var psPoint = document.getElementById("pointID").value;
      var pickedItem = document.getElementById("selectItems").value;
      for (psItem = 1; psItem <= 100; psItem++) {
        var pointItem = 'item' + psItem;
        var testItem = document.getElementById(pointItem).innerHTML;
        if (testItem == pickedItem) {
           psIndex = psItem;
           break;
        };    
      };    
      var psBdue = 'bDue' + psIndex;
      var pickedBalanceDue = document.getElementById(psBdue).innerHTML;
      var spickedBalanceDue = pickedBalanceDue.replace(/\,/g,''); //get rid of comma
      spickedBalanceDue = parseFloat(spickedBalanceDue);  // converts to float
      var aDiscount = aDiscount.replace(/\,/g,'');

      totAmount = parseFloat(totAmount);
      aDiscount = parseFloat(aDiscount);
      totAmount = totAmount + spickedBalanceDue - aDiscount;
      // alert(spickedBalanceDue);
      contotAmount = convertNumber(totAmount); //convert back to thousand string
      document.getElementById('pttAmount').value = contotAmount;
      // alert(contotAmount);
      
      pSelect.remove(pSelect.selectedIndex);
      var tbl = document.getElementById("paymentTable");
      var lastRow = tbl.rows.length; //gets the table's last index
      var iteration = lastRow - 1;
      var row = tbl.insertRow(lastRow);
      row.id = 'row'+ i;
      trow = row.id;
      
      // pdisplay = '<span style="font-weight:bold; font-size: 14px;">'+ pickedItem + '</span><br/><span style="font-weight:normal; font-size:10px;">' + pickedBalanceDue;
      var itemCell = row.insertCell(0);
      itemCell.id = 'pItem' + i;
      itemCell.style = 'text-align:center; padding-top: 10px;'
      itemCell.innerHTML = pickedItem;
      
      var bdueCell = row.insertCell(1);
      bdueCell.id = 'pbdue' + i;
      bdueCell.style = 'text-align:center; font-size: 14px; font-weight: bold; padding-top: 10px;'
      bdueCell.innerHTML = pickedBalanceDue;

      var allocateCell = row.insertCell(2);
      var editAmount = document.createElement("input");
      editAmount.type = 'text';
      editAmount.name = 'aAmount' + i;
      editAmount.id = 'aAmount' + i;
      editAmount.maxlength = lastRow;
      editAmount.style = 'text-align: center; z-index: 2; position: relative; width: 95%; margin-bottom: 0px;'
      editAmount.value = pickedBalanceDue;
      allocateCell.appendChild(editAmount);

      editID = editAmount.id;
      var theEditAmount = document.getElementById(editID);
      document.getElementById(editID).onblur = onUpdate;

      var buttonCell = row.insertCell(3);
      var delButton = document.createElement("button");
      delButton.type = 'button';
      delButton.innerHTML = 'delete';
      delButton.style = 'font-size: 14px; width: 100%; color: red;'
      delButton.id = 'delBtn' + i;
      buttonCell.appendChild(delButton);

      document.getElementById("lastEntry").value = i;
      btnID = delButton.id;
      var theBtn = document.getElementById(btnID);
      document.getElementById(btnID).onclick = delRow;

      calChange();
    }  
    i++;
  }

  function openaddCharge()
  {
    $("#addChargeModal").modal();
  }

  function delRow()
  {
    var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex; // This is row Index
    var itable = document.getElementById("paymentTable");
    var row = itable.rows[rowIndex];
    var thisRowID = row.id;
    
    // alert(thisRowID);
    tpointID = thisRowID.slice(3,4); // extract ID
    // alert(tpointID);
    pointItem = 'pItem' + tpointID;
    pointBaldue = 'pbdue' + tpointID;
    pointalAmount = 'aAmount' + tpointID;
    var value_Item = document.getElementById(pointItem).innerHTML;
    // alert(value_Item);
    var selectBack = document.getElementById('selectItems');
    $("#selectItems").append('<option value='+value_Item+'>'+value_Item+'</option>');

    var value_baldue = document.getElementById(pointBaldue).innerHTML;
    value_baldue = numberConverted(value_baldue);
    var value_alAmount = document.getElementById(pointalAmount).value;
    value_alAmount = numberConverted(value_alAmount);
 
    var value_totAmount = document.getElementById('pttAmount').value;
    value_totAmount = numberConverted(value_totAmount);
    value_totAmount = value_totAmount - value_alAmount;
    value_totAmount = convertNumber(value_totAmount);
    document.getElementById('pttAmount').value = value_totAmount;
    document.getElementById("paymentTable").deleteRow(rowIndex);

    calChange();
  }

  function showPay()
  {
    var tplan = document.getElementById('planName').innerHTML;
    if (tplan!=""){
      $('#accountHistory').collapse('hide');
      $('#payForm').collapse('show');
      $('#create_pay').collapse('hide');
      $('#change_plan').collapse('hide');
    }else{
      alert("There is no plan assigned on this account yet. There is nothing to pay.")
    }
  }

  function showVoid()
  {
    
    $("#voidtrans").modal("show");
    
  }

  $("#void_transaction").click(function() 
  {  
    document.location = '<?php echo base_url() ?>financemanagement/void/'; 
  });

  function closePay()
  {
    // $('#accountHistory').collapse('show');
    // $('#payForm').collapse('hide');
    // $('#create_pay').collapse('hide');
    // $('#change_plan').collapse('hide');
    location.reload();
  }

  function createMe()
  {
    $('#accountHistory').collapse('hide');
    $('#payForm').collapse('hide');
    $('#create_pay').collapse('show');
    $('#change_plan').collapse('hide');
  }

  function changePlan()
  {
   $('#accountHistory').collapse('hide');
    $('#payForm').collapse('hide');
    $('#create_pay').collapse('hide');
    $('#change_plan').collapse('show');
  }

  function closeTrans(){
    var rsure=confirm("Do you want to cancel this transaction?");
    if (rsure==true)
    {
      $("form#savePayment")[0].reset();
      $("#payNow").modal("hide");
    }else{
    
    } 
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


  function showReceipt()
  {
//    var gen_receipt = document.getElementById('
    var amountReceived = document.getElementById("ptAmountTendered").value;
    var rref = document.getElementById("ptRefNum").value; 
      if (amountReceived>0){ // check if non-negative number
        if (!rref){  // check if ref number was provided
          alert("Please enter the Transaction Referrence Number.")
          }else{
          var refNumber = document.getElementById('ptRefNum').value;
          var totalAmount = document.getElementById('pttAmount').value;
          var totDiscount = document.getElementById('ptDiscount').value;
          var totamountTend = document.getElementById('ptAmountTendered').value;
          if (isNaN(totamountTend) || !totamountTend ){ 
            totamountTend = '0.00';
          } 
          totamountTend = convertNumber(totamountTend);

          var totChange = document.getElementById('ptChange').value;
          var totDiscount = totDiscount.replace(/\,/g,'');
          totDiscount = parseFloat(totDiscount);
          if (isNaN(totDiscount) || !totDiscount ){ 
            totDiscount = '0.00';
          }     
          totDiscount = convertNumber(totDiscount);
          document.getElementById('discountRes').innerHTML = 'PhP ' +totamountTend;
          document.getElementById('changeRes').innerHTML = 'PhP ' +totChange;
          
          var iter = document.getElementById('lastEntry').value;
          for (iterate = 1; iterate <= iter; iterate++) 
          {
            itemr = 'pItem' + iterate;
            amountr = 'aAmount' + iterate;
            if(document.getElementById(itemr)!=null || document.getElementById(itemr)!=undefined) {
              var itemD = document.getElementById(itemr).innerHTML;
              var amountD = document.getElementById(amountr).value;

              var tble = document.getElementById("resTable");
              var lastRow = tble.rows.length; //gets the table's last index
              var iteration = lastRow - 1;
              var srow = tble.insertRow(lastRow);
                            
              var itemCell = srow.insertCell(0);
              itemCell.style = 'text-align:center; font-size: 10px; '
              itemCell.innerHTML = itemD;
              
              var bdueCell = srow.insertCell(1);
              bdueCell.style = 'text-align:center; font-size: 10px;'
              bdueCell.innerHTML = 'PhP '+amountD;
            }
          }
          
          var itemD = document.getElementById(itemr).innerHTML;
          var amountD = document.getElementById(amountr).value;

          var tble = document.getElementById("resTable");
          var lastRow = tble.rows.length; //gets the table's last index
          var iteration = lastRow - 1;
          var srow = tble.insertRow(lastRow);
                        
          var itemCell = srow.insertCell(0);
          itemCell.style = 'text-align:right; font-size: 14px; padding-top: 10px;'
          itemCell.innerHTML = 'Discount:  '
          
          var bdueCell = srow.insertCell(1);
          bdueCell.style = 'text-align:center; font-size: 14px; padding-top: 10px; color:#BB0000;'
          bdueCell.innerHTML = 'PhP '+totDiscount;

          var lastRow = tble.rows.length; 
          var iteration = lastRow - 1;
          var srow = tble.insertRow(lastRow);
                          
          var itemCell = srow.insertCell(0);
          itemCell.style = 'text-align:right; font-size: 14px; font-weight: bold; padding-top: 10px;'
          itemCell.innerHTML = 'T O T A L :  '
          
          var bdueCell = srow.insertCell(1);
          bdueCell.style = 'text-align:center; font-size: 14px; font-weight: bold; padding-top: 10px; color:#BB0000;'
          bdueCell.innerHTML = 'PhP '+totalAmount;
          
          $("#processPay").modal();
          
        }
      }else{
        alert("Please enter a valid amount tendered.")
      }        
    }
  
// $("#processPay").blur(function() 
// {
//   alert('this is the blur!!');
//   var tble = document.getElementById("resTable");
//   var rowcount = tble.rows.length; 
//   rowcount = rowcount - 2;
//   for (delcount = 0; delcount <= rowcount; delcount++){
//   document.getElementById('resTable').deleteRow(1);
//   }
//   $("#processPay").blur();

// });

</script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.table.addrow.js"></script>  -->




<div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">26</div>
                    <div>New Comments!</div>
                  </div>
                </div>
              </div>
                <a href="#">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">26</div>
                    <div>New Comments!</div>
                  </div>
                </div>
              </div>
                <a href="#">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                  <div class="huge">26</div>
                  <div>New Comments!</div>
                  </div>
                </div>
              </div>
                <a href="#">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-tasks fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge">12</div>
                    <div>New Tasks!</div>
                  </div>
                </div>
              </div>
              <a href="#">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </span>
              <div class="clearfix"></div>
              </div>
              </a>
            </div>
          </div>
        </div> 


        <div class="col-md-5">
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary"><b>Customize Account</b></button>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-success"><b>Pay Now!</b></button>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-danger"><b>Void Transaction</b></button>
                  </div>
                </div>  
              </div>