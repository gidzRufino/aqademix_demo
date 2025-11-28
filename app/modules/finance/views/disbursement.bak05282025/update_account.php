<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header bg-purple">
         <b class="modal-title" id="myModalLabel">
            <i class="fa fa-bank"></i> New Account
         </b>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-12">
               <div class="form-group has-feedback">
                  <label for="act_num">Account Number</label>
                  <input type="text" class="form-control" id="act_num" placeholder="Account Number">
               </div>
               <div class="form-group has-feedback">
                  <label for="act_name">Account Name</label>
                  <input type="text" class="form-control" id="act_name" placeholder="Account Name">
               </div>
               <div class="form-group has-feedback">
                  <label for="act_bank_name">Bank Name</label>
                  <input type="text" class="form-control" id="act_bank_name" placeholder="Bank Name">
               </div>
               <div class="form-group has-feedback">
                  <label for="act_branch">Branch</label>
                  <input type="text" class="form-control" id="act_branch" placeholder="Bank Branch">
                  <input type="hidden" id="act_process">
               </div>
               <div class="form-group">
                  <label for="act_type">Account Type</label>
                  <select class="form-control select2" id="act_type">
                     <option disabled selected id="sel_act_type">Select Account Type</option>
                     <option value="Savings Account">Savings Account</option>
                     <option value="Current Account">Current Account</option>
                     <option value="Checking Account">Checking Account</option>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <div class="row">
            <div class="col-md-12 text-right">
               <button type="button" class="btn bg-red margin pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
               <button type="button" id="updateAccount" class="btn bg-green margin pull-right"><i class="fa fa-check"></i> Update</button>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
// $(document).ready(function () {
  $("#updateAccount").click(function () {
     const tempType = $("#sel_act_type").val();
     const realType = $("#act_type").val();
     const type = $("#act_type").val() === null ? tempType : realType;
     const data = {
        num: $("#act_num").val(),
        name: $("#act_name").val(),
        bname: $("#act_bank_name").val(),
        branch: $("#act_branch").val(),
        type: type,
        proc: $("#act_process").val(),
        csrf_test_name: $.cookie('csrf_cookie_name')
     };

     const url = "<?php echo base_url('finance/update_account'); ?>";

     $.post(url, data, function (response) {
        if (response.success) {
           alert('Account Added Successfully!');
           disbursements('accounts');
        } else {
           alert('No record was updated. Please try again later.');
        }
     }, 'json').fail(function () {
        alert('Failed to connect to the server.');
     });
  });


</script>
