<div class="row">
    <div class="col-lg-12">
        <div style="margin-top:10px;">
            <div class="control-group pull-right">
              <div class="controls"> 
                  <!--<button data-toggle="modal" data-target="#sched"  style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Create</button>-->  
                  <button onclick="getRooms()" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">View Rooms</button>  
                  <button data-toggle="modal" data-target="#addRoomsForm" style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Add Rooms</button>
                  <button onclick="document.location='<?php echo base_url('schedule') ?>'" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">View Schedules</button>
                  
                   <select onclick="selectDepartmentSched(this.value)" name="inputOption" id="inputOption" style="width:100px; color:black;" required>
                            <option value="1">K-12</option>
                            <option value="2">College</option>
                    </select>
                </div>
            </div>
        </div>
        <h3 class="page-header clearfix" style="margin:0">Schedule/Room Management</h3>
    </div>
    <div class="col-lg-12" id="sched_body">
        
         <?php
         if($this->uri->segment(2)=='college'):
                 $this->load->view('collegeSchedule'); 
         else:
            if($this->uri->segment(3)==FALSE):
                   $this->load->view('schedules'); 
            else:
                if($this->uri->segment(2)=='sectionSched'):
                   $this->load->view('sectionSched'); 
                endif;

            endif;
        endif;    
         ?>
    </div>
</div>
<div id="addSchedMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a onclick="getSchedule()"><i class="fa fa-plus-square fa-fw"></i>Add Schedule</a></li>
       <li class="pointer"><a tabindex="-1"><i class="fa fa-edit fa-fw"></i>Edit Schedule</a></li>
       <li onclick="getSectionSched()" class="pointer"><a tabindex="-1"><i class="fa fa-eye fa-fw"></i>View Section's Schedule </a></li>
       <li class="divider"></li>
       <li onclick="deleteSchedule()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Delete Schedule</a></li>
    </ul>
</div>
<div id="addTimeMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a onclick="getTime()"><i class="fa fa-plus-square fa-fw"></i>Add Time</a></li>
       <li id="timeDeleteMenu" onclick="deleteTime()" style="display: none;" class="pointer"><a><i class="fa fa-trash fa-fw"></i>Delete Time</a></li>
    </ul>
</div>
<input type="hidden" id="selectedSchedId" />
<input type="hidden" id="selectedDayID" />
<input type="hidden" id="timeSchedID" />
<input type="hidden" id="selectedSectionID" />

<?php 
    $this->load->view('addRooms');
    $this->load->view('addTime');
    $this->load->view('createSchedModal');
?>
<script type="text/javascript">
    function selectDepartmentSched(value)
    {
        var url = "<?php echo base_url().'schedule/loadSchedule/' ?>"+value;
            
        $.ajax({
               type: "GET",
               url: url,
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#sched_body').html(data)
               }
             });

        return false;   
    }
    function saveTime()
    {
        var from = $('#addTimeFrom').val()
        var to = $('#addTimeTo').val()
        var department = $('#timeDepartment').val()
        var url = "<?php echo base_url().'schedule/addTime/' ?>"+department; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               dataType: 'json',
               url: url,
               data: 'from='+from+'&to='+to+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   if(data.status)
                       {
                           alert(data.msg)
                           location.reload()
                       }else{
                           alert(data.msg)
                       }
               }
             });

        return false;
    
    }
    
    function getTime()
    {
        $('#addTimeModal').modal('show');
    }
    
    function getSchedule()
    {
        $('#inputTeacher').select2()
        var day_id = $('#selectedDayID').val()
        var from = $('#inputTimeFrom').val()
        var to = $('#inputTimeTo').val()
        var time_id = $('#timeSchedID').val()
        $('#schedDay').modal('show');
        $('#cDayHidden').val(day_id)
        $('#cTimeID').val(time_id)
        switch(day_id){
            case '1':
               day_id="Monday" 
            break;
            case '2':
               day_id="Tuesday" 
            break;
            case '3':
               day_id="Wednesday" 
            break;
            case '4':
               day_id="Thursday" 
            break;
            case '5':
               day_id="Friday" 
            break;
            case '6':
               day_id="Saturday" 
            break;
        }
        $('#currentDay').html(day_id)
        $('#timeFrom_span').html(from)
        $('#timeTo_span').html(to)
    }
    function getRooms()
    {
        var url = "<?php echo base_url().'schedule/getRooms/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "GET",
               url: url,
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#sched_body').html(data)
               }
             });

        return false;
    }
    
        function maxSched()
    {
        var url = "<?php echo base_url().'schedule/maxSched/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "GET",
               url: url,
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#max_Schedule').html(data);
               }
             });

        return false;
    }
    
function addTimeSelect(fromTo)
{
    var hour = $('#inputHour'+fromTo).val()
    var minutes = $('#inputMinutes'+fromTo).val()
    var AmPm = $('#'+fromTo).val()
    
    if(AmPm=="PM"){
        hour = parseInt(hour) + 12;
    }

    $('#addTime'+fromTo).val(hour+':'+minutes+':'+'00')
}

function getTeacherSched(id)
    {
        var url = "<?php echo base_url().'schedule/teacherSched/' ?>"+id; // the script where you handle the form input.
        $.ajax({
               type: "GET",
               url: url,
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#sched_body').html(data);
               }
             });

        return false;
    }
    
    function getSectionSched()
    {
        var section_id = $('#selectedSectionID').val();
        var url = "<?php echo base_url().'schedule/sectionSched/' ?>"+section_id; // the script where you handle the form input.
        $.ajax({
               type: "GET",
               url: url,
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   //$('#sched_body').html(data);
                   document.location=url;
               }
             });

        return false;
    }

    function deleteSchedule()
    {
       var id = $('#selectedSchedId').val()
       var answer = confirm("Do you really want to delete this schedule? You cannot undo this action.");
        if(answer==true){
            var url = "<?php echo base_url().'schedule/deleteSched/'?>"+id ;
               $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                data: 'qcode='+id, // serializes the form's elements.
                success: function(data)
                {   
                    if(data.status){
                        $('#'+id+'_sched').addClass('hide')
                        alert(data.msg)
                    }else{
                        alert(data.msg)
                    }
                    
                }
              });
         }
         
        
    }
    
    function deleteTime()
    {
       var id = $('#timeSchedID').val()
       var answer = confirm("Do you really want to delete this Time? Remember there might be some schedules that is assigned to this time. \n\
                             You cannot undo this action, so be careful.");
        if(answer==true){
            var url = "<?php echo base_url().'schedule/deleteTime/'?>"+id ;
               $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                data: 'qcode='+id, // serializes the form's elements.
                success: function(data)
                {   
                    if(data.status){
                        $('#'+id+'_time').addClass('hide')
                        alert(data.msg)
                    }else{
                        alert(data.msg)
                    }
                    
                }
              });
         }
         
        
    }
</script>