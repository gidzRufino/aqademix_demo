<?php echo link_tag('assets/css/plugins/chat/pick-a-color-1.2.3.min.css'); 
$sem = $this->uri->segment(5);
 switch ($sem):
     case 1:
        $first = 'Selected = "Selected"';
        $second = '';
        $summer = '';
     break;    
     case 2:
        $second = 'Selected = "Selected"';
        $first = '';
        $summer = '';
     break;    
     case 3:
        $summer = 'Selected = "Selected"';
        $first = '';
        $second = '';
     break;    
     default :
        $first = 'Selected = "Selected"';
        $second = '';
        $summer = '';
     break;    
 endswitch;
?>
<style>
    table td.highlighted {
        background-color:#4073A0;
      }
</style>
<div class="col-lg-12">
    <div style="margin-top:10px;">
        <div class="form-group pull-right">
              <select onclick="getSchedulePerSem(this.value, '<?php echo $this->uri->segment(4) ?>')" tabindex="-1" id="inputSem" name="inputSem" style="width:100%" >
                  <option>Select Semester</option>
                  <option <?php echo $first; ?> value="1">First Semester</option>
                  <option <?php echo $second; ?>  value="2">Second Semester</option>
                  <option <?php echo $summer; ?>  value="3">Summer</option>
              </select>
        </div>
        <div class="btn-group pull-right">
              <button onclick="document.location='<?php echo base_url('college') ?>'" class="btn btn-success btn-sm">Dashboard</button>
              <button onclick="loadSchedule()"  class="btn btn-success btn-sm">Add Schedule</button>
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
                    <th class="text-center" style="width:12.5%;">Sun</th>
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
                           $day1 = Modules::run('college/schedule/getSingleTimeSchedule', 1, $value, $sub_id, $sem);
                           $day2 = Modules::run('college/schedule/getSingleTimeSchedule', 2, $value, $sub_id, $sem);
                           $day3 = Modules::run('college/schedule/getSingleTimeSchedule', 3, $value, $sub_id, $sem);
                           $day4 = Modules::run('college/schedule/getSingleTimeSchedule', 4, $value, $sub_id, $sem);
                           $day5 = Modules::run('college/schedule/getSingleTimeSchedule', 5, $value, $sub_id, $sem);
                           $day6 = Modules::run('college/schedule/getSingleTimeSchedule', 6, $value, $sub_id, $sem);
                           $day7 = Modules::run('college/schedule/getSingleTimeSchedule', 7, $value, $sub_id, $sem);
                           
                   ?>
                           <tr class="time" id="tr_<?php echo $key ?>">
                               <th class="text-center no-padding" style="width:14%; height:30px;" ><span style="position:relative; top:-11px; font-weight: bold;"><?php echo date('g:i:s', strtotime($value)) ?></span></th>
                               
                                <td key="<?php echo $key ?>_1" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="1" id="td_<?php echo $key ?>_1" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day1 as $d1):
                                            if(strtotime($value)== strtotime($d1->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_1','<?php echo $d1->sched_gcode  ?>')" id="delete_<?php echo $d1->sched_gcode  ?>_1" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d1->sched_gcode  ?>" bg="<?php echo $d1->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_1" />
                                                    <?php echo $d1->sub_code.' - Rm. '.$d1->room.'<br />'.$d1->short_code.'-'.$d1->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d1->t_to) && strtotime($value) >  strtotime($d1->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d1->sched_gcode  ?>"  bg="<?php echo $d1->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_1" />
                                                      <?php echo $d1->t_from.' - '.$d1->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                               
                                <td key="<?php echo $key ?>_2" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="2" id="td_<?php echo $key ?>_2" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day2 as $d2):
                                            if(strtotime($value)== strtotime($d2->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_2','<?php echo $d2->sched_gcode  ?>')" id="delete_<?php echo $d2->sched_gcode  ?>_2" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d2->sched_gcode  ?>" bg="<?php echo $d2->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_2" />
                                                    <?php echo $d2->sub_code.' - Rm. '.$d2->room.'<br />'.$d2->short_code.'-'.$d2->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d2->t_to) && strtotime($value) >  strtotime($d2->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d2->sched_gcode  ?>"  bg="<?php echo $d2->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_2" />
                                                      <?php echo $d2->t_from.' - '.$d2->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                                <td key="<?php echo $key ?>_3" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="3" id="td_<?php echo $key ?>_3" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day3 as $d3):
                                            if(strtotime($value)== strtotime($d3->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_3','<?php echo $d3->sched_gcode  ?>')" id="delete_<?php echo $d3->sched_gcode  ?>_3" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d3->sched_gcode  ?>" bg="<?php echo $d3->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_3" />
                                                    <?php echo $d3->sub_code.' - Rm. '.$d3->room.'<br />'.$d3->short_code.'-'.$d3->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d3->t_to) && strtotime($value) >  strtotime($d3->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d3->sched_gcode  ?>"  bg="<?php echo $d3->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_3" />
                                                      <?php echo $d3->t_from.' - '.$d3->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                               <td key="<?php echo $key ?>_4" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="4" id="td_<?php echo $key ?>_4" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day4 as $d4):
                                            if(strtotime($value)== strtotime($d4->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_4','<?php echo $d4->sched_gcode  ?>')" id="delete_<?php echo $d4->sched_gcode  ?>_4" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d4->sched_gcode  ?>" bg="<?php echo $d4->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_4" />
                                                    <?php echo $d4->sub_code.' - Rm. '.$d4->room.'<br />'.$d4->short_code.'-'.$d4->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d4->t_to) && strtotime($value) >  strtotime($d4->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d4->sched_gcode  ?>"  bg="<?php echo $d4->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_4" />
                                                      <?php echo $d4->t_from.' - '.$d4->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                               <td key="<?php echo $key ?>_5" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="5" id="td_<?php echo $key ?>_5" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day5 as $d5):
                                            if(strtotime($value)== strtotime($d5->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_5','<?php echo $d5->sched_gcode  ?>')" id="delete_<?php echo $d5->sched_gcode  ?>_5" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d5->sched_gcode  ?>" bg="<?php echo $d5->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_5" />
                                                    <?php echo $d5->sub_code.' - Rm. '.$d5->room.'<br />'.$d5->short_code.'-'.$d5->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d5->t_to) && strtotime($value) >  strtotime($d5->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d5->sched_gcode  ?>"  bg="<?php echo $d5->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_5" />
                                                      <?php echo $d5->t_from.' - '.$d5->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                               <td key="<?php echo $key ?>_6" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="6" id="td_<?php echo $key ?>_6" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day6 as $d6):
                                            if(strtotime($value)== strtotime($d6->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_6','<?php echo $d6->sched_gcode  ?>')" id="delete_<?php echo $d6->sched_gcode  ?>_6" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d6->sched_gcode  ?>" bg="<?php echo $d6->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_6" />
                                                    <?php echo $d6->sub_code.' - Rm. '.$d6->room.'<br />'.$d6->short_code.'-'.$d6->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d6->t_to) && strtotime($value) >  strtotime($d6->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d6->sched_gcode  ?>"  bg="<?php echo $d6->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_6" />
                                                      <?php echo $d6->t_from.' - '.$d6->t_to; ?>
                                                    
                                                <?php
                                            endif;
                                        endforeach;
                                   
                                   ?>
                               </td>
                               <td key="<?php echo $key ?>_7" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="7" id="td_<?php echo $key ?>_7" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
                                   <?php 
                                        
                                        foreach ($day7 as $d7):
                                            if(strtotime($value)== strtotime($d7->t_from)):
                                                ?>
                                                    <div onclick="confirmDelete('td_<?php echo $key ?>_7','<?php echo $d7->sched_gcode  ?>')" id="delete_<?php echo $d7->sched_gcode  ?>_7" style="position: relative; width: 100%; top:-18px; display: none;">
                                                        <i class="fa fa-times-circle" style="font-size:20px; position:absolute; left:96%; "></i>
                                                    </div>
                                                    <input gcode="<?php echo $d7->sched_gcode  ?>" bg="<?php echo $d7->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_7" />
                                                    <?php echo $d7->sub_code.' - Rm. '.$d7->room.'<br />'.$d7->short_code.'-'.$d7->section; ?>
                                                <?php 
                                            elseif(strtotime($value)< strtotime($d7->t_to) && strtotime($value) >  strtotime($d7->t_from)):
                                                ?>
                                                    <input gcode="<?php echo $d7->sched_gcode  ?>"  bg="<?php echo $d7->color_code ?>" type="hidden" value="1" id="input_<?php echo $key ?>_7" />
                                                      <?php echo $d7->t_from.' - '.$d7->t_to; ?>
                                                    
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
    <div class="panel panel-default">
        <div class="panel-heading ">
            Course
        </div>
        <div style="min-height: 150px; max-height: 350px;overflow-y: scroll; " class="panel-body  no-padding">
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
            <div onclick="document.location='<?php echo base_url('college/schedule/perCourse/'.$c->course_id.'/'.$i.'/'.$this->uri->segment(5)) ?>'" class='btn btn-default alert alert-link no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
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
        <div style="min-height: 250px; max-height: 350px;overflow-y: scroll; " class="panel-body  no-padding">
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
     $(document).ready(function(){
        $("td").each(function() {
            if($(this).text().trim()!="")
            {
                var key = $(this).attr('key');
                var color = $('#input_'+key).attr('bg');
                var gcode = $('#input_'+key).attr('gcode');
                $(this).attr('style','border:none;background:'+color);
                $(this).addClass('highlighted');
                $(this).attr('group_id',gcode);
                
            }
        })
    });
    
        var day1 = []
        var day2 = []
        var day3 = []
        var day4 = []
        var day5 = []
        var day6 = []
        var day7 = []
        
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
                    case 7:
                        day7.splice(day7.indexOf($(this).attr('time_id')),1);
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
            case '7':
                day7.push($('#'+id).attr('time_from'));
                day7.push($('#'+id).attr('time_to'));
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
        var data = "&mon="+firstLast(day1)+"&tue="+firstLast(day2)+"&wed="+firstLast(day3)+"&thu="+firstLast(day4)+"&fri="+firstLast(day5)+"&sat="+firstLast(day6)+"&sun="+firstLast(day7);
        var sem = $('#inputSem').val();
        var url = "<?php echo base_url().'college/schedule/addCollegeSched/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               dataType: 'json',
               url: url,
               data: $('#addSched').serialize()+data+'&sem='+sem+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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

    function getSchedulePerSem(sem, s_id)
    {
        if($('#schedTable td').hasClass('hasSched')){
            $('#schedTable td').css('background', 'none');
            $('#schedTable td').css('border', '1px solid #ddd');
            $('#schedTable td').html('');
        }
        
        var url = "<?php echo base_url().'college/schedule/getSchedulePerSubject/' ?>"+s_id+'/'+sem; // the script where you handle the form input.
        document.location = url;

    }
    </script>
    
    <script src="<?php echo base_url('assets/js/plugins/pick-a-color.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/tinycolor-0.9.15.min.js'); ?>"></script>
  