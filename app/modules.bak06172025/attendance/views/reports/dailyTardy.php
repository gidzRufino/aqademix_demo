<div class="col-lg-12">
    <h3 class="page-header" style="margin:10px 0">Number of Lates per Grade Level
    <small class="pull-right">
        <div class="form-group input-group pull-right">
            <input style="height:34px;" name="inputDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(4)==NULL?date("Y-m-d"):$this->uri->segment(4)); ?>" id="inputBdate" placeholder="Search for Date" required>
            <span class="input-group-btn">
                <button class="btn btn-success"onclick="getAttendance($('#inputBdate').val())">
                    <i id="verify_icon" class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </small>
    </h3>

</div>
<div class="col-lg-12">
    <table class="table table-stripped">
        <tr class="alert-info">
            <th class="col-lg-3">Grade Level</th>
            <th class="text-center">Number of Present Students</th>
            <th class="text-center">Number of Late Students</th>
        </tr>
        <?php 
            foreach ($grade as $gr):
                $totalAttendance = Modules::run('attendance/attendance_reports/getTotalAttendance', $gr->grade_id, $date);
                $totalTardy = Modules::run('attendance/attendance_reports/dailyTardyPerLevel', $date, $gr->grade_id);
        ?>
        <tr>
            <td><?php echo $gr->level ?></td>
            <th class="text-center"><?php echo $totalAttendance->num_rows(); ?></th>
            <th class="text-center pointer" title="Click here to get students per Section" onclick="latePerSection('<?php echo $date ?>', '<?php echo $gr->grade_id ?>','<?php echo $gr->level ?>')"><?php echo $totalTardy->num_rows(); ?></th>
        </tr>
        <?php 
            endforeach;
        ?>
    </table>
</div>


<div id="viewPerSection" class="modal fade col-lg-6 clearfix"  style="margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Number of Lates in <span id="gradeLevelID"></span>
        </div>
         <div id="sectionBody" class="panel-body">
           
         </div>
     </div>
</div>

<div id="viewStudentsPerSection" class="modal fade col-lg-6 clearfix"  style="margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Number of Lates in <span id="sectionID"></span>
        </div>
         <div id="studentsBody" class="panel-body">
           
         </div>
     </div>
</div>

<script type="text/javascript">
    
    function getAttendance(date)
    {
        document.location='<?php echo base_url('attendance/attendance_reports/dailyTardy/') ?>'+date;
    }
    
   function latePerSection(date, grade_level,level)
    {
        $('#viewPerSection').modal('show');
        $('#gradeLevelID').html(level)
        var url = '<?php echo base_url().'attendance/attendance_reports/dailyTardyPerSection/' ?>'+date+'/'+grade_level;
        $.ajax({
             type: "GET",
             url: url,
             data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
             beforeSend: function() {
                    showLoading('sectionBody');
                },
             success: function(data)
             {
                 $('#sectionBody').html(data);

             }
         });
    }
    
   function lateStudentsPerSection(date, sec_id, section)
    {
        $('#viewStudentsPerSection').modal('show');
        $('#sectionID').html(section);
        var url = '<?php echo base_url().'attendance/attendance_reports/lateStudentsPerSection/' ?>'+date+'/'+sec_id;
        $.ajax({
             type: "GET",
             url: url,
             data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
             beforeSend: function() {
                    showLoading('studentsBody');
                },
             success: function(data)
             {
                 $('#studentsBody').html(data);

             }
         });
    }
    
    function removeFromLate(att_id)
    {
        var url = '<?php echo base_url().'attendance/attendance_reports/removeFromLate/' ?>';
        $.ajax({
             type: "POST",
             url: url,
             data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+'&att_id='+att_id, // serializes the form's elements.
             success: function(data)
             {
                 $('#trLate_'+att_id).hide();

             }
         });
    }
    
    
    
</script>