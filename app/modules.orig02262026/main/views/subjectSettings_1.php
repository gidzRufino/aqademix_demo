<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Subject Management Settings</h3>
    </div>
    <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist" id="dcms_tab">
                <?php
                    foreach ($department as $dept):
                        if($dept->level_dept_id==1):
                            $active = 'active';
                        else:
                            $active = '';
                        endif;
                         switch ($dept->level_dept_id):
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                                $hide='';
                                $title = 'List of Subjects / Grade Level';
                                $menu = 'otherMenu';
                            break;
                            case 5:
                                if($settings->level_catered!=5):
                                    $hide = 'hide';
                                endif;
                                $title = 'List of Subjects';
                                $menu = 'collegeMenu';
                            break;    
                        endswitch;
                        
                        if($dept->level_dept_id > $settings->level_catered):
                            $hide = 'hide';
                        endif;
                        
                ?>
                        <li class="<?php echo $hide ?> <?php echo $active; ?>"><a href="#<?php echo $dept->level_dept_id ?>"><?php echo $dept->level_department ?></a></li>
                <?php
                    endforeach;
                ?>
                
            </ul>
            <div class="tab-content col-lg-12 no-padding">
                <?php
                    foreach ($department as $dept):
                        if($dept->level_dept_id==1):
                            $active = 'active';
                        else:
                            $active = '';
                        endif;
                        switch ($dept->level_dept_id):
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                                $title = 'List of Subjects / Grade Level';
                                $menu = 'otherMenu';
                            break;
                            case 5:
                                $title = 'List of Subjects';
                                $menu = 'collegeMenu';
                            break;    
                        endswitch;
                        
                ?>
                        <div class="col-lg-12 tab-pane <?php echo $active; ?>"  data-toggle="context" data-target="#<?php echo $menu ?>" style="padding-top: 15px;" id="<?php echo $dept->level_dept_id ?>">
                            <h5 style="margin:5px 0;"><?php echo $title ?></h5>
                            <?php
                                if($dept->level_dept_id!=5):
                                    
                            ?>
                             <?php 
                                    $section = Modules::run('registrar/getGradeLevel', $dept->level_dept_id, '=');
                                    foreach($section as $list):
                                         $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $list->grade_id);
                                ?>
                                        <div class="col-lg-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php echo $list->level; ?>
                                                    </div>
                                                    <div class="panel-body" onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>'),$('#subjects').val('<?php echo $subjects->subject_id; ?>')">
                                                        <ul id="<?php echo $list->grade_id ?>_section" style="list-style: disc">
                                                            <?php

                                                                  foreach($subjects as $s){  
                                                                      $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                                                    ?>
                                                                    <li id="<?php echo $s->id; ?>_sub" onmouseover="$('#sub_id').val('<?php echo $s->id; ?>')"><?php echo $singleSub->subject ?></li>
                                                                <?php }  
                                                                  ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                        </div>
                                <?php
                                    endforeach;
                                else:
                            ?>  
                                <ol id="college" class="col-lg-4">
                                    <?php 
                                        foreach($courses as $c):
                                    ?>
                                        <li id="<?php echo $c->course_id ?>_li" onmouseover="$('#sec_name').val('<?php echo $c->course ?>'), $('#sec_id').val('<?php echo $s->course_id ?>')"><?php echo $c->course ?></li>
                                    <?php
                                        endforeach;
                                    ?>
                                </ol>
                            <?php
                                endif;
                            ?>
                            
                        </div>
                <?php
                    endforeach;
                ?>
            </div>

    </div>
</div>
<input type="hidden" id="sub_id" />
<input type="hidden" id="subjects" />
<input type="hidden" id="grade_id" />
<div id="otherMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a href="#" onclick="getAdd('Subject')"><i class="fa fa-plus-square fa-fw"></i>Add Subject</a></li>
       <li class="divider"></li>
       <li onclick="removeSubject()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Remove Subject</a></li>
    </ul>
</div>
<div id="collegeMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a href="#" onclick="getAdd('Course')"><i class="fa fa-plus-square fa-fw"></i>Add Subject</a></li>
       <li class="pointer"><a tabindex="-1"><i class="fa fa-edit fa-fw"></i>Edit Subject</a></li>
       <li class="divider"></li>
       <li onclick="deleteCourse()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Delete Course</a></li>
    </ul>
</div>

<script type="text/javascript"> 
    $(document).ready(function() {
       $("#addedSubjects").select2({tags:[<?php
         foreach ($subject as $s) { 
             echo '"'.$s->subject.'",';
         }
                    ?>]});
       
       $("#inputGrade").select2();
       $('#dcms_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    });
    
        
    function getAdd(data)
    {
        $('#add'+data).modal('show');
    }
    
    function getLevel(level)
    {
        alert(level)
        if(level=='k12'){
            $('#k12').show()
            $('#college').hide()
        }else if(level=='college'){
            $('#k12').hide()
            $('#college').removClass('hide')
            
        }
    }
    
    function saveSubjectPerLevel()
    {
        var grade_level = $('#grade_id').val()
        var subjects = $('#subjects').val()
        var addSubjects = $('#addedSubjects').val()
        
        var url = "<?php echo base_url().'main/saveSubjectPerLevel/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "gradeLevel="+grade_level+"&subjects="+subjects +'&addSubjects='+addSubjects+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
               success: function(data)
               {
                  $('#'+grade_level+'_section').html(data);
                  alert('successfully added');
               }
        });
    }
    
    function addSubject()
    {
        var grade_level = $('#grade_id').val()
        var subjects = $('#subjects').val()
        var addSubjects = $('#addedSubjects').val()
        
        var url = "<?php echo base_url().'main/saveSubjectSettings/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "gradeLevel="+grade_level+"&subjects="+subjects +'&addSubjects='+addSubjects                                                                                                                                                                                                                                                                                    , // serializes the form's elements.
               success: function(data)
               {
                  $('#'+grade_level+'_section').html(data);
                  //location.reload();    
               }
        });
    }
    
    function saveSubjectSettings()
    {
        var gradeLevel =  '<?php echo $this->uri->segment(3) ?>';
        var subjects = $('#inputSubjects').val();
        
        var url = "<?php echo base_url().'main/saveSubjectSettings/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "gradeLevel="+gradeLevel+"&subjects="+subjects                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
               success: function(data)
               {
                  alert('Settings Successfully Saved');
                  location.reload();    
               }
        });
        
    }
    
    function getSubject(gradeLevel)
    {
        var url = "<?php echo base_url().'main/subjectSettings'?>" // the script where you handle the form input.
            document.location = url+'/'+gradeLevel; 
        $.ajax({
               type: "POST",
               url: url,
               data: "gradeLevel="+gradeLevel                                                                                                                                                                                                                                                                                  , // serializes the form's elements.
               success: function(data)
               {                   
                   $('#inputSubjects').val(data);
                   document.location = url+'/'+gradeLevel; 
               }
        });
        
        return false;
    }
    
    function removeSubject()
    {
        var subjects = $('#subjects').val();
        var grade_level = $('#grade_id').val()
        var subject_id = $('#sub_id').val();
        var url = "<?php echo base_url().'main/removeSubject'?>" // the script where you handle the form input.
            
        $.ajax({
               type: "POST",
               url: url,
               data: "gradeLevel="+grade_level+"&subject_id="+subject_id+"&subjects="+subjects+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                 , // serializes the form's elements.
               success: function(data)
               {                   
                   $('#'+subject_id+'_sub').addClass('hide');
                   alert(data)
               }
        });
        
        return false;
    }
    
</script>

<?php $this->load->view('addSubject_modal'); ?>