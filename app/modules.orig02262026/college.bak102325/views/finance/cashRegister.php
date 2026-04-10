<table class="table table-striped">
    <tr>
        <th></th>
        <th style="width: 20%;">Item Description</th>
        <th class="text-center">From</th>
        <th class="text-center">To</th>
        <th class="text-right">Charge</th>
        <th class="text-right">Payments</th>
        <th class="text-right">Balance</th>
        <th style="width: 20%;" class="text-right">Amount</th>
    </tr>
    <tbody id="itemBody">
        <?php 
        $chargeAmount = 0;
        $totalBalance = 0;
        $isFused = 0;
        $fusedCharges =0;
        $charges = Modules::run('college/finance/financeChargesByPlan',$year_level, $school_year, $sem, $plan_id );
        
        foreach ($charges as $c): 
            
            $discount = Modules::run('college/finance/getTransactionByCategory', $student->uid, $sem,$student->school_year,$c->category_id,2, $c->item_id);
            $totalDiscount += $discount->amount;
            
            $chargeAmount = ($c->item_id<=2?$c->amount*$totalUnits:($c->item_id==46?($c->amount*$totalSubs):$c->amount));
            
            $totalCharges += $chargeAmount;
            $inxcharges = Modules::run('college/finance/inExtraCharges', $user_id, $c->item_id);
            foreach ($inxcharges as $inxc):
                $inxcharge += $inxc->extra_amount;
            endforeach;
            if(!$inxcharges):
            else:
                $chargeAmount = $chargeAmount+$inxcharge;
            endif;
            
            $payments = Modules::run('college/finance/getTransactionByItemId', $student->uid, $sem,$school_year, $c->item_id);
            foreach ($payments->result() as $p):
                if ($p->sub_lab_fee_id == 0):
                    $totalPayments += $p->t_amount;
                endif;
            endforeach;
            
            $totalBalance = $chargeAmount - ($totalPayments+$discount->amount);
            
            if($c->is_fused):
                $isFused++;
            endif; 
