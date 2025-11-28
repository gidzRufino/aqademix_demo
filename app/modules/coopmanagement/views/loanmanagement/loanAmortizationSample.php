<?php
$cbu = ($loanType==1?50:0);
$numPayments = $terms * 4;
$amortization = $principal + (($principal*$interest)*$terms)+($loanType==2?($principal*$serviceCharge):0);

$netProceed = (($principal - ($principal*$serviceCharge))-$lpp)-$cbu;
?>
<h3 class="no-margin text-center">Amortization Schedule</h3>
<table id="amortTable" class="table table-striped" style="background: white;">
    <tr>
        <td>#</td>
        <td class="text-center">Date</td>
        <td class="text-center">Reference Number</td>
        <td class="text-right">Principal</td>
        <td class="text-right">Interest</td>
        <td class="text-right">Amortization</td>
        <td class="text-right">Balance</td>
    </tr>
    <?php 
        $balance_due = $amortization;
        for($amort=1; $amort<=$numPayments; $amort++): 
            $a = $amort;
            $date = Modules::run('coopmanagement/getAmortizationDate',$dateApplied,$a);
            
            $principalPerWeek = $principal/$numPayments;
            $interestPerWeek = ($principal*$interest)*$terms/$numPayments;
            $serviceChargePerWeek = ($loanType==2?($principal*$serviceCharge)/$numPayments:0);
            $weeklyAmortization = $principalPerWeek + $interestPerWeek+$serviceChargePerWeek;
            $balance_due = $balance_due - $weeklyAmortization;
    ?>
    <tr class="hasValue" trvalue="<?php echo $date->format('Y-m-d') ?>;<?php echo $balance_due ?>">
        <td class="text-center"><?php echo $amort ?></td>
        <td class="text-center"><?php echo $date->format('m-d-Y') ?></td>
        <td class="text-center"><?php echo $referenceNumber ?></td>
        <td class="text-right"><?php echo '&#8369; '.number_format($principalPerWeek,2,'.',',') ?></td>
        <td class="text-right"><?php echo '&#8369; '.number_format($interestPerWeek,2,'.',',') ?></td>
        <td class="text-right"><?php echo '&#8369; '.number_format($weeklyAmortization,2,'.',','); ?></td>
        <td class="text-right"><?php echo '&#8369; '.number_format($balance_due,2,'.',','); ?></td>
    </tr>
    <?php 
            
        endfor; 
    ?>
</table>
<input type="hidden" value="<?php echo $referenceNumber ?>" id="refNumber" />
<input type="hidden" value="<?php echo $principalPerWeek ?>" id="principalPerWeek" />
<input type="hidden" value="<?php echo $principal*$interest ?>" id="interestPerWeek" />
<input type="hidden" value="<?php echo $weeklyAmortization ?>" id="weeklyAmortization" />
<input type="hidden" value="<?php echo $principal*$serviceCharge ?>" id="serviceChargeDetails" />
<input type="hidden" value="<?php echo $netProceed ?>" id="netProceed" />
<input type="hidden" value="<?php echo $date->format('Y-m-d') ?>" id="maturityDate" />
<div class="col-lg-2"></div>
<div class="form-group form-horizontal col-lg-8 text-center">
    <label class="control-label text-center" style="font-size: 15px;" for="Height">Less Service Charge : &#8369; <?php echo number_format(($principal*$serviceCharge),2,'.',','); ?></label><br />
    <label class="control-label text-center" style="font-size: 22px;" for="Height">Net Proceed</label>
    <input style="font-weight: bold; font-size:22px; color: red;"  class="form-control text-center" value="<?php echo number_format($netProceed,2,'.',',') ?>" name="NP" type="text" id="NP" disabled>
</div>
<div class="col-lg-12 no-margin" id="comakerWrapper" style="display: none;">
    <hr class="col-lg-12" />

    <label class="control-label text-left" style="font-size: 15px;">Co Maker : <span id="comakerAdd"></span> <button onclick="$('#addComaker').modal('show')" class="btn btn-xs btn-warning">Add</button></label><br />
    <input type="hidden" id="comakerID_1" />
    <input type="hidden" id="comakerID_2" />
    <input type="hidden" id="comakerNames" />

    <div id="addComaker" class="modal fade" style="width:30%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                    <h6 class="panel-header no-margin col-lg-6">Search Co Maker</h6>
                <button class="btn btn-danger btn-xs panel-header pull-right no-margin" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input onkeyup="searchCoMaker(this.value)" id="searchCoMaker" class="form-control" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchCoName">

                    </div>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default text-center"><i class="fa fa-search"></i></button>

                    </div>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <button class="pull-right btn btn-success" data-dismiss="modal"  onclick="addComaker($('#comakerNames').val())">Add</button>
            </div>

        </div>
    </div>
</div>
<hr class="col-lg-12" />
<div class="col-lg-12">
    <button id="saveBtn" onclick="saveLoan()" class="btn btn-success btn-xs pull-right">Save</button>
</div>


<script type="text/javascript">
    
    function searchCoMaker(value)
    {
      var url = '<?php echo base_url().'coopmanagement/searchCoMaker/' ?>'+value;
        $.ajax({
           type: "GET",
           url: url,
           data: "id="+value, // serializes the form's elements.
           success: function(data)
           {
                 $('#searchCoName').show();
                 $('#searchCoName').html(data);
           }
         });

    return false;
    } 
    
    function saveLoan()
    {
        var data = [];
        $('#amortTable tr.hasValue').each(function(){
            data.push($(this).attr('trvalue'));
            
        });
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'coopmanagement/loans/saveLoan' ?>',
            dataType: 'json',
            data: {
                items               : JSON.stringify(data),
                dateApplied         : $('#dateApplied').val(),
                refNumber           : $('#refNumber').val(),
                accountNumber       : $('#account_number').attr('detail'),  
                principalAmount     : $('#loanAmount').val(),
                serviceCharge       : $('#serviceChargeDetails').val(),
                netProceed          : $('#netProceed').val(),
                loanType            : $('#loanType').val(),
                clpp                : $('#loanProtection').val(),
                cbu                 : $('#cbu').val(),
                principalPerWeek    : $('#principalPerWeek').val(),
                interestPerWeek     : $('#interestPerWeek').val(),
                weeklyAmortization  : $('#weeklyAmortization').val(),
                maturityDate        : $('#maturityDate').val(),
                comaker1            : $('#comakerID_1').val(),
                comaker2            : $('#comakerID_2').val(),
                csrf_test_name      : $.cookie('csrf_cookie_name')
                },
            success: function (response) {
                alert(response.msg);
            }

        });
    }
    
    
</script>    