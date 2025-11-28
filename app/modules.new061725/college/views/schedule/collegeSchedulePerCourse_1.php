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
              <button data-toggle="modal" data-target="#addRoomsForm" style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right"><i class="fa fa-window-maximize"></i></button>
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
                    <th class="text-center pointer" style="width:13%;">Time</th>
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
        <div class="panel-body no-padding" style="max-height: 700px; overflow-y: scroll">
            <table id="schedTables" class="table table-bordered">  
                <tbody>    
                   <tr>
                       <td></td>
                   </tr>
                   <?php 
                       foreach ($time_range as $key => $value):  
                           $day1 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 1, $course_id, $year, strtotime($value));
                           $day2 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 2, $course_id, $year, strtotime($value));
                           $day3 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 3, $course_id, $year, strtotime($value));
                           $day4 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 4, $course_id, $year, strtotime($value));
                           $day5 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 5, $course_id, $year, strtotime($value));
                           $day6 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 6, $course_id, $year, strtotime($value));
                           
                           
                           
                           $now = strtotime($value);
                           if(strtotime($day1->data->t_from) == $now):
                                $highlighted1 = 'highlighted';
                                $gcode1 = $day1->data->sched_gcode;
                                $style1 = 'background:'.$day1->color.';'.$day1->border;
                            elseif(strtotime($day1->data->t_to) > $now):
                                $highlighted1 =  'highlighted';
                                $gcode1 = $day1->data->sched_gcode;
                                $style1 ='background:'.$day1->color.';'.$day1->border;
                            elseif(strtotime($day1->data->t_to) < $now):
                                $highlighted1 =  'highlighted';
                                $gcode1 = $day1->data->sched_gcode;
                                $style1 ='background:'.$day1->color.';'.$day1->border;
                            else:
                                $highlighted1 = '';
                                $gcode1 = "";
                                $style1 = "";
                            endif;
                           if(new DateTime($day2->data->t_from) == $now):
                                $highlighted2 = 'highlighted';
                                $gcode2 = $day2->data->sched_gcode;
                                $style2 = 'background:'.$day2->color.';'.$day2->border;
                            elseif(new DateTime($day2->data->t_to) > $now):
                                $highlighted2 =  'highlighted';
                                $gcode2 = $day2->data->sched_gcode;
                                $style2 ='background:'.$day2->color.';'.$day2->border;
                            elseif(new DateTime($day2->data->t_to) < $now):
                                $highlighted2 =  'highlighted';
                                $gcode2 = $day2->data->sched_gcode;
                                $style2 ='background:'.$day2->color.';'.$day2->border;
                            else:
                                $highlighted2 = '';
                                $gcode2 = "";
                                $style2 = "";
                            endif;
                           if(new DateTime($day3->data->t_from) == $now):
                                $highlighted3 = 'highlighted';
                                $gcode3 = $day3->data->sched_gcode;
                                $style3 = 'background:'.$day3->color.';'.$day3->border;
                            elseif(new DateTime($day3->data->t_to) > $now):
                                $highlighted3 =  'highlighted';
                                $gcode3 = $day3->data->sched_gcode;
                                $style3 ='background:'.$day3->color.';'.$day3->border;
                            elseif(new DateTime($day3->data->t_to) < $now):
                                $highlighted3 =  'highlighted';
                                $gcode3 = $day3->data->sched_gcode;
                                $style3 ='background:'.$day3->color.';'.$day3->border;
                            else:
                                $highlighted3 = '';
                                $gcode3 = "";
                                $style3 = "";
                            endif;
                           if(new DateTime($day4->data->t_from) == $now):
                                $highlighted4 = 'highlighted';
                                $gcode4 = $day4->data->sched_gcode;
                                $style4 = 'background:'.$day4->color.';'.$day4->border;
                            elseif(new DateTime($day4->data->t_to) > $now):
                                $highlighted4 =  'highlighted';
                                $gcode4 = $day4->data->sched_gcode;
                                $style4 ='background:'.$day4->color.';'.$day4->border;
                            elseif(new DateTime($day4->data->t_to) < $now):
                                $highlighted4 =  'highlighted';
                                $gcode4 = $day4->data->sched_gcode;
                                $style4 ='background:'.$day4->color.';'.$day4->border;
                            else:
                                $highlighted4 = '';
                                $gcode4 = "";
                                $style4 = "";
                            endif;
                           if(new DateTime($day5->data->t_from) == $now):
                                $highlighted5 = 'highlighted';
                                $gcode5 = $day5->data->sched_gcode;
                                $style5 = 'background:'.$day5->color.';'.$day5->border;
                            elseif(new DateTime($day5->data->t_to) > $now):
                                $highlighted5 =  'highlighted';
                                $gcode5 = $day5->data->sched_gcode;
                                $style5 ='background:'.$day5->color.';'.$day5->border;
                            elseif(new DateTime($day5->data->t_to) < $now):
                                $highlighted5 =  'highlighted';
                                $gcode5 = $day5->data->sched_gcode;
                                $style5 ='background:'.$day5->color.';'.$day5->border;
                            else:
                                $highlighted5 = '';
                                $gcode5 = "";
                                $style5 = "";
                            endif;
                           if(new DateTime($day6->data->t_from) == $now):
                                $highlighted6 = 'highlighted';
                                $gcode6 = $day6->data->sched_gcode;
                                $style6 = 'background:'.$day5->color.';'.$day6->border;
                            elseif(new DateTime($day6->data->t_to) > $now):
                                $highlighted6 =  'highlighted';
                                $gcode6 = $day6->data->sched_gcode;
                                $style6 ='background:'.$day6->color.';'.$day6->border;
                            elseif(new DateTime($day6->data->t_to) < $now):
                                $highlighted6 =  'highlighted';
                                $gcode6 = $day6->data->sched_gcode;
                                $style6 ='background:'.$day6->color.';'.$day6->border;
                            else:
                                $highlighted6 = '';
                                $gcode6 = "";
                                $style6 = "";
                            endif;
                           
                   ?>
                           <tr class="time" id="tr_<?php echo $key ?>">
                               <th class="text-center no-padding" style="width:13%; height:30px;" ><span style="position:relative; top:-11px; font-weight: bold;"><?php echo date('g:i:s', strtotime($value)) ?></span></th>
                               
                               <td group_id ="<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day1->status?$day1->position:'')  ?>" day_id="1" id="td_<?php echo $key ?>_1" class="no-padding text-center <?php echo ($day1->status?$highlighted1:'') ?> <?php echo ($day1->status?$gcode1:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day1->status?$style1:'') ?>">
                                   <?php 
                                        if($day1->status)
                                        
                                        switch ($day1->position):
                                            case 'from':
