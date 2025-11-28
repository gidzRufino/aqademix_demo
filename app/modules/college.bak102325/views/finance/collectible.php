<?php


?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Remaining Collectibles - <span id="totalBalance"><?php echo $totalBalance; ?></span>
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'">Accounts</button>
                <button type="button"  class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Update Collectibles</button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li onclick="generateCollectibles('<?php echo $school_year ?>', 1)"><a href="#">First Semester</a></li>
                    <li onclick="generateCollectibles('<?php echo $school_year ?>', 2)"><a href="#">Second Semester</a></li>
                    <li onclick="generateCollectibles('<?php echo $school_year ?>', 3)"><a href="#">Summer</a></li>
                  </ul>
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
                <th>Student ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Total Charges</th>
                <th>Total Payments</th>
                <th>Balance</th>
                <th></th>
            </tr>
         
        <?php 
            foreach($students as $s):
                if($s->lastname!=""):
                    $accountDetails = json_decode(Modules::run('college/finance/getRunningBalance', base64_encode($s->st_id), $school_year,2));
                    $balance = $accountDetails->charges - $accountDetails->payments;
                    if($balance > 0):
        ?>
            <tr>
                <td><?php echo strtoupper($s->st_id) ?></td>
                <td><?php echo strtoupper($s->lastname) ?></td>
                <td><?php echo strtoupper($s->firstname) ?></td>
                <td><?php echo number_format($accountDetails->charges,2,'.',',') ?></td>
                <td><?php echo number_format($accountDetails->payments,2,'.',',') ?></td>
                <td><?php echo number_format($balance,2,'.',',') ?></td>
                <td class="text-center"><button onclick="document.location='<?php echo base_url('college/finance/accounts/'. base64_encode($s->st_id).'/'.$s->fc_semester) ?>'" class="btn btn-warning btn-xs">View Details</button></td>
            </tr>
        <?php       
                    endif;
                endif;
                unset($balance);
            endforeach;
        ?>
        </table>
    </div>
</div>
<div id="loadingModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 3000;">
    <div class="panel panel-default clearfix" style="width:20%; margin:75px auto;">
        <div class="col-xs-12" style="width:100%;">
            <div class="col-xs-12">
                <p class="text-center">Please wait while processing your request <br />
                
                <!-- <img src="<?php // echo base_url().'images/loading.gif' ?>" style="width:150px;" /> -->
                </p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'left'
    });
    
    $('#endDate').datepicker({
        orientation: 'left'
    });
   
    function generateCollectibles(year, sem)
    {
        var url = '<?php echo base_url().'college/finance/generateCollectibles/'?>'+year+'/'+sem;

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