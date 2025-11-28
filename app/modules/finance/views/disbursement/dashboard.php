<script type="text/javascript">
   $(document).ready(function() {
      $("#rwelcome").show();
      $("#rcontent").hide();
   });
</script>
<link rel="stylesheet" href="<?php echo base_url("assets/js/plugins/datepicker/datepicker3.css"); ?>">
<style media="screen">
   .content-wrapper{
      margin-left: 0px;
   }
   .box-header .col-md-4{
      font-size: 25px;
      padding-top: 10px;
   }
   .box-header b{
      padding-left: 15px;
   }
   #rcontent{
      margin-top: 10px;
   }
   #rheader{
      font-size: 16px;
   }
   .statbtn{
      width: 100%;
      margin: 5px 0;
   }
   .statmodal{
      width: 400px;
      top: 25%;
   }
   .btn-app{
      margin: 0 0 0 10px;
      width: 95px;
   }
   .info-box-text{
      color: gray;
      font-weight: bold;
   }
   .info-box{
      margin-top: 15px;
   }
   .tgreen{
      color: green;
      font-weight: bold;
   }
   .torange{
      color: orange;
      font-weight: bold;
   }
   .tgray{
      color: aqua;
   }
   .vertical-divider {
       display: inline-block;
       width: 1px;
       height: 50px; /* Adjust the height as needed */
       background-color: #ccc; /* Adjust the color as needed */
       margin: 0 20px; /* Adjust the spacing between buttons */
       vertical-align: middle;
   }
</style>

<div class="wrapper">
   <div class="content-wrapper">
      <section class="content">
         <div class="row">
            <div class="col-md-12">
               <div class="box box-primary">
                  <div class="box-header text-center">
                     <div class="col-md-4" id="pheader">
                       <b><i class="fa fa-money"></i> Disbursements</b>
                     </div>
                     <div class="col-md-8 text-center">
                        <a class="btn btn-app" onclick="disbursements('accounts')">
                           <!-- <span class="badge bg-aqua">11</span> -->
                           <i class="fa fa-bank fa-4x" ></i> Accounts
                        </a>
                        <a class="btn btn-app" onclick="disbursements('vendor')">
                           <!-- <span class="badge bg-orange">10</span> -->
                           <i class="fa fa-shopping-cart"></i> Vendors
                        </a>
                        <span class="vertical-divider"></span>
                        <a class="btn btn-app" onclick="disbursements('disburse')">
                           <!-- <span class="badge bg-aqua">11</span> -->
                           <i class="fa fa-tags"></i> Disbursements
                        </a>
                        <a class="btn btn-app" onclick="disbursements('cheque')">
                           <!-- <span class="badge bg-aqua">11</span> -->
                           <i class="fa fa-cc fa-4x" ></i> Cheques
                        </a>
                        <a class="btn btn-app" onclick="disbursements('cash')">
                           <!-- <span class="badge bg-aqua">11</span> -->
                           <i class="fa fa-money fa-4x" ></i> Cash
                        </a>
                        <a class="btn btn-app" onclick="disbursements('transfer')">
                           <!-- <span class="badge bg-aqua">11</span> -->
                           <i class="fa fa-google-wallet fa-4x" ></i> Bank Transfer
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="page_content">
            <div id="rwelcome" class="register-box-sm">
               <div class="row">
                  <div class="register-logo">
                     <h1>
                        <br /><br />Finance Corner <br /><br />
                        <small>"Be anxious for nothing; but in every thing by prayer and supplication with thanksgiving let your requests be made known unto God."
                        <br /><br /> - Philippians 4:6</small>
                     </h1>
                  </div>
               </div>
            </div>
            <div id="rcontent">
               <div class="row">
                  <div class="col-md-12">
                     <div class="box box-default">
                        <div id="rheader" class="box-header">

                        </div>
                        <div class="box-body pad table-responsive" style="overflow-x:scroll; overflow-y: scroll;max-height: 400px;">
                           <table id="rtable" class="table table-bordered tablesorter text-center">
                              <thead>

                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                        <div id="tfooter" class="box-footer">

                        </div>
                     </div>
                  </div>
               </div>
               <div id="rfooter" class="row">

               </div>
            </div>
         </div>
      </section>
   </div>
</div>

<div id="add_disbursement_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php
      $data['vendors'] = $vendors;
      $data['accounts'] = $accounts;
      $this->load->view('add_disbursement', $data);
   ?>
</div>

<div id="update_account_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php
      $this->load->view('update_account');
   ?>
</div>

<div id="update_vendor_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php
      $this->load->view('update_vendor');
   ?>
</div>

