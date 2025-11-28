<?php
    $settings = Modules::run('main/getSet');
    $sy = $settings->school_year;
    
   $is_admin = $this->session->userdata('is_admin');
   $userid = $this->session->userdata('user_id');
   $url_seg = $this->uri->segment(3);
    if ($url_seg==''){
      $use_sy = $set_sy->value;
    }else{
      $use_sy = base64_decode($url_seg);
    }
?>

<!--  -->
<div class="clearfix row" style="margin:0;">
  <div class="panel panel-info"style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 class="text-center panel-title"><b>Configure Finance Settings</b></h3>
    </div>
    <div class="panel-body">
      <div class="pull-right " style="margin-left: 10px;">
        <button name="addbtnItem" id="addbtnItem" type="button" data-toggle="modal" class="btn btn-sm btn-info pull-right"><i class="fa fa-star fa-fw"></i> New Item</button>
        <button name="addbtnPlan" id="addbtnPlan" type="button" data-toggle="modal" class="btn btn-sm btn-info pull-right"><i class="fa fa-suitcase fa-fw"></i> New Plan</button>
        <button name="addbtnDepartment" id="addbtnDepartment" type="button" data-toggle="modal" class="btn  btn-sm btn-info pull-right"><i class="fa fa-building fa-fw"></i> New Department</button>
      </div>

      <div class="pull-left span3" style="margin-top: 5px;" >
        <select onclick="get_sy()" tabindex="-1" id="get_sy" name="get_sy" style="width:225px;" >   
           <option>Select School Year</option>
              <?php foreach ($school_year as $sy){$syid = $sy->sy_id; ?>  
            <option value="<?php echo base64_encode($syid); ?>"><?php echo $sy->school_year ?></option>
              <?php } ?> 
        </select>
      </div>
    </div>
  </div>

      <?php if ($this->uri->segment(3)!=''){  ?>

  <div class="panel panel-info"style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <?php $sy_selected = $get_sy->school_year; ?>
      <h3 class="text-center panel-title"><b>Configuring School Year: </b><b style="color: red;"><?php echo $sy_selected ?></b>
      <a href="<?php echo base_url() ?>financemanagement/config/print/"><i class="fa fa-print pointer pull-right" style="font-size: 22px;"></i></a></h3>
    </div>
    <div class="panel-body">
      <div class="panel-group" id="level_down">    
        <?php foreach($getLevel as $iLevel) { 
          $levelmain = $iLevel->grade_id;
          $levelhash = "hash".$levelmain;
        ?>
        <div class="panel panel-info">
          <div class="panel panel-heading">
            <h2 class="panel-title">
              <a data-toggle="collapse" data-parent="#level_down" href="#<?php echo $levelhash ?>"><b><?php echo $iLevel->level ?></b></a>
            </h2>
          </div>
          <div id="<?php echo $levelhash ?>" class="panel-collapse ">
            <div class="panel-body">
            <button name="addbtn<?php echo $iLevel->grade_id ?>" id="addbtn<?php echo $iLevel->grade_id?>" style="margin-top: -10px; margin-bottom: 5px;" type="button" data-toggle="modal" class="addUp btn btn-success btn-sm pull-right"><i class="fa fa-plus fa-fw fa-lg"></i> Add Plan Items</button>
              <table class="table table-condensed table-responsive table-hover table-bordered" id="levelTable">
                <tr>
                    <td style="text-align:center;font-weight:bold;color:green;">Item Description</td>
                    <td style="text-align:center;font-weight:bold;color:green;">Amount</td> <!-- #0095DB -->
                    <td style="text-align:center;font-weight:bold;color:green;">Payment Freq.</td>
                    <td style="text-align:center;font-weight:bold;color:green;">School Year</td>
                    <td style="text-align:center;font-weight:bold;color:green;">Plan</td>
                    <td style="text-align:center;font-weight:bold;color:green;">Actions</td>
                  </tr>

                  <?php foreach($showInitsy as $si){ if($si->level_id==$iLevel->grade_id){
                    $itDescID = $si->item_id;
                    $initID = $si->init_id;
                    $itemAmount = $si->item_amount;
                    $schedID = $si->schedule_id;
                    $syID = $si->sy_id;
                    $impDate = $si->implement_date;
                    $itPlan = $si->plan_id;
                    $delBtn = "delitem". $initID;
                    $editBtn = "edititem". $initID;
                    
                  foreach($showItems as $sItem){ if($sItem->item_id==$itDescID){
                    $itDescription = $sItem->item_description;
                  }}
                  foreach($sfrequency as $sFreq){ if($sFreq->schedule_id==$schedID){
                    $itSchedule = $sFreq->schedule_description;
                  }} 
                  foreach($school_year as $sy){ if($sy->sy_id==$syID){
                    $itSY = $sy->school_year;
                  }} 
                  foreach($showPlan as $sp){ if($sp->plan_id==$itPlan){
                    $itPlanD = $sp->plan_description;
                  }} ?>

                  <tr align="center"> 
                    <td style="text-align:center"><?php echo $itDescription ?></td>
                    <td style="text-align:center"><?php echo number_format($itemAmount, 2, '.', ','); ?></td>
                    <td style="text-align:center"><?php echo $itSchedule ?></td>
                    <td style="text-align:center"><?php echo $itSY ?></td>
                    <td style="text-align:center"><?php echo $itPlanD ?></td>
                    <td style="text-align:center">
                      <span>
                        <button name="<?php echo $delBtn ?>" id="<?php echo $delBtn ?>" onclick="checkdel_btnID(this.id)" type="button" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                        <button name="<?php echo $editBtn ?>" id="<?php echo $editBtn ?>" onclick="checkedit_btnID(this.id)" type="button" class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> </button>
                      </span>
                    </td>
                  </tr>
                  <?php }} ?>
                </table>
            </div>
          </div>
        </div>
        <?php } ?> <!-- foreach($getLevel as $iLevel) -->
      </div>
    </div>    
    </div>
  </div>
   
  <?php }else{ ?> 
    
    <div class="">
      <div class="" style="margin-top: 0px;">
        <div class="jumbotron">
          <h1>Hi there!</h1>
          <p>To start configuring <b>e-sKwela</b> finance settings, please select the desired school year to configure from the 'Select School Year' dropdown menu located above. Have a great day! </p>
          <p>
          <a class="btn btn-primary btn-lg">
          Learn more
          </a>
          </p>
        </div>
      </div>
    </div>

  <?php } ?>

