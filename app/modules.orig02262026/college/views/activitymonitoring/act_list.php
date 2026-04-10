<div class="col-md-9">
    <button type="button" class="btn btn-default btn-sm" id="actsDisplay">List of Activities</button>
    <select id="attForm">
        <option value="none">Select Attendance View Type</option>
        <option value="1">Sealed Form</option>
        <option value="2">Unsealed Form</option>
    </select>
    <button type="button" class="btn btn-default btn-sm" id="attDisplay">List of Attendee</button>
    <select class="pull-right" style="width: 300px" id="act_list">
        <option value="none">
            Select Activity
        </option>
        <?php
        foreach ($activities AS $act):
            ?>
            <option value="<?php echo $act->act_id; ?>"><?php echo $act->act_title . " - [" . $act->act_date . "]"; ?></option>
            <?php
        endforeach;
        ?>
    </select>
</div>
<div class="col-md-3">
    <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#addActList"><i class="fa fa-plus fa-sm"></i></button>
    <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-right: 5px" id="deleteBtn"><i class="fa fa-trash fa-sm"></i></button>
    <button type="button" class="btn btn-warning btn-sm pull-right" style="margin-right: 5px" id="editBtn"><i class="fa fa-edit fa-sm"></i></button>
    <button type="button" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px" id="overrideBtn" data-toggle="modal" data-target="#attOverride">Override</button>
