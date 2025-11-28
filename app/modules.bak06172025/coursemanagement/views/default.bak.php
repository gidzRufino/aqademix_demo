<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Department / Course Management Settings</h3>
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
                                $title = 'List of Grade Level / Section';
                                $menu = 'otherMenu';
                            break;
                            case 5:
                                if($settings->level_catered!=5):
                                    $hide = 'hide';
                                endif;
                                $title = 'List of Courses';
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
                                $title = 'List of Grade Level / Section';
                                $menu = 'otherMenu';
                            break;
                            case 5:
                                $title = 'List of Courses';
                                $menu = 'collegeMenu';
                            break;    
                        endswitch;
                ?>
                        <div class="col-lg-12 tab-pane <?php echo $active; ?>"  data-toggle="context" data-target="#<?php echo $menu ?>" style="padding-top: 15px;" id="<?php echo $dept->level_dept_id ?>">
                            <h5 style="margin:5px 0;"><?php echo $title ?></h5>
                            <?php
                                if($dept->level_dept_id!=5):
                                    
                            ?>
                            <ul id="k12" class="col-lg-4">
                                <?php 
                                    $section = Modules::run('registrar/getGradeLevel', $dept->level_dept_id,'=');
                                    foreach($section as $list):
                                ?>
                                <li onmouseover="$('#grade_id').val('<?php echo $list->grade_id ?>')" style="list-style:none;"><?php echo $list->level ?></li>
                                        <hr style="margin:5px auto">
                                        <ul id="<?php echo $list->grade_id ?>_section" style="list-style: disc">
                                            <?php $section = Modules::run('registrar/getSectionByGradeId', $list->grade_id);
                                                  foreach($section->result() as $s){  
                                                    ?>
                                            <li id="<?php echo $s->s_id ?>_li" onmouseover="$('#sec_name').val('<?php echo $s->section ?>'), $('#sec_id').val('<?php echo $s->s_id ?>'),$('#grade_id').val('<?php echo $list->grade_id ?>')"><?php echo $s->section.' ('.$s->s_id.')' ?></li>
                                            <?php } ?>
                                        </ul>
                                <?php
                                    endforeach;
                                ?>
                            </ul>
                            <?php
                                else:
                            ?>  
                               
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
<input type="hidden" id="sec_id" />
<input type="hidden" id="sec_name" />
<input type="hidden" id="grade_id" />
<div id="otherMenu">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a href="#" onclick="getAdd('Section')"><i class="fa fa-plus-square fa-fw"></i>Add Section</a></li>
       <li class="pointer"><a href="#" onclick="getAdd('EditSection')" tabindex="-1"><i class="fa fa-edit fa-fw"></i>Rename Section</a></li>
       <li class="divider"></li>
       <li onclick="deleteSection()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Delete Section</a></li>
    </ul>
</div>
<?php 
$data['ro_year'] = Modules::run('registrar/getROYear'); 
$data['collegeSubjects'] = Modules::run('subjectmanagement/getCollegeSubjects');
$this->load->view('modalForms', $data); ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#dcms_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    })
    
    function getAdd(data)
    {
        $('#add'+data).modal('show');
    }
    
    function loadSubject(course)
    {
        $('#courseTitle').html(course);
        var url = '<?php echo base_url().'coursemanagement/loadSubject/' ?>'+$('#course_id').val()
         $.ajax({
               type: "GET",
               url: url,
               dataType: 'json',
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#11_Sem').html(data.fyfs);
                   $('#12_Sem').html(data.fyss);
                   $('#21_Sem').html(data.syfs);
                   $('#22_Sem').html(data.syss);
               }
             });

        return false;
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
    
    function addSection()
    {
        var section = $('#txtAddSection').val()
        var grade_id = $('#grade_id').val()
        var url = '<?php echo base_url().'coursemanagement/addSection/' ?>'+section+'/'+grade_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   dataType: 'json',
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data.msg)
                       if(data.status){
                            $('#'+grade_id+'_section').append('<li>'+section+'</li>');
                       }
                   }
                 });

            return false;
    }
    
    function addCourse()
    {
        var course = $('#inputCourse').val()
        var short_code = $('#inputShortCode').val()
        var url = '<?php echo base_url().'coursemanagement/addCourse/' ?>'+course+'/'+short_code;
             $.ajax({
                   type: "GET",
                   url: url,
                   dataType: 'json',
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data.msg)
                       if(data.status){
                            $('#college').append('<li>'+course+'</li>');
                       }
                   }
                 });

            return false;
    }
    
    function deleteSection()
    {
        var section_id = $('#sec_id').val()
        var section = $('#sec_name').val()
        var answer = confirm("Do you really want to delete this Section name '"+section+"'? You cannot undo this action, so be careful.");
        if(answer==true){
            var url = '<?php echo base_url().'coursemanagement/deleteSection/' ?>'+section_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully Deleted')
                       $('#'+section_id+'_li').hide();
                   }
                 });

            return false;
        }
    }
</script>
<?php $this->load->view('coursemanagement_modal'); ?>