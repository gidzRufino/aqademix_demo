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

?>
  <!--   $tcharge -> Total Charge <?php echo number_format($tcharge,2) ?>
    $tcredit -> Total Credit <?php echo number_format($tcredit,2) ?>
    $tbalance -> Total Balance <?php echo number_format($tbalance,2) ?>
 -->