</div>
<div class="modal" tabindex="-1" role="dialog" id="addActList">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-body col-md-12" id="actForm">
                <div class="form-group col-md-12">
                    <label class="form-group-text">Title</label>
                    <input type="text" class="form-control" id="actTitle" name="actTitle" />
                </div>
                <div class="form-group col-md-12">
                    <label class="form-group-text">Description</label>
                    <textarea class="form-control" id="actDesc" name="actDesc"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-group-text">Department</label>
                    <select class="form-control" id="targDept" name="targDept">
                        <option value="none">Select Department</option>
                        <option value="1">All Students</option>
                        <option value="2">College Students</option>
                        <option value="3">Elementary Students</option>
                        <option value="4">High School Students</option>
                        <option value="5">Education</option>
                        <option value="6">Arts and Sciences</option>
                        <option value="7">Faculty and Staff</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-group-text">Event Date</label>
                    <input class="form-control" type="date" id="actDate" name="actDate" />
                </div>
                <div class="form-group col-md-4">
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                           <label>Time</label>
                           <div class="input-group">
                              <input type="text" name="actTime" class="form-control timepicker" value="00:00">
                              <div class="input-group-addon">
                                 <i class="fa fa-clock-o"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitActivity">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="showActAttendance">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="attTable">
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="showActivities">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Activities</h3>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>Title</th>
                        <th>Activity Date</th>
                        <th>Activity Time</th>
                        <th>Status</th>
                    </thead>
                    <tbody id="activityTable"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="editActivity">modal-lg
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Activity</h5>
                </button>
            </div>
            <form class="modal-body col-md-12" id="editActForm">
                <div class="form-group col-md-12">
                    <label class="form-group-text">Title</label>
                    <input type="text" class="form-control" id="editActTitle" name="editActTitle" />
                </div>
                <div class="form-group col-md-12">
                    <label class="form-group-text">Description</label>
                    <textarea class="form-control" id="editActDesc" name="editActDesc"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-group-text">Department</label>
                    <select class="form-control" id="editTargDept" name="editTargDept">
                        <option value="none">Select Department</option>
                        <option value="1">All Students</option>
                        <option value="2">College Students</option>
                        <option value="3">Elementary Students</option>
                        <option value="4">High School Students</option>
                        <option value="5">Education</option>
                        <option value="6">Arts & Sciences</option>
                        <option value="7">Faculty and Staff</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-group-text">Event Date</label>
                    <input class="form-control" type="date" id="editActDate" name="editActDate" />
                </div>
                <div class="form-group col-md-4">
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                           <label>Time</label>
                           <div class="input-group">
                              <input type="text" id="editActTime" name="editActTime" class="form-control timepicker">
                              <div class="input-group-addon">
                                 <i class="fa fa-clock-o"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateActivity">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        $("#act_list").select2()
        $("#attForm").hide();
        $(".timepicker").timepicker({
            showInputs: false,
            showMeridian: false,
          });;
    })
    
    function reconDate(date) {
        var monthNames = [
          "January", "February", "March",
          "April", "May", "June", "July",
          "August", "September", "October",
          "November", "December"
        ];

        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return monthNames[monthIndex] + ' '+ day +', ' + year;
      }
    
    $("#actsDisplay").click(function(){
        $.ajax("<?php echo site_url('college/activity/getActivities'); ?>", {
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var html = "";
                $.each(data.activities, function(idx, val){
                    var date = new Date(),
                        mon = (date.getMonth() > 10) ? (date.getMonth()+1) : "0"+(date.getMonth()+1),
                        da = (date.getDate() > 10) ? date.getDate() : "0"+date.getDate(),
                        recon = date.getFullYear()+"-"+mon+"-"+da,
                        status;
                        if(val.act_date == recon){
                            status = "Ongoing";
                        }else if(val.act_date < recon){
                            status = data.att_count[idx];
                        }else{
                            status = "Upcoming";
                        }
                   html += "<tr>"+
                           "<td>"+val.act_title+"</td>"+
                           "<td>"+reconDate(new Date(val.act_date))+"</td>"+
                           "<td>"+tConvert(val.act_time)+"</td>"+
                           "<td>"+status+"</td>"+
                           "</tr>"; 
                });
                $("#activityTable").html(html);
                $("#showActivities").modal();
            }
        });
    })
    
    $("#updateActivity").click(function(){
       var act_id = $("#act_id").val(), form = $("#editActForm").serialize();
       $.ajax("<?php echo site_url('college/activity/updateActivity'); ?>", {
           type: "POST",
           dataType: "JSON",
           data: form+"&act_id="+act_id+"&csrf_test_name=" + $.cookie('csrf_cookie_name'),
           success: function(data){
               if(data.message === "success"){
                   document.location = "<?php echo site_url('college/activity/'); ?>";
                }
            }
       })
    });
    
    $("#deleteBtn").click(function(){
        if(confirm("Are you sure?\nNote: Deleting an activity or event will also delete all the attendee prior to the activity.\nYou have been warned") === true){
            var act_id = $("#act_id").val();
            $.ajax("<?php echo site_url('college/activity/deleteActivity/'); ?>"+act_id, {
               type: "GET",
               dataType: "JSON"
            }).always(function(){
                document.location = "<?php echo site_url('college/activity'); ?>";
            });
        }
    });
    
    $("#editBtn").click(function(){
        var act_id = $("#act_id").val();
        $.ajax("<?php echo site_url('college/activity/getActivity/'); ?>"+act_id, {
            type: "GET",
            dataType: "JSON"
        }).always(function(data){
            $("#editActTitle").val(data.act_title);
            $("#editActDesc").val(data.act_desc);
            $("#editTargDept").val(data.act_department);
            $("#editActDate").val(data.act_date);
            $("#editActTime").val(data.act_time);
            $("#editActivity").modal();
        });
    });
    
    $("#attDisplay").click(function(){
        var actId = $("#act_id").val(), type = $("#attForm").val();
        if(type == "none"){
            alert("You must select a type first");
        }else{
            window.open("<?php echo site_url('college/activity/showAttendance/'); ?>"+actId+"/"+type);
        }
    });
    
    $("#submitActivity").click(function () {
        var form = $("#actForm").serialize();
        console.info(form);
        $.ajax("<?php echo site_url('college/activity/createActivity'); ?>", {
            type: "POST",
            dataType: "JSON",
            data: form + "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
            success: function (data) {
                if (data.message == "success") {
                    document.location = "<?php echo site_url('college/activity'); ?>";
                } else {
                    alert("There seems to be a problem with the system, please feel free to contact a technical staff for assistance.");
                }
            }
        });
    });
</script>
