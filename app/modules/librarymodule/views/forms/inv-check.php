<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript">
   $(document).ready(function(){
   	$("#inv_table").tablesorter({debug: true});
   });  
</script>
<?php 
   $uri = $this->uri->segment(3);
   if ($uri) {
      foreach ($bk_category as $cy) {
         if ($cy->ca_id == $uri) {
            $ctitle = $cy->ca_category;
         }
      }
   }else{
      $ctitle = "General";
   }
?>
<div class="clearfix" style="margin:0px;">
  <div class="container-fluid">
    <div class="well well-sm" style="margin: 10px 0px">
      <div class="row">
        <div class="col-md-2 col-md-offset-1">
          <button type="button" class="btn btn-primary" onclick="newbook()" style="text-align:center;">
            <div class="col-md-12">
              <i class="fa fa-file-text-o fa-2x"></i><br/>
              <h4>New Entry</h4>
            </div>
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-info" onclick="showinventory()" style="text-align:center;">
            <div class="col-md-12">
              <i class="fa fa-clipboard fa-2x"></i><br/>
              <h4>Item List</h4>
            </div>
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-warning" onclick="goinventory()" style="text-align:center">
            <div class="col-md-12">
              <i class="fa fa-star fa-2x"></i><br/>
              <h4>Inventory</h4>
            </div>
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-success" onclick="golend()" style="text-align:center">
            <div class="col-md-12">
              <i class="fa fa-road fa-2x"></i><br/>
              <h4>Lend an Item</h4>
            </div>
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-default" onclick="dashboard()" style="text-align:center">
            <div class="col-md-12">
              <i class="fa fa-tasks fa-2x"></i><br/>
              <h4>Dashboard</h4>
            </div>
          </button>
        </div>
      </div>
    </div>
    <div class="panel panel-info">
    	<div class="panel-heading">
         <b>Inventory of Items</b> (press CTRL + F to search for a title. Command + F on Mac.)
    	</div>
    	<div class="panel-body">
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-md-12">
    					<!-- <table class="table table-condensed table-bordered"> -->
    					<div>
    					<table id="inv_table" style="width: 100%;" class="tablesorter table table-condensed table-bordered table-striped">
    						<thead style="background:#E6EEEE;">
                    	<tr>
                        <th class="bg-primary" style="text-align:center;">Item ID</th>
                      	<th class="bg-primary" style="text-align:center;">Title / Description</th>
                      	<th class="bg-primary" style="text-align:center;">Author</th>
                        <th class="bg-primary" style="text-align:center;">Dewey Decimal Classification</th>
                        <th class="bg-primary" style="text-align:center;">Description</th>
                        <th class="bg-primary" style="text-align:center;">Status</th>
                        <th class="bg-primary" style="text-align:center;"># of Items</th>
                    	</tr>
                    	</thead>

                    	<?php
                        $cnt = 0; $tcnt = 0;
                    		foreach ($bk_general as $inv) {
                          $tcnt++;
                          // $gen_id = $inv->gb_id;
                          // $icount = 0;
                          // foreach ($bk_item as $it) {
                          //   $igen_id = $it->bk_gb_id;
                          //   if ($gen_id == $igen_id) {
                          //      $icount++;
                          //   }
                          // }
                          // $cnt = $cnt + $icount;
                    	?>

                    	<tr>
                         <td style="text-align:center;"><a href="<?php echo base_url('librarymodule/item/'.base64_encode($inv->bk_id).'/'.base64_encode($inv->gb_id)) ?>"><?php echo $inv->bk_id ?></td>    
                         <td style="text-align:center;"><?php echo $inv->gb_title ?></td>
                         <td style="text-align:center;"><?php echo $inv->gb_author ?></td>
                         <td style="text-align:center;"><?php echo $inv->gb_dw ?></td>
                         <td style="text-align:center;"><?php echo $inv->gb_remarks ?></td>
                         <td style="width:120px;text-align:center;">
                           <select class="cstatus" id="stat<?php echo $inv->bk_id ?>" style="width:100%;" onchange="change_status(this.id)">
                              <option value="<?php echo $inv->bk_st_id ?>"><?php echo $inv->st_status ?></option>
                                 <?php foreach ($bk_status as $bc) { ?>
                              <option value="<?php echo $bc->st_id ?>"><?php echo $bc->st_status ?></option>   
                                 <?php } ?>
                           </select>
                         </td>
                         <td style="text-align:center;"><?php echo $inv->bk_st_date ?></td>
                      </tr>

                    	<?php
                    		}
                    	?>
                      <tr></tr>
                    	
                   </table>	
                   <!-- <input type="hidden" name="counts" id="counts" value="<?php echo $cnt ?>" required> -->
                   <input type="hidden" name="tcounts" id="tcounts" value="<?php echo $tcnt ?>" required>
                   </div>				
                  
    				</div>	
    			</div>
    		</div>			
    	</div>
    </div>

  </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
      $("#ebk_property").select2();
      $("#categ").select2();
      // $(".cstatus").select2();
      // var cnt = document.getElementById('counts').value;
      // var tcnt = document.getElementById('tcounts').value;
      // document.getElementById('cntd').innerHTML = cnt;
      // document.getElementById('tcntd').innerHTML = tcnt;

   });

   function getcateg()
   {
      var cval = document.getElementById('categ').value; document.location = '<?php echo base_url()?>librarymodule/inventory/'+ cval;
   }

   function change_status(id)
   {
      var ided = id.slice(4);
      var val = document.getElementById(id).value;
      // alert(val);
      var url1 = "<?php echo base_url() . 'librarymodule/update_status' ?>"; 
            $.ajax({
               type: "POST",
               url: url1,
               data: 'tr_st_id='+val+'&tr_bk_id='+ided+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function (data) {
                  alert('Status Updated.');
                  // // document.location = '<?php echo base_url() ?>librarymodule/lend';
                  // location.reload();
                  }
            });
   }

   $("#display_now").click(function(){
   
      var iid = document.getElementById('ebk_property').value;
      if(iid!=""&&iid!="Search Item"){
         document.location = '<?php echo base_url()?>librarymodule/books/'+ iid;
      }else{
         alert("Please select an item to be displayed and try again.");
      }
   });
</script>
