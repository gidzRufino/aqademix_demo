<div class="col-lg-12 clearboth" style="background: #ccc;">
    <div class="col-lg-8 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
        <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
            <?php if($this->eskwela->getSet()->level_catered == 5): ?>
                <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location='<?php echo base_url('college') ?>'">
            <?php else: ?>   
                <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location='<?php echo base_url() ?>'">
            <?php endif; ?>
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
                
            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>

            <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
            <h5 class="text-right" style="color:black;">S.Y. <?php echo $school_year.' - '.($school_year+1) ?><?php echo ($semester==1?' - First Semester':($semester==2?' - Second Semester':($semester==3?' - Summer':''))) ?></h5>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll; min-height: 100vh;">  
            
            <div class="col-lg-12 col-xs-12" style="margin-bottom:10px;">
                <span>Student's Legend :</span>
                &nbsp; &nbsp; <button onclick="getEnrollmentDetails('0','<?php echo $semester ?>','<?php echo $school_year ?>','Students for Evaluation')" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i> For Evaluation - <?php echo Modules::run('college/enrollment/getNumStudentsPerStatus',$semester, $school_year,'0') ?></button>
            &nbsp; &nbsp; <button onclick="getEnrollmentDetails('3','<?php echo $semester ?>','<?php echo $school_year ?>','Students for Payment')" class="btn btn-warning btn-xs"><i class="fa fa-money fa-fw"></i> For Payment - <?php echo Modules::run('college/enrollment/getNumStudentsPerStatus',$semester, $school_year, 3) ?></button>
            &nbsp; &nbsp; <button onclick="getEnrollmentDetails('4','<?php echo $semester ?>','<?php echo $school_year ?>','Students for Payment Evaluation')" class="btn btn-danger btn-xs"><i class="fa fa-cc fa-fw"></i> For Payment Evaluation - <?php echo Modules::run('college/enrollment/getNumStudentsPerStatus', $semester, $school_year,4) ?></button>
            &nbsp; &nbsp; <button onclick="getEnrollmentDetails('5','<?php echo $semester ?>','<?php echo $school_year ?>','Students for Payment Confirmation')" class="btn btn-success btn-xs"><i class="fa fa-cc fa-fw"></i> For Payment Confirmation - <?php echo Modules::run('college/enrollment/getNumStudentsPerStatus',$semester, $school_year, 5) ?></button>
            &nbsp; &nbsp; <button onclick="getEnrollmentDetails('1','<?php echo $semester ?>','<?php echo $school_year ?>','Officially Enrolled Students')" class="btn btn-primary btn-sm"><i class="fa fa-user fa-fw"></i> Officially Enrolled - <?php echo Modules::run('college/enrollment/getNumStudentsPerStatus',$semester, $school_year, 1) ?></button>
            </div><br />
            <div class="clearfix row">
                <div class="col-lg-8 col-xs-12">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Enrollment Details
                            </div>
                            <div class="panel-body" id="studentDetails" style='min-height: 50vh;'>
                                <?php if($st_id != NULL): 
                                        echo $student;
                                    endif; 
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Padala Centers
                                <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#addPadala"><i class="fa fa-plus fa-xs"></i></button>
                            </div>
                            <div class="panel-body" id="studentDetails" style='min-height: 50vh;'>
                                <table class="table table-bordered">
                                    <tbody>
                                        <?php
                                            $pads = Modules::run('college/enrollment/getPadala', 1);
                                            foreach($pads AS $p):
                                        ?>
                                        <tr>
                                            <td><img pc-id="<?php echo $p->pc_id; ?>" pc-name="<?php echo $p->pc_name; ?>" pc-sn="<?php echo $p->pc_short_name; ?>" pc-type="<?php echo $p->pc_type; ?>" pc-acc-name="<?php echo $p->pc_account_name; ?>" pc-acc-no="<?php echo $p->pc_account_number; ?>" pc-branch="<?php echo $p->pc_branch; ?>" pc-contact="<?php echo $p->pc_contact_no; ?>" pc-status="<?php echo $p->pc_status; ?>" pc-logo="<?php echo ($p->pc_logo != null) ? $p->pc_logo : 'Select Logo'; ?>" class='pc_class' style="cursor: pointer; width: 50px; height: 50px;" onclick="showEditPadalaModal(this)" class="img img-thumbnail" src="<?php echo base_url() . 'images/banks/'.$p->pc_logo ?>"/></td>
                                            <td><span><?php echo $p->pc_name; ?></span></td>
                                            <td><?php echo ($p->pc_type != 3) ? $p->pc_account_number : $p->pc_account_name; ?></td>
                                            <td><?php echo $p->pc_contact_no; ?></td>
                                        </tr>
                                        <?php
                                            endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 ">    
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Total Students Enrolled Online <strong><span class="pull-right"><?php echo Modules::run('college/enrollment/getNumStudentsPerStatus',$semester, $school_year) ?></span></strong>
                        </div>
                        <div class="panel-body no-padding" style='min-height: 80vh; overflow-y: scroll;'>
                            <div class="list-group">
                                <?php 
                                    foreach($students as $s): 
                                        switch($s->status):
                                            case 0:
                                                $status = 'FOR EVALUATION';
                                            break;
                                            case 1:
                                            break;    
                                            case 3:
                                                $status = 'FOR PAYMENT';
                                            break;    
                                            case 4:
                                                $status = 'FOR PAYMENT EVALUATION';
                                            break;    
                                            case 5:
                                                $status = 'FOR PAYMENT CONFIRMATION';
                                            break;    
                                        endswitch;
                                        
                                ?>
                                <a href="<?php echo base_url('college/enrollment/monitor').'/'.$s->semester.'/'.$s->school_year.'/'.base64_encode($s->st_id).'/'.(isset($s->course)?'':1) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo strtoupper($s->firstname.' '.$s->lastname) ?></h5>
                                  </div>
                                    <p class="mb-1"><?php echo ucwords(strtolower((isset($s->course)?$s->course:$s->level))) ?></p>
                                    <small class="text-danger">Enrollment Status: <b><?php echo $status ?></b></small>
                                </a>
                                <?php endforeach; ?>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>  <!--end of modal-body --> 
        </div>
    </div>   
