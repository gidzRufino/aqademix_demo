<?php
    foreach($settings as $set){
        $sy = $set->school_year;
    }
   $is_admin = $this->session->userdata('is_admin');
?>
<div class="clearfix row-fluid">
    <div class="row">
        <div class="pull-left span6 ">
            
            <h4>Finance Management - Categories</h4>
            <input type="hidden" id="setAction" />
            <input type="hidden" id="setId" />

			<table class="table table-hover">
				<tr>
					<th class="span4" style="text-align:center;">Description</th><th class="span2" style="text-align:center;">Amount</th>
				</tr>
                <?php foreach ($fin_category as $fc) {
                    if($fc->cat_description==""||$fc->cat_description==null){
                        $cat_description = "-";
                    }else{
                        $cat_description = $fc->cat_description;
                    }
                    if($fc->cat_amount==""||$fc->cat_amount==null){
                        $cat_amount = "-";
                    }else{
                        $cat_amount = $fc->cat_amount;
                    }
                ?>
                <tr>
                    <td><?php echo $cat_description ?></td>
                    <td><?php echo $cat_amount ?></td>
                </tr>
				<?php } ?>

			</table>
            <a data-toggle="modal" href="#addCategory" onmouseover="document.getElementById('setAction').value='newCategory'" class="thumbnail text-center">
                <img  
                      alt="" style="width:24px;" src="<?php echo base_url();?>images/plus.jpg">
                Add New
                </a>
        </div>
    </div>
</div>
  <!-- <a data-toggle="modal" href="#addId" onmouseover="document.getElementById('setId').value='<?php echo $EL->user_id; ?>'" >Add ID&nbsp;</a> -->
<div id="addCategory" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">New Finance Management Category</h3>
  </div>
  <div class="modal-body">
  <!-- ajax form -->
  <form id="saveCategory" action="" method="post">
    <div class="control-group">
      <label class="control-label" for="input">Description:</label>
      <div class="controls">
        <input type="hidden" name="deptID" id="deptID" value="1" placeholder="Amount" required>
        <input type="text" name="inputDescription" id="inputDescription" placeholder="Description" required>
      </div>
      <label class="control-label" for="input">Amount:</label>
      <div class="controls">
        <input type="text" name="inputAmount" id="inputAmount" placeholder="Amount" required>
      </div>
    </div>
    </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="saveBtn" onmouseover="document.getElementById('setAction').value='saveCategory'" data-dismiss="modal" class="btn btn-primary">Save </button>
    <div id="resultSection" class="help-block" ></div>
  </div>
</div>

<script type="text/javascript">

    $("#saveBtn").click(function() {       
        var url = "<?php echo base_url().'index.php/financemanagement/saveCategory' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               data: $("#saveCategory").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   document.location='<?php echo base_url() ?>index.php/financemanagement/setFinCategory'
                   $("form#saveCategory")[0].reset()               }
             });
        
        return false; // avoid to execute the actual submit of the form.

        });
</script>
