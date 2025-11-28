<?php
switch ($year):
    case 1:
        $year_level = 'First Year';
    break;
    case 2:
        $year_level = 'Second Year';
    break;
    case 3:
        $year_level = 'Third Year';
    break;
    case 4:
        $year_level = 'Fourth Year';
    break;
    case 5:
        $year_level = 'Fifth Year';
    break;
endswitch;
?>
<table class='table table-hover table-striped'>
    <tr>
        <th class="text-center" colspan="4"><?php echo $year_level; ?></th>
        <th>
            <div class="btn-group pull-right" role="group" aria-label="">
                <button title="Set Finance Charges" class="btn btn-xs btn-info" onclick="setFinanceCharges($('#selectCourse').val(), '<?php echo $year ?>')"><i class="fa fa-plus fa-fw"></i></button>
                <button title="Print Finance Charges" class="btn btn-xs btn-success" onclick="printFinanceCharges($('#selectCourse').val(), '<?php echo $year ?>')"><i class="fa fa-print fa-fw"></i></button>
            </div>
        </th>
    </tr>
    <tr>
        <td style="width:5%;">#</td>
        <td style="width:25%;">Particulars</td>
        <td style="width:20%; text-align: right;">Amount</td>
        <td style="width:20%; text-align: right;">School Year</td>
        <td style="width:20%; text-align: right;">Option</td>
    </tr>
    <tbody id="tbd_1">
        <?php
        $i=1;
        $total=0;
            foreach ($charges as $c):
             $next = $c->school_year + 1;
         ?>
        <tr id="tr_<?php echo $c->charge_id ?>">
            <td><?php echo $i++;?></td>
            <td><?php echo $c->item_description ?></td>
            <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($c->amount, 2, '.',',') ?></td>
            <td class="text-right"><?php echo $c->school_year.' - '.$next ?></td>
            <td class="text-right">
                <div class="btn-group" role="group" aria-label="">
                    <button title="Edit Item" class="btn btn-xs btn-warning" onclick="editFinItem('<?php echo $c->item_description ?>', '<?php echo $c->amount ?>','<?php echo $c->charge_id ?>')"><i class="fa fa-pencil-square-o fa-fw"></i></button>
                    <button title="Delete Item" class="btn btn-xs btn-danger" onclick="$('#deleteFinCharges').modal('show'), $('#del_charge_id').val('<?php echo $c->charge_id ?>')"><i class="fa fa-trash fa-fw"></i></button>
                </div>
            </td>
        </tr>
        <?php
            $total += $c->amount;
            endforeach;
            if($total!=0):
        ?>
        <tr>
            <th>TOTAL</th>
            <th></th>
            <th class="text-right"><?php echo number_format($total, 2, '.',',') ?></th>
            <th></th>
        </tr>
        <?php endif; ?>
    </tbody>
</table>