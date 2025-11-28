<?php
$students = explode(',', base64_decode($st_ids));
$totalBalance = 0;
$overAll = 0;
foreach ($students as $s):
    $student = Modules::run('registrar/getSingleStudent', $s, $school_year);
    if($student->u_id==""):
        $user_id = $student->us_id;
    else:
        $user_id = $student->u_id;
    endif;

    $plan = Modules::run('api/finance_api/getPlanByCourse', $student->grade_id, 0);
    $charges = Modules::run('api/finance_api/financeChargesByPlan',0, $school_year, 0, $plan->fin_plan_id );
    //$addCharge = Modules::run('college/finance/financeChargesByPlan',NULL, $student->school_year, 0 );
    $financeAccount = Modules::run('api/finance_api/getFinanceAccount', $student->u_id);   

    $AD = json_decode(Modules::run('api/finance_api/getRunningBalance', base64_encode($s), $school_year));
    $balance = $AD->charges - $AD->payments;
    $totalBalance += $balance;

?>
    <div class="col-xs-12 no-padding">
        <div class="panel panel-green no-margin">         
           <div class="panel-heading">
              <div class="row">
                 <div class="col-xs-5">
                   <h3><b><span><?php echo $student->firstname ?></span></b></h3>  
                 </div>
                 <div class="col-xs-7 text-right">
                    <div><h3><b class="partialTotal" val="<?php echo ($totalBalance<=0?0:$totalBalance)?>"><?php echo number_format(($totalBalance<=0?0:$totalBalance), 2)?></b></h3></div>
                    <div>Running Bill </div>
                 </div>
              </div>
           </div>
            <div class="panel-footer clearfix no-padding">
                <button onclick="$('#finChargeDetails').modal('show')" class="btn btn-large btn-danger" style="width:50%; border-radius: 0; height: 50px;"><h4><strong>View Charges</strong></h4></button>
                <button onclick="$('#finPaymentDetails').modal('show')" class="btn btn-large btn-warning pull-right" style="width:50%; border-radius: 0; height: 50px;"><h4><strong>View Payment</strong></h4></button>
            </div>
        </div>
     </div>
    <div id="finChargeDetails" class="modal fade col-xs-12" style="margin:20px auto 0; float: none !important" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="panel panel-red">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="text-center">Finance Charges</h4> 
            </div>
             <div class="panel-body">
               <table class="table table-hover table-striped">
                        <tr>
                            <th style="width:10%;">#</th>
                            <th style="width:50%;">Particulars</th>
                            <th style="width:40%; text-align: right;">Amount</th>
                        </tr>
                        <tbody id="finChargesBody">
                        <?php
                        $i=1;
                        $total=0;
                        $amount=0;

                        foreach ($charges as $c):
                             $next = $c->school_year + 1;
                                ?>
                               <tr id="tr_<?php echo $c->charge_id ?>">
                                   <td><?php echo $i++;?></td>
                                   <td><?php echo $c->item_description ?></td>
                                   <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
                               </tr>
                               <?php
                                   $total += $c->amount;
                                   endforeach;
                                   $totalExtra = 0;
                                   $extraCharges = Modules::run('api/finance_api/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                                   $previousYear = Modules::run('api/finance_api/getExtraFinanceCharges', $user_id, 0, ($student->school_year-1));
                                   //print_r($previousYear->result());
                                   if($extraCharges->num_rows()>0):
                                       foreach ($extraCharges->result() as $ec):
                                       ?>
                                           <tr style="background: #0ff !important;" id="trExtra_<?php echo $ec->extra_id ?>"
                                               >
                                               <td style="background: #0ff !important;"><?php echo $i++;?></td>
                                               <td style="background: #0ff !important;"><?php echo $ec->item_description?></td>
                                               <td style="background: #0ff !important;" id="td_<?php echo $ec->extra_id ?>" class="text-right"><?php echo number_format($ec->extra_amount, 2, '.',',') ?></td>
                                           </tr>
                                       <?php
                                       $totalExtra += $ec->extra_amount;
                                       endforeach;

                                       $total = $total + $totalExtra;
                                   endif;
                                   if($previousYear->num_rows()>0):
                                       foreach ($previousYear->result() as $es):
                                       ?>
                                           <tr style="background: #0ff !important;" id="trExtra_<?php echo $es->extra_id ?>"
                                              >
                                               <td style="background: #0ff !important;"><?php echo $i++;?></td>
                                               <td style="background: #0ff !important;"><?php echo $es->item_description?></td>
                                               <td style="background: #0ff !important;" id="td_<?php echo $es->extra_id ?>" class="text-right"><?php echo number_format($es->extra_amount, 2, '.',',') ?></td>
                                           </tr>
                                       <?php
                                       $totalExtra += $es->extra_amount;
                                       endforeach;
                                       $total = $total + $totalExtra;
                                   endif; 

                                   if($total!=0):
                               ?>
                               <tr style="background:yellow;">
                                   <th>TOTAL</th>
                                   <th></th>
                                   <th class="text-right"><?php echo number_format($total, 2, '.',',') ?></th>
                                   <th></th>
                               </tr>
                               <?php endif; ?>

                     </tbody>
               </table>        
             </div>
         </div>
    </div>
    <div id="finPaymentDetails" class="modal fade" style="margin:20px 10px 0; float: none !important" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="panel panel-yellow">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="text-center">Payment History</h4> 
            </div>
             <div class="panel-body">
               <table class="table table-hover table-striped">
                        <?php
                                $transaction = Modules::run('api/finance_api/finance/getTransaction', $student->uid, 0, $student->school_year);
                                $paymentTotal = 0;
                                $i = 1;
                                if($transaction->num_rows()>0):
                                    $balance = 0;
                                    foreach ($transaction->result() as $tr):
                                        $i++;
                        ?>

                                    <?php
                                            $total = $total - $tr->t_amount ;
                                        if($tr->t_type==2):
                                            $discounts = Modules::run('api/finance_api/getDiscountsByItemId', $student->uid, 0, $student->school_year, $tr->disc_id);
                                    ?>
                                    <tr>
                                        <td style="width:50%;"><?php echo $tr->t_date ?></td>
                                        <td style="width:50%;"><?php echo $tr->item_description?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;"></td>
                                        <td  style="width:50%;"><?php echo '( '.number_format($tr->t_amount, 2, '.',',').' )'?></td>
                                    </tr>
                                    <?php
                                        else:
                                    ?>
                                    <tr>
                                        <td style="width:50%;"><?php echo $tr->t_date ?></td>
                                        <td style="width:50%;"><?php echo $tr->item_description?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;"></td>
                                        <td style="width:50%;"><?php echo number_format($tr->t_amount, 2, '.',',')?></td>
                                    </tr>
                                    <?php

                                        endif;
                                        $paymentTotal = $total;
                                    endforeach;
                                    if($paymentTotal!=0):
                                    ?>

                                    <tr style="background:yellow;">
                                        <th colspan="2" style="background:yellow;" class="text-right"><?php echo number_format($paymentTotal, 2, '.',',') ?></th>

                                    </tr>
                                    <?php
                                    endif;
                                 endif;   
                                ?>


                </table>  
             </div>
         </div>
    </div>
<?php
  
  unset($totalBalance);
endforeach;
?>

<div class="col-xs-12 no-padding">
    <div class="panel panel-primary">         
       <div class="panel-heading">
          <div class="row">
             <div class="col-xs-5">
               <h3><b>Total Balance</b></h3>  
             </div>
             <div class="col-xs-7 text-right">
                 <div><h3><b id="totalBill"></b></h3></div>
             </div>
          </div>
       </div>
    </div>
 </div>

<script type="text/javascript">
var total = 0
$('.partialTotal').each(function(){
    total += parseFloat($(this).attr('val'));
})


    $('#totalBill').html(numberWithCommas(total.toFixed(2)));



    function numberWithCommas(x) {
        if(x==null){
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>    