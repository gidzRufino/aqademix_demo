<?php echo link_tag('assets/css/plugins/chat/pick-a-color-1.2.3.min.css'); ?>
<style>
    table td.highlighted {
        background-color:#4073A0;
      }
</style>
<div class="col-lg-12">
    <div style="margin-top:10px;">
        <div class="control-group pull-right">
          <div class="controls"> 
              <button onclick="loadSchedule()" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">Add Schedule</button>
              <button onclick="document.location='<?php echo base_url('college') ?>'" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">Dashboard</button>
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
            <table id="schedTables" class="table table-bordered">  
                <tbody>    
                   <tr>
                       <td></td>
                   </tr>
                   <?php 
                       foreach ($time_range as $key => $value):  
                           $day1 = Modules::run('college/schedule/getSingleTimeSchedule', 1, $value, $sub_id);
                           $day2 = Modules::run('college/schedule/getSingleTimeSchedule', 2, $value, $sub_id);
                           $day3 = Modules::run('college/schedule/getSingleTimeSchedule', 3, $value, $sub_id);
                           $day4 = Modules::run('college/schedule/getSingleTimeSchedule', 4, $value, $sub_id);
                           $day5 = Modules::run('college/schedule/getSingleTimeSchedule', 5, $value, $sub_id);
                           $day6 = Modules::run('college/schedule/getSingleTimeSchedule', 6, $value, $sub_id);
                   ?>
                           <tr class="time" id="tr_<?php echo $key ?>">
                               <th class="text-center no-padding" style="width:14%; height:30px;" ><span style="position:relative; font-weight: bold;"><?php echo date('g:i:s', strtotime($value)) ?></span></th>
                               
                               <td group_id ="<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>"  time_id ="<?php echo $value ?>" position = "<?php echo ($day1->status?$day1->position:'')  ?>" day_id="1" id="td_<?php echo $key ?>_1" class="no-padding text-center <?php echo ($day1->status?'highlighted':'') ?> <?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day1->status?'background:'.$day1->color.';'.$day1->border:'') ?>">
                                   <?php 
                                        if($day1->status)
                                        switch ($day1->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>_1" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day1->data->sub_code.' - Rm. '.$day1->data->room;
                                            break;
                                            case 'mid':
                                                
                                            break;
                                            case 'to':
                                                echo $day1->data->t_from.' - '.$day1->data->t_to;
                                            break;
                                        endswitch; 
                                   
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>" time_id ="<?php echo $value ?>" position = "<?php echo ($day2->status?$day2->position:'')  ?>" day_id="2"  id="td_<?php echo $key ?>_2" class="text-center <?php echo ($day2->status?'highlighted':'') ?> <?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day2->status?'background:'.$day2->color.';'.$day2->border:'') ?>">
                                    <?php 
                                        if($day2->status)
                                        switch ($day2->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>_2" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day2->data->sub_code.' - Rm. '.$day2->data->room;
                                            break;
                                            case 'mid':

                                            break;
                                            case 'to':
                                                echo $day2->data->t_from.' - '.$day2->data->t_to;
                                            break;
                                        endswitch; 
                                   
                                    ?>
                               </td>
                               <td group_id ="<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>" time_id ="<?php echo $value ?>" day_id="3"  id="td_<?php echo $key ?>_3" class="text-center <?php echo ($day3->status?'highlighted':'') ?> <?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day3->status?'background:'.$day3->color.';'.$day3->border:'') ?>">
                                    <?php 
                                        if($day3->status)
                                        switch ($day3->position):
                                            case 'from':
                                                
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>_3" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day3->data->sub_code.' - Rm. '.$day3->data->room;
                                            break;
                                            case 'mid':

                                            break;
                                            case 'to':
                                                echo $day3->data->t_from.' - '.$day3->data->t_to;
                                            break;
                                        endswitch; 
                                   
                                    ?>
                               </td>
                               <td group_id ="<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>" time_id ="<?php echo $value ?>" day_id="4"  id="td_<?php echo $key ?>_4" class="text-center <?php echo ($day4->status?'highlighted':'') ?> <?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day4->status?'background:'.$day4->color.';'.$day4->border:'') ?>">
                                    <?php 
                                        if($day4->status)
                                        switch ($day4->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>_4" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day4->data->sub_code.' - Rm. '.$day4->data->room;
                                            break;
                                            case 'mid':

                                            break;
                                            case 'to':
                                                echo $day4->data->t_from.' - '.$day4->data->t_to;
                                            break;
                                        endswitch; 
                                   
                                    ?>
                               </td>
                               <td group_id ="<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>" time_id ="<?php echo $value ?>" day_id="5" id="td_<?php echo $key ?>_5" class="text-center <?php echo ($day5->status?'highlighted':'') ?> <?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day5->status?'background:'.$day5->color.';'.$day5->border:'') ?> ">
                                    <?php 
                                        if($day5->status)
                                        switch ($day5->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>_5" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day5->data->sub_code.' - Rm. '.$day5->data->room;
                                            break;
                                            case 'mid':

                                            break;
                                            case 'to':
                                                echo $day5->data->t_from.' - '.$day5->data->t_to;
                                            break;
                                        endswitch; 
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>" time_id ="<?php echo $value ?>" day_id="6"  id="td_<?php echo $key ?>_6" class="text-center <?php echo ($day6->status?'highlighted':'') ?> <?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day6->status?'background:'.$day6->color.';'.$day6->border:'') ?>">
                                     <?php 
                                        if($day6->status)
                                        switch ($day6->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>_6" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day6->data->sub_code.' - Rm. '.$day6->data->room;
                                            break;
                                            case 'mid':

                                            break;
                                            case 'to':
                                                echo $day6->data->t_from.' - '.$day6->data->t_to;
                                            break;
                                        endswitch; 
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
            Course
        </div>
        <div style="min-height: 200px; max-height: 300px;overflow-y: scroll; " class="panel-body  no-padding">
            <?php foreach($course as $c): 
                    for($i=1;$i<=4;$i++):
                        switch ($i):
                            case 1: 
                                $a = 'First';  
                            break;
                            case 2: 
                                $a = 'Second';  
                            break;
                            case 3: 
                                $a = 'Third';  
                            break;
                            case 4: 
                                $a = 'Fourth';  
                            break;
                        endswitch;
                ?>
            <div onclick="document.location='<?php echo base_url('college/schedule/perCourse/'.$c->course_id.'/'.$i.'/1/'.$sy) ?>'"  class='btn btn-default alert alert-warning no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                <div class="notify">
                    <?php echo strtoupper($c->short_code).' - '.$a; ?>
                </div>
            </div>        
            <?php 
            endfor;
            endforeach; ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
           List of Subjects
        </div>
        <div style="min-height: 250px; max-height: 250px;overflow-y: scroll; " class="panel-body  no-padding">
            <?php foreach($collegeSubjects->result() as $s):
                    $subs = Modules::run('college/subjectmanagement/getSubjectsOffered', $s->s_id);
                    if($subs->num_rows()>0):
                ?>
            <div onclick="getSchedulePerSubject('<?php echo $s->s_id; ?>')" class='btn btn-info alert alert-info no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                
                <div class="notify">
                    <?php echo strtoupper($s->sub_code).' ( '.$subs->num_rows().' )'; ?>
                </div>
            </div>      
            
                <?php endif; 
                endforeach; ?>
        </div>
    </div>
</div>

<?php 
    $this->load->view('createSchedModal');
?>
<script type="text/javascript">
        var day1 = []
        var day2 = []
        var day3 = []
        var day4 = []
        var day5 = []
        var day6 = []
        
        var isMouseDown = false, isHighlighted, gcode, day_id;
        
        $('#schedTables td').mousedown(function(){
           
           if($(this).hasClass("highlighted"))
           {
               gcode = $(this).attr('group_id');
               $(this).removeClass('highlighted');

           }else{
               
                isMouseDown = true;
                $(this).toggleClass("highlighted");
                isHighlighted = $(this).hasClass("highlighted");
                highlight($(this).attr('id'));
           }
           return false;
        });
        
        $('#schedTables td').mouseover(function (){
            if($(this).hasClass("highlighted"))
            {
                gcode = $(this).attr('group_id');
                day_id = $(this).attr('day_id');
                $('#delete_'+gcode+'_'+day_id).addClass('pointer');
                
                $('#delete_'+gcode+'_'+day_id).show()
                $('#delete_'+gcode+'_'+day_id).addClass('show');
            }
            
            if(isMouseDown){
                $(this).toggleClass("highlighted", isHighlighted);
                highlight($(this).attr('id'));
            }
        });
        
        $('#schedTables td').mouseout(function(){
            gcode = $(this).attr('group_id');
            day_id = $(this).attr('day_id');
            
            if($(this).hasClass("highlighted"))
            {
                if($('#delete_'+gcode+'_'+day_id).hasClass('show'))
                {
                    $('#delete_'+gcode+'_'+day_id).hide();
                    $('#delete_'+gcode+'_'+day_id).removeClass('show')
                }
            }
        });
        
        $(document)
          .mouseup(function () {
            isMouseDown = false;
            
        });
    
    function confirmDelete(id, gcode)
    {
            
               var confirmDelete = confirm('Are you sure you want to Delete this Schedule? Please note that you cannot undo this action.');
               if(confirmDelete)
               {
                    $('.'+gcode).css('background', '')
                    $('.'+gcode).css('border', '1px solid #ddd');
                    $('.'+gcode).html('');
                    $('.'+gcode).removeClass('highlighted');
                    isMousedown = false;
                    deleteSchedule(gcode)
               }
    }
    
    function deleteSchedule(gcode)
    {
        var url = "<?php echo base_url().'college/schedule/deleteSchedule/' ?>"+gcode; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               data:'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data);
                   location.reload();
               }
             });

        return false;
    }
    
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
        if(isHighlighted)
        {
            $('#schedDay').modal('show');
        }else{
            alert('Please Select Day and Time to add the schedule');
        }
        
    }
    
    function getSchedule()
    {
        var data = "&mon="+firstLast(day1)+"&tue="+firstLast(day2)+"&wed="+firstLast(day3)+"&thu="+firstLast(day4)+"&fri="+firstLast(day5)+"&sat="+firstLast(day6);
        var url = "<?php echo base_url().'college/schedule/addCollegeSched/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               dataType: 'json',
               url: url,
               data: $('#addSched').serialize()+data+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data.msg);
                   location.reload();
               }
             });

        return false;
    }

    function getSchedulePerSubject(s_id)
    {
        if($('#schedTable td').hasClass('hasSched')){
            $('#schedTable td').css('background', 'none');
            $('#schedTable td').css('border', '1px solid #ddd');
            $('#schedTable td').html('');
        }
        
        var url = "<?php echo base_url().'college/schedule/getSchedulePerSubject/' ?>"+s_id; // the script where you handle the form input.
        document.location = url;

    }
    </script>
    
    <script src="<?php echo base_url('assets/js/plugins/pick-a-color.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/tinycolor-0.9.15.min.js'); ?>"></script>