//                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day1->status?$day1->data->sched_gcode:'')  ?>_1" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day1->data->sub_code.' - Rm. '.$day1->data->room.'<br />'.$day1->data->short_code.'-'.$day1->data->section;
                                            break;
                                            case 'mid':
                                                echo date('g:i:s', strtotime($day1->data->t_from)).' - '. date('g:i:s', strtotime($day1->data->t_to));
                                            break;
                                        endswitch; 
                                   
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day2->status?$day2->position:'')  ?>" day_id="2"  id="td_<?php echo $key ?>_2" class="text-center <?php echo ($day2->status?$highlighted2:'') ?> <?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>" style="width:12.5%; <?php echo ($day2->status?$style2:'') ?>">
                                    <?php 
                                        if($day2->status)
                                        switch ($day2->position):
                                            case 'from':
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_2','<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day2->status?$day2->data->sched_gcode:'')  ?>_2" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day2->data->sub_code.' - Rm. '.$day2->data->room.'<br />'.$day2->data->short_code.'-'.$day2->data->section;
                                            break;
                                            case 'mid':

                                                echo date('g:i:s', strtotime($day2->data->t_from)).' - '. date('g:i:s', strtotime($day2->data->t_to));
                                            break;
                                        endswitch; 
                                   
                                    ?>
                               </td>
                               <td group_id ="<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day3->status?$day3->position:'')  ?>" day_id="3" id="td_<?php echo $key ?>_3" class="no-padding text-center <?php echo ($day3->status?$highlighted3:'') ?> <?php echo ($day3->status?$gcode3:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day3->status?$style3:'') ?>">
                                   <?php 
                                        if($day3->status)
                                        
                                        switch ($day3->position):
                                            case 'from':
//                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_3','<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day3->status?$day3->data->sched_gcode:'')  ?>_3" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day3->data->sub_code.' - Rm. '.$day3->data->room.'<br />'.$day3->data->short_code.'-'.$day3->data->section;
                                            break;
                                            case 'mid':
                                                echo date('g:i:s', strtotime($day3->data->t_from)).' - '. date('g:i:s', strtotime($day3->data->t_to));
                                            break;
                                        endswitch; 
                                   
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day4->status?$day4->position:'')  ?>" day_id="4" id="td_<?php echo $key ?>_4" class="no-padding text-center <?php echo ($day4->status?$highlighted4:'') ?> <?php echo ($day4->status?$gcode4:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day4->status?$style4:'') ?>">
                                   <?php 
                                        if($day4->status)
                                        
                                        switch ($day4->position):
                                            case 'from':
