<?php
    foreach($settings as $set){
        $sy = $set->school_year;
    }
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
?>

<div class="clearfix row" style="margin:0;">
  <div class="row">
    <div class="span9">
      <div class="pull-left span3">
          <h3>Finance Management</h3>
      </div>
      <div class="pull-right span3" style="margin-top:15px;">
        <select onclick="getStudent()" tabindex="-1" id="searchingStudents" style="width:225px;" >   
           <option>Search by Family Name</option>
              <?php foreach ($students as $st){$id = $st->user_id; ?>  
            <option value="<?php echo $id; ?>"><?php echo $st->lastname.',&nbsp;'.substr($st->firstname, 0, 1); ?></option>
              <?php } ?> 
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- could input intro picture and hide after search -->
  </div>
  <div class="row">
    <?php
        if ($this->uri->segment(3)!=''){ 
    ?>
    <div class="span9 well well-small">
      <div class="row">
        <div class="span1 pull-left">
          <?php        
            foreach ($searched_student as $ss) {
              if ($ss->avatar==''|| $ss->avatar=='NULL' || $ss->avatar=="noimage.jpg"){
                  $image = 'noImage.png';
              }else{
                  $image = $ss->avatar;
              }
            }
          ?>
          <a class="" data-toggle="modal" href="#uploadProfile"><img alt="Upload Image Here" style="width:150px; border:solid gray" src="<?php echo base_url().APPPATH;?>uploads/<?php echo $image;?>" /></a>
          <?php } ?>
        </div>
        <div class="span4 pull-left" style="padding-top:5px;">
          <?php 
            if ($this->uri->segment(3)!=''){
              $student_full_name = "";
              foreach ($searched_student as $searched_student)
              {
                $student_full_name = $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname; 
                $student_level_section = $searched_student->level ." / ".$searched_student->section;
                $student_id = $searched_student->user_id;
                $slevelID = $searched_student->grade_level_id;
          ?>               
          <h5 style="color:black; margin: 0 0 0 0px;">Name: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h5>
          <h6 style="color:black; margin: 0 0 0 0px;">Student ID: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->user_id;?></span> </h6>
          <h6 style="color:black; margin: 0 0 0 0px;">Grade Level: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->level;?></span> </h6>
          <h6 style="color:black; margin: 0 0 0 0px;">Section: &nbsp;<span style="color:#BB0000;"><?php echo $searched_student->section;?></span> </h6>
          <br />
          <?php }  ?>
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
    <div class="span9">
      <ul class="nav nav-tabs nav-justified" id="finTab">
        <li class="active"><a href="#accountDetail" style="color:black;">Account History</a></li>
        <li><a href="#itemizedSOA" style="color:black;">Itemized Statement of Account</a></li>
      </ul>
      <div class="span9 tab-content">
        <!-- <div class="row collapse" data-toggle="collapse" id="accountHistory"> -->
        <div class="tab-pane active" id="accountDetail">
          <div class="span9">
            <div class="row"> 
              <?php } ?>
              <?php if ($this->uri->segment(3)!=''){ ?>
              <div class="span2 pull-left">
                <h4>Account History</h4>
              </div>
              <div class="span1 pull-right"> 
                <!-- empty -->
              </div>
              <div class="span2 pull-right">
                <span>
                  <button onclick="showPay()" type="button" class="btn btn-success btn-mini">Pay Now!</button>
                  <button type="button" onclick="createMe()" class="btn btn-info btn-mini">Create Charges</button>
                </span>
              </div>
              <?php } ?>
            </div>
            <div class="row">
              <div class="span8"> 
                <?php if ($this->uri->segment(3)!=''){ ?>
                <table class="table table-hover table-responsive table-condensed"> <!-- table-condensed -->
                  <tr class="info">
                    <th class="span2" style="text-align:center">Date</th>
                    <th class="span1" style="text-align:center">Control #</th>
                    <th class="span2" style="text-align:center">Description</th>
                    <th class="span2" style="text-align:center">Charges</th>
                    <th class="span2" style="text-align:center">Credit</th>
                  </tr>
                    <?php
                      $stud_id = $searched_student->user_id;
                      $tcharge = 0;
                      $tcredit = 0;
                      $istCharge = 0;
                      $istCredit = 0;
                      $stLevel_id = $searched_student->grade_level_id;
                        foreach ($initialLevel as $ist){ 
                          if($ist->level_id==$stLevel_id){ ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $ist->implement_date ?></td> 
                    <td style="text-align:center;">Initial</td>        
                    <td style="text-align:center;"><?php echo $ist->item_description ?></td>        
                    <?php
                    if ($ist->ch_cr==0) {
                      $istCharge = $ist->item_amount;
                      $istCredit = 0;
                      $tcharge = $tcharge + $istCharge;
                    }elseif ($ist->ch_cr==1) {
                      $istCharge = 0;
                      $istCredit = $ist->item_amount;
                      $tcredit = $tcredit + $istCredit;
                    }?>
                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($istCharge,2) ?></td>        
                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($istCredit,2) ?></td>        
                  </tr>
                    <?php } } 
                      foreach ($sTransaction as $st){ if($st->stud_id==$stud_id){ 
                    ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $st->tdate ?></td>
                    <td style="text-align:center;"><?php echo $st->ref_number ?></td>
                    <td style="text-align:center;"><?php echo $st->item_description ?></td>  
                      <?php if($st->charge_credit==1){ 
                        $scredit=$st->d_amount;
                        $tcredit=$tcredit+$scredit; 
                      ?>
                    <td style="text-align:center;"> - </td>
                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_amount,2) ?></td>
                      <?php } elseif($st->charge_credit==0){ 
                        $scharge=$st->d_amount;
                        $tcharge=$tcharge+$scharge; 
                      ?>
                    <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_amount,2) ?></td>
                    <td style="text-align:center;"> - </td>
                      <?php } ?> 
                  </tr>                   
                    <?php } } ?>
                    <?php $tbalance = $tcharge - $tcredit; ?>
                  <tr>
                    <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">T O T A L </span></th>
                    <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcharge,2) ?></span></th>
                    <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcredit,2) ?></span></th>
                  </tr>
                  <tr>
                    <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">TOTAL BALANCE</span></th>
                    <th colspan="2" style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tbalance,2) ?></span></th>
                  </tr>
                </table>
                <input type="hidden" name="htcharge" id="htcharge" value="<?php echo number_format($tcharge,2) ?>" required>
                <input type="hidden" name="htcredit" id="htcredit" value="<?php echo number_format($tcredit,2) ?>" required>
                <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance,2) ?>" required>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="span9">
                <?php if ($this->uri->segment(3)!=''){ ?>
                <div class="span1 pull-right"> 
                  <!-- empty -->
                </div>
                <div class="span2 pull-right">
                  <span>
                    <button onclick="showPay()" type="button" data-toggle="modal" class="btn btn-success btn-mini">Pay Now!</button>
                    <button type="button" data-toggle="modal" class="btn btn-info btn-mini">Create Charges</button>
                  </span>
                  <?php } ?>
                </div>
              </div>
            </div> 
            <div class="row">
              &nbsp;
            </div>
          </div>  
        </div>
    <?php if ($this->uri->segment(3)!=''){ ?>
        <div class="tab-pane" id="itemizedSOA" ><!-- empty -->
          <div class="row">
            <div class="span4 pull-left">
              <h4>Itemized Statement of Account</h4>
            </div>
            <div class="span1 pull-right"> 
                <!-- empty -->
              </div>
              <div class="span2 pull-right">
                <span>
                  <button onclick="showPay()" type="button" class="btn btn-success btn-mini">Pay Now!</button>
                  <button type="button" onclick="createMe()" class="btn btn-info btn-mini">Create Charges</button>
                </span>
              </div>
          </div>
          <div class="row">
            <div class="span8">
              <table class="table table-hover table-responsive table-condensed">
                <tr class="info">
                  <th class="span2" style="text-align:center">Item</th>
                  <th class="span2" style="text-align:center">Charge</th>
                  <th class="span2" style="text-align:center">Credit</th>
                  <th class="span2" style="text-align:center">Balance</th>
                  <th class="span2" style="text-align:center">Balance Due</th>
                  <th class="span2" style="text-align:center">Due Date</th>
                </tr>
                  <?php 
                  $tbalance_due = 0;
                  $ar_itemChoice = array();
                  $ar_balance = array();
                  $ar_index = 0;
                  $ar = 0;
                  $cID = 0;
                  foreach ($initialLevel as $iL) {
                    if($iL->level_id==$slevelID) { 
                      $cID += 1; ?>  
                  <tr>
                    <td style="text-align:center;" id="item<?php echo $cID ?>"><?php echo $iL->item_description ?></td>
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
                              $ssCharge = $sBal->d_amount; // if there is an existing amount
                              $stCharge = $stCharge + $ssCharge;
                            }elseif($sBal->charge_credit==1) {
                              $ssCredit = $sBal->d_amount;
                              $stCredit = $stCredit + $ssCredit;
                            }
                      } } }  
                      $tAmount = $iL->item_amount; 
                      $stBalance = $tAmount - $stCredit; 
                      $tmBalance = $tAmount/10;

                      switch ($monthNow) {
                        case '1':
                          $balance_due = $tAmount -($tmBalance*2) - $stCredit;
                          $due_date = 'January';
                          break;
                        case '2':
                          $balance_due = $tAmount -($tmBalance*1) - $stCredit;
                          $due_date = 'February';
                          break;
                        case '3':
                          $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                          $due_date = 'March';
                          break;
                        case '6':
                          $balance_due = $tAmount -($tmBalance*9) - $stCredit;
                          $due_date = 'June';
                          break;
                        case '7':
                          $balance_due = $tAmount -($tmBalance*8) - $stCredit;
                          $due_date = 'July';
                          break;
                        case '8':
                          $balance_due = $tAmount -($tmBalance*7) - $stCredit;
                          $due_date = 'August';
                          break;
                        case '9':
                          $balance_due = $tAmount -($tmBalance*6) - $stCredit;
                          $due_date = 'September';
                          break;
                        case '10':
                          $balance_due = $tAmount -($tmBalance*5) - $stCredit;
                          $due_date = 'October';
                          break;
                        case '11':
                          $balance_due = $tAmount -($tmBalance*4) - $stCredit;
                          $due_date = 'November';
                          break;
                        case '12':
                          $balance_due = $tAmount -($tmBalance*3) - $stCredit;
                          $due_date = 'December';
                          break;
                        default:
                          $balance_due = $stBalance;
                          break;
                      }
                      $tbalance_due = $tbalance_due + $balance_due;
                      $ar_balance[$ar_index] = $balance_due;
                    ?>
                    <td style="text-align:center;"><?php echo number_format($tAmount,2)  ?></td>
                    <td style="text-align:center;"><?php echo number_format($stCredit,2) ?></td>
                    <td style="text-align:center;"><?php echo number_format($stBalance,2) ?></td>
                    <td style="text-align:center;" id="bDue<?php echo $cID ?>"><?php echo number_format($balance_due,2) ?></td>
                    <td style="text-align:center;"><?php echo $due_date." ". date('Y') ?></td>
                  </tr>
                  <?php }} ?>
              </table>
              <input type="hidden" name="balance_due" id="balance_due" value="<?php echo number_format($tbalance_due,2) ?>" required>
              <input type="hidden" name="pointID" id="pointID" value="<?php echo $cID ?>" required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>  
