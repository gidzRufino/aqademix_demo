<?php 
$transaction = Modules::run('college/finance/getTransactionByDate', $student->uid, $student->semester, $student->school_year, $details->t_date);
//print_r($transaction->result());

//foreach ($transaction->result()  as $tt):
//    if($tt->t_type==2):
//        $discounts = Modules::run('college/finance/getDiscountsById', $tr->disc_id);
//        if($discounts->dic_type==0):
//            if($discounts->disc_item_id==1):
//                $discAmount = $item_value * $discounts->disc_amount;
//            endif;
//            $subtotal += $discAmount;
//        else:
//             $subtotal += $tt->t_amount ;
//        endif;
//       
//    endif;
//endforeach;
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix pointer" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $details->trans_id ?>" aria-expanded="true" aria-controls="collapseOne">
      <h4 class="panel-title">
          <div class="col-lg-2">
            <?php echo $details->t_date ?>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-2 no-padding">
              <span class="pull-right"><?php echo ($details->t_type==2?'( '.number_format($item_value,2,'.',',').' )':number_format($item_value,2,'.',',')) ?></span>
          </div>   
          <div class="col-lg-2 no-padding">
              <span class="pull-right"><?php echo number_format(($total), 2, '.',',')?></span>
          </div>   
          <div class="col-lg-2"></div>
      </h4>
    </div>
    <div id="<?php echo $details->trans_id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
          <?php
          
                $i = 1;
                if($transaction->row()):
                    foreach ($transaction->result() as $tr):
                        if($tr->t_type==2):
                            $discounts = Modules::run('college/finance/getDiscountsById', $tr->disc_id);
                                
                                ?>                
                                <div class="col-lg-12 no-padding"
                                     data-toggle="context" data-target="#otherMenu" 
                                     delete_remarks="[ Discount type: <?php echo $tr->item_description.' - '.$discounts->disc_remarks ?>, Amount:<?php echo number_format($details->t_amount, 2, '.',',')?>]"
                                     onmouseover="$('#delete_trans_type').val('<?php echo $tr->t_type ?>'),$('#delete_trans_id').val('<?php echo $details->trans_id ?>'), $('#delete_item_id').val('<?php echo $details->t_charge_id ?>')">

                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-3"><?php echo $tr->ref_number ?></div>
                                    <div class="col-lg-3"><?php echo $discounts->schlr_type. ' Discount' ?></div>
                                    <div class="col-lg-2 no-padding"><span class="pull-right"><?php echo '( '.number_format(($tr->t_charge_id==1?$item_value:$tr->t_amount), 2, '.',',').' )'?></span></div>
                                    <div class="col-lg-2 no-padding"><span class="pull-right"></span></div>
                                    <div class="col-lg-2"><?php echo $discounts->disc_remarks ?></div>
                                </div>
          
                            <?php
                        endif;    
                    endforeach;
                endif;
          ?>
      </div>
    </div>
  </div>