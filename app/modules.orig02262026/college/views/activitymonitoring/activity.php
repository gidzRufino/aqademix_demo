<div class="col-md-12">
    <div class="row">
        <div class="col-md-12 pull-right" style="margin-top: 25px;">
            <?php echo $this->load->view('act_list', $activities); ?>
        </div>
        <input type="text" id="focusonme" style="position: absolute; left: -1000px"/>
    </div>
</div>
<div class="col-md-12" style="margin-top: 25px;" id="att_list">
</div>
<?php $this->load->view('att_override'); ?>
<script>
    var actTimer, alTimer;
    $(document).ready(function () {
        $("#focusonme").focus();
        $("#attDisplay").hide();
        $("#editBtn").hide();
        $("#deleteBtn").hide();
        $("#overrideBtn").hide();
    });
    
    function formatDate(time){
        var hours = time.getHours(), minutes = time.getMinutes(), ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours %12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':'+minutes + ' ' + ampm;
        return strTime;
    }
    
    function tConvert (time) {
        // Check correct time format and split into components
        time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
          time = time.slice (1);  // Remove full string match value
          time[5] = +time[0] < 12 ? 'am' : 'pm'; // Set AM/PM
          time[0] = +time[0] % 12 || 12; // Adjust hours
          time[3] = ' ';
        }
        return time.join (''); // return adjusted time or original string
      }
    
    function reFocus(){
        $("#focusonme").val('');
        $("#focusonme").focus();
    }
    
    $("#act_list").on('change', function () {
        $.ajax('<?php echo site_url('college/activity/getAttendanceList/'); ?>' + $(this).val(), {
            type: "GET",
            dataType: "JSON"
        }).always(function (data) {
            $("#att_list").html(data.responseText);
            $("#attDisplay").show();
            $("#editBtn").show();
            $("#deleteBtn").show();
            $("#attForm").show();
            $("#overrideBtn").show();
            reFocus();
        });
    });
    
    $("#att_list").click(function(){
        reFocus();
    })
    
    $("#focusonme").on('change', function(){
        if($("#act_id").val() != undefined){
            clearTimeout(actTimer);
            clearTimeout(alTimer); 
           var rfid = $(this).val().toString();
            $.ajax("<?php echo site_url('college/activity/getProfileByRFID/'); ?>"+rfid, {
                type: "GET",
                dataType: "JSON",
                success:function(data){
                    var dept = $("#dept_id").val();
                    if(data.employee_id !== null){
                        parseEmployeeDetails(data);
                    }else{
                        if(dept != 8){
                            parseStudentDetails(data, dept);
                        }else{
                            showAlert("This is an employee only event.");
                        }
                    }
                }
            }).always(function(){
                reFocus();
            });
        }else{
            alert("Please select an activty or create a new one before using the attendance system");
        }
    });
    
    function updateActivityAttendance(profid){
        $.ajax("<?php echo site_url('college/activity/updateActivityAttendance'); ?>", {
           type: "POST",
           dataType: "JSON",
           data: {
               prof_id: profid,
               act_id: $("#act_id").val(),
               csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data){
                var html = "";
                $.each(data, function(idx, val){
                    var out = (val.act_out != "00:00:00") ? tConvert(val.act_out) : "-";
                    html += "<tr>"+
                        "<td>"+val.name+"</td>"+
                        "<td>"+tConvert(val.act_in)+"</td>"+
                        "<td>"+out+"</td>"+
                    "</tr>";
                });
                $("#attlist_bod").html(html);
            }
        });
    }
    
    function showElemHsDetails(st, data){
        var name = st.firstname+" "+st.lastname;
        $("#profilePic").attr('src', '<?php echo site_url('uploads/'); ?>'+st.avatar);
        $("#personalAtt").html("<h4>Name: "+name.toUpperCase()+"</h4>" +
                "<h4>Grade: "+data.level+"</h4>" +
                "<h4>Section: "+data.section+"</h4>");
        $("#curTime").html(formatDate(new Date()));
        updateActivityAttendance(st.st_id);
    }
    
    function showCollegeDetails(st, data){
        var name = st.firstname+" "+st.lastname, year = "1st Year", yearLevel = data.year_level;
        $("#profilePic").attr('src', '<?php echo site_url('uploads/'); ?>'+st.avatar);
        if(yearLevel == 2){
            year = "2nd Year";
        }else if(yearLevel == 3){
            year = "3rd Year";
        }else if(yearLevel == 4){
            year = "4rth Year";
        }else if(yearLevel == 5){
            year = "5th Year";
        }
        $("#personalAtt").html("<h4>Name: "+name.toUpperCase()+"</h4>" +
                "<h4>Year: "+year+"</h4>" +
                "<h4>Course: "+data.short_code+"</h4>");
        updateActivityAttendance(st.st_id);
        $("#curTime").html(formatDate(new Date()));
    }
    
    function parseStudentDetails(st, dept){
        $.ajax("<?php echo site_url('college/activity/getStudentCredentials/'); ?>"+st.st_id,{
            type: "GET",
            dataType: "JSON",
            success: function(data){
                if(data.type == 1){
                    if(dept == 1){
                        showElemHsDetails(st, data);
                    }else if(dept == 3){
                        if(data.grade_id >= 2 && data.grade_id <= 11){
                            showElemHsDetails(st, data);
                        }else{
                            showAlert("Elementary exclusive event");
                        }
                    }else if(dept == 4){
                        if(data.grade_id >= 12 && data.grade_id <= 13){
                            showElemHsDetails(st, data);
                        }else{
                            showAlert("Highschool exclusive event");
                        }
                    }else{
                        showAlert("College exclusive event");
                    }
                }else{
                    if(dept == 1 || dept == 2){
                        showCollegeDetails(st, data);
                    }else if(dept == 5){
                        if(data.dept_id == 1){
                            showCollegeDetails(st, data);
                        }else{
                            showAlert("Education department exlusive event");
                        }
                    }else if(dept == 6){
                        if(data.dept_id == 2){
                            showCollegeDetails(st, data);
                        }else{
                            showAlert("Science department exlusive event");
                        }
                    }else if(dept == 7){
                        if(data.dept_id == 3){
                            showCollegeDetails(st, data);
                        }else{
                            showAlert("Art department exlusive event");
                        }
                    }else{
                        showAlert("Elementary/Highschool exclusive event")
                    }
                }
                actTimer = setTimeout(resetView, 5000);
            }
        })
    }
    
    function parseEmployeeDetails(emp){
        $.ajax("<?php echo site_url('college/activity/getEmployeeCredentials/'); ?>"+emp.employee_id, {
           type: "GET",
           dataType: "JSON",
           success:function(data){
                var name = emp.firstname+" "+emp.lastname;
                $("#profilePic").attr('src', '<?php echo site_url('uploads/'); ?>'+emp.avatar);
                $("#personalAtt").html("<h4>Name: "+name.toUpperCase()+"</h4>" +
                        "<h4>Position: "+data.position+"</h4>" +
                        "<h4>Department: "+data.department+"</h4>");
                $("#curTime").html(formatDate(new Date()));
                actTimer = setTimeout(resetView, 5000);
                updateActivityAttendance(emp.employee_id);
           }
        });
    }
    
    function showAlert(message){
        $("#alertContent").html(message);
        $("#messageAlert").css('display', 'block');
        alTimer = setTimeout(hideAlert, 3000);
    }
    
    function hideAlert(){
        $("#messageAlert").css('display', 'none');
    }

    function resetView() {
        $("#profilePic").attr('src', '<?php echo site_url('images/icons/who.jpg'); ?>');
        $("#personalAtt").html("<h4>Name: -</h4>" +
                "<h4>Grade: -</h4>" +
                "<h4>Section: -</h4>");
        $("#curTime").html("--:-- --");
    }
</script>
