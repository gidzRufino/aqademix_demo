<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header bg-purple text-center">
          <h3 class="modal-title">Update Disbursement</h3>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-6">
               <div class="form-group has-feedback">
                  <label >Disbursement Description</label>
                  <input type="text" class="form-control" id="up_name" placeholder="Disbrusement Name">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                 <label >Disbursement Category</label>
                 <select placeholder="Category" class="form-control select2" style="width:100%; line-height:22px;" id="up_category">
                    <option disabled="disabled" id="sel_category" selected>Select Category</option>

                    <?php foreach ($category->result() as $cat) { ?>

                    <option value="<?php echo $cat->ctid ?>"><?php echo $cat->ct_category ?></option>

                    <?php } ?>

                 </select>
              </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="form-group ">
                 <label >Status</label>
                 <select placeholder="Payment Type" class="form-control select2" style="width:100%; line-height:22px;" id="up_status">
                    <option disabled="disabled" selected>Select Status</option>
                    <option id="sel_stat" disabled selected></option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Released</option>
                  </select>
              </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="form-group has-feedback">
                  <label >Vendor</label>
                  <select placeholder="Vendor" class="form-control select2" style="width:100%; line-height:22px;" id="up_vendor" name="px_type">
                     <option disabled="disabled" id="sel_vendor" selected>Select Vendor</option>

                     <?php foreach ($vendors->result() as $ven) { ?>

                     <option value="<?php echo base64_encode($ven->veid) ?>"><?php echo $ven->ve_name ?></option>

                     <?php } ?>

                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group ">
                   <label >Payment Type</label>
                   <select placeholder="Payment Type" class="form-control select2" style="width:100%; line-height:22px;" id="up_paytype">
                     <option disabled="disabled" id="sel_paytype" selected>Select Payment Type</option>
                     <option value="1">Cash</option>
                     <option value="2">Cheque</option>
                     <option value="3">Bank Transfer</option>
                    </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group has-feedback">
                  <label >Amount</label>
                  <input type="text" class="form-control" id="up_amount" placeholder="Disbursement Amount">
               </div>
            </div>
         </div>
         <div class="row">
           <div class="col-md-12">
              <div id="is_bank" class="form-group">
                <label>From Account</label>
                <select placeholder="Account" class="form-control select2" style="width:100%; line-height:22px;" id="up_account">
                   <option disabled="disabled" id="sel_bank" selected>Select Account</option>

                      <?php foreach ($accounts->result() as $ac) { ?>

                      <option value="<?php echo base64_encode($ac->baid) ?>"><?php echo $ac->ba_act_num.' '.$ac->ba_act_name.' | '.$ac->ba_bank_name.' '.$ac->ba_branch_name ?></option>

                      <?php } ?>

                 </select>
             </div>
              <div id="is_cheque" class="form-group has-feedback">
                 <label id="upchecklabel">Cheque #</label>
                 <input type="text" class="form-control" id="up_cheque" placeholder="Reference Number">
              </div>
            </div>
         </div>
      </div>
      <div class="hidden">
         <input type="hidden" id="disburse_id"  required>
         <input type="hidden" id="check_id"  required>
      </div>
      <div class="modal-footer">
         <div class="row">
            <div class="col-md-8 pull-right">
               <button type="button" id="update_disbursement" class="btn bg-green margin pull-right"><i class="fa fa-check"></i> Update</button>
               <button type="button" class="btn bg-red margin pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   $('#up_paytype').on('change', function() {
      var selectedValue = $(this).val();
      switch (selectedValue) {
         case '1':
            $("#upchecklabel").text('Reference Number');
            $("#up_bank").hide();
            $("#up_cheque").show();
            break;
         case '2':
            $("#upchecklabel").text('Cheque Number');
            $("#up_bank, #up_cheque").show();
            break;
         case '3':
            $("#upchecklabel").text('Reference Number');
            $("#up_bank, #up_cheque").show();
            break;
         default:
            $("#up_bank").hide();
            $("#up_cheque").hide();
            break;
      }
   });

   $("#update_disbursement").click(function () {
       const diid = $("#disburse_id").val();
       const chid = $("#check_id").val();
       const name = $("#up_name").val();
       const category = $("#up_category").val() || $("#sel_category").val();
       const vendor = $("#up_vendor").val() || $("#sel_vendor").val();
       let amount = string2number($("#up_amount").val());
       const type = $("#up_paytype").val() || $("#sel_paytype").val();
       const bank = $("#up_account").val() || $("#sel_bank").val();
       const stat = $("#up_status").val() || $("#sel_stat").val();
       const check = $("#up_cheque").val();

       if (isNaN(amount) || !name) {
           alert("Please ensure all required fields are filled out correctly.");
           return;
       }

       const url = "<?php echo base_url().'finance/update_disbursement' ?>";
       const data = {
           diid,
           chid,
           name,
           category,
           vendor,
           amount,
           type,
           bank,
           stat,
           check,
           csrf_test_name: $.cookie('csrf_cookie_name')
       };

       $.ajax({
           type: "POST",
           url: url,
           dataType: "json",
           data: data,
           success: function (response) {
               if (response.success) {
                   alert("Disbursement Updated Successfully!");
                   $("#update_disbursement_mod").modal("hide");
                   disbursements("disburse");
               } else {
                   alert("An error occurred. Please try again later.");
               }
           },
           error: function (xhr, status, error) {
               console.error("AJAX Error:", error);
               alert("Failed to update disbursement. Please check your connection and try again.");
           }
       });
   });

</script>
