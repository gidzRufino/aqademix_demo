<?php 
    $i = 1;
    foreach ($asTransactions as $trans): ?>
        <tr class="<?php echo $trans->as_je_num ?>" onmouseover="$('#deleteController').val('<?php echo $trans->as_je_num ?>')">
            <td><?php echo $i++ ?></td>
            <td class="text-center"><?php echo date('F d, Y', strtotime($trans->as_trans_date)) ?></td>
            <td class="text-center"><?php echo $trans->coa_name ?></td>
            <td class="text-right debit" tdValue="<?php echo ($trans->as_trans_type?$trans->as_trans_amount:0) ?>"><?php echo ($trans->as_trans_type? number_format($trans->as_trans_amount,2,'.',','):'---') ?></td>
            <td class="text-right credit" tdValue="<?php echo ($trans->as_trans_type?$trans->as_trans_amount:0) ?>"><?php echo ($trans->as_trans_type==0?number_format($trans->as_trans_amount,2,'.',','):'---') ?></td>
            <td><button onclick="$('#confirmDeleteModal').modal('show')" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash"></i></button></td>
        </tr>
<?php endforeach;?>
        <input type="hidden" id="deleteController" />
        <input type="hidden" id="jeDetailsDateFrom" value="<?php echo $dateFrom ?>" />
        <input type="hidden" id="jeDetailsDateTo" value="<?php echo $dateTo ?>" />
        
        

