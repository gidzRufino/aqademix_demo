<?php 
$userid = $this->session->userdata('user_id');
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Finance Account  -  Add New Charge</h4>
    </div>
  	<div class="modal-body" style="height:350px;">
	    <div class="row">
	    	<div class="col-md-12">
		    	<form class="form-horizontal" id="addChargeForm" name="addChargeForm">
			      <div class="panel panel-info" style="margin-bottom: 0px;">
		        	<div class="panel-heading">
		        		<div class="row">
		        			<div class="col-md-12">
					          <div class="col-md-2">
					            <a class="" data-toggle="modal" href="#uploadProfile"><img alt="no image available" style="margin-top: -8px; -moz-border-radius:50%; -webkit-border-radius:50%; border-radius:50%; height:80px; border:solid white; z-index:5; position: absolute; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3);    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3)" src="<?php echo base_url()?>uploads/<?php echo $avatari;?>" /></a>
					          </div>
					          <div class="col-md-10">
					            <h4><b>Account Name:</b>&nbsp;<span style="color:#BB0000;"><?php echo $searched_student->firstname ." ".$searched_student->middlename ." ".$searched_student->lastname;?></span></h4> 
					            <h5><b>Account ID:</b>&nbsp;<span style="color:#BB0000;"><?php echo $student_id ?></span></h5>             
					          </div>
					        </div>
					      </div>  
			        </div>      
			      </div>
			      <div class="row">
			      	<div class="col-md-12">
			      		<div class="col-md-8 col-md-offset-2">
					      <div class="form-group">
					        <label class="control-label" for="input">Select an item</label>
					        <div class="controls">
					          <select tabindex="-1" id="ac_itemID" name="ac_itemID" style="width:225px;" >   
					            <option>Select an Item</option>
					                <?php foreach ($showItems as $item_list){ ?>  
					            <option value="<?php echo $item_list->item_id; ?>"><?php echo $item_list->item_description; ?></option>
					                <?php } ?> 
					          </select>
					        </div>
					      </div>
					      <div class="form-group">
					        <label class="control-label" for="input">Amount of the item</label>
					        <div class="controls">
					          <input type="text" id="ac_amount" class="form-control" name="ac_amount" placeholder="Enter amount">
					        </div>
					      </div>
					      <div class="form-group">
					        <label class="control-label" for="input">Transaction Remarks</label>
					        <div class="controls">
					          <input type="text" id="ac_ptremarks" class="form-control" name="ac_ptremarks" placeholder="Brief description about the transaction." style="width: 311px;">
					        </div>
					      </div></div>
					    </div>
			      </div>
			      <div class="hidden-group">
			          
			          <?php 
			            $ac_usrCode = substr($userid, 0,3);
			            $ac_sysRef = date("ymdHis") ."-". $ac_usrCode; 
			            $ac_tdate = date("m-d-Y");
			            $ac_refNumber = "SysGen-".$ac_usrCode; 
			            $ac_credit = 0;
			          ?>        
			     
			        <input type="hidden" name="ac_transID" id="ac_transID" value="<?php echo $ac_sysRef ?>" required>
			        <input type="hidden" name="ac_ptreferrence" id="ac_ptreferrence" value="<?php echo $ac_refNumber ?>" required>
			        <input type="hidden" name="a_studID" id="ac_studID" value="<?php echo base64_encode($searched_student->st_id) ?>" required>
			        <input type="hidden" name="ac_tDate" id="ac_tDate" value="<?php echo $ac_tdate ?>" required>
			        <input type="hidden" name="ac_userID" id="ac_userID" value="<?php echo $userid ?>" required>
			        <input type="hidden" name="ac_scredit" id="ac_scredit" value="<?php echo $ac_credit ?>" required>
			        <input type="hidden" name="ac_cc" id="ac_cc" value="<?php echo $ac_credit ?>" required>
			        <input type="hidden" name="sy_id" id="sy_id" value="<?php echo $sy_now ?>" required>
			        
			      </div>
			    </form>
	    		
	    	</div>	
	    </div>	
  	</div>
  	<div class="modal-footer">
      <button id="chargeSavebtn" data-dismiss="modal" onclick="addCharge()"class="btn btn-primary btn-sm"><i class="fa fa-thumbs-up fa-fw"> </i> Save Charge</button>
      <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"> </i> Cancel</button>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#ac_itemID").select2();
	});

  function addCharge()
  {
    var ac_itemID = document.getElementById('ac_itemID').value;
    if (ac_itemID!="" || ac_itemID!=0)
    {
      var ac_amount = document.getElementById('ac_amount').value;
      if (ac_amount!="" ||ac_amount!=0)
      {
        ac_amount = numberConverted(ac_amount);
        document.getElementById('ac_amount').value = ac_amount;    
        var acharge_url = "<?php echo base_url().'financemanagement/addCharge' ?>";
        $.ajax({
           type: "POST",
           url: acharge_url,
           data: $("#addChargeForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), 
           success: function(data){
            alert("Success!!! Charge successfully added.");  
            location.reload();
           }
        });
      }else{
        alert("Please enter a valid amount");
      }
    }else{
      alert("Please select an item.");
    }
  }

    function convertNumber(sNumber) 
  {
    //Seperates the components of the number
    var n= sNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
  }

  function numberConverted(svariable)
  {
    var cNumber = svariable.replace(/\,/g,'');
    cNumber = parseFloat(cNumber);
    if (isNaN(cNumber) || !cNumber ){ 
      cNumber = 0;
    }

    return cNumber;
  }

</script>