<div class="col-lg-12">
    <div class='panel panel-red'>
        <div class='panel-heading clearfix'>
            <h5 class="pull-left">Student Billing Status History</h5>
            <button onclick="showSOAForm()" class="btn btn-warning pull-right"><i class="fa fa-print fa-2x"></i></button>
        </div>
        <div class='panel-body'>
            <table class="table">
                <?php 
                $yearlyPayment = 38000;
                $totalExtra = 0;
                $isPriviledge = FALSE;
                $totalCharges = 0;
                $totalDiscount = 0;
                $totalPayment = 0;
                $penalty = 0;
                $remainingMoney = 0;
                $status = 'Unpaid';
                $mop = Modules::run('finance/getMOP', $btype);
        
                foreach ($charges as $c):
                    $totalCharges += $c->amount;
                endforeach;
                
                $extraCharges = Modules::run('finance/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                if($extraCharges->num_rows()>0):
                    foreach ($extraCharges->result() as $ec):
                        if($ec->category_id!=6):
                            $totalExtra += $ec->extra_amount;
                        endif;
                    endforeach;
                endif;
                
                
                $overAllCharges = $totalCharges + $totalExtra;
                
                $discount = Modules::run('finance/getTransactionByItemId', $student->st_id,NULL,$student->school_year,NULL,2);
                foreach ($discount->result() as $d):
                    $totalDiscount += $d->t_amount;
                endforeach;
                if($student->st_type==1):
                    $totalDiscount += 5000;
                endif;  
                $totalDiscount!=0?$totalDiscount:0;
                
                $chargesLessDiscount = $overAllCharges - $totalDiscount;
                
                $downpayment = $overAllCharges - $yearlyPayment;
                
                $remainingFee = $overAllCharges - $downpayment;
                
                $paymentTransaction = Modules::run('finance/getTransaction', $student->uid, 0, $student->school_year);
                
                $startMonth = 6;
                $totalMonth = 10;
                $currentMonth = abs(date('m'));
                
                switch ($btype):
                    case 1:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthlyFee = $remainingFee/10;
                        $numMonth = 10;
                        $addMonth = 0;
                    break;    
                    case 2:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthPassed = $monthPassed+3;
                        $monthlyFee = $remainingFee/4;
                        $numMonth = 4;
                        $addMonth = 2;

                    break;    
                    case 3:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthPassed = $monthPassed+5;
                        $monthlyFee = $remainingFee/2;
                        $numMonth = 2;
                        $addMonth = 5;
                    break;    
                endswitch;
                
                if($paymentTransaction->num_rows()>0):
                    $balance = 0;
                    foreach ($paymentTransaction->result() as $tr):
                        if($tr->t_type<2 && $tr->category_id!=6):
                            $totalPayment += $tr->t_amount;
                        endif;
                    endforeach;
                    if($student->st_type==1): 
                        $isPriviledge = TRUE;
                    endif;
                    
               endif;
               
               if($dpBalance>0):
                   $dpDue = $dpBalance;
                   $status = 'Unpaid';
                   $color = 'alert-info';
                   if($monthPassed>0):
                        $status = 'Overdue';
                        $color = 'alert-danger';
                   endif;
                   $totalPayment = 0;
               else:
                   $color = 'alert-success';
                   $status = 'Paid';
                   $totalPayment = $totalPayment;
               endif; 
                ?>
                <tr>
                    <td colspan="5" class="text-center"><h4 class="no-margin">DOWNPAYMENT</h4></td>
                </tr>
                <tr class="alert-info">
                    <th class="text-center">OR #</th>
                    <th class="text-center">DATE</th>
                    <th class="text-right">Payments / Discounts</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center">Remarks</th>
                </tr>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
                    <th class="text-right"><?php echo number_format($downpayment,2,".",",")  ?></th>
                    <th class="text-center"></th>
                </tr>
                <?php
                if($dpBalance>0):
                   $dpDue = $dpBalance;
                   $status = 'Unpaid';
                   $color = 'alert-info';
                   if($monthPassed>0):
                        $status = 'Overdue';
                        $color = 'alert-danger';
                   endif;
                   $totalPayment = 0;
               else:
                   $color = 'alert-success';
                   $status = 'Paid';
                   $totalPayment = $totalPayment;
               endif; 
                if($totalDiscount>0):
                   $dpBalance = $downpayment - $totalDiscount;
                   $dpDue = $dpBalance;
                   ?>
                    <tr class="<?php echo $color ?>">
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format($totalDiscount,2,".",",")  ?></td>
                        <td class="text-right"><?php echo number_format(($dpBalance<0?0:$dpBalance),2,".",",")  ?></td>
                        <td class="text-center">DISCOUNT</td>
                    </tr>
                    <?php  
                else:
                    $dpBalance = $downpayment;
                    $dpDue = $dpBalance;
                endif;
                $remainingMoney = $totalPayment - $dpBalance;
                $tfPaymentDeduction = 0;
                
                foreach ($paymentTransaction->result() as $tr):
                    if($tr->t_type<2 && $tr->category_id!=6):
                            if($dpBalance<0):
                                $dpBalance = $dpBalance - $tr->t_amount;
                                $dpDue = $dpBalance;
                            endif;    
                            if($dpBalance > 0):
                                $dpBalance = $dpBalance - $tr->t_amount;
                                $dpDue = $dpBalance;
                            ?>
                                <tr class="<?php echo $color ?>">
                                    <td class="text-center"><?php echo $tr->ref_number  ?></td>
                                    <td class="text-center"><?php echo date('m/d/Y', strtotime($tr->t_date)) ?></td>
                                    <td class="text-right"><?php echo number_format($tr->t_amount,2,".",",")  ?></td>
                                    <td class="text-right"><?php echo ($dpBalance<0?'( '.number_format(abs($dpBalance),2,".",",").' )':number_format($dpBalance,2,".",","))  ?></td>
                                    <td class="text-center"></td>
                                </tr>
                            <?php
                                if($tr->category_id==1):
                                    $tfPaymentDeduction+=$tr->t_amount;
                                endif;
                                if($dpBalance<0):
                                    $remainingMoney = abs($dpBalance);
                                    break;
                                endif;
                            endif;
                    endif;
                endforeach;
                ?>
            </table>
            <table class="table">
                <tr>
                    <td colspan="6" class="text-center"><h4 class="no-margin">TUITION</h4></td>
                </tr>
                <tr class="alert-info">
                    <th class="text-center" style="width:15%;"></th>
                    <th class="text-center">OR #</th>
                    <th class="text-center">DATE</th>
                    <th class="text-right" style="width:15%;">Payments / Fees</th>
                    <th class="text-right" style="width:15%;">Due</th>
                    <th class="text-center">Remarks</th>
                </tr>
                <tr>
                    <th class="text-center" style="width:15%;"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right" style="width:15%;"></th>
                    <th class="text-right" style="width:15%;">38,000.00</th>
                    <th class="text-center"></th>
                </tr>
            <?php
                $payment = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0, $student->school_year, 1);
                $totalTFPayment = $payment->amount;
                $rm = $remainingMoney;
                $tfpayment = 0;
                $atfpayment = 0;
                $ptfpayment = 0;
                $previousBalance = 0;
                $overAllTFCharges = 0;
                //echo $rm-3800;
                $tfRemaining = $totalTFPayment-$tfPaymentDeduction;
                
                $tpCount = 0;
                for($i = 1; $i<=$totalMonth; $i++):
                    $monthNums = (($i+5)+$addMonth);
                    $monthNum = ($monthNums>12?$monthNums-12:$monthNums);
                    $monthNum = ($monthNum < 10?'0'.$monthNum:$monthNum);
                    //$tfpayment = $tpayment->amount;
                    $expectedPayment = ($monthlyFee * $i);
                    $overAllTFCharges = $monthlyFee * 10;
                    
                    
                    if($i < 11):
                        $hasPen = FALSE;
                        $hasOutstandingBalance = FALSE;
                        $penalty = 0;
                        $tpayment = Modules::run('finance/finance_lma/getTFPayment',  $student->uid, abs($monthNum));
                        $ptpayment = Modules::run('finance/finance_lma/getTFPayment',  $student->uid, abs($monthNum-1));

                        if($tpayment->num_rows()>1):
                            foreach ($tpayment->result() as $tp):
                                $tpCount++;
                                $tpayments += $tp->t_amount;
                            endforeach;
                        endif;
                        
                        $penaltys = Modules::run('finance/finance_lma/getPenalty',$student->uid,0, $this->session->school_year, abs($monthNum));
                        if($penaltys->row()):
                            $hasPen = TRUE;
                            $penalty = $penaltys->row()->pen_amount;
                        endif;
                        
                        echo $monthNums.'<br />';
                        echo $tfRemaining.' | '.$balance_due.'<br />';
                        //echo $balance_due;
                        $tfpayment = 0;
                        $tfRemaining = $tfRemaining;
                        
                        if($tpayment->row()): // has current payment
                            if($tpCount > 0): //advance payment;
                                //echo $tpCount.'<br />';
                                if($tpCount != $tpayment->num_rows()):
                                    
                                else:
                                    $tfRemaining = $tfRemaining - ($tpayment->row()->t_amount+$balance_due+$penalty);
                                    $tfpayment = $monthlyFee+$balance_due+$penalty;
                                    $balance_due = ($monthlyFee+$balance_due+$penalty)-$tfpayment;
                                    //echo $balance_due;
                                    $tpCount--;
                                endif;
                            
                            //else:   
                            endif;
                            
                            if(!$ptpayment->row()):
                                 $tfpayment = $monthlyFee+$balance_due;
                                 //$remarks ='boom';
                            else:
                                $tfpayment = $tpayment->row()->t_amount;
                                $balance_due = $tfpayment-($monthlyFee+$penalty+$balance_due);
                                $tfRemaining = $tfRemaining - ($tpayment->row()->t_amount+$balance_due);
                                if($balance_due < 0):
                                    $balance_due = 0;
                                endif;
                                $remarks ='boom';
                            endif;
                        else: //no currentPayment
                            if($tfRemaining > 0):
                                if($tpCount > 0):
                                    if($tpCount != $tpayment->num_rows()):
                                        $tfpayment = $monthlyFee+$balance_due;
                                        $tpayments = $tpayments - 3800;
                                        $tfRemaining = $tfRemaining - ($monthlyFee+$balance_due+$penalty);
                                        $balance_due = ($monthlyFee+$balance_due+$penalty)-$tfpayment;

                                        $tpCount--;
                                        //$remarks ='hey';
                                    else:
                                        $tfRemaining = $tfRemaining - ($tpayment->row()->t_amount+$balance_due);
                                        $tfpayment = -$tpayment->row()->t_amount;
                                        $balance_due = (3800+($tfpayment))+$balance_due;
                                        $partialBalance = $balance_due;
                                        $tpayments = ($tpayments-3800)+$balance_due;
                                        
                                        
                                        $tpCount--;
                                    endif;
                                else:
                                    $tfRemaining = $tfRemaining - ($monthlyFee+$balance_due+$penalty);
                                    $tfpayment = ($monthlyFee+$balance_due+$penalty);
                                    $balance_due = ($monthlyFee+$balance_due)-$tfpayment;  
                                    //$remarks ='yow';
                                endif;
                            else:
                                $tfpayment = 0;
                                $balance_due = ($monthlyFee+$balance_due);
                            endif;    
                        endif;
                        
                        

                        $color = ($i+5)<$currentMonth?$partialBalance>0?'alert-danger':'alert-success':'alert-info';
                        $color = ($i+5)<=$currentMonth?$partialBalance==0?'alert-success':'alert-info':'alert-info';
                        $status = ($tfpayment>=$monthlyFee?'Paid':'Unpaid');

                        $m = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
                        if(strtotime($m->row()->bill_date) < strtotime(date('Y-m-d'))):
                            if($partialBalance>0):
                                $hasPen = TRUE;
                                $color = 'alert-danger';
                                $status = 'Overdue';
                                if($isPriviledge):
                                    $penalty = $mop->special_penalty;
                                else:
                                    $penalty = $mop->regular_penalty;
                                endif;
                                //Modules::run('finance/billing/savePenalty', $student->uid,$monthNum,$penalty, $this->session->school_year);

                            endif;
                        endif;
                        if($monthNums>$currentMonth):
                            $penalty = 0;
                        endif;
                        $balance_due = $balance_due + $penalty;
                        $tfBalance += $partialBalance+$penalty;
                        ?>
                            <tr class="<?php echo $color ?>">
                                <td colspan="6" class="text-left"><?php echo date('F', strtotime(date('Y-'.$monthNum.'-01'))) ?></td>
                            </tr>

                            <tr class="<?php echo $color ?>">
                                <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tuition</td>
                                <td class="text-center"><?php echo $tpayment->row()->ref_number  ?></td>
                                <td class="text-center"><?php echo ($tpayment->row()==NULL?"":date('m/d/Y', strtotime($tpayment->row()->t_date))) ?></td>
                                <td class="text-right"><?php echo ($tfpayment<0?'( '.number_format(abs($tfpayment),2,".",",").' )':number_format($tfpayment,2,".",","))  ?></td>
                                <td class="text-right"><?php echo ($balance_due<0?'( '.number_format(abs($balance_due),2,".",",").' )':number_format($balance_due,2,".",","))  ?></td>
                                <td class="text-center"><?php echo $remarks ?></td>
                            </tr>
                            <?php

                            if($hasPen):
                                ?>
                                <tr class="<?php echo $color ?>">
                                    <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penalty</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"><?php echo number_format($penalty,2,".",",")  ?></td>
                                    <td class="text-right"></td>
                                    <td class="text-center"></td>
                                </tr>
                            <?php
                            endif;
                    endif;
                   $addMonth = $addMonth + $addM;
                endfor;
                
                ?>
            
            </table>
            
            
            
        </div>
    </div>
