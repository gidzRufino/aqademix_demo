<table class="table table-striped">
    <tr>
        <th></th>
        <th style="width: 20%;">Item Description</th>
        <th class="text-right">Charge</th>
        <th class="text-right">Payments</th>
        <th class="text-right">Balance</th>
        <th style="width: 20%;" class="text-right">Amount</th>
    </tr>
    <tbody id="itemBody">
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
                
                $overAllCharges = $totalCharges;
                
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
               
            if($dpBalance > 0):
                ?>
                 <tr id="trp_2" tr_val="" totalvalue="">
                     <td id="control_2"  class="text-center"><input td_id ="2" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                     <td>DOWNPAYMENT</td>
                     <td class="text-right"><?php echo number_format($downpayment,2,".",",")  ?></td>
                     <td class="text-right"><?php echo number_format($dpPayment,2,".",",") ?></td>
                     <td class="text-right"><?php echo number_format($dpBalance,2,".",",") ?></td>
                     <td id="due_2" class="text-right editable_2"  tdValue="0"></td>
                 </tr>
                 <?php
            endif;
            $rm = $totalPayment;
            $remainingBalance = $remainingFee - $rm;
            if($remainingBalance > 0):
                ?>
                <tr id="trp_1" tr_val="" totalvalue="">    
                    <td id="control_1"  class="text-center"><input td_id ="1" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                    <td>TUITION</td>
                    <td class="text-right"><?php echo number_format($remainingFee,2,".",",")  ?></td>
                    <td class="text-right"><?php echo number_format($totalPayment,2,".",",") ?></td>
                    <td class="text-right"><?php echo number_format($remainingBalance,2,".",",") ?></td>
                    <td id="due_1" class="text-right editable_1"  tdValue="0"></td>
                </tr>
                <?php
            endif;
            $schoolBusCharges = Modules::run('finance/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                
            $schoolBusPayment = Modules::run('finance/finance_lma/getSchoolBusPayment', $student->uid);
            foreach ($schoolBusPayment->result() as $sbp):
                $schoolBusTotal += $sbp->t_amount;
            endforeach;
                
                $sbusRM = $schoolBusTotal;
            
            if($schoolBusCharges->num_rows()>0):
                foreach ($schoolBusCharges->result() as $ec):
                    if($ec->category_id==6):
                        $sbusPayment = 0;
                            if($sbusRM > 0):
                                $sbusPayment = $ec->extra_amount;
                            endif;
                            $sbusBalance = $ec->extra_amount-$sbusPayment;
                        
                        if($sbusBalance > 0):
                            ?>
                            <tr id="trp_<?php echo $ec->extra_item_id ?>" tr_val="" totalvalue="">    
                                <td id="control_<?php echo $ec->extra_item_id ?>"  class="text-center"><input td_id ="<?php echo $ec->extra_item_id ?>" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                                <td><?php echo strtoupper($ec->item_description) ?></td>
                                <td class="text-right"><?php echo number_format($ec->extra_amount,2,".",",")  ?></td>
                                <td class="text-right"><?php echo number_format($sbusPayment,2,".",",") ?></td>
                                <td class="text-right"><?php echo number_format($sbusBalance,2,".",",") ?></td>
                                <td id="due_<?php echo $ec->extra_item_id ?>" class="text-right editable_<?php echo $ec->extra_item_id ?>"  tdValue="0"></td>
                            </tr>
                            <?php
                        endif;    
                            
                            $sbusRM = $sbusRM - $ec->extra_amount;
                    endif;
                endforeach;
            endif;
            
                if($penCharges->num_rows()>0):
                    foreach ($penCharges->result() as $pen):
             ?>
                <tr id="trp_pen_<?php echo $pen->pen_id.'_'.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?>" tr_val="" totalvalue="">    
                    <td id="control_pen_<?php echo $pen->pen_id.'_'.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?>"  class="text-center"><input td_id ="pen_<?php echo $pen->pen_id.'_'.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?>" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                    <td><?php echo 'Penalty '.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?></td>
                    <td class="text-right"><?php echo number_format($pen->pen_amount,2,".",",")  ?></td>
                    <td class="text-right"><?php echo number_format(0,2,".",",") ?></td>
                    <td class="text-right"><?php echo number_format(0,2,".",",") ?></td>
                    <td id="due_pen_<?php echo $pen->pen_id.'_'.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?>" class="text-right editable_pen_<?php echo $pen->pen_id.'_'.date('F', strtotime(date('Y-'.$pen->pen_month.'-d')))?>"  tdValue="0"></td>
                </tr>
             <?php
                    endforeach;
                endif;
             
             ?>    
    </tbody>
</table>

 <div class="bg-success clearfix" style="padding-top:10px;">
     <div class="form-group col-lg-3">
        <label>TOTAL</label>
        <input class="text-center" value="0" style="font-size: 25px; font-weight: bold; color: red; width: 100%;" name="pttAmount" id="pttAmount" disabled>
    </div>
     <div class="form-group col-lg-3">
        <label class="control-label" for="input">AMOUNT TENDER</label>
        <input class="text-center" style="font-size: 25px; font-weight: bold; color: green; width: 100%;" name="ptAmountTendered" id="ptAmountTendered" onblur="cash_change()" required>

    </div> 
    <div class="form-group col-lg-3">
        <label>CHANGE</label>
        <input class="text-center" style="font-size: 25px; font-weight: bold; color: blue; width: 100%;" name="ptChange" id="ptChange" disabled>
    </div>
     <div class="form-group col-lg-3">
        <button type="button" class="btn btn-success" id="paynow" onclick="$('#confirmPayment').modal('show') " style="width: 100%;"><i class="fa fa-thumbs-up fa-lg fa-fw"></i><b>PAY NOW!!!</b></button>
        <button type="button" class="btn btn-danger" onclick="$('#pttAmount').val(0)" style="width: 100%; margin-top: 10px;"><b><i class="fa fa-times fa-lg fa-fw"></i>C L E A R</b></button>
         
     </div>
 </div>
<script type="text/javascript">
var total = 0;

$(function () { 
    
    $('.form-check-input').click(function()
    {
        if($(this).is(':checked'))
           { 
            var id = $(this).attr('td_id');
            var OriginalContent = $('.editable_'+id).attr('tdValue'); 
            $('.editable_'+id).addClass("cellEditing"); 
            $('.editable_'+id).html("<input  type='text' style='height:30px; text-align:center' value='' />"); 
            $('.editable_'+id).children().first().focus(); 
            $('.editable_'+id).children().first().keypress(function (e) 
                { if (e.which == 13) 
                    { 
                        var newContent = $(this).val(); 
                        calculate(newContent, 'add')
                        $('.editable_'+id).attr('tdValue', newContent);
                        $('#trp_'+id).attr('tr_val', id+'_'+newContent)

                        $(this).parent().html(numberWithCommas(parseFloat(newContent).toFixed(2))); 
                        $(this).parent().removeClass("cellEditing");
                    }
                });
            
        }else{
            var id = $(this).attr('td_id');
            var OriginalContent = $('.editable_'+id).attr('tdValue');
            
            calculate(OriginalContent, 'minus');
            $('.editable_'+id).attr('tdValue', 0)
            $('.editable_'+id).html('');
            $('#trp_'+id).attr('tr_val','');
            
        }
        
    });
    
    
    function calculate(value, option)
    {
        if(option=='add')
        {
            total = parseFloat(total) + parseFloat(value);
        }else{
            total = parseFloat(total) - parseFloat(value);
            
        }    
        $('#pttAmount').val(numberWithCommas(total.toFixed(2)));
    }
})


    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
  
</script>  
    