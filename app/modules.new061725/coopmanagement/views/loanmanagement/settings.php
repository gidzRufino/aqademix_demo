<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Loans Management Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/application') ?>'">Loan Application</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll/settings') ?>'">Loans for Disbursement</button>
          </div>
    </h3>
</div>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h6 class="panel-header no-margin col-lg-6">List of Loan Types</h6>
            <button class="btn btn-success btn-xs panel-header pull-right no-margin"><i class="fa fa-plus"></i></button>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Loan Type</th>
                    <th class="text-center">Interest Rate</th>
                    <th class="text-center">Service Charge</th>
                    <th class="text-center">Penalty</th>
                    <th>Action</th>
                </tr>
                <?php $loanTypes = Modules::run('coopmanagement/loans/getLoanTypes'); 
                $i=1;
                    foreach ($loanTypes as $lt):
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo strtoupper($lt->clt_type) ?></td>
                    <td class="text-center"><?php echo ($lt->clt_interest*100).' %' ?></td>
                    <td class="text-center"><?php echo ($lt->clt_service_charge*100).' %' ?></td>
                    <td class="text-center"><?php echo ($lt->clt_overdue_penalty*100).' %' ?></td>
                    <td class="text-center">
                        <button onclick="$('#editLoanSettings').modal('show'), 
                                    $('#interestRate').val('<?php echo $lt->clt_interest ?>'), 
                                    $('#serviceCharge').val('<?php echo $lt->clt_service_charge ?>'),
                                    $('#penaltyCharge').val('<?php echo $lt->clt_overdue_penalty ?>'),
                                    $('#clt_id').val('<?php echo $lt->clt_id ?>')"
                                class="btn btn-success btn-xs panel-header no-margin"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h6 class="panel-header no-margin col-lg-6">Credit Comitteee</h6>
                <button class="btn btn-success btn-xs panel-header pull-right no-margin" onclick="addAuthorizePersonToReview()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Name of Person</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php $reviewPerson = Modules::run('coopmanagement/personToReview'); 
                    $r=1;
                        foreach ($reviewPerson as $rp):
                    ?>
                    <tr>
                        <td><?php echo $r++; ?></td>
                        <td class="text-left"><?php echo strtoupper($rp->lastname.', '.$rp->firstname) ?></td>
                        <td class="text-center"><?php echo strtoupper($rp->position) ?></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-xs panel-header no-margin"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-xs panel-header no-margin"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php
                        endforeach;
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="editLoanSettings" class="modal fade" style="width:40%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h5 class="panel-header no-margin">Edit Loan Settings <small class="text-danger text-muted">Note: Values should be Decimal Form</small></h5>
            <button class="btn btn-danger btn-xs panel-header pull-right no-margin" data-dismiss="modal"><i class="fa fa-close"></i></button>
        </div>
        <div class="panel-body">
            <div class="form-group form-horizontal">
                <label class="control-label" for="Height">Interest Rate</label>
                <input  class="form-control" name="interestRate" type="text" id="interestRate" placeholder="Interest Rate" required>
            </div>
            <div class="form-group form-horizontal">
                <label class="control-label" for="Height">Service Charge</label>
                <input  class="form-control" name="serviceCharge" type="text" id="serviceCharge" placeholder="Service Charge" required>
            </div>
            <div class="form-group form-horizontal">
                <label class="control-label" for="Height">Penalty Charge</label>
                <input  class="form-control" name="penaltyCharge" type="text" id="penaltyCharge" placeholder="Penalty Charge" required>
                <input  class="form-control" name="clt_id" type="hidden" id="clt_id" placeholder="Penalty Charge" required>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button class="pull-right btn btn-success" onclick="editLoanSettings()">Save</button>
        </div>
            
    </div>
</div>

<div id="addAuthorizePersonToReview" class="modal fade" style="width:30%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h6 class="panel-header no-margin col-lg-6">Add Person to Review Loans</h6>
            <button class="btn btn-danger btn-xs panel-header pull-right no-margin" data-dismiss="modal"><i class="fa fa-close"></i></button>
        </div>
        <div class="panel-body">
            <div class="input-group col-lg-12">
                <input onkeyup="search(this.value)" id="searchBox" class="form-control" type="text" placeholder="Search Name Here" />
                <div onblur="$(this).hide()" style=" margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

                </div>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default text-center"><i class="fa fa-search"></i></button>

                </div>
                <input type="hidden" id="coop_account_user_id" />
                <input type="hidden" id="is_credit_comittee" value="0" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button class="pull-right btn btn-success" onclick="addToCreditCommitee()">Add</button>
        </div>
            
    </div>
</div>

<script type="text/javascript">
    
    function addAuthorizePersonToReview()
    {
        $('#addAuthorizePersonToReview').modal('show');
    }
    
    function editLoanSettings()
    {
        
        var url = '<?php echo base_url().'coopmanagement/loans/editLoanSettings' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                clt_id              : $('#clt_id').val(),
                interest            : $('#interestRate').val(),
                serviceCharge       : $('#serviceCharge').val(),
                penalty             : $('#penaltyCharge').val(),
                csrf_test_name      : $.cookie('csrf_cookie_name')
            },
            success: function(data)
            {
                alert(data);
                location.reload();
            }
         });

        return false;
    }
    
    function addToCreditCommitee()
    {
        
        var url = '<?php echo base_url().'coopmanagement/addCreditCommittee' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                user_id             : $('#coop_account_user_id').val(),
                is_credit_comittee  : $('#is_credit_comittee').val(),
                csrf_test_name      : $.cookie('csrf_cookie_name')
            },
            success: function(data)
            {
                alert(data);
                location.reload();
            }
         });

        return false;
    }
    
    function search(value)
    {
      var url = '<?php echo base_url().'coopmanagement/searchMembers/' ?>'+value;
        $.ajax({
           type: "GET",
           url: url,
           data: "id="+value, // serializes the form's elements.
           success: function(data)
           {
                 $('#searchName').show();
                 $('#searchName').html(data);
           }
         });

    return false;
    }    

</script> 