<!-- <div id="payForm"class="collapse in" data-toggle="collapse" data-parent="#accountHistory"> -->
<?php if ($this->uri->segment(3)!=''){ ?>
  <div class="row">
    <div id="payForm" class="collapse in" data-toggle="collapse" data-parent="#accountHistory">
        <div class="row">
          <div class="span8 offset1">
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Heads Up!</strong> You can select an item from the drop-down list to add items for payment. 
            </div>
          </div>
        </div>
        <div class="span 9 well">
          <div class="row"> 
            <div class="span9">
              <div class="row">
                <div class="span3 pull-left">
                  <h4 id="testMe">Payment Transaction</h4>
                </div>
                <div class="pull-right span3" style="margin-top:5px;">
                  <select name="selectItems" tabindex="-1" onclick="addPayment()" id="selectItems" class="span2">
                     <option value="" selected="selected">Please select an item</option>
                     <?php
                       foreach($ar_itemChoice as $key => $value){
                          echo '<option value="'.$value.'">'.$value.'</option>';
                      } ?>
                  </select>  
                  <!-- <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance,2) ?>" required> -->
                  &nbsp;<button type="button" onclick="addPayment()" class="btn btn-success btn-small">add</button>
                </div>      
              </div>    
            </div>
          </div>
          <div class="row">
            <div class="span9">
              <div class="row">
                <div class="span7 offset1">
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
                  <input type="text" onblur="calcDiscount()" name="ptDiscount" id="ptDiscount" placeholder="Discount" required>
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
                  <input type="text" name="ptRefNum" id="ptRefNum" syle="width: 600px; "placeholder="OR / Referrence Number" required>
                </div>
              </div>  
              <div class="row">
                <div class="span2">
                  <label class="control-label" for="input" style="color:#BB0000;">Change</label>
                  <input type="text" name="ptChange" id="ptChange"  disabled>
                </div>
              </div> 
            </div>
          </div>
          <div class="row">
            <div class="span3 pull-right">
              <span style="padding-left: 65px;"><button onclick="showReceipt()" id="processPayBtn" data-toggle="modal" aria-hidden="true" class="btn btn-small btn-success">Process Payment </button>&nbsp;<button onclick="closePay()" type="button" data-toggle="modal" class="btn btn-danger btn-small">Cancel</button></span> 
              <input type="hidden" name="lastEntry" id="lastEntry" value=""required> <!-- last detail key -->
            </div>
          </div>
        </div>
      </div>
    </div>  <!-- end of the container -->
