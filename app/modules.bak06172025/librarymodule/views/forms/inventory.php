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
          <div class="row">
               <div class="col-md-3" style="margin-top: 14px;"><b><span id="categ_title"><?php echo $ctitle ?></span> Item Inventory</b> (<span id="cntd"></span> Items) 
                <!-- (<span id="tcntd"></span> Titles) -->
               </div>
               <div class="col-md-5 well well-sm" style="margin-bottom: 0px;">
                <!-- <div class="input-group"> -->
                <div class="col-md-9">  
                   <select id="ebk_property" name="ebk_property" tabindex="-1" style="width:100%;">
                      <option style="width:400px;">Quick Search</option>
                      <?php foreach ($bk_general as $blg) { ?>
                      <option style="width:400px;" value="<?php echo base64_encode($blg->gb_id) ?>">Title: <?php echo $blg->gb_title.' | Author: '.$blg->gb_author.'| Desc:'.$blg->gb_remarks.' | DWC:'.$blg->gb_dw  ?></option>
                      <?php } ?>
                   </select>
                </div>
                <div class="col-md-3">
                   <button class="btn btn-primary btn-sm" id="display_now" type="button">Display Item Now!</button> 
                </div>
             <!-- </div> -->
               </div>
               <div class="col-md-4 pull-right" style="margin-top: 12px;">
                  <div class="col-md-5"><b><span>Display by Category</span></b></div>
                  <div class="col-md-7 pull-right">
                     <select id="categ" style="width:100%;" onchange="getcateg()">
                        <option>Select Category</option>
                        <?php foreach ($bk_category as $bc) { ?>
                        <option value="<?php echo $bc->ca_id ?>"><?php echo $bc->ca_category ?></option>   
                        <?php } ?>
                     </select>
                  </div>
                </div>
        </div>
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
                      	<th class="bg-primary" style="text-align:center;">Title / Description</th>
                      	<th class="bg-primary" style="text-align:center;">Author</th>
                        <th class="bg-primary" style="text-align:center;">Dewey Decimal Classification</th>
                        <th class="bg-primary" style="text-align:center;">Description</th>
                        <th class="bg-primary" style="text-align:center;">Category</th>
                        <th class="bg-primary" style="text-align:center;"># of Items</th>
                    	</tr>
                    	</thead>

                    	<?php
                        $cnt = 0; $tcnt = 0;
                    		foreach ($bk_general as $inv) {
                          $tcnt++;
                          $gen_id = $inv->gb_id;
                          $icount = 0;
                          foreach ($bk_item as $it) {
                            $igen_id = $it->bk_gb_id;
                            if ($gen_id == $igen_id) {
                               $icount++;
                            }
                          }
                          $cnt = $cnt + $icount;
                    	?>

                    	<tr>
                         <td style="text-align:center;"><a href="<?php echo base_url('librarymodule/books/'.base64_encode($inv->gb_id)) ?>"><?php echo $inv->gb_title ?></td>    
                         <td style="text-align:center;"><?php echo $inv->gb_author ?></td>
                         <td style="text-align:center;"><?php echo $inv->gb_dw ?></td>
                         <td style="text-align:center;"><?php echo $inv->gb_remarks ?></td>
                         <td style="text-align:center;"><?php echo $inv->ca_category ?></td>
                         <td style="text-align:center;"><?php echo $icount ?></td>
                      </tr>

                    	<?php
                    		}
                    	?>
                      <tr></tr>
                    	
                   </table>	
                   <input type="hidden" name="counts" id="counts" value="<?php echo $cnt ?>" required>
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
      var cnt = document.getElementById('counts').value;
      var tcnt = document.getElementById('tcounts').value;
      document.getElementById('cntd').innerHTML = cnt;
      // document.getElementById('tcntd').innerHTML = tcnt;

   });

   function getcateg()
   {
      var cval = document.getElementById('categ').value; document.location = '<?php echo base_url()?>librarymodule/inventory/'+ cval;
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
