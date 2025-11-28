<script type="text/javascript">

    $(document).ready(function() {
        //$("a#passSlipAction").click(function() {});

});
</script>
<div class="clearfix row-fluid">
    <h1>Pass Slip Lists</h1>
   <input type="hidden" id="setAction" />
   <input type="hidden" id="setId" />
   
<table class='table table-striped'>
    <?php //print_r($pass_slip_list); ?>
    <tr><td>Date Issue</td><td>Name</td><td>Reason</td><td>Place</td><td>Status</td><td>Action</td></tr>
    <?php foreach ($pass_slip_list as $passlip){?>
    <tr>
        <td><?php echo $passlip->date_issue; ?></td>
        <td><?php echo $passlip->lastname.", ".$passlip->firstname ?></td>              
        <td><?php if($passlip->reason==1): echo 'OFFICIAL'; else: echo 'PERSONAL - '.$passlip->reason; endif; ?></td>
        <td><?php echo $passlip->place ?></td>
        <td>
            <?php 
                if ($passlip->authorized_by_hr){
                    $approved = 1;
                    echo 'Approved';
                }else{
                    $approved = 0;
                    echo 'Pending ';
                }
            ?>
        </td>
        <td>
            <a href="#passSlipModal" id="passSlipAction" onclick="passSlipActionID('<?php echo $passlip->pass_slip_id ?>', '<?php echo $passlip->reason ?>', '<?php echo $passlip->reason ?>', '<?php echo $passlip->place ?>', '<?php echo $passlip->date_issue; ?>', '<?php echo $passlip->employee_id; ?>', '<?php echo $approved; ?>')" data-toggle="modal">View Details</a>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

<?php echo Modules::run('hr/passSlip'); ?>
<script type="text/javascript">
    function passSlipActionID(id, reason, reasonOthers, place, date, emp, approved){
        $('#inputPassSlipID').val(id); 
        $('#approveInput').show();
        if($('#inputPassSlipID').val() !== 0){
            if(reason==1){
              $('#inputReason').val(reason).attr('readonly','readonly');  
            }else{
              $('#inputReason').val(0).attr('readonly','readonly');
            }
            
            $('#inputReasonOthers').val(reasonOthers).attr('readonly','readonly');
            $('#inputDate').val(date).attr('readonly','readonly');
            $('#inputEmployeeID').val(emp);
            $('#inputPlace').val(place).attr('readonly','readonly');
            $('#isUpdated').val(approved);
            
            
        } 
    }
</script>

