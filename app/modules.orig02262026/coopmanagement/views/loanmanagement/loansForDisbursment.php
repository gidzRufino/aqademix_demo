<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Loans for Disbursement
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/application') ?>'">Loan Application</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/pending') ?>'">Pending Loan</button>
          </div>
    </h3>
</div>
<div class="col-lg-12">
    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th style="width:22%; text-align: Left;">Name</th>
            <th style="width:8%; text-align: Left;">Loan Type</th>
            <th class="text-right">Principal Amount</th>
            <th class="text-right">Interest</th>
            <th class="text-right">Net Proceed</th>
            <th class="text-center">Date Approved</th>
            <th class="text-center">Status</th>
            <th class="text-center"></th>
        </tr>
        
        <?php 
        $i=0;
        //print_r($pendingLoans);
        foreach($forDisbursement as $pl): $i++; ?>
        <tr >
            <th><?php echo $i; ?>.</th>
            <td style="width:22%; text-align: left;"><?php echo strtoupper($pl->lastname.', '.$pl->firstname) ?></td>
            <td style="width:8%; text-align: left;"><?php echo strtoupper($pl->clt_type) ?></td>
            <td style="width:15%;" class="text-right">&#8369; <?php echo number_format($pl->ld_principal_amount,2,'.',',') ?></td>
            <td style="width:12%;" class="text-right">&#8369; <?php echo number_format($pl->ld_interest,2,'.',',') ?></td>
            <td style="width:12%;" class="text-right">&#8369; <?php echo number_format($pl->ld_principal_amount-($pl->ld_principal_amount*$pl->clt_service_charge),2,'.',',') ?></td>
            <td class="text-center"><?php echo date('F d, Y', strtotime($pl->ld_date_approved)) ?></td>
            <td class="pointer" onclick="document.location='<?php echo base_url('coopmanagement/loans/loanDetails/').base64_encode($pl->ld_account_num).'/'.base64_encode($pl->ld_ref_number) ?>'" class="text-center ">
                <span class="label label-warning"><?php echo ($pl->ld_status==1?'For Disbursement':($pl->ld_status==2?'Released':'')) ?></span>
            </td>
            <td><button class="btn btn-xs pull-right btn-info" onclick="$('#releaseModal').modal('show'), $('#netProceedLabel').val('<?php echo '&#8369; '. number_format($pl->ld_principal_amount-($pl->ld_principal_amount*$pl->clt_service_charge),2,'.',',') ?>'),   
                                                                        $('#netProceed').val('<?php echo $pl->ld_principal_amount-($pl->ld_principal_amount*$pl->clt_service_charge) ?>'), 
                                                                        $('#ld_ref_number').val('<?php echo $pl->ld_ref_number ?>'), 
                                                                        $('#profile_id').val('<?php echo $pl->cad_profile_id ?>'),
                                                                        $('#name').val('<?php echo strtoupper($pl->lastname.', '.$pl->firstname) ?>'),
                                                                        $('#account_number').val('<?php echo $pl->cad_account_no ?>')">Release</button></td>
        </tr>
        
        <?php endforeach; ?>
    </table>
</div>

<div id="releaseModal"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Loan Releasing</b></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="Height">Net Proceed</label>
                    <input style="font-weight: bold; font-size:22px; color: red;" value="&#8369; "  class="form-control text-center" name="netProceedLabel" type="text" id="netProceedLabel" disabled>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="Select Loan Type">Release in: </label>
                    <select style="width:100%;" id="releaseIn">
                          <option onclick="$('#chequeWrapper1').hide()" value="0">Cash</option>
                          <option onclick="$('#chequeWrapper1').show()" value="1">Cheque</option>
                    </select>
                </div>
                <br />
                <div id="chequeWrapper1" class="form-group" style="display:none;">
                   <div class="form-group">
                       <label>Bank</label>
                       <select style="width:75%; color: black;"  name="bank" id="bank" required>
                         <option value="0">Select Bank</option> 
                           <?php 
                                  foreach ($getBanks as $b)
                                    {   
                              ?>                        
                                   <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                           <?php }?>
                       </select>
                       <button onclick="$('#addBank').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
                   </div>
                   <div class="form-group">
                       <label>Cheque #</label>
                       <input type="text" style="width: 200px; color: black" placeholder="" id="chequeNumber" />
                   </div>
               </div>
                <input type="hidden" id="ld_ref_number" />
                <input type="hidden" id="account_number" />
                <input type="hidden" id="profile_id" />
                <input type="hidden" id="name" />
                <input type="hidden" id="netProceed" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="releaseLoan()" data-dismiss="modal" class="btn btn-primary btn-lg">Release</button>
            </div>
    </div>

</div>

<div id="addBank" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Bank   
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Bank Name</label>
                <input type="text" id="bank" class="form-control" placeholder="Bank" />
            </div>
            <div class="form-group">
                <label>Bank Short Name</label>
                <input type="text" id="bankShortName" class="form-control" placeholder="Bank Short Name" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addBank()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<script type="text/javascript">
        
    function releaseLoan()
    {
        var url = '<?php echo base_url().'coopmanagement/loans/releaseLoan' ?>';
             $.ajax({
                type: "POST",
                url: url,
                data: {
                    name            : $('#name').val(),
                    releaseIn       : $('#releaseIn').val(),
                    bank            : $('#bank').val(),
                    chequeNumber    : $('#chequeNumber').val(),
                    netProceed      : $('#netProceed').val(),
                    accountNumber   : $('#account_number').val(),
                    profile_id      : $('#profile_id').val(),
                    refNumber       : $('#ld_ref_number').val(),
                    csrf_test_name  : $.cookie('csrf_cookie_name')  
                 }, // serializes the form's elements.
                success: function(data)
                {
                    alert(data);
                    location.reload();
                }
              });

         return false;
    } 
</script>