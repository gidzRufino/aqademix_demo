  <div class="row" style="margin-bottom: 10px;">
    <div class="">
      <div class="span4 pull-left">
<!--                <h4>Itemized Statement of Account</h4>-->
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
          foreach ($initialLevel as $iL){
              if($iL->level_id==$stLevel_id && $iL->plan_id==$stPlan_id || $iL->level_id==$stLevel_id && $iL->plan_id==$stPlanGen){
              $cID += 1; 

        ?>  

          <tr class="info">
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
                      $ssCharge = $sBal->d_charge; // if there is an existing amount
                      $stCharge = $stCharge + $ssCharge;
                    }elseif($sBal->charge_credit==1) {
                      $ssCredit = $sBal->d_credit;
                      $stCredit = $stCredit + $ssCredit;
              } } } }  
              
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
                case '4':
                  $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                  $due_date = 'April';
                  break;
                case '5':
                  $balance_due = $tAmount -($tmBalance*0) - $stCredit;
                  $due_date = 'May';
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
            <td style="text-align:center;"><?php echo $iL->schedule_description ?></td>
            <td style="text-align:center;"><?php echo $due_date." ". date('Y') ?></td>
          </tr>

          <?php }} 
           // print_r($show_extra) ;                 
           foreach ($show_extra as $i_soa) {
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

          } ?>

      </table>
      <input type="hidden" name="balance_due" id="balance_due" value="<?php echo number_format($tbalance_due,2) ?>" required>
      <input type="hidden" name="pointID" id="pointID" value="<?php echo $cID ?>" required>
    </div>
  </div>




