<div class="form-group">
    <label>Finance Item</label> <br />
    <select style="width:90%;"  name="editFinItems" id="editFinItems" required>
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
                <option <?php echo $selected ?> id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo strtoupper($i->item_description); ?></option>
        <?php }?>
    </select>   
</div>
<div class="form-group">
    <label>Reference #</label>
<input type="text" id="editRefNumber" onclick="$(this).val('')" value="<?php echo $transaction->ref_number?>" class="form-control"  placeholder="OR Number" />
</div>
<div class="form-group">
    <label>Receipt Type</label>
    <?php switch ($transaction->t_receipt_type):
        case 0:
            $or = "selected";
            $ar = "";
            $tr = "";
        break;    
        case 1:
            $ar = "selected";
            $or = "";
            $tr = "" ;       
        break;    
        case 2:
            $tr = "selected";
            $or = "";
            $ar = "";
        break;
        default:
            $tr = "";
            $or = "";
            $ar = "";
            
        break;    
    endswitch;
    ?>
    
    <select style="color: black;" tabindex="-1" id="inputEditReceipt" name="inputReceipt"  class="col-lg-12">
       <option <?php echo $or ?> value="0">Official Receipt</option>
       <option <?php echo $ar ?> value="1">Acknowledgment Receipt</option>
       <option <?php echo $tr ?> value="2">Temporary Receipt</option>

   </select>
</div>
<div class="form-group">
    <label class="control-label" for="input">Transaction Date</label>
    <input class="form-control" name="editTransactionDate" type="text" value="<?php echo $transaction->t_date ?>" data-date-format="yyyy-mm-dd" id="editTransactionDate" placeholder="<?php echo $transaction->t_date ?>" required>
</div> 
<div class="form-group">
    <label>Amount</label>
    <input type="text" id="editTransAmount" onclick="$(this).val('')" class="form-control" value="<?php echo $transaction->t_amount ?>" placeholder="Amount" />
</div>

<input type="hidden" id="edit_trans_id" value="<?php echo $transaction->trans_id ?>" />