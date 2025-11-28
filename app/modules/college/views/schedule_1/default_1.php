<div class="col-lg-12">
    <div style="margin-top:10px;">
        <div class="control-group pull-right">
          <div class="controls"> 
              <!--<button data-toggle="modal" data-target="#sched"  style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Create</button>-->  
              <button onclick="getRooms()" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">View Rooms</button>  
              <button data-toggle="modal" data-target="#addRoomsForm" style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Add Rooms</button>
              <button onclick="document.location='<?php echo base_url('schedule') ?>'" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">View Schedules</button>
            </div>
        </div>
    </div>
    <h3 class="page-header clearfix" style="margin:0">College Schedule/Room Management</h3>
</div>
<div class="col-lg-9">
    <div class="panel panel-danger">
        <div class="panel-heading no-padding">
            <table class="table table-bordered table-hover no-margin">
            <thead>
                <tr>
                    <th class="text-center pointer" style="width:14%;">Time</th>
                    <!--<th class="text-center" style="width:12.5%;">Sun</th>-->
                    <th class="text-center" style="width:12.5%;">Mon</th>
                    <th class="text-center" style="width:12.5%;">Tue</th>
                    <th class="text-center" style="width:12.5%;">Wed</th>
                    <th class="text-center" style="width:12.5%;">Thu</th>
                    <th class="text-center" style="width:12.5%;">Fri</th>
                    <th class="text-center" style="width:12.5%;">Sat</th>
                </tr>
            </thead>
            </table>
        </div>
        <div class="panel-body no-padding" style="max-height: 550px; overflow-y: scroll">
            <?php
             $monInclude = Modules::run('schedule/getSchedPerDay', 1);
             $mon = json_decode($monInclude);
             $tueInclude = Modules::run('schedule/getSchedPerDay', 2);
             $tue = json_decode($tuesInclude);
             $wedInclude = Modules::run('schedule/getSchedPerDay', 3);
             $wed = json_decode($wedInclude);
             $friInclude = Modules::run('schedule/getSchedPerDay', 5);
             $fri = json_decode($friInclude);
             $satInclude = Modules::run('schedule/getSchedPerDay', 6);
             $sat = json_decode($satInclude);
            ?>
            <table class="table table-bordered">    
                <tbody>    
                    <?php 
                        foreach ($time_range as $key => $value):
                           $monSubjects = explode(',', trim($mon->subjects->$key,','));
                           $tueSubjects = explode(',', trim($tue->subjects->$key,','));
                           $wedSubjects = explode(',', trim($wed->subjects->$key,','));
                           $friSubjects = explode(',', trim($fri->subjects->$key,','));
                           $satSubjects = explode(',', trim($sat->subjects->$key,','));
                           
                    ?>
                            <tr class="time" data-toggle="context" data-target="#addSchedMenu" id="tr_<?php echo $key ?>">
                                <td class="text-center" style="width:14%;" ><?php echo $value ?></td>
                                <td time_id ="<?php echo $key ?>" day_id="1" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_1" class="text-center" style="width:12.5%;">
                                   <?php
                                        foreach ($monSubjects as $k => $value):
                                            $monSub = Modules::run('academic/getCollegeSubjects', $value);
                                            if($monSub->sub_code!=""):
                                                ?>
                                                    <span class="btn btn-xs btn-warning col-lg-12 pointer" style="margin-bottom:2px;"><?php echo $monSub->sub_code;?></span>
                                                    <?php
                                            endif;
                                        endforeach;
                                   ?>
                                    
                                </td>
                                <td time_id ="<?php echo $key ?>" day_id="2" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_2" class="text-center" style="width:12.5%;">
                                <?php
                                        foreach ($tueSubjects as $k => $value):
                                            $tueSub = Modules::run('academic/getCollegeSubjects', $value);
                                            if($tueSub->sub_code!=""):
                                                ?>
                                                    <span class="btn btn-xs btn-warning col-lg-12 pointer" style="margin-bottom:2px;"><?php echo $tueSub->sub_code;?></span>
                                                    <?php
                                            endif;
                                        endforeach;
                                   ?>
                                </td>
                                <td time_id ="<?php echo $key ?>" day_id="3" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_3" class="text-center" style="width:12.5%;">
                                <?php
                                        foreach ($wedSubjects as $k => $value):
                                            $wedSub = Modules::run('academic/getCollegeSubjects', $value);
                                            if($wedSub->sub_code!=""):
                                                ?>
                                                    <span class="btn btn-xs btn-warning col-lg-12 pointer" style="margin-bottom:2px;"><?php echo $wedSub->sub_code;?></span>
                                                    <?php
                                            endif;
                                        endforeach;
                                   ?>
                                </td>
                                <td time_id ="<?php echo $key ?>" day_id="4" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_4" class="text-center" style="width:12.5%;">
                                </td>
                                <td time_id ="<?php echo $key ?>" day_id="5" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_5" class="text-center" style="width:12.5%;<?php echo $wedBg ?>">
                                   <?php
                                        foreach ($friSubjects as $k => $value):
                                            $friSub = Modules::run('academic/getCollegeSubjects', $value);
                                            if($friSub->sub_code!=""):
                                                ?>
                                                    <span class="btn btn-xs btn-warning col-lg-12 pointer" style="margin-bottom:2px;"><?php echo $friSub->sub_code;?></span>
                                                    <?php
                                            endif;
                                        endforeach;
                                   ?>
                                </td>
                                <td time_id ="<?php echo $key ?>" day_id="6" ondblclick="highlight(this.id)" id="td_<?php echo $key ?>_6" class="text-center" style="width:12.5%;">
                                   <?php
                                        foreach ($satSubjects as $k => $value):
                                            $satSub = Modules::run('academic/getCollegeSubjects', $value);
                                            if($satSub->sub_code!=""):
                                                ?>
                                                    <span class="btn btn-xs btn-warning col-lg-12 pointer" style="margin-bottom:2px;"><?php echo $satSub->sub_code;?></span>
                                                    <?php
                                            endif;
                                        endforeach;
                                   ?>
                                </td>
                            </tr>                    
                    <?php        
                        endforeach;


                    ?>

                </tbody>

        </table>
        </div>
    </div>
    
            
