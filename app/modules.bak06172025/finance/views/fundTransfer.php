
<?php
    $attributes = array('class' => '','role'=>'form', 'id'=>'fundTransferForm');
    echo form_open(base_url().'finance/finance_pisd/processFundTransfer', $attributes);
?>
    <div class="form-group">
        <label>Transfer To Account &nbsp;<small class="text-info">Note: Leave Blank if transferring to Same Account</small></label> <br />
         <div class="input-group col-lg-12">
            <input onkeyup="searchTransferAccount(this.value)" id="searchTransferBox" class="form-control" type="text" placeholder="Search Name Here" />
            <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchTransferName">

            </div>
            <div class="input-group-btn">
              <button style="height: 34px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnTransferControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year.' - '.($school_year+1) ?> <span class="caret"></span></button>
              <ul class="dropdown-menu dropdown-menu-right">
                    <?php $ro_years = Modules::run('registrar/getROYear');

                        foreach ($ro_years as $ro)
                        {   
                          $roYears = $ro->ro_years+1;

                    ?>    
                            <li onclick="$('#btnTransferControl').html('<?php echo $ro->ro_years.' - '.$roYears; ?>  <span class=\'caret\'></span>'), $('#transferSchoolYearTo').val('<?php echo $ro->ro_years ?>')"><a href="#"><?php echo $ro->ro_years.' - '.$roYears; ?></a></li>
                    <?php } ?>
              </ul> 
            </div><!-- /btn-group -->
        </div>
    </div>


    <div class="form-group">
        <label>Transfer Item to</label> <br />
        <select style="width:90%;"  name="transferItemTo" id="transferItemTo" required>
          <option value="0">Select Item</option> 
            <?php 
                   foreach ($fin_items as $i)
                     {   
                       if($i->item_id==$transaction->t_charge_id):
                           $selected = 'selected="selected"';
                       else:
                           $selected = '';
                       endif;
               ?>                        
                    <option onclick="$('#transferItemNameTo').val('<?php echo strtoupper($i->item_description); ?>')" <?php echo $selected ?> id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo strtoupper($i->item_description); ?></option>
            <?php }?>
        </select>   
          <input type="hidden" name="transferItemFrom" id="transferItemFrom" value="<?php echo $transaction->t_charge_id ?>" />
          <input type="hidden" name="transferItemNameFrom" id="transferItemNameFrom" value="<?php echo strtoupper($transaction->item_description) ?>" />
          <input type="hidden" name="transferItemNameTo" id="transferItemNameTo" value="<?php echo strtoupper($transaction->item_description) ?>" />
    </div>
    <div class="form-group">
    <input type="hidden" name="transferPaymentType" id="transferPaymentType" value="<?php echo $transaction->t_type ?>" />
    <input type="hidden" name="transferSchoolYear" id="transferSchoolYear" value="<?php echo $school_year ?>" />
    <input type="hidden" name="transferSchoolYearTo" id="transferSchoolYearTo" value="<?php echo $school_year ?>" />
    <input type="hidden" name="transferSTIDFrom" id="transferSTIDFrom" value="<?php echo $st_id ?>" />
    <input type="hidden" name="transferSTID" id="transferSTID" value="<?php echo $st_id ?>" />
    <input type="hidden" name="transferRefNumber" id="transferRefNumber"  value="<?php echo $transaction->ref_number?>" class="form-control"  placeholder="OR Number" />
    <input type="hidden" name="transferReceiptType" id="transferReceiptType"  value="<?php echo $transaction->t_receipt_type?>" class="form-control" />
    <input type="hidden" name="transferAmountFrom" id="transferAmountFrom"  value="<?php echo $transaction->t_amount?>" class="form-control" />
    <input type="hidden" name="transferNameFrom" id="transferNameFrom"  value="<?php echo $name ?>" class="form-control" />
    <input type="hidden" name="transferNameTo" id="transferNameTo"  value="<?php echo $name ?>" class="form-control" />
    </div>

    <div class="form-group">
        <label>Transfer Amount</label>
        <input type="text" name="transferedAmount" id="transferedAmount" onclick="$(this).val('')" class="form-control" value="<?php echo $transaction->t_amount ?>" placeholder="Amount" />
    </div>

    <input type="hidden" name="transfer_trans_id" id="transfer_trans_id" value="<?php echo $transaction->trans_id ?>" />
</form>
<script type="text/javascript">
    
    function processFundTransfer()
    {
        var data = $('#fundTransferForm').serialize();
       
        var url = '<?php echo base_url().'finance/finance_pisd/processFundTransfer/' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            beforeSend: function() {
               
            },
            success: function(data)
            {
                alert(data);
                location.reload();
            }
        });

    return false;
    }
    
</script>
    