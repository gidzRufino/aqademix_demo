<?php
    
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   
?>


<div class="clearfix" style="margin:0px;">
   <div class="panel panel-default" style="margin-top: 15px;">
      <div class="panel-heading text-center">
         <h3 class="panel-title"><b>Finance Account Available Plans</b></h3>
         <form id="testpost" action="" method="post">
            <input type="text" name="test_id" id="test_id" placeholder="please enter something here" required>
            <button id="sendBtn"  onclick="sendnow()" class="btn btn-sm btn-success">Save Plan</button>
            
         </form>
      </div>
   </div>
</div>

<script type="text/javascript">
   
   function sendnow()
   {
      var url1 = "<?php echo base_url().'financemanagement/testsend' ?>";
      $.ajax({
         type: "POST",
         url: url1,
         data: $("#testpost").serialize(),
         success: function(data){};
      });
   }

  
  //  function saveEditPlan()
  // {
  
  //   var eplan_url = "<?php echo base_url().'financemanagement/saveEditPlan' ?>";
  //   $.ajax({
  //      type: "POST",
  //      url: eplan_url,
  //      data: $("#saveEditplanform").serialize(), 
  //      success: function(data){location.reload();}
  //   });
    
  //   alert("Success!!! The plan was successfully edited. A notification has also been sent to the administration.");  
    
</script>