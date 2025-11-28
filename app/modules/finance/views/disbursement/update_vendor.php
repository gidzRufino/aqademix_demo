<div class="modal-dialog modal-lg">
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
                  <label for="ve_name">Name</label>
                  <input type="text" class="form-control" id="ve_name" placeholder="Vendor Name">
               </div>
               <div class="form-group has-feedback">
                  <label for="ve_address">Address</label>
                  <input type="text" class="form-control" id="ve_address" placeholder="Vendor Address">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                 <label for="ve_email">Email Address</label>
                 <input type="text" class="form-control" id="ve_email" placeholder="Email Address">
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                 <label for="ve_contact_num">Contact Number</label>
                 <input type="text" class="form-control" id="ve_contact_num" placeholder="Contact Number">
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                  <label for="ve_ba_act_name">Bank Account Name</label>
                  <input type="text" class="form-control" id="ve_ba_act_name" placeholder="Bank Account Name">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                  <label for="ve_ba_act_num">Account Number</label>
                  <input type="text" class="form-control" id="ve_ba_act_num" placeholder="Account Number">
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group has-feedback">
                  <label for="ve_bank_name">Bank Name</label>
                  <input type="text" class="form-control" id="ve_bank_name" placeholder="Bank Name">
                  <input type="hidden" id="ve_process">
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <div class="row">
            <div class="col-md-12 text-right">
               <button type="button" class="btn bg-red margin pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
               <button type="button" id="updateVendor" class="btn bg-green margin pull-right"><i class="fa fa-check"></i> Update</button>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
// $(document).ready(function () {
  $("#updateVendor").click(function () {
     const data = {
        name: $("#ve_name").val(),
        address: $("#ve_address").val(),
        email: $("#ve_email").val(),
        contact: $("#ve_contact_num").val(),
        act_name: $("#ve_ba_act_name").val(),
        act_num: $("#ve_ba_act_num").val(),
        bank: $("#ve_bank_name").val(),
        proc: $("#ve_process").val(),
        csrf_test_name: $.cookie('csrf_cookie_name')
     };

     const url = "<?php echo base_url('finance/update_vendor'); ?>";

     $.post(url, data, function (response) {
        if (response.success) {
           alert('Account Added Successfully!');
           $("#update_vendor_mod").modal('hide');
           disbursements('vendor');
        } else {
           alert('No record was updated. Please try again later.');
        }
     }, 'json').fail(function () {
        alert('Failed to connect to the server.');
     });
  });


</script>
