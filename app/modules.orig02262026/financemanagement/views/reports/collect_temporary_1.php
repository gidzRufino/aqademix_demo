
foreach ($accountz as $az) {
    $rolling = '';
    $az_level = $az->grade_level_id;
    if($az_level==$our_level){
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
        foreach ($show_extra as $se) {
            $se_item = $se->item_id;
            $se_id = $se->stud_id;
            if ($itemz_id==$se_item && $se_id==$stud_id) {
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
                    <!-- <td class="span2" style="text-align:center"><a href="<?php echo base_url('financemanagement/search/'.$st_id) ?>"><?php echo $stud_id; ?></a></td> -->
                    <td class="span2" style="text-align:center"><?php echo $my_name ?></td>
                    <td class="span2" style="text-align:center"><?php echo $my_grade ?></td>
                    <td class="span2" style="text-align:center"><?php echo $ga->plan_description ?></td>
                    <td class="span2" style="text-align:center"><?php echo number_format($itot_charge, 2) ?></td>
                    <td class="span2" style="text-align:center"><?php echo number_format($itot_credit, 2) ?></td>
                    <td class="span2" style="text-align:center"><?php echo number_format($itot_balance, 2) ?></td>
                    <td class="span2" style="text-align:center"><?php echo number_format($tot_balance_due, 2)?></td>
                  </tr>

    
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
      } // if($az_level==$our_level)
  } // foreach ($accountz as $az) 

?>       