<div id="update_status_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php
      $this->load->view('update_status');
   ?>
</div>

<div id="update_disbursement_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <?php
      $data['vendors'] = $vendors;
      $data['accounts'] = $accounts;
      $this->load->view('update_disbursement', $data);
   ?>
</div>

<script src="<?php echo base_url("assets/js/plugins/datepicker/bootstrap-datepicker.js"); ?>"></script>
<script type="text/javascript">
   window.addEventListener('DOMContentLoaded', () => {
      datepicker('#datepicker', {
         formatter: (input, date) => {
           // Format the date as yyyy-mm-dd
           const yyyy = date.getFullYear();
           const mm = String(date.getMonth() + 1).padStart(2, '0');
           const dd = String(date.getDate()).padStart(2, '0');
           input.value = `${yyyy}-${mm}-${dd}`;
         }
      });
   });

   $(document).ready(function() {
      $(".datepicker").datepicker({
		 format: 'yyyy-mm-dd',
		 autoclose: true
	 });
      $(".tablesorter").tablesorter();
      $(document).on('input', '.searchit', function(){
         let search = $(this).val();
         let proc = $(this).attr('id');
         load_search(search, proc);
      });
      $("#is_bank, #is_cheque, #rcontent").hide();
      $("#rwelcome").show();
   });

   function load_search(query, proc)
   {
      const url = '<?php echo base_url()?>finance/search';
      const csrfToken = $.cookie('csrf_cookie_name');
      $("#rtable tbody, #rfooter").empty();

      $.ajax({
         url: url,
         dataType:'json',
         method: "POST",
         data:{
            query: query,
            proc: proc,
            csrf_test_name: csrfToken
         },
         success:function(data){
            $("#rtable tbody").append(data.tbody);
            $("#rfooter").append(data.tfooter);
         }
      });
   }

   function dldis(point){
      var id = point.substr(2);
      var link = "<?php echo base_url() . 'finance/del_dis_record' ?>";
      if (confirm("Do you really want to delete this record? This process is irreversible. A log will be generated for this action.")) {
         $.ajax({
            type: "POST",
            url: link,
            data: '&id='+id+'&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',
            success: function (data) {
               if (data.success) {
                  alert('Transaction successfully deleted / voided.');
                  disbursements('disburse');
               }
            }
         });
      }
   }

   function delVendor(point){
      var id = point.substr(2);
      var link = "<?php echo base_url() . 'finance/del_dis_vendor' ?>";
      if (confirm("Do you really want to delete this Vendor? This process is irreversible. A log will be generated for this action.")) {
         $.ajax({
            type: "POST",
            url: link,
            data: '&id='+id+'&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',
            success: function (data) {
               if (data.success) {
                  alert('Transaction successfully deleted / voided.');
                  disbursements('vendor');
               }
            }
         });
      }
   }

   function delAccount(point){
      var id = point.substr(2);
      var link = "<?php echo base_url() . 'finance/del_dis_account' ?>";
      if (confirm("Do you really want to delete this account? This process is irreversible. A log will be generated for this action.")) {
         $.ajax({
            type: "POST",
            url: link,
            data: '&id='+id+'&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',
            success: function (data) {
               if (data.success) {
                  alert('Transaction successfully deleted / voided.');
                  disbursements('accounts');
               }
            }
         });
      }
   }

   function editAccount(point){
      const id = point.substr(2);
      const link = "<?php echo base_url() . 'finance/fetch_dis_account' ?>";
      const csrfToken = $.cookie('csrf_cookie_name');
      $.ajax({
         type: "POST",
         url: link,
         dataType: 'json',
         data:{
            id:id,
            csrf_test_name: csrfToken
         },
         success: function (data){
            $("#act_num").val(data.act_num);
            $("#act_name").val(data.act_name);
            $("#act_bank_name").val(data.act_bname);
            $("#act_branch").val(data.act_branch);
            $("#sel_act_type").val(data.act_type);
            $("#sel_act_type").text(data.act_type);
            $("#act_process").val(data.act_id);
            $("#update_account_mod").modal('show');
         }
      });
   }

   function editVendor(point){
      const id = point.substr(2);
      const link = "<?php echo base_url() . 'finance/fetch_dis_vendor' ?>";
      const csrfToken = $.cookie('csrf_cookie_name');
      $.ajax({
         type: "POST",
         url: link,
         dataType: 'json',
         data:{
            id:id,
            csrf_test_name: csrfToken
         },
         success: function (data){
            $("#ve_name").val(data.ve_name);
            $("#ve_address").val(data.ve_address);
            $("#ve_email").val(data.ve_email);
            $("#ve_contact_num").val(data.ve_contact_num);
            $("#ve_ba_act_num").val(data.ve_ba_act_num);
            $("#ve_ba_act_name").val(data.ve_ba_act_name);
            $("#ve_bank_name").val(data.ve_bank_name);
            $("#ve_process").val(data.ve_process);
            $("#update_vendor_mod").modal('show');
         }
      });
   }

   function edchq(point) {
    var id = point.substr(3);
    var proc = point.substr(0, 3);
    let iproc = '';

    switch (proc) {
        case 'eca':
            iproc = 'cash';
            break;
        case 'ect':
            iproc = 'transfer';
            break;
        case 'ech':
            iproc = 'cheque';
            break;
        default:
            iproc = 'disburse';
    }

    $("#usid").val(id);
    $("#usprocess").val(iproc);
    $("#update_status_mod").modal('show');
}

   function eddis(point){
      var id = point.substr(2);
      var link = "<?php echo base_url() . 'finance/fetch_dis_record' ?>";
      $.ajax({
         type: "POST",
         url: link,
         data: '&id='+id+'&csrf_test_name=' + $.cookie('csrf_cookie_name'),
         dataType: 'json',
         success: function (data) {
            $("#disburse_id").val(data.disburse_id);
            $("#check_id").val(data.check_id);
            $("#up_name").val(data.name);
            $("#sel_stat").val(data.statid).text(data.status);
            $("#sel_vendor").val(data.vendid).text(data.vendor);
            $("#up_amount").val(data.amount);
            $("#sel_paytype").val(data.paytypeid).text(data.paytype);
            $("#sel_bank").val(data.accountid).text(data.account);
            $("#sel_category").val(data.ctid).text(data.category);
            $("#up_cheque").val(data.cheque);
            $("#up_clear_date").val(data.clearance);
            switch (data.paytypeid) {
               case '1':
                  $("#is_bank, #is_clear, #up_clear_date").hide();
                  $("#is_cheque").show();
                  $("#upchecklabel").text('Reference Number');
                  break;
               case '2':
                  $("#is_bank, #is_cheque, #is_clear, #up_clear_date").show();
                  $("#upchecklabel").text('Cheque Number');
                  break;
               case '3':
                  $("#is_bank, #is_cheque").show();
                  $("#is_clear, #up_clear_date").hide();
                  $("#upchecklabel").text('Reference Number');
                  break;
               default:
                  $("#is_bank, #is_cheque, #is_clear, #db_clearance_date").hide();
                  break;
            }
            $("#update_disbursement_mod").modal("show");
         },
         error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Failed to fetch disbursement data. Please try again.");
            $("#update_disbursement_mod").modal("hide");
        }
      });
   }

   $('#db_paytype').on('change', function() {
      var selectedValue = $(this).val();
      switch (selectedValue) {
         case '1':
            $("#checklabel").text('Reference Number');
            $("#is_bank, #is_clear, #db_clearance_date").hide();
            $("#is_cheque").show();
            break;
         case '2':
            $("#checklabel").text('Cheque Number');
            $("#is_bank, #is_cheque, #is_clear, #db_clearance_date").show();
            break;
         case '3':
            $("#checklabel").text('Reference Number');
            $("#is_clear, #db_clearance_date").hide();
            $("#is_bank, #is_cheque").show();
            break;
         default:
            $("#is_bank, #is_cheque, #is_clear, #db_clearance_date").hide();
            break;
      }
   });


   function disbursements(tx)
   {
      const link = "<?php echo base_url() . 'finance/fetch_disbursements/' ?>" + tx;
      const csrfToken = $.cookie('csrf_cookie_name');

      $("#rtable thead, #rtable tbody, #rheader, #rfooter, #pheader").empty();

      $.ajax({
         type: "POST",
         url: link,
         dataType: 'json',
         data:{
            proc: tx,
            csrf_test_name: csrfToken
         },
         success: function (data) {
            $("#rheader").append(data.tbanner);
            $("#pheader").append(data.pheader);
            $("#rfooter").append(data.tfooter);
            $("#rtable thead").append(data.thead);
            $("#rtable tbody").append(data.tbody);
            $("#rwelcome").hide();
            $("#rcontent").show();
         }
      });
   }

   function add_disbursement(){
      $("#add_disbursement_mod").find('input').val('');
      $("#add_disbursement_mod").modal('show');
   }

   function add_vendor(){
      $("#update_vendor_mod").find('input').val('');
      $("#update_vendor_mod").modal('show');
   }

   function add_account()
   {
      $("#update_account_mod").find('input').val('');
      $("#update_account_mod").modal('show');
   }

</script>