<div id="addItemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Create New Payment Item</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="addItemForm" name="addItemForm">
      <div class="control-group">     
        <label class="control-label" for="input" >Item Description</label>
        <div class="controls">
          <span><select id="itSelItem" name="itSelItem" class="span3" style="width:95%;" tabindex="-1" >   
           <option>Select an Item</option>
              <?php foreach ($showItems as $initLev){ ?>  
           <option value="<?php echo $initLev->item_id; ?>"><?php echo $initLev->item_description ?></option>
              <?php } ?> 
          </select></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Payment Plan</label>
        <div class="controls">
          <select id="itPlan" name="itPlan" class="span3" style="width:95%;" tabindex="-1" >   
           <option>Select Plan</option>
              <?php foreach ($showPlan as $sPlan){ ?>  
           <option value="<?php echo $sPlan->plan_id; ?>"><?php echo $sPlan->plan_description ?></option>
              <?php } ?> 
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Enter Amount in PhP</label>
        <div class="controls">
          <input type="text" onblur="amountEntered()" name="itAmount" id="itAmount" style="width:95%;" placeholder="Enter item amount in PhP" required>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Implementation Frequency </label>
        <div class="controls">
          <select id="itSched" name="itSched" class="span3" style="width:95%;" tabindex="-1" >   
            <option>Select implementation Frequency</option>
              <?php foreach ($sfrequency as $sfreq){ ?>  
            <option value="<?php echo $sfreq->schedule_id; ?>"><?php echo $sfreq->schedule_description ?></option>
                <?php } ?> 
          </select>
        </div>  
      </div>
      <div class="control-group">
        <label class="control-label" for="input">Select School Year</label>
        <div class="controls">
          <select name="itSY" id="itSY" class="span3" style="width:95%;" tabindex="-1"  >   
            <option>Select School Year</option>
                  <?php foreach ($school_year as $sy){ ?>  
            <option value="<?php echo $sy->sy_id; ?>"><?php echo $sy->school_year ?></option>
                  <?php } ?> 
          </select>
        </div>
      </div>
      <div class="hidding">
        <input name="itImpDate" type="hidden" id="itImpDate" value="<?php echo date("F Y") ?> "  required>
        <input type="hidden" name="itID" id="itID" required>
        <input type="hidden" name="itChCr" id="itChCr" value="0" required>
      </div>
      <div class="hiddingLog">
        <?php 
          $elogtdate = date("F d, Y [g:i:s a]");
          $elogremarks = '';
        ?>
        <input type="hidden" name="npelogdate" id="npelogdate" value="<?php echo $elogtdate ?>"required>
        <input type="hidden" name="npelogaccount" id="npelogaccount" value="<?php echo $userid ?>"required>
        <input type="hidden" name="npelogremarks" id="npelogremarks" value="<?php echo $elogremarks ?>"required>
      </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveItem"><i class="fa fa-save fa-fw"> </i> Save Changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Create New Plan Modal -->
