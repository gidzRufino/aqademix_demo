
<?php 
$total = 0;
$overAll = 0;
foreach($sales as $s): 
    $item = Modules::run('canteen/getItemPerDay',$s->transaction_date, $s->canteen_item_id);
    $total = ($item->item_quantity * $item->item_price);
    $overAll += $total
    ?>

    <tr>
        <td><?php echo $s->transaction_num ?></td>
        <td><?php echo $s->transaction_date ?></td>
        <td><?php echo $s->canteen_item_name ?></td>
        <td><?php echo $item->item_quantity?></td>
        <td class="text-right"><?php echo number_format($s->item_price, 2, '.',',')?></td>
        <td class="text-right"><?php echo number_format($total, 2, ".", ',')?></td>
    </tr>
<?php 
   // unset($total);
endforeach; ?>
    <tr>
        <th colspan="5"></th>
        <th class="text-right"> <?php echo number_format($overAll, 2, '.',',') ?></th>
    </tr>