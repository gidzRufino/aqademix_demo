<?php
    
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   
?>


<div class="clearfix" style="margin:0px;">
   <div class="panel panel-default" style="margin-top: 15px;">
      <div class="panel-heading text-center">
         <h3 class="panel-title"><b>Finance Account Available Plans</b></h3>
         <!-- <form id="testpost" method="post"> -->
            <input type="text" name="test_id" id="test_id" placeholder="please enter something here" required>
            <button id="sendBtn"  onclick="sendnow()" class="btn btn-sm btn-success">Save Plan</button>
            
            <select id='testsel'> 
              <option value="a">this is a</option>
              <option value="b">this is b</option>
              <option value="c">this is c</option>
              <option value="d">this is d</option>
              <option value="e">this is e</option>
            </select>


         <!-- </form> -->
      </div>
   </div>
   <div class="panel panel-default" style="margin-top: 15px;">
     
   </div>
</div>

<script type="text/javascript">
   
   function sendnow()
   {
    var tested = document.getElementById('test_id').value;
    document.location = '<?php echo base_url()?>financemanagement/testsend/'+tested; 
   }

   $("#testsel").on('change', function(){
      alert(this.value);
      document.getElementById('test_id').value = this.value;
   });

</script>