</div>
<div class="modal fade" id="addPadala" tabindex="-1" role="dialog" aria-labelledby="addPadala" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Add Payment Method</h5>
      </div>
      <div class="modal-body">
		<form class="form-group" id="addPadalaForm">
			<label class="form-group-text">Padala Type</label>
			<select class="form-control" id="pcType" name="pcType" onchange="setPadalaForm(this)">
				<option value="-1">Select Padala Type</option>
				<option value="1">Bank</option>
				<option value="2">Padala</option>
				<option value="3">GCash</option>
			</select>
            <div id="pcNameDiv" class="hidden">
                <label class="form-group-text">Name</label>
                <input type="text" id="pcName" name="pcName" class="form-control" disabled />
            </div>
            <div id="pcShortDiv" class="hidden">
                <label class="form-group-text">Short Name</label>
                <input type="text" id="pcShortName" name="pcShortName" class="form-control" disabled />
            </div>
            <diV id="pcAccNameDiv" class="hidden">
                <label class="form-group-text">Account Name</label>
                <input type="text" class="form-control" id="pcAccountName" name="pcAccountName" />
            </diV>
            <div id="pcAccNumDiv" class="hidden">
                <label class="form-group-text">Account Number</label>
                <input type="text" class="form-control" id="pcAccountNumber" name="pcAccountNumber" disabled />
            </div>
            <div id="pcBranchDiv" class="hidden">
                <label class="form-group-text">Branch</label>
                <input type="text" class="form-control" id="pcBranch" name="pcBranch" disabled />
            </div>
            <diV id="pcContactDiv" class="hidden">
                <label class="form-group-text">Contact Number</label>
                <input type="text" class="form-control" id="pcContact" name="pcContact" />
            </div>
            <diV id="pcLogoDiv" class="hidden">
                <label class="form-group-text">Logo</label>
                <label class="btn btn-default btn-block">
                    <span id="logoIdentity">Select Logo</span> <input type="file" class='hidden' id="pcLogo" name="pcLogo" onchange="setLogo(this)" />
                </label>
            </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitBtn" onclick="addPadala(this)" disabled>Add Payment Method</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editPadala" tabindex="-1" role="dialog" aria-labelledby="editPadala" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<i class="fa fa-trash text-danger fa-sm pull-right" id='deleteBtn' style="margin-right: 6px; cursor: pointer;" onclick="readyDelete(this)"></i>
        <h5 class="modal-title">Edit Payment Method</h5>
      </div>
      <div class="modal-body">
		<form class="form-group" id="editPadalaForm">
            <input type="hidden" id="pcID" name="pcID" />
            <label class="form-group-text">Padala Type</label>
			<select class="form-control" id="pcType" name="pcType" onchange="setPadalaForm(this)">
				<option value="-1">Select Padala Type</option>
				<option value="1">Bank</option>
				<option value="2">Padala</option>
				<option value="3">GCash</option>
			</select>
            <div id="pcNameDiv" class="hidden">
                <label class="form-group-text">Name</label>
                <input type="text" id="pcName" name="pcName" class="form-control" disabled />
            </div>
            <div id="pcShortDiv" class="hidden">
                <label class="form-group-text">Short Name</label>
                <input type="text" id="pcShortName" name="pcShortName" class="form-control" disabled />
            </div>
            <diV id="pcAccNameDiv" class="hidden">
                <label class="form-group-text">Account Name</label>
                <input type="text" class="form-control" id="pcAccountName" name="pcAccountName" />
            </diV>
            <div id="pcAccNumDiv" class="hidden">
                <label class="form-group-text">Account Number</label>
                <input type="text" class="form-control" id="pcAccountNumber" name="pcAccountNumber" disabled />
            </div>
            <div id="pcBranchDiv" class="hidden">
                <label class="form-group-text">Branch</label>
                <input type="text" class="form-control" id="pcBranch" name="pcBranch" disabled />
            </div>
            <diV id="pcContactDiv" class="hidden">
                <label class="form-group-text">Contact Number</label>
                <input type="text" class="form-control" id="pcContact" name="pcContact" />
            </div>
            <label class="form-group-text">Status</label>
            <select class="form-control" id="pcStatus" name="pcStatus">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <div id="pcLogoDiv" class="hidden">
                <label class="form-group-text">Logo</label>
                <label class="btn btn-default btn-block">
                    <span id="logoIdentity">Select Logo</span> <input type="file" class='hidden' id="pcLogo" name="pcLogo" onchange="setLogo(this)" />
                </label>
            </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="editPadala(this)">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="readyDelete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-body text-center">
			<h1><i class="fa fa-exclamation text-danger"></i></h1>
			<h5>The action you are about to do cannot be undone.</h4>
			<small>Do you still wish to continue?</small>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deletePadala(this)">Proceed</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="enrollDetails" class="modal fade col-lg-4 col-xs-12" style="margin:30px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h4 id="entitle" class="no-margin col-lg-6">hey!</h4>
            <button class="pull-right btn btn-xs btn-danger" data-dismiss="modal">x</button>
        </div>
        <div style="height:60vh; overflow-y: scroll; cursor: pointer" class="panel-body" id="enrollBody">
            
        </div>
    </div>
