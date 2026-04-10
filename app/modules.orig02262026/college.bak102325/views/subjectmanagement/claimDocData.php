<h5 class="text-center no-margin">This Data is Already Printed and Claimed </h5>
<table class="table table-striped"> <tr><td>Type of Doc</td><td>Date/Time Claim</td></tr>
<?php foreach ($result as $r):
?>
<tr>
    <td><?php echo $r->claim_type; ?></td>    
    <td><?php echo date('F d, Y G:i:s', strtotime($r->claim_date_time)); ?></td>    
</tr>    
<?php endforeach; ?>
</table>