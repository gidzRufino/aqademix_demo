<h2>SSS Contribution Table</h2>
<div id="links" class="pull-left">
    <?php echo $links; ?>
</div>

<table class="table table-bordered" width="500">
    <tr>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">#</th>
        <th colspan="2" class="text-center">Range of Compensation</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Contribution</th>
    </tr>
    <tr>
        <th>From</th>
        <th>To</th>
    </tr>
    <?php
    $t = ($t == '' ? 1 : $t + 1);
    foreach ($sss as $s): ?>
        <tr>
            <td><?php echo $t++; ?></td>
            <td class="text-center"><?php echo ($s->ssst_id != 1 ? number_format($s->ssst_from, 2, '.', ',') : 'BELOW'); ?></td>
            <td class="text-center"><?php echo ($s->ssst_id != 67 ? number_format($s->ssst_to, 2, '.', ',') : 'OVER') ?></td>
            <td id="<?php echo $s->esk_payroll_sss_table_code ?>" width="30%" class="editable text-right"><?php echo number_format($s->ssst_ee, 2, '.', ',') ?></td>
        </tr>
    <?php endforeach; ?>
</table>