<?php 
$transaction = Modules::run('college/finance/getTransactionByDate', $student->uid, $student->semester, $student->school_year, $details->t_date);

foreach ($transaction->result()  as $tt):
    if($tt->t_type!=2):
        $subtotal += $tt->t_amount ;
    endif;
endforeach;
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix pointer" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $details->trans_id ?>" aria-expanded="true" aria-controls="collapseOne">
      <h4 class="panel-title">
          <div class="col-lg-2">
            <?php echo $details->t_date ?>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-2 no-padding">
              <span class="pull-right"><?php echo ($details->t_type==2?'( '.number_format($subtotal,2,'.',',').' )':number_format($subtotal,2,'.',',')) ?></span>
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
                if($transaction->num_rows()>0):
                    foreach ($transaction->result() as $tr):
                        
                        if($tr->t_type!=2):
                                ?>
                                    <div class="col-lg-12 no-padding" 
                                         data-toggle="context" data-target="#otherMenu" 
                                         onmouseover="$('#delete_trans_type').val('<?php echo $details->t_type ?>'),$('#delete_trans_id').val('<?php echo $details->trans_id ?>'), $('#delete_item_id').val('<?php echo $details->t_charge_id ?>')">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-3"><?php echo $tr->ref_number ?></div>
                                        <div class="col-lg-3"><?php echo ($tr->fused_category==0?$tr->item_description:$tr->fin_category) ?></div>
                                        <div class="col-lg-2 no-padding"><span class="pull-right"><?php echo number_format($tr->t_amount, 2, '.',',')?></span></div>
                                        <div class="col-lg-2 no-padding"><span class="pull-right"></span></div>
                                        <div class="col-lg-2"><?php echo $tr->t_remarks ?></div>
                                    </div>


                              <?php  
                        endif;
                    endforeach;
                endif;
          ?>
      </div>
    </div>
  </div>