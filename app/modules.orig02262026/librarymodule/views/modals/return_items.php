<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header bg-primary">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Library Transaction</h4>
    </div>
  	<!-- <div class="modal-body" style="overflow-y:scroll; height:400px;"> -->
    <div class="modal-body">
      <div class="row">
        div.
      </div>
    </div>
		</div>
  	<div class="modal-footer">
  		<span>
        <button type="button" data-dismiss="modal" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i> close</button>
      </span>
    </div>	
	</div>
</div>


<script type="text/javascript">
  
$(document).ready(function() {
  $("#selectPlan").select2();
});

function savePlan()
{
  var plan_url = "<?php echo base_url().'financemanagement/saveAccountPlan' ?>";
  $.ajax({
     type: "POST",
     url: plan_url,
     data: $("#saveplanform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
     success: function(data){location.reload();}
  });
  
  alert("Success!!! The account is now enrolled to a payment plan.");  

}

 </script>