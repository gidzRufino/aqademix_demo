<?php echo link_tag('assets/css/plugins/chat/pick-a-color-1.2.3.min.css'); 
$sem = $this->uri->segment(6);
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
              <select onclick="getSchedulePerCourse('<?php echo $this->uri->segment(4) ?>', '<?php echo $this->uri->segment(5) ?>', this.value, '<?php echo $this->uri->segment(7) ?>' )" tabindex="-1" id="inputSem" name="inputSem" style="width:100%" >
                  <option>Select Semester</option>
                  <option <?php echo $first; ?> value="1">First Semester</option>
                  <option <?php echo $second; ?>  value="2">Second Semester</option>
                  <option <?php echo $summer; ?>  value="3">Summer</option>
              </select>
        </div>
        <div class="form-group pull-right">
              <select onclick="getSchedulePerCourse('<?php echo $this->uri->segment(4) ?>', '<?php echo $this->uri->segment(5) ?>', '<?php echo $this->uri->segment(6) ?>', this.value)" tabindex="-1" id="inputROYear" name="inputROYear" style="width:100%" >
                  <option>Select School Year</option>
                  <?php 
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($presentSY==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
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
                           $day1 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 1, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day2 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 2, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day3 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 3, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day4 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 4, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day5 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 5, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day6 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 6, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           $day7 = Modules::run('college/schedule/getSingleTimeSchedulePerCourse', 7, $course_id, $year, strtotime($value), $this->uri->segment(6), $presentSY);
                           
                   ?>
                           <tr class="time" id="tr_<?php echo $key ?>">
                               <th class="text-center no-padding" style="width:14%; height:30px;" ><span style="position:relative; top:-11px; font-weight: bold;"><?php echo date('g:i:s', strtotime($value)) ?></span></th>
                               
                                <td  data-toggle="context" data-target="#otherMenu" key="<?php echo $key ?>_1" time_from="<?php echo $value ?>"  time_to ="<?php echo date('H:i:s', strtotime('+30 minutes', strtotime($value))) ?>" day_id="1" id="td_<?php echo $key ?>_1" class="no-padding text-center" style="width:12.5%; text-algin:center; ">
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
                                                      <?php echo date('g:i:s', strtotime($d1->t_from)).' - '.date('g:i:s', strtotime($d1->t_to)); ?>
                                                    
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
                                                      <?php echo date('g:i:s', strtotime($d2->t_from)).' - '.date('g:i:s', strtotime($d2->t_to)); ?>
                                                    
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
                                                      <?php echo date('g:i:s', strtotime($d3->t_from)).' - '.date('g:i:s', strtotime($d3->t_to)); ?>
                                                    
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
                                                      <?php echo date('g:i:s', strtotime($d4->t_from)).' - '.date('g:i:s', strtotime($d4->t_to)); ?>
                                                    
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
                                                      <?php echo date('g:i:s', strtotime($d5->t_from)).' - '.date('g:i:s', strtotime($d5->t_to)); ?>
                                                    
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
    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
           Search Subject
           <button class="btn btn-default btn-xs pull-right" title="Search Subject or Press F6" onclick="$('#selectSubjectModal').modal('show')"><i class="fa fa-search"></i></button>
        </div>
    </div>
    <div class="panel panel-yellow">
        <div class="panel-heading ">
            Course <b id="activeLink"></b>
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
                        $activeLink = $this->uri->segment(4) . '' . $this->uri->segment(5);
                        $linkID = $c->course_id . '' . $i;
                ?>
            <div onclick="document.location='<?php echo base_url('college/schedule/perCourse/'.$c->course_id.'/'.$i.'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)) ?>'"  class='btn btn-warning alert alert-warning no-margin <?php echo ($linkID==$activeLink)? active : "" ?>' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                <div class="notify">
                    <?php echo strtoupper($c->short_code).' - '.$a; ?>
                </div>
            </div>        
            <?php 
            endfor;
            endforeach; ?>
        </div>
    </div>
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
           List of Rooms
        </div>
        <div style="min-height: 250px; max-height: 200px;overflow-y: scroll; " class="panel-body  no-padding">
            <?php foreach($rooms as $r):
                ?>
            <div onclick="getSchedulePerRoom('<?php echo $r->rm_id; ?>')" class='btn btn-success alert alert-success no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;">
                
                <div class="notify">
                    <?php echo strtoupper($r->room); ?>
                </div>
            </div>      
            
                <?php
                endforeach; ?>
        </div>
    </div>
</div>

<div id="selectSubjectModal" class="modal fade" style="width:900px; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h4 class="no-margin">Search Subject
            <button data-dismiss="modal" class="btn btn-xs btn-danger pull-right">x</button> 
            <div class="form-group col-lg-4 pull-right" id='searchBox' style="margin:10px 0;">
                <div class="controls">
                  <input autocomplete="off"  class="form-control" onkeydown="searchSubject(this.value)"  name="searchSubject" type="text" id="searchSubject" placeholder="Search Subject" required>
                  <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
                  <input type="hidden" id="course_id" name="course_id" value="0" />
                </div>
                <div style="min-height: 30px;  background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

                </div>
            </div>   
            </h4>
        </div>
        <div class="panel-body clearfix" id="subjectBody">
            
        </div>
            
    </div>
</div>

<div id="otherMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a href="#" onclick="$('#editSchedule').modal('show');"><i class="fa fa-pencil-square fa-fw"></i>Edit Schedule</a></li>
       <li class="divider"></li>
       <li onclick="removeSubject()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Remove Schedule</a></li>
    </ul>
 
</div>
<input type="hidden" id="sched_code" />

<?php 
    $this->load->view('createSchedModal');
?>
<style type="text/css">
  .btn-default:active{
    background-color: #f0ad4e;
  }
</style>
<script type="text/javascript">

$(function(){
  var aLink = $('.active>div').text();
  $('#activeLink').text(' : ' +aLink+ ' Year');
});
    
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
                
                //alert(color)
            }
        })
        
        shortcut.add("F6",function() {
            $('#selectSubjectModal').modal('show')
        });
        
        $('#inputSem').select2()
    });
    
    function getSchedulePerRoom(room_id)
    {
        document.location = "<?php echo base_url('college/schedule/perRoom/') ?>"+room_id+'/'+$('#inputSem').val();
    }
    
        
    function searchSubject(value)
     {
        var course_id = '<?php echo $this->uri->segment(4) ?>';
        var url = "<?php echo base_url().'college/schedule/loadSubject/'?>"+value+'/'+course_id; // the script where you handle the form input.

        $.ajax({
               type: "GET",
               url: url,
               //dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#subjectBody').html(data)
               }
             });

        return false; 
     }
    
   function getSchedulePerCourse(seg4, seg5, sem, sy)
   {
       var url = '<?php echo base_url('college/schedule/perCourse/') ?>'+seg4+'/'+seg5+'/'+sem+'/'+sy;
       document.location = url;
   }
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
        var data = "&mon="+firstLast(day1)+"&tue="+firstLast(day2)+"&wed="+firstLast(day3)+"&thu="+firstLast(day4)+"&fri="+firstLast(day5)+"&sat="+firstLast(day6)+"&sat="+firstLast(day7);
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
    
    
    function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function() {
                    return (false);
                };
                window.onhelp = function() {
                    return (false);
                };
            }
            evt.returnValue = false;
            evt.keyCode = 0;
            window.status = msg;
            evt.preventDefault();
            evt.stopPropagation();
            //alert(msg);
        }

        window.status = "Done";

    }

    </script>
    
    <script src="<?php echo base_url('assets/js/plugins/pick-a-color.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/tinycolor-0.9.15.min.js'); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>