</div>    
   
<input type="hidden" value="<?php echo base_url() ?>" id="base" />
<script type="text/javascript">

    $(document).ready(function () {
        //$('#enrollDetails').modal('show');
    });
    
    function setPadalaForm(select)
    {
        var sel = $(select),
            type = sel.val(),
            form = sel.parent(),
            pcname = form.find("#pcNameDiv"),
            pcshort = form.find("#pcShortDiv"),
            pcaccname = form.find("#pcAccNameDiv"),
            pcaccnum = form.find("#pcAccNumDiv"),
            pcbranch = form.find("#pcBranchDiv"),
            pccontact = form.find("#pcContactDiv"),
            pclogo = form.find("#pcLogoDiv");
        if(type != -1){
            switch(type)
            {
                case "1":
                    if(pcname.hasClass("hidden"))
                    {
                        pcname.find("input").removeAttr("disabled");
                        pcname.removeClass("hidden");
                    }
                    if(pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").removeAttr("disabled");
                        pcshort.removeClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").removeAttr("disabled");
                        pcaccnum.removeClass("hidden");
                    }
                    if(pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").removeAttr("disabled");
                        pcbranch.removeClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
                case "2":
                    if(pcname.hasClass("hidden"))
                    {
                        pcname.find("input").removeAttr("disabled");
                        pcname.removeClass("hidden");
                    }
                    if(pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").removeAttr("disabled");
                        pcshort.removeClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").removeAttr("disabled");
                        pcaccnum.removeClass("hidden");
                    }
                    if(pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").removeAttr("disabled");
                        pcbranch.removeClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
                case "3":
                    if(!pcname.hasClass("hidden"))
                    {
                        pcname.find("input").attr("disabled", true);
                        pcname.addClass("hidden");
                    }
                    if(!pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").attr("disabled", true);
                        pcshort.addClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(!pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").attr("disabled", true);
                        pcaccnum.addClass("hidden");
                    }
                    if(!pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").attr("disabled", true);
                        pcbranch.addClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
            }
            form.parent().next().find("#submitBtn").removeAttr("disabled");
        }
        else
        {
            if(!pcname.hasClass("hidden"))
            {
                pcname.find("input").attr("disabled");
                pcname.addClass("hidden");
            }
            if(!pcshort.hasClass("hidden"))
            {
                pcshort.find("input").attr("disabled");
                pcshort.addClass("hidden");
            }
            if(!pcaccname.hasClass("hidden"))
            {
                pcaccname.find("input").attr("disabled");
                pcaccname.addClass("hidden");
            }
            if(!pcaccnum.hasClass("hidden"))
            {
                pcaccnum.find("input").attr("disabled");
                pcaccnum.addClass("hidden");
            }
            if(!pcbranch.hasClass("hidden"))
            {
                pcbranch.find("input").attr("disabled");
                pcbranch.addClass("hidden");
            }
            if(!pccontact.hasClass("hidden"))
            {
                pccontact.find("input").attr("disabled");
                pccontact.addClass("hidden");
            }
            if(!pclogo.hasClass("hidden"))
            {
                pclogo.find("input").attr("disabled");
                pclogo.addClass("hidden");
            }
            form.parent().next().find("#submitBtn").attr("disabled");
        }
    }

    function setLogo(input)
    {
        var file = $(input)[0].files[0].name;
        $(input).parent().find("#logoIdentity").html(file);
    }
    
    function deletePadala(btn)
	{
		$.ajax
		(
			{
				url: "<?php echo site_url('/college/enrollment/deletePadala'); ?>",
				type: "POST",
				dataType: "JSON",
				data:
				{
					id: $(btn).attr('pc-id'),
					csrf_test_name: $.cookie('csrf_cookie_name')
				},
				beforeSend: function () 
				{
					$('#loadingModal').modal('show');
				},
				success: function(data)
				{
					switch(data.type)
					{
						case 1:
							{
								alert(data.message);
								location.reload();
								break;
							}
						case 2:
							{
								alert(data.message);
								$("#loadingModal").modal('hide');
								break;
							}
					}
				}
			}
		)
	}

	function readyDelete(btn)
	{
		$("#readyDelete #deleteBtn").attr('pc-id', $(btn).attr('pc-id'));
		$("#readyDelete").modal();
	}

	function showEditPadalaModal(btn)
	{
		let target = $("#editPadala #editPadalaForm"),
            holder = $(btn);
        $("#editPadala").find("#deleteBtn").attr('pc-id', holder.attr('pc-id'));
        
		target.find("#pcID").val(holder.attr('pc-id'));
		target.find("#pcName").val(holder.attr('pc-name'));
		target.find("#pcShortName").val(holder.attr('pc-sn'));
		target.find("#pcType").val(holder.attr('pc-type'));
		target.find("#pcAccountName").val(holder.attr('pc-acc-name'));
		target.find("#pcAccountNumber").val(holder.attr('pc-acc-no'));
		target.find("#pcBranch").val(holder.attr('pc-branch'));
		target.find("#pcContact").val(holder.attr('pc-contact'));
        target.find("#pcStatus").val(holder.attr('pc-status'));
        target.find("#logoIdentity").html(holder.attr('pc-logo'));
        var sel = target.find("#pcType"),
        form = sel.parent(),
        type = holder.attr('pc-type'),
        pcname = form.find("#pcNameDiv"),
        pcshort = form.find("#pcShortDiv"),
        pcaccname = form.find("#pcAccNameDiv"),
        pcaccnum = form.find("#pcAccNumDiv"),
        pcbranch = form.find("#pcBranchDiv"),
        pccontact = form.find("#pcContactDiv"),
        pclogo = form.find("#pcLogoDiv");
        if(type != -1){
            switch(type)
            {
                case "1":
                    if(pcname.hasClass("hidden"))
                    {
                        pcname.find("input").removeAttr("disabled");
                        pcname.removeClass("hidden");
                    }
                    if(pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").removeAttr("disabled");
                        pcshort.removeClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").removeAttr("disabled");
                        pcaccnum.removeClass("hidden");
                    }
                    if(pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").removeAttr("disabled");
                        pcbranch.removeClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
                case "2":
                    if(pcname.hasClass("hidden"))
                    {
                        pcname.find("input").removeAttr("disabled");
                        pcname.removeClass("hidden");
                    }
                    if(pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").removeAttr("disabled");
                        pcshort.removeClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").removeAttr("disabled");
                        pcaccnum.removeClass("hidden");
                    }
                    if(pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").removeAttr("disabled");
                        pcbranch.removeClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
                case "3":
                    if(!pcname.hasClass("hidden"))
                    {
                        pcname.find("input").attr("disabled", true);
                        pcname.addClass("hidden");
                    }
                    if(!pcshort.hasClass("hidden"))
                    {
                        pcshort.find("input").attr("disabled", true);
                        pcshort.addClass("hidden");
                    }
                    if(pcaccname.hasClass("hidden"))
                    {
                        pcaccname.removeClass("hidden");
                    }
                    if(!pcaccnum.hasClass("hidden"))
                    {
                        pcaccnum.find("input").attr("disabled", true);
                        pcaccnum.addClass("hidden");
                    }
                    if(!pcbranch.hasClass("hidden"))
                    {
                        pcbranch.find("input").attr("disabled", true);
                        pcbranch.addClass("hidden");
                    }
                    if(pccontact.hasClass("hidden"))
                    {
                        pccontact.removeClass("hidden");
                    }
                    if(pclogo.hasClass("hidden"))
                    {
                        pclogo.removeClass("hidden");
                    }
                break;
            }
            form.parent().next().find("#submitBtn").removeAttr("disabled");
        }
        else
        {
            if(!pcname.hasClass("hidden"))
            {
                pcname.find("input").attr("disabled");
                pcname.addClass("hidden");
            }
            if(!pcshort.hasClass("hidden"))
            {
                pcshort.find("input").attr("disabled");
                pcshort.addClass("hidden");
            }
            if(!pcaccname.hasClass("hidden"))
            {
                pcaccname.find("input").attr("disabled");
                pcaccname.addClass("hidden");
            }
            if(!pcaccnum.hasClass("hidden"))
            {
                pcaccnum.find("input").attr("disabled");
                pcaccnum.addClass("hidden");
            }
            if(!pcbranch.hasClass("hidden"))
            {
                pcbranch.find("input").attr("disabled");
                pcbranch.addClass("hidden");
            }
            if(!pccontact.hasClass("hidden"))
            {
                pccontact.find("input").attr("disabled");
                pccontact.addClass("hidden");
            }
            if(!pclogo.hasClass("hidden"))
            {
                pclogo.find("input").attr("disabled");
                pclogo.addClass("hidden");
            }
            form.parent().next().find("#submitBtn").attr("disabled");
        }
		$("#editPadala").modal();
	}

	function editPadala(btn)
	{
		let form = $(btn).parent().prev().find("#editPadalaForm");
            formData = new FormData(form[0]);
            formData.append('pcLogo', form.find("#pcLogo")[0].files[0]);
            formData.append('csrf_test_name', $.cookie('csrf_cookie_name'));
		$.ajax
		(
			{
				url: "<?php echo site_url('/college/enrollment/editPadala'); ?>",
				type: "POST",
				dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
				beforeSend: function () 
				{
					$('#loadingModal').modal('show');
				},
				success: function(data)
				{
					switch(data.type)
					{
						case 1:
							{
								alert(data.message);
								location.reload();
								break;
							}
						case 2:
							{
								alert(data.message);
								$("#loadingModal").modal('hide');
								break;
							}
					}
				}
			}
		);
	}
	
	function addPadala(btn)
	{
		var form = $(btn).parent().prev().find("#addPadalaForm"),
            type = form.find("#pcType").val(),
            formData = new FormData(form[0]);
            formData.append('pcLogo', form.find("#pcLogo")[0].files[0]);
            formData.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        if(type != -1)
        {
            $.ajax
            (
                {
                    url: "<?php echo site_url('/college/enrollment/addPadala'); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () 
                    {
                        $('#loadingModal').modal('show');
                    },
                    success: function(data)
                    {
                        switch(data.type)
                        {
                            case 1:
                                {
                                    alert(data.message);
                                    location.reload();
                                    break;
                                }
                            case 2:
                                {
                                    alert(data.message);
                                    $("#loadingModal").modal('hide');
                                    break;
                                }
                        }
                    }
                }
            );
        }
        else
        {
            alert("Choose a type before proceeding");
        }
    }
    
    function getEnrollmentDetails(status, semester, school_year, title)
    {
        var base = $('#base').val();
        var url = base+'college/enrollment/listOfStudentsEnrolled/'+semester+'/'+school_year+'/'+status;
        
        $.ajax({
            type: 'GET',
            url: url,
            data:'',
            success: function (data)
            {
                $('#entitle').html(title);
                $('#enrollDetails').modal('show');
                $('#enrollBody').html(data);
            }
        });

    }

</script>