//                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_4','<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day4->status?$day4->data->sched_gcode:'')  ?>_4" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day4->data->sub_code.' - Rm. '.$day4->data->room.'<br />'.$day4->data->short_code.'-'.$day4->data->section;
                                            break;
                                            case 'mid':
                                                echo date('g:i:s', strtotime($day4->data->t_from)).' - '. date('g:i:s', strtotime($day4->data->t_to));
                                            break;
                                        endswitch; 
                                   
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day5->status?$day5->position:'')  ?>" day_id="5" id="td_<?php echo $key ?>_5" class="no-padding text-center <?php echo ($day5->status?$highlighted5:'') ?> <?php echo ($day5->status?$gcode5:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day5->status?$style5:'') ?>">
                                   <?php 
                                        if($day5->status)
                                        
                                        switch ($day5->position):
                                            case 'from':
//                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_5','<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day5->status?$day5->data->sched_gcode:'')  ?>_5" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day5->data->sub_code.' - Rm. '.$day5->data->room.'<br />'.$day5->data->short_code.'-'.$day5->data->section;
                                            break;
                                            case 'mid':
                                                echo date('g:i:s', strtotime($day5->data->t_from)).' - '. date('g:i:s', strtotime($day5->data->t_to));
                                            break;
                                        endswitch; 
                                   
                                   ?>
                               </td>
                               <td group_id ="<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" position = "<?php echo ($day6->status?$day6->position:'')  ?>" day_id="6" id="td_<?php echo $key ?>_6" class="no-padding text-center <?php echo ($day6->status?$highlighted6:'') ?> <?php echo ($day6->status?$gcode6:'')  ?>" style="width:12.5%; text-algin:center; vertical-align: middle; <?php echo ($day6->status?$style6:'') ?>">
                                   <?php 
                                        if($day6->status)
                                        
                                        switch ($day6->position):
                                            case 'from':
//                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_6','<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>')" id="delete_<?php echo ($day6->status?$day6->data->sched_gcode:'')  ?>_6" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                <?php
                                                echo $day6->data->sub_code.' - Rm. '.$day6->data->room.'<br />'.$day6->data->short_code.'-'.$day6->data->section;
                                            break;
                                            case 'mid':
                                                echo date('g:i:s', strtotime($day6->data->t_from)).' - '. date('g:i:s', strtotime($day6->data->t_to));
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
            <div onclick="document.location='<?php echo base_url('college/schedule/perCourse/'.$c->course_id.'/'.$i) ?>'"  class='btn btn-default alert alert-warning no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
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
        <div style="min-height: 250px; max-height: 500px;overflow-y: scroll; " class="panel-body  no-padding">
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
               day_id = $(this).attr('day_id');
               
               switch(day_id)
               {
                    case 1:
                       day1.splice(day1.indexOf($(this).attr('time_id')),1);
                    break;
                    case 2:
                        day2.splice(day2.indexOf($(this).attr('time_id')),1);
                    break;
                    case 3:
                        day3.splice(day3.indexOf($(this).attr('time_id')),1);
                    break;
                    case 4:
                        day4.splice(day4.indexOf($(this).attr('time_id')),1);
                    break;
                    case 5:
                        day5.splice(day5.indexOf($(this).attr('time_id')),1);
                    break;
                    case 6:
                        day6.splice(day6.indexOf($(this).attr('time_id')),1);
                    break;
               
               }
               
           }else{
               
                isMouseDown = true;
                $(this).toggleClass("highlighted");
                isHighlighted = $(this).hasClass("highlighted");
                highlight($(this).attr('id'));
                //alert(firstLast(day1))
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
                day1.push($('#'+id).attr('time_from'));
                day1.push($('#'+id).attr('time_to'));
            break;
            case '2':
                day2.push($('#'+id).attr('time_from'));
                day2.push($('#'+id).attr('time_to'));
            break;    
            case '3':
                day3.push($('#'+id).attr('time_from'));
                day3.push($('#'+id).attr('time_to'));
            break;    
            case '4':
                day4.push($('#'+id).attr('time_from'));
                day4.push($('#'+id).attr('time_to'));
            break;    
            case '5':
                day5.push($('#'+id).attr('time_from'));
                day5.push($('#'+id).attr('time_to'));
            break;    
            case '6':
                day6.push($('#'+id).attr('time_from'));
                day6.push($('#'+id).attr('time_to'));
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
                   console.log(data.source)
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