</div>
<div class="col-lg-3 no-padding">
    <div class="panel panel-yellow">
        <div class="panel-heading ">
            Faculty
        </div>
        <div style="min-height: 250px; max-height: 250px;overflow-y: scroll; " class="panel-body  no-padding">
            <?php foreach($employees->result() as $e): ?>
            <div class='btn btn-warning alert alert-warning no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                <div class="notify">
                    <?php echo strtoupper($e->firstname.' '.$e->lastname); ?>
                </div>
            </div>        
            <?php endforeach; ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
           List of Subjects Per Course
        </div>
        <div style="min-height: 250px; max-height: 250px;overflow-y: scroll; " class="panel-body  no-padding">
            <?php foreach($subjects as $s): ?>
            <div class='btn btn-info alert alert-info no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                <div class="notify">
                    <?php echo strtoupper($s->sub_code.' ['.$s->short_code.']'); ?>
                </div>
            </div>        
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div id="addSchedMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a onclick="loadSchedule()"><i class="fa fa-plus-square fa-fw"></i>Add Schedule</a></li>
       <li class="pointer"><a tabindex="-1"><i class="fa fa-edit fa-fw"></i>Edit Schedule</a></li>
       <li onclick="getSectionSched()" class="pointer"><a tabindex="-1"><i class="fa fa-eye fa-fw"></i>View Section's Schedule </a></li>
       <li class="divider"></li>
       <li onclick="deleteSchedule()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Delete Schedule</a></li>
    </ul>
</div>
<?php 
    $this->load->view('addRooms');
    $this->load->view('createSchedModal');
?>
<script type="text/javascript">

        var day1 = []
        var day2 = []
        var day3 = []
        var day4 = []
        var day5 = []
        var day6 = []
    function highlight(id)
    {
        var column = $('#'+id).attr('day_id');
        switch(column){
            case '1':
                day1.push($('#'+id).attr('time_id'));
            break;
            case '2':
                day2.push($('#'+id).attr('time_id'));
            break;    
            case '3':
                day3.push($('#'+id).attr('time_id'));
            break;    
            case '4':
                day4.push($('#'+id).attr('time_id'));
            break;    
            case '5':
                day5.push($('#'+id).attr('time_id'));
            break;    
            case '6':
                day6.push($('#'+id).attr('time_id'));
            break;    
        }
        
        
        if($('#'+id).hasClass('hasBG')){
            document.getElementById(id).style = 'background:none';
            $('#'+id).removeClass('hasBG');
        }else{
            document.getElementById(id).style = 'background:#4073A0';
            $('#'+id).addClass('hasBG');
        }
        
        
    }
    
    function remove_duplicates(arr) {
        var obj = {};
        for (var i = 0; i < arr.length; i++) {
            obj[arr[i]] = true;
        }
        arr = [];
        for (var key in obj) {
            arr.push(key);
        }
        return arr;
    }
    
    function firstLast(array)
    {
        if(array==''){
            var result = "";
        }else{
            var obj = remove_duplicates(array);
            var first = obj[0];
            var last = obj.slice(-1)[0];
            result = first+','+last;
        }
        
        return result;
        
    }
    
    function loadSchedule()
    {
        $('#schedDay').modal('show');
    }
    
    function getSchedule()
    {
        var data = "&mon="+firstLast(day1)+"&tue="+firstLast(day2)+"&wed="+firstLast(day3)+"&thu="+firstLast(day4)+"&fri="+firstLast(day5)+"&sat="+firstLast(day6);
        var url = "<?php echo base_url().'schedule/addCollegeSched/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               dataType: 'json',
               url: url,
               data: $('#addSched').serialize()+data+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data.msg);
                   $('#schedDay').modal('hide');
               }
             });

        return false;
    }
    
    </script>