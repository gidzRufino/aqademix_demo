<div class="row">
    <div class="col-lg-12">
        <!-- <h3 style="margin:10px 0;" class="page-header">Remaining Collectibles - <span id="totalBalance"><?php //echo $totalBalance ?></span> -->
            <div class="btn-group pull-right" role="group" aria-label="" style="padding:20px 0 0 0">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
                <button type="button" class="btn btn-default" onclick="generateCollectibles('<?php echo $school_year ?>')">Update Collectibles</button>
                <button type="button" class="btn btn-default" onclick="printCollectible()">Print</button>
            </div>
        </h3>
    </div>
    <div class="col-lg-2"></div>
    <div id="salesTable" class="col-lg-8">
        <div id="links" class="pull-left">
            <?php 
                echo $links; ?>
        </div>
        <table class="table table-striped">
            <tr>
                <th>Grade Level</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Total Charges</th>
                <th>Total Payments</th>
                <th>Balance</th>
                <th></th>
            </tr>
         
        <?php 
           // print_r($students);
            foreach($students as $s):
                $total = 0;
                $total_transaction =0;
                $balance = 0;

                if($s->lastname!=""):
                    // $accountDetails = json_decode(Modules::run('finance/getRunningBalance', base64_encode($s->st_id), $school_year));
                    $accountDetails = json_decode(Modules::run('finance/getRunningBalance', base64_encode($s->user_id), $school_year));
                    
                    // $balance = $accountDetails->charges - $accountDetails->payments;
                    // if($balance > 0):
                    $plan = Modules::run('finance/getPlanByCourse', $s->grade_id, 0,$s->st_type, $s->school_year);
                    $charges = ($plan->fin_plan_id != '' ? Modules::run('finance/financeChargesByPlan',0, $s->school_year, 0, $plan->fin_plan_id, $s->semester) : 0);
                    if ($charges != 0) {                        
                        foreach ($charges as $key => $c) {
                            $total += $c->amount;
                        }
                        $transactions = Modules::run('finance/getTransaction', $s->st_id, $s->semester, $s->school_year);
                        foreach ($transactions->result() as $key => $transaction) {
                            $total_transaction += $transaction->t_amount;
                        }
                    } else {
                        $total = 0;
                        $total_transaction = 0;
                    }
                $balance = $total - $total_transaction;
                // $all_collectible += $balance;
                if ($balance == 0) {
                    continue;
                }
        ?>
            <tr>
                <!-- <td><?php// echo strtoupper($s->st_id) ?></td> -->
                <!-- <td><?php //echo strtoupper($s->user_id) ?></td> -->
                <td><?php echo strtoupper($s->level) ?></td>
                <td><?php echo strtoupper($s->lastname) ?></td>
                <td><?php echo strtoupper($s->firstname) ?></td>
                <td><?php echo number_format($total,2,'.',',') ?></td>
                <td><?php echo number_format($total_transaction,2,'.',',') ?></td>
                <!--<td><?php //echo number_format($balance,2,'.',',') ?></td>  -->
                <td><?php echo number_format($balance,2,'.',',') ?></td> 
                <td class="text-center"><button onclick="window.open('<?php echo base_url('finance/accounts/'. base64_encode($s->st_id).'/'.$school_year) ?>')" target="_blank" class="btn btn-warning btn-xs">View Details</button></td>
            </tr>
        <?php       
                    endif;
                // endif;
                unset($balance);
            endforeach;
        ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'left'
    });
    
    $('#endDate').datepicker({
        orientation: 'left'
    });
    
    // $('#totalBalance').text();
    function printCollectible()
    {
        // var sy = $('#inputSY').val();
        // var employee_id = $('#assign_employee_id').val();
        var school_year = <?php echo $s->school_year ?>;
        var url = '<?php echo base_url() . 'finance/printCollectible/'?>'+school_year;
        window.open(url, '_blank');
    }

    function generateCollectibles(year)
    {
        var url = '<?php echo base_url().'finance/generateCollectibles/'?>'+year;

        $.ajax({
               type: "GET",
               url: url,
               dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend:function(){
                    $('#loadingModal').modal('show');
                },
               success: function(data)
               {
                   $('#loadingModal').modal('hide');
                   $('#totalBalance').html(data.totalBalance)
               }
             });

        return false; 
    }  
    

</script>    