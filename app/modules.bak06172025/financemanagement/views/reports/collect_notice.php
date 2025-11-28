<?php
class MYPDF extends Pdf {

}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetTitle('Collection Notice');
$pdf->SetSubject('Sets of Collection Notice');
$pdf->SetKeywords('Collection Notice, SOA, Statement of Accounts');
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);

$resolution = array(218,297);
$pdf->AddPage('L', $resolution);
// $pdf->AddPage('L', 'A4');


$pdf->SetFont('helvetica', 'B', 8);

$school_name = $school_settings->set_school_name;
$address = $school_settings->set_school_address;
$our_level = $clevel;
$our_date = $cdate;
$ac_tdate = date("F d, Y");
$sy_now = $showsetsy->value_3; // eg. 2015
$sy_code = $showsetsy->value;
$rolling = '';
        $test_mic = '';


foreach ($accountz as $az) {
    $rolling = '';
    // $az_level = $az->grade_level_id;
    $az_level = $az->grade_id;
    if($az_level==$our_level){
        $lname = $az->lastname;
        $fname = $az->firstname;
        $mname = $az->middlename;
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

        // $pdf->AddPage('P', 'A4');

    if ($stPlan_id!=null && $stPlan_id!=11){ // not null payment plan and full scholar code

    foreach ($initialLevel as $ist){ 

      if($ist->level_id==$stLevel_id && $ist->plan_id==$stPlan_id && $sy_code==$ist->sy_id || $ist->level_id==$stLevel_id && $ist->plan_id==$stPlanGen && $sy_code==$ist->sy_id){

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

  foreach ($sTransaction as $st){ if($st->stud_id==$stud_id && $st->sy_id==$sy_code){ 

    if($st->charge_credit==1 && $st->sy_id==$sy_code){ 
      $scredit=$st->d_credit;
      $tcredit=$tcredit+$scredit; 
    }elseif($st->charge_credit==0 && $st->sy_id==$sy_code){ 
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
        if($iL->level_id==$stLevel_id && $iL->plan_id==$stPlan_id && $sy_code==$iL->sy_id || $iL->level_id==$stLevel_id && $iL->plan_id==$stPlanGen && $sy_code==$iL->sy_id){
        $cID += 1; 

        $ar += 1;
        $ar_index = $ar - 1;
        $ar_itemChoice[$ar_index] = $iL->item_description;
        $init_item_id = $iL->item_id;
        $stCharge = 0;
        $stCredit = 0;
        $monthNow = date('n');
        $monthNow = $monthNow + $madvance;  
        foreach ($sTransaction as $sBal) {
          if($sBal->stud_id==$stud_id && $sBal->sy_id==$sy_code){ 
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

        // $itemzi = $iL->item_description;
        // $rolling = $rolling.'<tr><td style="text-align:center;border: 1px solid gray;">'.$itemzi.'</td>';

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
        $itemzi = $iL->item_description;

        if ($balance_due>0){
          $rolling = $rolling.'<tr><td style="text-align:center;border: 1px solid gray;">'.$itemzi.'</td>';
          $rolling = $rolling.'<td style="text-align:center;border: 1px solid gray;">PhP '.$bdue.'</td></tr>';
        }
    }}} 
    
    foreach ($showItems as $showitems) { // for every items on the list
        $itemz_id = $showitems->item_id;
        $item_name = $showitems->item_description;
        $charge_t = 0;
        $credit_t = 0;
        $one_item_pointer = 1; // to check one item only

        foreach ($show_extra as $se) { // for each items declared on the extra check the items and id
            $se_item = $se->item_id;
            $se_id = $se->stud_id;
            if ($itemz_id==$se_item && $se_id==$stud_id && $one_item_pointer==1) {
              $one_item_pointer = $one_item_pointer + 1;
                foreach ($tdetails as $td) {
                    $td_id = $td->stud_id;
                    $td_item = $td->item_id;
                    if($itemz_id==$td_item && $td_id==$stud_id && $td->sy_id==$sy_code){
                        $charge_t = $charge_t + $td->d_charge;
                        $credit_t = $credit_t + $td->d_credit;
                    }

                }
                $total_balance = $charge_t - $credit_t;
                $total_bdue = number_format($total_balance, 2);
                if($total_balance>0){
                $total_bdue = number_format($total_balance, 2);
                $tbalance_due = $tbalance_due + $total_balance;
                  }else{
                     $total_bdue = '0.00';
                  }
                $itemz = $item_name;
                

                // if ($total_bdue!='0.00'){
                if ($total_bdue>0){
                $rolling = $rolling.'<tr>
                <td style="text-align:center;border: 1px solid gray;">'.$itemz.'</td>
                <td style="text-align:center;border: 1px solid gray;">PhP '.$total_bdue.'</td>
                </tr>';
                }

                // get out of this for each
            }
        }
    }

    if($tbalance_due>0){
    $tot_balance_due = number_format($tbalance_due, 2);
    }else{
      $tot_balance_due = '0.00';
    }

    $html = '
    <table style="border: 1px solid gray;">
        <tr>
            <td style="padding: 15px;">
                <table style="width: 400px;border-collapse:collapse; margin-left: 50px;">
                    <tr>
                        <th colspan="6" style="text-align:center; font-size: 14px;"><br />'.$school_name.'</th>
                        
                    </tr>   
                    <tr>
                        <td colspan="6" style="text-align:center; font-style: italic; font-size: 8px;">'.$address.'</td>
                    </tr>
                    <tr>
                        <th colspan="6" style="text-align:center; font-size: 12px;">Statement of Account</th>
                    </tr>
                    <tr>
                        <th colspan="6" style="text-align:right; font-size: 10px;">'.$ac_tdate.'</th>
                    </tr>
                    <tr>
                        <th colspan="6" style="padding: 5px; font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Name: '.$my_name.'</th>
                    </tr>
                    <tr>
                        <th colspan="6" style="padding: 15px; font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Grade / Level: '.$my_grade.'</th>

                    </tr>    
                    <tr>
                        <td colspan="6" style="text-align:center;">
                            <table cellspacing="0" cellpadding="1" style="border: 1px solid black; width: 400px;">
                            
                                <tr>
                                    <th colspan="4" style="border: 1px solid gray; text-align:center; font-size: 10px">Account Summary</th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid gray;text-align:center;">Total Charge</th>
                                    <th style="text-align:center;border: 1px solid gray;">Total Credit</th>
                                    <th style="text-align:center;border: 1px solid gray;">Total Balance</th>
                                    <th style="text-align:center;border: 1px solid gray;">Min. Amount Due</th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;border: 1px solid gray;"> PhP '.$itot_charge.'</td>
                                    <td style="text-align:center;border: 1px solid gray;">PhP '.$itot_credit.'</td>
                                    <td style="text-align:center;border: 1px solid gray;">PhP '.$itot_balance.'</td>
                                    <td style="text-align:center;border: 1px solid gray;">PhP '.$tot_balance_due.'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="6" style="text-align:center;"> A C C O U N T &nbsp;&nbsp; D E T A I L S </th>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:center;">
                            <table cellspacing="0" cellpadding="1" style="border: 1px solid black; width: 400px;">
                                <tr>
                                    <th style="text-align:center;border: 1px solid gray;font-size: 10px;">Item Description</th>
                                    <th style="text-align:center;border: 1px solid gray;font-size: 10px;">Min. Amount Due</th>
                                </tr>
                                '.$rolling.'
                                <tr>
                                    <td style="text-align:center;border: 1px solid gray; font-size: 10px;">TOTAL BALANCE DUE</td>
                                    <td style="text-align:center;border: 1px solid gray;font-size: 10px;">PhP '.$tot_balance_due.'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:center; font-size: 8px;">&nbsp;&nbsp;&nbsp;&nbsp;Please settle this account on or before [ '.$cdate.' ]. Please disregard if already settled. Prepared and printed by the '.$school_name.' Administration.<br /></td>
                    </tr>                    
                    <tr>
                        <td colspan="6" style="text-align:center; font-size: 8px;">'.$test_mic.'</td>
                    </tr>    
                </table>
            </td> 
            <td margin-left: 60px;>
                <table style="border: 1px dashed gray; width: 300px;">
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 11px;"><br /><br />'.$school_name.'</th>
                    </tr>
                    
                    <tr>
                        <td colspan="4" style="text-align:center; font-size: 8px;"> Account Name: '.$my_name.' <br /></td>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 10px;">Statement of Account Acknowledgment Form <br />
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align:center; font-size: 8px;"> ____________________________________ </th>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> ______________ </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align:center; font-size: 8px;"> Parent Signature over Printed Name </th>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> Date <br /></th>
                    </tr>
                </table>
                
                <table style="border: 1px dashed gray; width: 300px;">
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 11px;"> <br /><br />'.$school_name.'</th>
                    </tr>
                    <tr>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> </th>
                        <th colspan="2" style="border: 1px solid gray; text-align:center; font-size: 10px;"><br />Admission Slip</th>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> </th>
                    </tr>
                    <tr>
                        <th><br /></th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 8px;">Name: '.$my_name.'
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 8px;">Grade / Level: '.$my_grade.' <br />
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 10px;">Remarks: _______________________________
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 10px;">___________________________________________
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align:center; font-size: 10px;">___________________________________________ <br />
                        </th>
                    </tr>
                    <tr>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> ______________ </th>
                        <th colspan="3" style="text-align:center; font-size: 8px;"> ________________________________________ </th>
                    </tr>
                    <tr>
                        <th colspan="1" style="text-align:center; font-size: 8px;"> Date</th>
                        <th colspan="3" style="text-align:center; font-size: 8px;"> Authorized Signature over Printed Name <br /></th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    ';

    // output the HTML content
    $pdf->writeHTML($html, true, 0, true, 0);
    // $pdf->AddPage();
    // } //forloop
    } // if($az_level==$our_level)
} // foreach ($accountz as $az) 

// force print dialog
$js .= 'print(true);';

// set javascript
$pdf->IncludeJS($js);

// reset pointer to the last page
$pdf->lastPage();

$title = 'lca_'.$my_grade.'_soa_'.$cdate.'.pdf';

// ob_end_clean();
//Close and output PDF document
$pdf->Output($title, 'I');


//============================================================+
// END OF FILE
//============================================================+

?>
