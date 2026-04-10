<div class="modal-dialog modal-lg">
   <div class="modal-content">
      <div class="modal-header bg-purple">
          <b class="modal-title" id="myModalLabel"><i class="fa fa-tags"></i> New Disbursement</b>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-6">
               <div class="form-group has-feedback">
                  <label for="input">Disbursement Description</label>
                  <input type="text" class="form-control" id="db_name" placeholder="Disbrusement Name">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group has-feedback">
                 <label for="input">Disbursement Category</label>
                 <select placeholder="Category" class="form-control select2" style="width:100%; line-height:22px;" id="db_category">
                    <option disabled="disabled" selected>Select Category</option>

                    <?php foreach ($category->result() as $cat) { ?>

                    <option value="<?php echo $cat->ctid ?>"><?php echo $cat->ct_category ?></option>

                    <?php } ?>

                 </select>
              </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="form-group has-feedback">
                  <label for="input">Vendor</label>
                  <select placeholder="Vendor" class="form-control select2" style="width:100%; line-height:22px;" id="db_vendor" name="px_type">
                     <option disabled="disabled" selected>Select Vendor</option>

                     <?php foreach ($vendors->result() as $ven) { ?>

                     <option value="<?php echo base64_encode($ven->veid) ?>"><?php echo $ven->ve_name ?></option>

                     <?php } ?>

                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group ">
                   <label for="input">Payment Type</label>
                   <select placeholder="Payment Type" class="form-control select2" style="width:100%; line-height:22px;" id="db_paytype">
                     <option disabled="disabled" selected>Select Payment Type</option>
                     <option value="1">Cash</option>
                     <option value="2">Cheque</option>
                     <option value="3">Bank Transfer</option>
                    </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group has-feedback">
                  <label for="input">Amount</label>
                  <input type="text" class="form-control" id="db_amount" placeholder="Disbursement Amount">
               </div>
            </div>
         </div>
         <div class="row">
           <div class="col-md-12">
              <div id="is_bank" class="form-group">
                <label for="input">From Account</label>
                <select placeholder="Account" class="form-control select2" style="width:100%; line-height:22px;" id="db_account">
                   <option disabled="disabled" selected>Select Account</option>

                      <?php foreach ($accounts->result() as $ac) { ?>

                      <option value="<?php echo base64_encode($ac->baid) ?>"><?php echo $ac->ba_act_num.' '.$ac->ba_act_name.' | '.$ac->ba_bank_name.' '.$ac->ba_branch_name ?></option>

                      <?php } ?>

                 </select>
             </div>
              <div id="is_cheque" class="form-group has-feedback">
                 <label id="checklabel">Cheque #</label>
                 <input type="text" class="form-control" id="db_cheque" placeholder="Reference Number">
              </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <div class="row">
            <div class="col-md-8 pull-right">
               <button type="button" id="send_disbursement" class="btn bg-green margin pull-right"><i class="fa fa-check"></i> Add</button>
               <button type="button" class="btn bg-red margin pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   $("#send_disbursement").click(function(){
      var name = $("#db_name").val();
      var vendor = $("#db_vendor").val();
      var amount = $("#db_amount").val();
      var category = $("#db_category").val();
      var type = $("#db_paytype").val();
      var bank = $("#db_account").val();
      var check = $("#db_cheque").val();
      var url = "<?php echo base_url().'finance/add_disbursement' ?>";
      $.ajax({
         type: "POST",
         url: url,
         dataType: 'json',
         data: "&category="+category+"&vendor="+vendor+"&amount="+amount+"&type="+type+"&bank="+bank+"&check="+check+"&name="+name+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
         success: function(data){
            if (data.success) {
               alert('Disbursement Added Successfully!');
               $("#add_disbursement_mod").modal('hide');
               disbursements('disburse');
            }else{
               alert('An error has been detected. Please try again later.');
            }
         }
      });
   });

</script>