<?php }else{ ?>
  <div class="main_content">
    <div class="span8 offset2" style="margin-top: -50px;">
      <div class="hero-unit">
        <h1>Hi there!</h1>
        <p>Welcome to <bold>StudentGate</bold> Finance Manager! You may start by selecting a student from the drop-down list above. Have a Great day! </p>
        <p>
        <a class="btn btn-primary btn-large">
        Learn more
        </a>
        </p>
      </div>
    </div>
  </div>
</div>
<?php } ?> 

   
<!-- modal for payment -->


<div id="payNow" class="modal hide fade span6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">Payment Process - Account # &nbsp;<?php echo $student_id ?></h3>
  </div>
  <div class="modal-body"> 

  <!-- ajax form -->

  <form id="savePayment" action="" method="post">
    <div class="control-group">
      <div class="controls">
        <label class="control-label" for="input" style="color:#BB0000;">Total Balance</label>
        <input class="form-control" name="totBalance" id="totBalance" type="text" value="PhP &nbsp;<?php echo number_format($tbalance,2) ?>" disabled>
      
        <?php 
          $usrCode = substr($userid, 0,3);
          $sysRef = date("ymdHis") ."-". $usrCode; 
          $tdate = date("F d, Y");
        ?>        
        
        <input type="hidden" name="tobalance" id="tobalance" value="<?php echo $tbalance ?>" required>
        <input type="hidden" name="sysGenRef" id="sysGenRef" value="<?php echo $sysRef ?>" required>
        <input type="hidden" name="studID" id="studID" value="<?php echo $student_id ?>" required>
        <input type="hidden" name="tDate" id="tDate" value="<?php echo $tdate ?>" required>
        <input type="hidden" name="userID" id="userID" value="<?php echo $userid ?>" required>
        <input type="hidden" name="scharge" id="scharge" value="0" required>
        <input type="hidden" name="scategID" id="scategID" value="10" required>
        <input type="hidden" name="scharge_credit" id="scharge_credit" value="1" required>

      </div>
      <?php
      if ($this->uri->segment(3)!=''){ ?>
      <div class="controls">
        <div class="span2" style="float:left; margin-left:0px;">
          <label class="control-label" for="input" style="color:#BB0000;">Amount Paid</label>
          <input type="text" name="scredit" id="scredit" placeholder="Amount Paid" required>
        </div>
        <div class="span3" style="float:left; margin-left:70px;">
          <label class="control-label" for="input" style="color:#BB0000;">Referrence Number</label>
          <input type="text" name="refNumber" id="refNumber" placeholder="OR Referrence Number" required>
        </div>
      </div>
      <div class="controls">
        <label class="control-label" for="input" style="color:#BB0000;">Transaction Remarks:</label>
        <textarea class="form-control span5" id="sremarks" name="sremarks" rows="3" placeholder="Any remarks about this transaction..." ></textarea>
      </div>
    </div>
  </form>
  </div>
  <div class="modal-footer">
    <button onclick="closeTrans()" class="btn" aria-hidden="true">Close</button>
    <button onclick="showReceipt()" id="processPayBtn" data-toggle="modal" aria-hidden="true" class="btn btn-primary">Process Payment </button>
    <div id="resultSection" class="help-block" ></div>
  </div>
</div>
<?php }?>


