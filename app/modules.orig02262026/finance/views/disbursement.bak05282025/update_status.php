<div class="modal-dialog modal-xs statmodal">
   <div class="modal-content">
      <div class="modal-header text-center">
         <b class="modal-title" id="myModalLabel">
            <i class="fa fa-bank"></i> Update Status
         </b>
      </div>
      <div class="modal-body">
         <button type="button" id="rlstat" class="btn bg-orange statbtn"><i class="fa fa-rocket"></i> Released</button>
         <button type="button" id="clstat" class="btn bg-green statbtn"><i class="fa fa-check"></i> Cleared</button>
         <button type="button" id="cnstat" class="btn bg-red statbtn"><i class="fa fa-times-circle"></i> Cancelled</button>
         <input type="hidden" id="usid">
         <input type="hidden" id="usprocess">
      </div>
   </div>
</div>

<script type="text/javascript">

$(".statbtn").click(function () {
    const data = {
        statid: this.id, // Corrected key-value pair syntax
        usid: $("#usid").val(),
        csrf_test_name: $.cookie('csrf_cookie_name') // Ensure this cookie exists
    };

    const url = "<?php echo base_url('finance/update_status'); ?>";
    const thisprocess = $("#usprocess").val();

    $.post(url, data, function (response) {
        if (response.success) {
            alert('Transaction Updated Successfully!');
            $("#update_status_mod").modal('hide');
            disbursements(thisprocess); // Ensure this function is defined elsewhere
        } else {
            alert('No transaction was updated. Please try again later.');
        }
    }, 'json').fail(function () {
        alert('Failed to connect to the server.');
    });
});

</script>