</div>


<div id="printSOA" class="modal fade" style="width:20%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Print Statement of Account  
        </div>
         <div class="panel-body">
             <div class="form-group">
                 <label>Select Option to Print</label>
               <select id="soaOption" style="width:100%;">
                   <option onclick="$('#soaSectionWrapper').hide();" value="0">Individual</option>
                   <!--<option onclick="$('#soaSectionWrapper').show();" value="1">By Section</option>-->
               </select>
            </div>
             <div class="form-group" style="display: none;" id="soaSectionWrapper">
                 <?php
                    $section = Modules::run('registrar/getAllSection');
                 ?>
                 <label>Select Section</label>
                <select id="soaSection" style="width:100%;">
                    <?php foreach($section->result() as $sec): ?>
                    <option value="<?php echo $sec->section_id ?>"><?php echo strtoupper($sec->level.' - '.$sec->section) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input style="margin-right: 10px;" class="form-control" name="inputDdate" type="text" data-date-format="yyyy-mm-dd" id="inputDdate" placeholder="Due Date" required>

            </div>
         </div>
        <div class="panel-footer clearfix">
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>
            <a href='#'data-dismiss='modal' onclick='printSOA()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Generate</a>
        </div>
     </div>
</div>


<script type="text/javascript">
    
    function showSOAForm()
    {
        $('#printSOA').modal('show');
        $('#inputDdate').datepicker();
    }
    
    function printSOA()
    {
        var option = $('#soaOption').val();
        var secIn = '';
        var date = $('#inputDdate').val();
        if(option==0)
        {
            secIn = '<?php echo base64_encode($student->uid) ?>';
        }else{
            secIn = $('#soaSection').val();
        }
        var url = '<?php echo base_url('finance/finance_lma/printSOA/') ?>'+option+'/'+secIn+'/'+date;
        window.open(url, '_blank');
    }
    
    $(document).ready(function(){
        var sum = 0;
        var bal = 0;
        // iterate through each td based on class and add the values
        $(".due").each(function() {

            var value = $(this).attr('val');
             //alert(value)
            // add only if the value is number
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
               
            }
            
        });
        
        $('#totalDue').html(numberWithCommas(sum.toFixed(2)));
        
        $(".balance").each(function() {

            var value = $(this).attr('val');
             //alert(value)
            // add only if the value is number
            if(!isNaN(value) && value.length != 0) {
                bal += parseFloat(value);
               
            }
            
        });
        
        $('#totalBalance').html(numberWithCommas(bal.toFixed(2)))
    });
    
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    
</script>