//            if($c->category_id==1):
//                $due = $c->amount/10;
//                if($tfdiscounts>=$chargeAmount):
//                    $totalBalance = 0;
//                endif;
//            else:
//                $due = $totalBalance;
//            endif;
        
            if($totalBalance > 0):
                if(!$c->is_fused):
                ?>
                 <tr id="trp_<?php echo $c->item_id ?>" tr_val="" totalvalue="" isFused="0">
                     <td id="control_<?php echo $c->item_id ?>"  class="text-center"><input td_id ="<?php echo $c->item_id ?>" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                     <td><?php echo strtoupper($c->item_description) ?></td>
                     <td class="text-center">
                         <select style="width:90%;"  name="sfrom<?php echo $c->item_id ?>" id="sfrom<?php echo $c->item_id ?>" hidden required>
                            <option>From</option> 
                        
                        <?php 
                            $months = array("Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.", "Jul.", "Aug.", "Sept.", "Oct.", "Nov.", "Dec");
                            foreach ($months as $month) {
                        ?>                        
                        
                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                        
                        <?php 
                            }
                        ?>
                        
                        </select>
                     </td>  
                     <td class="text-center">
                         <select style="width:90%;"  name="sto<?php echo $c->item_id ?>" id="sto<?php echo $c->item_id ?>" hidden required>
                            <option>To</option> 
                        
                        <?php 
                            $months = array("Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.", "Jul.", "Aug.", "Sept.", "Oct.", "Nov.", "Dec");
                            foreach ($months as $month) {
                        ?>                        
                        
                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                        
                        <?php 
                            }
                        ?>
                        
                        </select>
                     </td>      
                     <td class="text-right"><?php echo number_format($chargeAmount,2,".",",") ?></td>
                     <td class="text-right"><?php echo number_format($totalPayments,2,".",",") ?></td>
                     <td class="text-right"><?php echo number_format($totalBalance,2,".",",") ?></td>
                     <td id="due_<?php echo $c->item_id ?>" class="text-right editable_<?php echo $c->item_id ?>"  tdValue="0"></td>
                 </tr>
                 <?php
                 else:
                     foreach ($charges as $c):
                        if($c->is_fused):
                            $chargeAmount = ($c->item_id<=2?$c->amount*$totalUnits:($c->item_id==46?($c->amount*$totalSubs):$c->amount));
                            $fusedCharges += $chargeAmount;

                        endif;
                    endforeach;
                     if($isFused==1):
                        $fpayments = Modules::run('college/finance/getFusedPayments', $student->uid, $sem,$school_year, $c->category_id);
                        //print_r($fpayments->result());
                        foreach ($fpayments->result() as $f):
                           $fusedPayments += $f->t_amount;
                        endforeach;
                       $fusedBalance = $fusedCharges - $fusedPayments;
                       ?>
                       <tr id="trp_<?php echo $c->item_id ?>" tr_val="" totalvalue="" isFused="<?php echo $c->category_id ?>">
                           <td id="control_<?php echo $c->item_id ?>"  class="text-center"><input td_id ="<?php echo $c->item_id ?>" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                           <td><?php echo strtoupper($c->fin_category) ?></td>
                           <td class="text-center"></td>  
                           <td class="text-center"></td>      
                           <td class="text-right"><?php echo number_format($fusedCharges,2,".",",") ?></td>
                           <td class="text-right"><?php echo number_format($fusedPayments,2,".",",") ?></td>
                           <td class="text-right"><?php echo number_format($fusedBalance,2,".",",") ?></td>
                           <td id="due_<?php echo $c->item_id ?>" class="text-right editable_<?php echo $c->item_id ?>"  tdValue="0"></td>
                       </tr>
                       <?php
                     endif;
                 endif;
                 
            endif;     
                $fusedPayments = 0;
                $totalPayments = 0; 
                $totalBalance = 0;
        endforeach;
            $totalLabPayment = 0;
            $labBalance = 0;
            foreach ($loadedSubject as $sl):
                if ($sl->sub_lab_fee_id != 0):
                    $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                    $labPayment = Modules::run('finance/finance_pisd/getTransactionByItemId', $student->uid, NULL,$school_year, $itemCharge->item_id);
                    foreach ($labPayment->result() as $labP):
                        $totalLabPayment += $labP->t_amount;
                    endforeach;
                        $labBalance = $itemCharge->default_value - $totalLabPayment;
                    ?>
                   <tr id="trp_<?php echo $itemCharge->item_id ?>" tr_val="" totalvalue="" isFused="0">
                       <td id="control_<?php echo $c->item_id ?>"  class="text-center"><input td_id ="<?php echo $itemCharge->item_id ?>" class="form-check-input" type="checkbox" value="" id="defaultCheck1"/></td>
                       <td><?php echo strtoupper($itemCharge->item_description) ?></td>
                       <td class="text-center"></td>  
                       <td class="text-center"></td>      
                       <td class="text-right"><?php echo number_format($itemCharge->default_value,2,".",",") ?></td>
                       <td class="text-right"><?php echo number_format($totalLabPayment,2,".",",") ?></td>
                       <td class="text-right"><?php echo number_format($labBalance,2,".",",") ?></td>
                       <td id="due_<?php echo $itemCharge->item_id ?>" class="text-right editable_<?php echo $itemCharge->item_id ?>"  tdValue="0"></td>
                   </tr>
                    <?php
                $totalLabPayment = 0;
                $labBalance = 0;
                endif;
            endforeach;
            $extraC = Modules::run('college/finance/getExtraFinanceChargesForCR',$user_id, $sem, $school_year);
            
            if($extraC->num_rows()>0):
                foreach ($extraC->result() as $exc):
                    $totalExtraChargePerID = Modules::run('college/finance/getExtraFinanceCharges',$user_id, $sem, $school_year, $exc->item_id);
                    
                    $mxPayments = Modules::run('finance/finance_pisd/getTransactionByItemId', $student->uid, NULL,$school_year, $exc->item_id);
                    foreach ($mxPayments->result() as $mxp):
                        $totalMxpayments += $mxp->t_amount;
                    endforeach;
                    $totalMxBalance = $totalExtraChargePerID->row()->amount - $totalMxpayments;
                    
                    //echo $totalMxpayments;
                    if($totalMxBalance > 0):
                    ?>
                    <tr id="trp_<?php echo $exc->extra_item_id ?>" tr_val="" totalvalue="">
                        <td id="control_<?php echo $exc->extra_item_id ?>"  class="text-center"><input td_id ="<?php echo $exc->extra_item_id ?>" class="form-check-input" type="checkbox" value="" id="defaultCheck2"/></td>
                        <td><?php echo strtoupper($exc->item_description) ?></td>
                        <td class="text-center">
                        </td>  
                        <td class="text-center">
                        </td>      
                        <td class="text-right"><?php echo number_format($totalExtraChargePerID->row()->amount,2,".",",") ?></td>
                        <td class="text-right"><?php echo number_format($totalMxpayments,2,".",",") ?></td>
                        <td class="text-right"><?php echo number_format($totalMxBalance,2,".",",") ?></td>
                        <td id="due_<?php echo $exc->item_id ?>" class="text-right editable_<?php echo $exc->item_id ?>"  tdValue="0"></td>
                    </tr>
                    <?php 
                    endif;
                    $totalMxpayments = 0;
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
        <input onkeypress="if(event.keyCode == 13){ payNow(), $('#confirmBtn').focus()}" class="text-center" style="font-size: 25px; font-weight: bold; color: green; width: 100%;" name="ptAmountTendered" id="ptAmountTendered" onblur="cash_change()" required>

    </div> 
    <div class="form-group col-lg-3">
        <label>CHANGE</label>
        <input class="text-center" style="font-size: 25px; font-weight: bold; color: blue; width: 100%;" name="ptChange" id="ptChange" disabled>
    </div>
     <div class="form-group col-lg-3">
        <button type="button" class="btn btn-success" id="paynow" onclick="payNow()" style="width: 100%;"><i class="fa fa-thumbs-up fa-lg fa-fw"></i><b>PAY NOW!!!</b></button>
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
            if (id==1||id==10) {
                var sfromid = '#sfrom'+id; 
                var stoid = '#sto' + id;
                $(sfromid).removeAttr('hidden');
                $(stoid).removeAttr('hidden');
            }
            var OriginalContent = $('.editable_'+id).attr('tdValue'); 
            $('.editable_'+id).addClass("cellEditing"); 
            $('.editable_'+id).html("<input  type='text' style='height:30px; text-align:center' value='' />"); 
            $('.editable_'+id).children().first().focus(); 
            $('.editable_'+id).children().first().keypress(function (e) 
                { if (e.which == 13) 
                    { 
                        var newContent = $(this).val(); 
                        var isFused = $('#trp_'+id).attr('isFused');
                        calculate(newContent, 'add')
                        $('.editable_'+id).attr('tdValue', newContent);
                        $('#trp_'+id).attr('tr_val', id+'_'+newContent+'_'+isFused)

                        $(this).parent().html(numberWithCommas(parseFloat(newContent).toFixed(2))); 
                        $(this).parent().removeClass("cellEditing");
                    }
                });
            
        }else{
            var id = $(this).attr('td_id');
            var OriginalContent = $('.editable_'+id).attr('tdValue');
            if (id==1||id==10) {
                var sfromid = '#sfrom'+id; 
                var stoid = '#sto' + id;
                $(sfromid).attr('hidden', 'hidden');
                $(stoid).attr('hidden', 'hidden');
            }
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
    