<div id="newPlanModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="plan_label">Create New Plan</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="newPlanForm" name="newPlanForm">
          <div class="control-group" style="margin-top: -15px;">
            <label class="control-label" for="input" id="plan_flabel" style="color:#BB0000;">New Plan Name</label>
            <div class="controls">
              <input name="nwPlanName" id="nwPlanName" type="text" style="width:100%; margin-bottom: 15px;" placeholder="Enter the Plan name"  required>
              <input type="hidden" name="plan_indicate" id="plan_indicate" value=""required>
              <input type="hidden" name="old_plan" id="old_plan" value=""required>
              <input type="hidden" name="plan_id" id="plan_id" value=""required>
            </div>
          </div>
          <div id="plan_tableform" style="overflow-y:scroll; height: 250px;" >
            <table class="table table-condensed table-bordered">
              <tr>
                <th style="text-align:center">Existing Plans</th>
                <th class="text-center">Actions</th>
              </tr>
              <?php foreach ($showPlans as $sp) { 
                $sp_id = $sp->plan_id;
                $sp_name = $sp->plan_description;
              ?>
              <tr>
                <td style="text-align:center"><?php echo $sp->plan_description; ?></td>
                <td class="text-center">
                  <span>
                    <button name="pldel<?php echo $sp_name ?>" id="pldel<?php echo $sp_id ?>" onclick="pl_delBtn(this.id)" type="button" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                    <button name="pledit<?php echo $sp_name ?>" id="pledit<?php echo $sp_id ?>" onclick="pl_editBtn(this.id)" type="button" class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> </button>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <div class="hiddingLog">
            <?php 
              $elogtdate = date("F d, Y [g:i:s a]");
              $elogremarks = '';
            ?>
            <input type="hidden" name="pelogdate" id="pelogdate" value="<?php echo $elogtdate ?>"required>
            <input type="hidden" name="pelogaccount" id="pelogaccount" value="<?php echo $userid ?>"required>
            <input type="hidden" name="pelogremarks" id="pelogremarks" value="<?php echo $elogremarks ?>"required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="saveNwPlan" class="btn btn-success btn-sm"><i class="fa fa-save fa-fw"></i> Save New Plan</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fa-fw"> </i> Cancel</button>  
      </div>
    </div>
  </div>
</div>

<!-- end Create New Plan Modal -->
<!-- New Item  -->
<div id="newItemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="item_label">Create New Item</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="newItemForm" name="newItemForm">
          <div class="control-group" style="margin-top:-15px;">
            <label id="item_flabel" class="control-label" for="input" style="color:#BB0000;">New Item Name</label>
            <div class="controls">
              <input name="nwItemName" id="nwItemName" type="text" style="width: 100%;" placeholder="Enter the name of the new item."  required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input" style="color:#BB0000;">Department</label>
            <div class="controls">
              <span>
                <select id="nwDept" name="nwDept" onclick="showCateg(this.value)" tabindex="-1" style="width:100%; margin-bottom: 15px;" >   
                  <option>Select Department</option>
                    <?php foreach ($showDept as $sd){ ?>  
                  <option value="<?php echo $sd->dept_id; ?>"><?php echo $sd->dept_description ?></option>
                    <?php } ?> 
                </select>
              </span>
              </div>
          </div>
          <div id="item_tableform" style="height: 250px; overflow-y:scroll; ">
            <table class="table table-condensed table-bordered">
              <tr>
                <th style="text-align:center">Existing Item</th>
                <th style="text-align:center">Department</th>
                <th class="text-center">Actions</th>
              </tr>
              <?php foreach ($showItems as $sm) { 
                $sm_id = $sm->item_id;
                $sm_name = $sm->item_description;
                $sm_did = $sm->dept_id;
                $sm_dname = $sm->dept_description;
              ?>
              <tr>
                <td style="text-align:center"><?php echo $sm->item_description; ?></td>
                <td id="it_dname<?php echo $sm_id; ?>" name="it_dname<?php echo $sd->dept_description; ?>" style="text-align:center"><?php echo $sm->dept_description; ?></td>
                <td class="text-center">
                  <span>
                    <button name="itdel<?php echo $sm_name ?>" id="itdel<?php echo $sm_id ?>" onclick="it_delBtn(this.id)" type="button" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                    <button name="itedit<?php echo $sm_name ?>" id="itedit<?php echo $sm_id ?>" onclick="it_editBtn(this.id)" type="button" class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> </button>
                    <input type="hidden" name="it_did<?php echo $sm_id ?>" id="it_did<?php echo $sm_id ?>" value="<?php echo $sm_did ?>"required>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <div class="hiddingLog">
            <?php 
              $elogtdate = date("F d, Y [g:i:s a]");
              $elogremarks = '';
            ?>
            <input type="hidden" name="item_indicate" id="item_indicate" value=""required>
            <input type="hidden" name="old_item" id="old_item" value=""required>
            <input type="hidden" name="item_id" id="item_id" value=""required>
            <input type="hidden" name="old_idept" id="old_idept" value=""required>
            <input type="hidden" name="delogdate" id="delogdate" value="<?php echo $elogtdate ?>"required>
            <input type="hidden" name="delogaccount" id="delogaccount" value="<?php echo $userid ?>"required>
            <input type="hidden" name="delogremarks" id="delogremarks" value="<?php echo $elogremarks ?>"required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="chargeSavebtn" data-dismiss="modal" onclick="saveNewItem()"class="btn btn-success btn-sm"><i class="fa fa-save fa-fw"> </i> Save Item</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fa-fw"> </i> Cancel</button>  
      </div>
    </div>
  </div>
</div>

<!-- Create New Department-->
<div id="newDeptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="deptLabel">Create New Department</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"id="newDeptForm" name="newDeptForm">
          <div class="control-group" style="margin-top: -15px;">
            <input type="hidden" name="oldDept" id="oldDept" value="" required>
            <input type="hidden" name="odept_id" id="odept_id" value="" required>
            <label class="control-label" for="input" id="deptformlable" style="color:#BB0000;">New Department Name</label>
            <div class="controls">
               <input name="nwDeptName" id="nwDeptName" type="text" style="width:100%; margin-bottom: 15px;" placeholder="Enter New Department name."  reccrcquired>
            </div>
          </div>
          <div id="dept_table">
            <table class="table table-condensed table-bordered" style="margin-bottom: 15px;">
              <tr>
                <th style="text-align:center">Existing Departments</th>
                <th class="text-center">Actions</th>
              </tr>
              
              <?php foreach ($showDept as $sd) { 
                $sd_id = $sd->dept_id;
                $sd_desc = $sd->dept_description;
              ?>
              
              <tr>
                <td style="text-align:center"><?php echo $sd->dept_description; ?> </td>
                <td class="text-center">
                  <span>
                    <button name="ddel<?php echo $sd_desc ?>" id="ddel<?php echo $sd_desc ?>" onclick="ddel_btnID(this.id)" type="button" data-toggle="modal" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                    <button name="dedit<?php echo $sd_id ?>" id="dedit<?php echo $sd_desc ?>" onclick="dedit_btnID(this.id)" type="button" class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> </button>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <div class="hiddingLog">
            <?php 
              $elogtdate = date("F d, Y [g:i:s a]");
              $elogremarks = '';
            ?>
            <input type="hidden" name="delogdate" id="delogdate" value="<?php echo $elogtdate ?>"required>
            <input type="hidden" name="delogaccount" id="delogaccount" value="<?php echo $userid ?>"required>
            <input type="hidden" name="delogremarks" id="delogremarks" value="<?php echo $elogremarks ?>"required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="saveNwDept" class="btn btn-success btn-sm"><i class="fa fa-save fa-fw"> </i>Save Department</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fa-fw"> </i> Cancel</button>  
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
    $("#itSelItem").select2();
    $("#get_sy").select2();
    $("#itSched").select2();
    $("#itSY").select2();
    $("#nwCateg").select2();
    $("#nwDept").select2();
    $("#itPlan").select2();
    $("#nwCategoryDept").select2();
});

function get_sy()
  {
    var syid = document.getElementById("get_sy").value;
    var voptions = 'Select School Year'
    if (syid==voptions){
      document.location = '<?php echo base_url()?>financemanagement/'   
    }else{
      document.location = '<?php echo base_url()?>financemanagement/config/'+syid   
    }
  }

$(".addUp").click(function(){ // identify the button clicked
    var btnID = this.id;
    btnID = btnID.slice(6,8); //get levelID
    document.getElementById('itID').value = btnID;
    $("#addItemModal").modal();
     // var curRow = this.parentNode.parentNode.rowIndex;
     // var grid = document.getElementById("levelTable");
     // rowPoint = curRow + 2;
     // addRow = grid.insertRow(rowPoint);
     // var addRowCell = addRow.insertCell(0);
     // addRowCell.colSpan = "6"
     // addRowCell.innerHTML = 'Yes we Made it! Thank You Lord!';    

});

	function saveNewItem()
	{
		var nItem = document.getElementById('nwItemName').value;
    var i_indicate = document.getElementById("item_indicate").value;
		if (nItem!=""){
			var nDept = document.getElementById('nwDept').value;
			if(nDept!=""){
        if (i_indicate=="new_item"){
          var splan = document.getElementById('nwItemName').value;
          svRemarks = 'Created New Item ['+splan+'}';
          document.getElementById('pelogremarks').value = svRemarks;
  				var item_url = "<?php echo base_url().'financemanagement/saveNewItem' ?>"; // the script where you handle the form input.
  				$.ajax({
  	       	type: "POST",
  	       	url: item_url,
  	       	data: $("#newItemForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
  	       	success: function(data){
  		       	alert('New item successfully added!');
  		       	location.reload();
            }
  				});
        }else if (i_indicate=="edit_item"){
          var splan = document.getElementById('nwItemName').value;
          var oitem = document.getElementById("old_item").value;
          var odept = document.getElementById("old_idept").value;
          var ndept = document.getElementById("nwDept").value;
          svRemarks = 'Edited an existing item [from: ' +oitem+':'+odept+' to:'+splan+':'+ndept+']';
          document.getElementById('pelogremarks').value = svRemarks;
          var item_url = "<?php echo base_url().'financemanagement/editItem' ?>"; // the script where you handle the form input.
          $.ajax({
            type: "POST",
            url: item_url,
            data: $("#newItemForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data){
              alert('Yey!!! Item successfully edited!');
              location.reload();
            }
          });
        }
			}else{
				alert("Please select department.")
			}
		}else{

			alert("Please enter new item name.")
		}
	}

	function amountEntered()
	{
		var amnt = document.getElementById('itAmount').value;
		if (isNaN(amnt)){alert("Please enter a valid amount.")
		}else{
		if(amnt!=null || amnt !=undefined){
			amnt = convertNumtoString(amnt);
			document.getElementById('itAmount').value = amnt;
		}}
	}

	  function convertNumtoString(sNumber) 
	  {
	    //Seperates the components of the number
	    var n= sNumber.toString().split(".");
	    //Comma-fies the first part
	    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    //Combines the two sections
	    return n.join(".");
	  }

	  function convertStrintoNum(svariable)
	  {
	    var cNumber = svariable.replace(/\,/g,'');
	    cNumber = parseFloat(cNumber);
	    if (isNaN(cNumber) || !cNumber ){ 
	      cNumber = 0;
	    }
	    return cNumber;
	  }

	$("#addbtnItem").click(function(){	
	   document.getElementById("nwItemName").placeholder = "Enter the name of the new item."
     document.getElementById("nwItemName").value = "";
     document.getElementById("item_label").innerHTML = "Create New Item";
     document.getElementById("item_flabel").innerHTML = "New Item Name";
     document.getElementById("item_indicate").value = "new_item";
     var itm = document.getElementById("item_tableform");
     itm.style.display = "block";
		$("#newItemModal").modal();

	});

	$("#addbtnPlan").click(function(){
    document.getElementById("nwPlanName").placeholder = "Enter the Plan name";
    document.getElementById("nwPlanName").value = "";
    document.getElementById("plan_label").innerHTML = "Create New Plan";
    document.getElementById("plan_flabel").innerHTML = "New Plan Name";
    document.getElementById("plan_indicate").value = "new_plan";
    var pln = document.getElementById("plan_tableform");
    pln.style.display = "block";
		$("#newPlanModal").modal();
	});

	$("#addbtnDepartment").click(function(){
    document.getElementById("deptLabel").innerHTML = "Create New Department";
    document.getElementById("deptformlable").innerHTML = "New Department Name";
    document.getElementById("nwDeptName").placeholder = "Enter New Department name.";
    document.getElementById("nwDeptName").value = "";
    var dpt = document.getElementById("dept_table");
    dpt.style.display = "block";
		$("#newDeptModal").modal();
	});

	$("#addbtnCategory").click(function(){ 
		$("#newCategoryModal").modal();
	});


	// function showCateg(deptIdent)
	// {		
	//     var xmlhttp;
	//     if (window.XMLHttpRequest) {
	//         // code for IE7+, Firefox, Chrome, Opera, Safari
	//         xmlhttp=new XMLHttpRequest();
	//     } else {
	//         // code for IE6, IE5
	//         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	//     }
	//     xmlhttp.onreadystatechange=function() {
	//         if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//             document.getElementById("nwCateg").innerHTML=xmlhttp.responseText;
	//         }
	//     }
	//     xmlhttp.open("GET","<?php echo base_url().'financemanagement/showCategory/'?>"+deptIdent,true);
	//     xmlhttp.send();
	   	// var categBtn = document.getElementById('categDiv');
	   	// categBtn.display = block;
	// }

	$("#saveItem").click(function() 
	{
	var svItemName = document.getElementById('itSelItem');
	var svItPlan = document.getElementById('itPlan');
	var svItAmount = document.getElementById('itAmount').value;
	svItAmount = convertStrintoNum(svItAmount);
	var	svItSched = document.getElementById('itSched');
	var svItSy = document.getElementById('itSY');
	var svItImpDate = document.getElementById('itImpDate').value;
	var svLvl = document.getElementById('itID').value;
	svItem = svItemName.options[svItemName.selectedIndex].text;
	svPlan = svItPlan.options[svItPlan.selectedIndex].text;
	svSched = svItSched.options[svItSched.selectedIndex].text;
	svSY = svItSy.options[svItSy.selectedIndex].text;
	svRemarks = 'Created new payment items [Lvl:'+svLvl+', Pl:'+svPlan+', It:'+svItem+', Amt:'+svItAmount+', Fq:'+svSched+', SY:'+svSY+', Imp:'+svItImpDate;
	document.getElementById('npelogremarks').value = svRemarks;

	var svItemName = document.getElementById('itSelItem').value;
	var svItPlan = document.getElementById('itPlan').value;
	var	svItSched = document.getElementById('itSched').value;
	var svItSy = document.getElementById('itSY').value;
	
	if (svItemName!='Select an Item'){
		if (svItPlan!='Select Plan'){
			if(svItAmount!=''){
				if (isNaN(svItAmount) || !svItAmount){
					alert('Please enter a valid item Amount');
				}else{
					if(svItSched!='Select implementation Frequency'){
						if(svItSy!='Select School Year'){
							// if(svItImpDate!=''){
								var url1 = "<?php echo base_url().'financemanagement/savePaymentItems' ?>"; // the script where you handle the form input.
								var amntNow = document.getElementById('itAmount').value;
								amntNow = convertStrintoNum(amntNow);
								document.getElementById('itAmount').value = amntNow;
								$.ajax({
							       type: "POST",
							       url: url1,
							       data: $("#addItemForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
							       success: function(data){
							       	alert('Item successfully added!');
							       	location.reload()
							       	;}
							    });
							// }else{alert('Please provide implementation date.');}
						}else{alert('Please select SY');}
					}else{alert('Please select collection frequency.');}
				}
			}else{alert('Please enter item Amount');}
		}else{alert('Please Select a Plan');}
	}else{alert('Please Select an Item');}

	});

	$("#saveNwPlan").click(function() 
	{
    var p_indicate = document.getElementById("plan_indicate").value;
    if (p_indicate=="new_plan"){
    	var splan = document.getElementById('nwPlanName').value;
    	svRemarks = 'Created New Plan ['+splan+'}';
    	document.getElementById('pelogremarks').value = svRemarks;
    	var url1 = "<?php echo base_url().'financemanagement/savePlan' ?>"; // the script where you handle the form input.
    	$.ajax({
        type: "POST",
        url: url1,
        data: $("#newPlanForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data){
          alert('Yey!!! New Plan successfully added!');
          location.reload();
        }
      });
    }else if (p_indicate=="edit_plan"){
      var splan = document.getElementById('nwPlanName').value;
      var oplan = document.getElementById("old_plan").value;
      svRemarks = 'Edited an existing plan [from: ' +oplan+' to:'+splan+']';
      document.getElementById('pelogremarks').value = svRemarks;
      var url1 = "<?php echo base_url().'financemanagement/editplan' ?>"; // the script where you handle the form input.
      $.ajax({
        type: "POST",
        url: url1,
        data: $("#newPlanForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data){
          alert('Yey!!! Plan successfully edited.');
          location.reload();
        }
      });
    }
	});

	$("#saveNwDept").click(function()
	{
    var indicate = document.getElementById("deptLabel").innerHTML;
    if (indicate == "Create New Department"){
      var splan = document.getElementById('nwDeptName').value;
      svRemarks = 'Created New Department ['+splan+'}';
      document.getElementById('delogremarks').value = svRemarks;
      var newDeptURL = "<?php echo base_url().'financemanagement/saveNewDept' ?>";
      $.ajax({
        type: "POST",
        url: newDeptURL,
        data: $("#newDeptForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data){
          alert('Bravo!!! New Department successfully added!');
          location.reload();
        }
      });
    }else if (indicate == "Edit Department"){
      var splan = document.getElementById('nwDeptName').value;
      var odept = document.getElementById('oldDept').value;
      svRemarks = 'Edited an existing Department [from: ' +odept+' to:'+splan+']';
      document.getElementById('delogremarks').value = svRemarks;
      var newDeptURL = "<?php echo base_url().'financemanagement/saveEditDept' ?>";
      $.ajax({
        type: "POST",
        url: newDeptURL,
        data: $("#newDeptForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data){
          alert('Bravo!!! Department successfully edited!');
          location.reload();
        }
      });
    }
	});

function ddel_btnID(d_id)
{
  var ddesc = d_id.slice(4); // ddel#
  alert("Sorry!!! Some data are already connected to Department name: '" + ddesc + "'. You may need to contact your system administrator to delete this.");
}

function pl_delBtn(pl_id)
{
  var pln = document.getElementById(pl_id).name;
  var plname = pln.slice(5); // pldel#
  alert("Sorry!!! Some data are already connected to PLAN: '" + plname + "'. You may need to contact your system administrator to delete this.");
}

function it_delBtn(it_id)
{
  var itn = document.getElementById(it_id).name;
  var itname = itn.slice(5); // itedit#
  alert("Sorry!!! Some data are already connected to this item ("+itname+"). You may need to contact your system administrator to delete this.");
}

function dedit_btnID(e_id)
{
  var dedit = document.getElementById('dept_table');
  var edit_id = e_id.slice(5); // dedit#
  dedit.style.display = "none";
  var d_eid = document.getElementById(e_id).name;
  deptid = d_eid.slice(5);
  document.getElementById("odept_id").value = deptid;
  document.getElementById("oldDept").value = edit_id;
  document.getElementById("nwDeptName").value = edit_id;
  document.getElementById("nwDeptName").placeholder = edit_id;
  document.getElementById("deptLabel").innerHTML = "Edit Department";
  document.getElementById("deptformlable").innerHTML = "Edit '" + edit_id + "' to: ";
}

function pl_editBtn(pe_id)
{
  var pln = document.getElementById("plan_tableform");
  pln.style.display = "none"
  var pln_id = pe_id.slice(6);
  var pln_name = document.getElementById(pe_id).name;
  pln_name = pln_name.slice(6);
  document.getElementById("nwPlanName").placeholder = pln_name;
  document.getElementById("nwPlanName").value = pln_name;
  document.getElementById("plan_label").innerHTML = "Edit Existing Plan";
  document.getElementById("plan_flabel").innerHTML = "Edit " + pln_name + " to: ";
  document.getElementById("plan_indicate").value = "edit_plan";
  document.getElementById("old_plan").value = pln_name;
  document.getElementById("plan_id").value = pln_id;
}

function it_editBtn(ie_id)
{
  var itt = document.getElementById("item_tableform");
  itt.style.display = "none";
  var it_id = ie_id.slice(6);
  var it_name = document.getElementById(ie_id).name;
  it_name = it_name.slice(6);
  document.getElementById("nwItemName").placeholder = it_name;
  document.getElementById("nwItemName").value = it_name;
  document.getElementById("item_label").innerHTML = "Edit Existing Item";
  document.getElementById("item_flabel").innerHTML = "Edit " + it_name + " to: ";
  document.getElementById("item_indicate").value = "edit_item";
  document.getElementById("old_item").value = it_name;
  document.getElementById("item_id").value = it_id;
  var ipointdname = 'it_dname' + it_id;
  var it_dname = document.getElementById(ipointdname).innerHTML;
  document.getElementById("old_idept").value = it_dname;
  var ipointdid = 'it_did' + it_id;
  var it_did = document.getElementById(ipointdid).value;
  $("#nwDept").select2().select2('val', it_did);
}

function checkedit_btnID(ebtn_id)
{
	var init_id = ebtn_id.slice(8);  //edititem#
	document.location = '<?php echo base_url() ?>financemanagement/config/edit/' + init_id;
}

function checkdel_btnID(dbtn_id)
{
	var init_id = dbtn_id.slice(7);
	document.location = '<?php echo base_url() ?>financemanagement/config/del/' + init_id;	
}
</script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
