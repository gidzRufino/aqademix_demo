<div class="col-lg-12">
    <div class='panel panel-red'>
        <div class='panel-heading clearfix'>
            <h5 class="pull-left">Student Billing Status History</h5>
            <button onclick="showSOAForm()" class="btn btn-warning pull-right"><i class="fa fa-print fa-2x"></i></button>
        </div>
        <div class='panel-body'>
            <table class="table">
                <tr>
                    <th style="width:18%;">Charge Description</th>
                    <th style="width:15%;" class="text-right">Amount</th>
                    <th  class="text-center">Month</th>
                    <th class="text-right">Payments</th>
                    <th class="text-right">Balance</th>
                    <th class="text-right">Amount Due</th>
                    <th class="text-center">Status</th>
                </tr>
                <?php 
                $yearlyPayment = 38000;
                $totalExtra = 0;
                $isPriviledge = FALSE;
                $totalCharges = 0;
                $totalDiscount = 0;
                $totalPayment = 0;
                $penalty = 0;
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
                $totalMonth = 12;
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
                    
                    $totalPayment = $totalPayment+$totalDiscount;
               endif;
               
               
               if($totalPayment>$downpayment):
                   $dpPayment = $downpayment;
               else:
                   $dpBalance = $downpayment - $totalPayment;
                   $dpPayment = $downpayment - $dpBalance;
               endif;
               
               $dpBalance = $downpayment - $dpPayment;
               
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
                   $totalPayment = $totalPayment-$dpPayment;
               endif;
               
                ?>
                <tr class="<?php echo $color ?>">
                    <td style="width:15%;">DOWNPAYMENT</th>
                    <td style="width:15%;" class="text-right"><?php echo number_format($downpayment,2,".",",")  ?></td>
                    <th class="text-right"></td
                    <td class="text-right"></td>
                    <td class="text-right"><?php echo number_format($dpPayment,2,".",",")  ?></td>
                    <td class="text-right"><?php echo number_format($dpBalance,2,".",",")  ?></td>
                    <td class="text-right"><?php echo number_format($dpDue,2,".",",")  ?></td>
                    <td class="text-center"><?php echo $status ?></td>
                </tr>
                <?php
                    $tfpayment = 0;
                    $atfpayment = 0;
                    $ptfpayment = 0;
                    $previousBalance = 0;
                    $overAllTFCharges = 0;
                    $overAllDue = 0;
                    
                    for($i = 1; $i<=$numMonth; $i++):
                        if($btype==3):
                            $monthNums = ($i+$addMonth);
                        else:
                            $monthNums = (($i+5)+$addMonth);
                        endif;
                        $monthNum = ($monthNums>12?$monthNums-12:$monthNums);
                        $monthNum = ($monthNum < 10?'0'.$monthNum:$monthNum);
                        
                        $apayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums+1));
                        $atfpayment = $apayment->amount;

                        $ppayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums-1));
                        $ptfpayment = $ppayment->amount;

                        $tpayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, $monthNums);
                        $tfpayment = $tpayment->amount;
                        
                        $expectedPayment = ($monthlyFee * $i);
                        $totalBalance = $totalPayment;
                        $totalBalance = $expectedPayment - $totalBalance;
                            
                       
                        if($totalPayment>0):  
                            if($tfpayment==0):
                                if($totalPayment>$expectedPayment):
                                    $tfpayment = $monthlyFee;
                                else:
                                    if($ptfpayment!=0):
                                    if(($monthlyFee - $totalPayment)>0):
                                            $tfpayment = $expectedPayment - $totalTFPayment;
                                        else:
                                            $tfpayment = $expectedPayment - $totalTFPayment; 
                                        endif;
                                    else:
                                            $tfpayment = $monthlyFee-$totalBalance; 
                                            if($tfpayment<=0):
                                                $tfpayment = 0;
                                            endif;
                                    endif;
                                    
                                endif;
                            else:
                                if($i==1):
                                    echo $totalPayment;
                                endif;
                            endif;    
                        endif;
                        
                        $totalDue = $monthNums<=$currentMonth?$monthlyFee-$tfpayment:0;
                        
                        $color = $monthNums<$currentMonth?$totalDue>0?'alert-danger':'alert-success':'alert-info';
                        $color = ($totalPayment>=$expectedPayment?'alert-success':$monthNums<=$currentMonth?$totalDue==0?'alert-success':'alert-info':'alert-info');
                        $status = ($totalPayment>=$expectedPayment?'Paid':'Unpaid');
                        $m = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
                        if(strtotime($m->row()->bill_date) < strtotime(date('Y-m-d'))):
                            if($totalDue>0):
                                $color = 'alert-danger';
                                $status = 'Overdue';
                                if($isPriviledge):
                                    $penalty = $mop->special_penalty;
                                else:
                                    $penalty = $mop->regular_penalty;
                                endif;
                                Modules::run('finance/billing/savePenalty', $student->uid,$monthNum,$penalty, $this->session->school_year);
                            
                            endif;
                        endif;
                        if($monthNums>$currentMonth):
                            $penalty = 0;
                        endif;
                        
                    if($i < 11):
                        ?>
                            <tr class="<?php echo $color ?>">
                                <td style="width:15%;">TUITION</td>
                                <td style="width:15%;" class="text-right"><?php echo number_format($monthlyFee,2,'.',',') ?></td>
                                <td class="text-center"><?php echo date('F', strtotime(date('Y-'.$monthNum.'-01'))) ?></td>
                                <td class="text-right"><?php echo number_format($tfpayment,2,".",",")  ?></td>
                                <td class="text-right"><?php echo number_format($monthlyFee-$tfpayment,2,'.',',') ?></td>
                                <td class="text-right"><?php echo number_format($totalDue+$penalty,2,".",",")  ?></td>
                                <td class="text-center"><?php echo $status ?></td>
                            </tr>
                        <?php
                    endif;
                    switch ($btype):
                        case 1:
                            $addM = 0;
                        break;    
                        case 2:
                            $addM = 1;
                        break;    
                        case 3:
                           $addM = 3;
                        break;    
                    endswitch;
                   $addMonth = $addMonth + $addM;
                    endfor;
                    
                $schoolBusCharges = Modules::run('finance/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                
                if($paymentTransaction->num_rows()>0):
                    $balance = 0;
                    foreach ($paymentTransaction->result() as $tr):
                        if($tr->t_type<2 && $tr->category_id==6):
                            $totalSBusPayment += $tr->t_amount;
                        endif;
                    endforeach;
                endif;
                
                
                if($schoolBusCharges->num_rows()>0):
                    foreach ($schoolBusCharges->result() as $ec):
                        if($ec->category_id==6):
                            $totalSchoolbus += $ec->extra_amount;
                        
                            $monthName = explode('-', $ec->item_description);
                            if($totalSBusPayment >= $totalSchoolbus):
                                $sbusPayment = $ec->extra_amount;
                                $balance = 0;
                            endif;
                            $color = ($totalSBusPayment>=$totalSchoolbus?'alert-success':$monthNums<=$currentMonth?$totalDue==0?'alert-success':'alert-info':'alert-info');
                            $status = ($totalSBusPayment>=$totalSchoolbus?'Paid':'Unpaid');
                                                    ?>
                        <tr class="<?php echo $color ?>">
                            <td style="width:15%;"><?php echo $ec->item_description ?></td>
                            <td style="width:15%;" class="text-right"><?php echo number_format($ec->extra_amount,2,'.',',') ?></td>
                            <td class="text-center"><?php echo $monthName[1];  ?></td>
                            <td class="text-right"><?php echo $sbusPayment; ?></td>
                            <td class="text-right"><?php echo number_format($balance,2,".",",")  ?></td>
                            <td class="text-right"><?php echo number_format(0,2,".",",")  ?></td>
                            <td class="text-center"><?php echo $status ?></td>
                        </tr>
                        <?php
                        
                        endif;
                    endforeach;
                    $overAllCharges += $totalSchoolbus;
                endif;
                    $overAllBalance = ($overAllCharges) - ($totalPayment+$dpPayment);
                    
                ?>
                    <tr>
                        <th style="width:15%;">TOTAL</th>
                        <th style="width:15%;" class="text-right"><?php echo number_format($overAllCharges,2,'.',',') ?></th>
                        <th class="text-center"></th>
                        <th class="text-right"><?php echo number_format($totalPayment+$dpPayment,2,".",",")  ?></th>
                        <th class="text-right"><?php echo number_format($overAllBalance,2,".",",")  ?></th>
                        <th class="text-center"></th>
                    </tr>
                
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