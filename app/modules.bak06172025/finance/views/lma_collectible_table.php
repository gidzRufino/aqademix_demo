
<table class="table table-striped">
<tr>
    <th>Last Name</th>
    <th>First Name</th>
    <th class="text-right">Total Charges</th>
    <th class="text-right">Total Balance</th>
    <th class="text-right">Amount Due</th>
    <th>Action</th>
    <th></th>
</tr>

<?php 
$penalty = 0;
$totalDue = 0;
foreach($students as $s):
    //if($s->rfid!=""):
        $financeAccount = Modules::run('finance/getFinanceAccount', $s->user_id);
        $accountDetails = json_decode(Modules::run('finance/getRunningBalance', base64_encode($s->st_id), $school_year));
        $balance = $accountDetails->charges - $accountDetails->payments;
        $btype = $financeAccount->billing_type;

        $amountDue = json_decode(Modules::run('finance/finance_lma/getAmountDue',$s, $btype, $accountDetails->charges));
        $penaltys = Modules::run('finance/finance_lma/getPenalty',$s->st_id,0, $school_year);
        if($penaltys->result()):
            foreach($penaltys->result() as $pen):
                $penalty += $pen->pen_amount;
            endforeach;
        endif;

        ?>
            <tr>
                <td><?php echo strtoupper($s->lastname) ?></td>
                <td><?php echo strtoupper($s->firstname) ?></td>
                <td class="text-right"><?php echo number_format($accountDetails->charges,2,'.',',') ?></td>
                <td class="text-right"><?php echo number_format(($balance+$penalty),2,'.',',') ?></td>
                <td class="text-right"><?php echo number_format($amountDue->due+$penalty,2,'.',',') ?></td>
                <td class="text-center">
                    <a href="<?php echo base_url('finance/accounts/'. base64_encode($s->st_id).'/'.$school_year) ?>" target="_blank" class="btn btn-warning btn-xs">View Details</a>
                    <button onclick="$('#sendSMS_<?php echo $s->user_id ?>').modal('show'), $('#number_<?php echo $s->user_id ?>').val('<?php echo $s->ice_contact ?>'),checkTxtLength($('#counter_<?php echo $s->user_id ?>').html(), '<?php echo $s->user_id ?>')" class="btn btn-success btn-xs">Send SMS</button>
                </td>
            </tr>
        <?php 
        $totalDue = $amountDue->due+$penalty;
$message = "Little Me Advisory #5 s2018:  Good Day Dear Parents! This is a gentle reminder of ".strtoupper($s->firstname)."'s account in the amount of P".$totalDue.". Downpayment should be fully paid first then you can proceed with your regular monthly tuition. Pls be guided that penalties will apply to late payments. For any queries, pls do not hesitate to visit us in the office. God bless and welcome to Little Me Academy!!!";
    $penalty = 0; 
    ?>
        <div id="sendSMS_<?php echo $s->user_id ?>" class="modal fade" style="width:50%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="col-lg-6 panel panel-primary clearfix no-padding">
                <div class="panel-heading">
                    <h6>Send SMS Billing</h6>
                </div>
                <div class="panel-body col-lg-12"> 
                    <div class="form-group">
                    <input class="form-control" type="text" name="number" id="number_<?php echo $s->user_id ?>" value="0" placeholder="Mobile Number" required>
                    <br />
                    <br />
                    <textarea class="form-control"  onkeyup="checkTxtLength($('#counter_<?php echo $s->user_id ?>').html(), '<?php echo $s->user_id ?>')" style="margin-bottom:10px; text-align: left;" name="txtMsg"  id="txtMsg_<?php echo $s->user_id ?>" rows="8" data-provide="limit" data-counter="#counter_<?php echo $s->user_id ?>" placeholder="Enter Text Here" required>
<?php echo $message ?>
                    </textarea>
                    <em id="counter_<?php echo $s->user_id ?>" style=""><?php echo 459-strlen($message) ?></em>
                    <br />

                    <button id="smsBtn_<?php echo $s->user_id ?>" onclick="sendSMS('<?php echo $s->user_id ?>')" class="btn btn-info pull-right disabled" style="margin-top:10px;">Send SMS</button>
                </div>
            </div>
        </div>   
    <?php        
endforeach;
?>
</table>
        