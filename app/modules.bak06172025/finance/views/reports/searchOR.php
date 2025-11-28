<?php
    $teller = Modules::run('hr/getEmployee', base64_encode($orDetails->row()->t_em_id));
?>

<h3 style="margin:3px 0;">
    <span id="name" style="color:#BB0000;"><?php echo strtoupper($orDetails->row()->firstname." ". $orDetails->row()->lastname) ?></span>
</h3>
<h5 class="col-lg-6" style="color:black; margin:3px 0;">
    Receipt Number : <?php echo $or_number ?><br />
    Date : <?php echo date('F d, Y', strtotime($orDetails->row()->t_date)) ?>
</h5>
<h5 class="col-lg-6 pull-right text-right" style="color:black; margin:3px 0;">
    Teller : <?php echo strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname) ?>
</h5>

<div class="col-lg-12" style="margin-top:10px;">
    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Item Description</th>
            <th class="text-right">Amount</th>
        </tr>
        <?php 
        $i = 1;
        $total = 0;
        foreach($orDetails->result() as $ord): 
        $total += $ord->t_amount;    
        ?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo strtoupper($ord->item_description) ?></td>
            <td class="text-right"><?php echo number_format($ord->t_amount,2,'.',',') ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="2">TOTAL</th>
            <th class="text-right"><?php echo number_format($total,2,'.',',') ?></th>
        </tr>
    </table>
</div>
<hr class="col-lg-11" />

<input type="hidden" id="receiptNumber" value="<?php echo $or_number ?>" />
<?php if($orDetails->row()->t_type==3): ?>
<div class="col-lg-12" style="position: absolute; top:65px; opacity: .50">
    <img src="<?php echo base_url('images/cancelled.png') ?>" style="width: 100%" />
</div>
<?php endif;