<!-- modal for payment process for confirmation -->

<!-- <div id="yey" class="collapse in" data-toggle="collapse" data-parent="#accountHistory"> 
  <button onclick="showback()" class="btn" aria-hidden="true">yey!</button>
</div>
 -->
<div id="processPay" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">Transaction Summary</h3>
  </div>
  <div class="modal-body">
  
  <!-- ajax form -->
  <form id="savePayment" action="" method="post">
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
  </form>
  </div>
<?php
if ($this->uri->segment(3)!=''){ ?>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button id="saveBtn" onmouseover="document.getElementById('setAction').value='savePayment'" data-dismiss="modal" class="btn btn-primary">Confirm</button>
    <div id="resultSection" class="help-block" ></div>
  </div>
</div>
<?php }?>


<!-- javascript -->
<!-- javascript -->
<!-- javascript -->



<script type="text/javascript">

$(document).ready(function() {
    $("#inputGender").select2();
    $("#inputPayment").select2();
    $("#searchingStudents").select2(); 
    $("#selectItems").select2();
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
      document.location = '<?php echo base_url()?>index.php/financeManagement/'   
    }else{
      document.location = '<?php echo base_url()?>index.php/financeManagement/search/'+uid   
    }
  }

</script> 

<script type="text/javascript">

  $("#saveBtn").click(function() 
  {       
    var url1 = "<?php echo base_url().'index.php/financeManagement/saveTransaction' ?>"; // the script where you handle the form input.
    var url2 = "<?php echo base_url().'index.php/financeManagement/saveTransactionDetails' ?>"; // the script where you handle the form input.
    var uid = document.getElementById("getStudent").value;
    $.ajax({
       type: "POST",
       url: url,
       data: $("#savePayment").serialize(), // serializes the form's elements.
       success: function(data)
       {
         document.location='<?php echo base_url() ?>index.php/financeManagement/search/<?php echo $student_id ?>'
         $("form#savePayment")[0].reset()               
       }
    });

    for (dcounter =1; dcounter <= lastDetailKey; dcounter ){
     $.ajax({
     type: "POST",
     url: url2,
     data: $("#saveDetails").serialize(), // serializes the form's elements.
     success: function(data)
     {
       document.location='<?php echo base_url() ?>index.php/financeManagement/search/<?php echo $student_id ?>'
       $("form#saveDetails")[0].reset()               
     }
    });
    }
    return false; // avoid to execute the actual submit of the form.
  });

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
    }else if(pSelect.value == ''){
      alert("Please Select an Item.");
    }else if(pSelect.value == 0){
      alert("Please Select an Item.");
    }else{
      var psItem = 0;
      var psIndex = 0;
      var psPoint = document.getElementById("pointID").value
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
      
      var itemCell = row.insertCell(0);
      itemCell.id = 'pItem' + i;
      itemCell.style = 'text-align:center; font-size: 14px; font-weight: bold; padding-top: 10px;'
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
      editAmount.style = 'text-align: center; z-index: 2; position: relative;'
      editAmount.value = pickedBalanceDue;
      allocateCell.appendChild(editAmount);

      editID = editAmount.id;
      var theEditAmount = document.getElementById(editID);
      document.getElementById(editID).onblur = onUpdate;

      var buttonCell = row.insertCell(3);
      var delButton = document.createElement("button");
      delButton.type = 'button';
      delButton.innerHTML = 'delete';
      delButton.style = 'font-size: 14px; margin: 2px 0 0 -4px; color: red;'
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
    $('#accountHistory').collapse('hide');
    $('#payForm').collapse('show');
  }

  function closePay()
  {
    $('#accountHistory').collapse('show');
    $('#payForm').collapse('hide');

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
      cNumber = '0';
    }
    return cNumber;
  }


  function showReceipt()
  {
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
  

</script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.table.addrow.js"></script>  -->