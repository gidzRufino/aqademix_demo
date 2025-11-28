<div class="col-lg-12 page-header no-margin">
    <h3 style="margin:10px 0;" class="col-lg-4"><a href="<?php echo base_url('college') ?>"><i class="fa fa-home fa-fw"></i></a> Grading System
    </h3>
    <div class="col-lg-8" style="margin-top: 10px;">
                            <?php
                                $sem = Modules::run('main/getSemester');
                                switch ($sem):
                                    case 1:
                                        $semester = 'First Semester';
                                    break;
                                    case 2:
                                        $semester = 'Second Semester';
                                    break;
                                    case 3:
                                        $semester = 'Summer';
                                    break;
                                endswitch;
                            ?>
             
            <select onclick="loadAssignment('<?php echo $teacher_id; ?>', this.value)"  style="margin-right: 20px; width:200px; margin-top:3px;" id='subjectsTaught' class="input-group pull-right">
               <?php
                echo '<option>Select Subject</option>';
                    foreach ($result as $r):
                        ?>
                            <option 
                                id="<?php echo $r->section_id ?>"
                                sched_code='<?php echo $r->sched_gcode; ?>'
                                sub_code='<?php echo $r->sec_sub_id; ?>'
                                value="<?php echo $r->section_id ?>"><?php echo $r->sub_code.' - '.$r->section?></option>

                        <?php
                    endforeach;
                    ?>
            </select>               
            <select style="margin-right: 20px; width:200px; margin-top:3px;" onclick="changeSem(this.value)" id='semInput' class="input-group select2-searching select2-search pull-right">
                <option>Select Semester</option>
                <option value="1">First Semester</option>
                <option value="2">Second Semester</option>
                <option value="3">Summer</option>
            </select>
            <div class="form-group pull-right">
                    <select tabindex="-1" id="inputSY" style="margin-right: 20px; width:200px; margin-top:3px;" >
                        <option>School Year</option>
                        <?php 
                              foreach ($ro_year as $ro)
                               {   
                                  $roYears = $ro->ro_years+1;
                                  if($this->session->userdata('school_year')==$ro->ro_years):
                                      $selected = 'Selected';
                                  else:
                                      $selected = '';
                                  endif;
                              ?>                        
                            <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                            <?php }?>
                    </select>
             </div>
            
    </div>
    
</div>

<div class="col-lg-12 no-padding">
    <div id='gsBody' class="col-lg-12">
        <div class="alert alert-info text-center">
            <h3><i class="fa fa-info-circle" id="gsMsg"> Hi There! To start with, Select the desired Semester and Subject.</i></h3>
        </div>
    </div>
</div>

<input type="hidden" value="<?php echo $subject_id ?>" id="subject_id" />
<input type="hidden" id="st_id" />
<input type="hidden" id="term_id" />
<input type="hidden" id="course_id" />
<input type="hidden" id="grade_id" />
<input type="hidden" id="year_level" />
<input type="hidden" id="faculty_id" />
<input type="hidden" id="semester" value="<?php echo $sem ?>" />
<div id="validateGrade">
    <ul class="dropdown-menu no-padding" role="menu">
        <button class=" btn btn-default btn-block"  onclick="validateGrade()" ><li class="pointer text-danger no-padding"><i class="fa fa-check fa-fw"></i>Validate Grade</li></button>
    </ul>
</div>
<div id="inValidateGrade">
    <ul class="dropdown-menu no-padding" role="menu">
        <button class=" btn btn-default btn-block"><li onclick="inValidateGrade()" class="pointer text-danger no-padding"><i class="fa fa-close fa-fw"></i>Invalidate Grade</li></button>
    </ul>
</div>

<script type="text/javascript">
$('#semInput').select2();
$('#subjectsTaught').select2();
$('#inputSY').select2();

function changeSem(sem)
{
    
    getTeachingAssignment(sem)
    $('#semester').val(sem)
}
    
function inValidateGrade()
{
    var answer = confirm("Are you sure you want to revoke the Validity of this grade?.");
        if(answer==true){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'college/gradingsystem/inValidateGrade' ?>",
            dataType: 'json',
            data:{
                st_id : $('#st_id').val(),
                term_id : $('#term_id').val(),
                subject_id: $('#subject_id').val(),
                course_id: $('#course_id').val(),
                year_level: $('#year_level').val(),
                faculty_id: $('#faculty_id').val(),
                semester: $('#semester').val(),
                csrf_test_name : $.cookie('csrf_cookie_name')
            },
            cache: false,
            success: function(data) {
              
            }
        });
        }else{
            
        }
}
    
function postGrade()
{
    var answer = confirm("Do you really want to Validate this to Final Rating? Doing so will prevent you from editing.");
    var st_id = $('#st_id').val()
    var term_id = $('#term_id').val();
    var grade = 0;
    if($('#'+term_id+'_4').html()=='')
    {
        var term = 2;
        grade = $('#'+term_id+'_'+term).html()
    }else{
        var term = 4;
        grade = $('#'+term_id+'_'+term).html()
    }
        if(answer==true){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'college/gradingsystem/postGrade' ?>",
            //dataType: 'json',
            data:{
                st_id : $('#st_id').val(),
                term_id : term,
                subject_id: $('#subject_id').val(),
                course_id: $('#course_id').val(),
                year_level: $('#year_level').val(),
                faculty_id: $('#faculty_id').val(),
                semester: $('#semester').val(),
                grade: grade,
                school_year: '<?php echo $this->session->userdata('school_year') ?>',
                csrf_test_name : $.cookie('csrf_cookie_name')
            },
            cache: false,
            success: function(data) {
                $('#btn_'+$('#term_id').val()).html('POSTED')
            }
        });
        }else{
            
        }
}
    
function validateGrade()
{
    var answer = confirm("Do you really want to Validate this to Final Rating? Doing so will prevent you from editing.");
    var st_id = $('#st_id').val()
    var term_id = $('#term_id').val()
        if(answer==true){
            
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'college/gradingsystem/validateGrade' ?>",
            dataType: 'json',
            data:{
                st_id : $('#st_id').val(),
                term_id : $('#term_id').val(),
                subject_id: $('#subject_id').val(),
                course_id: $('#course_id').val(),
                year_level: $('#year_level').val(),
                faculty_id: $('#faculty_id').val(),
                semester: $('#semester').val(),
                grade: $('#grade_id').val(),
                school_year: '<?php echo $this->session->userdata('school_year') ?>',
                csrf_test_name : $.cookie('csrf_cookie_name')
            },
            cache: false,
            success: function(data) {
               $('#'+st_id+'_'+term_id).html('<button class="btn btn-success btn-xs">Validated</button>');
               console.log(data)
            }
        });
        }else{
            
        }
}


    
function editTable(id) 
    {   
    var OriginalContent = $('#'+id).text(); 
    var ID = id;
    var st_id = $('#'+id).attr('st_id');
    var tdn = $('#'+id).attr('tdn');
    var gst = $('#'+id).attr('gst');
    var row = $('#'+id).attr('row');
    var term = $('#'+id).attr('term');
    var course_id = $('#'+id).attr('course_id');
    var year_level = $('#'+id).attr('year_level');
    var subject = $('#subject_id').val();
   
    $('#'+id).addClass("cellEditing"); 
    $('#'+id).html("<input id ='input_"+id+"'type='text' style='height:30px; width:50px; text-align:center' value='" + OriginalContent + "' />"); 
    $('#'+id).children().first().focus(); 
    $('#'+id).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $('#input_'+id).val(); 
            
            
            $('#'+id).text(newContent); 
            $('#input_'+id).parent().removeClass("cellEditing");
            var nxt = parseInt(1)+parseInt(id);
            var parseCS = parseFloat(newContent);
            $('#'+row+'_'+gst).text(number2string(parseCS));
            //getNext(row+'_'+tdn+'_'+2);
            
           // alert(row+'_'+tdn+'_'+2)
            //ID.trigger('dblclick'); 
            getNext(nxt+'_'+gst);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'college/gradingsystem/validateGrade' ?>",
                dataType: 'json',
                data:{
                    st_id : st_id,
                    term_id : term,
                    subject_id: subject,
                    course_id: course_id,
                    year_level: year_level,
                    faculty_id: $('#faculty_id').val(),
                    semester: $('#semester').val(),
                    grade: parseCS,
                        school_year: $('#inputSY').val(),
                    csrf_test_name : $.cookie('csrf_cookie_name')
                },
                cache: false,
                success: function(data) {
                  $('#success').html(data.msg);
                  $('#alert-info').fadeOut(5000);
                  
//                    var nxt = parseInt(1)+parseInt(tdn);
                    getNext(nxt+'_'+gst);
                    
                }
            });
      } 
    }); 

        $('#'+id).children().first().blur(function(){ 
        $('#'+id).parent().text(OriginalContent); 
        $('#'+id).parent().removeClass("cellEditing"); 
    }); 
}

function getNext(id)
{
            var ID = id
            
            var st_id = $('#'+id).attr('st_id');
            var tdn = $('#'+id).attr('tdn');
            var gst = $('#'+id).attr('gst');
            var term = $('#'+id).attr('term');
            var subject = $('#subject_id').val();
            var row = $('#'+id).attr('row');
            var course_id = $('#'+id).attr('course_id');
            var year_level = $('#'+id).attr('year_level');
            
            var OriginalContent = $('#'+id).text(); 
            $('#'+id).addClass("cellEditing"); 
            $('#'+id).html("<input id ='input_"+id+"'type='text' style='height:30px;width:50px; text-align:center' value='" + OriginalContent + "' />"); 
            $('#'+id).children().first().focus(); 
            $('#'+id).children().first().keypress(function (e) 
            { if (e.which == 13) { 
                    
                    var newContent = $('#input_'+id).val();
                    
                    var nxt = parseInt(1)+parseInt(row);
                    $('#'+id).text(newContent); 
                    $('#'+id).parent().removeClass("cellEditing");
                    var parseCS = parseFloat(newContent);
                    $('#'+row+'_'+gst).text(number2string(parseCS)); 
                        
                    getNext(nxt+'_'+gst);
                     $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'college/gradingsystem/validateGrade' ?>",
                        dataType: 'json',
                        data:{
                            st_id : st_id,
                            term_id : term,
                            subject_id: subject,
                            course_id: course_id,
                            year_level: year_level,
                            faculty_id: $('#faculty_id').val(),
                            semester: $('#semester').val(),
                            grade: parseCS,
                            school_year: $('#inputSY').val(),
                            csrf_test_name : $.cookie('csrf_cookie_name')
                        },
                        cache: false,
                        success: function(data) {
                          $('#success').html(data.msg);
                          $('#alert-info').fadeOut(5000);

//                            var nxt = parseInt(1)+parseInt(tdn);
//                            getNext(row+'_'+tdn+'_'+2);

                        }
                    });
                   
                } 
            });
            $('#'+id).children().first().blur(function(){ 
            $('#'+id).text(OriginalContent); 
            $('#'+id).parent().removeClass("cellEditing"); 
            
        });
}    
    
    
    function getTeachingAssignment(value)
    {
          var school_year = $('#inputSY').val()
          var url = '<?php echo base_url().'college/gradingsystem/getTeacherAssignmentDrop/' ?>'+'<?php echo $this->session->userdata('employee_id'); ?>'+'/'+value+'/'+school_year;
            $.ajax({
               type: "GET",
               url: url,
               beforeSend: function() {
                    $('#gsMsg')
               },
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                     $('#subjectsTaught').html(data);
               }
             });

        return false;
    }
    
    function searchSubject(value)
    {
          var url = '<?php echo base_url().'college/gradingsystem/searchSubjectAssign/' ?>'+'<?php echo $this->session->userdata('employee_id'); ?>'+'/'+value;
            $.ajax({
               type: "GET",
               url: url,
               beforeSend: function() {
                        $('#searchLoading').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
               },
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                    $('#searchLoading').html('<i class="fa fa-search"></i>')
                     $('#searchName').show();
                     $('#searchName').html(data);
               }
             });

        return false;
    }
    
    $(".btngroup > .btn").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    });
    
    function loadAssignment(id, s_id)
    {
        //alert('hey')
          var school_year = $('#inputSY').val();
          var sem_id = $('#semInput').val();
          var sched_code = $('#'+s_id).attr('sched_code');
          var sub_code = $('#'+s_id).attr('sub_code');
          var url = '<?php echo base_url().'college/gradingsystem/getStudentsPerSubject/' ?>'+id+'/'+sched_code+'/'+s_id+'/'+sub_code+'/'+sem_id+'/'+school_year;
         
            $.ajax({
               type: "GET",
               url: url, // serializes the form's elements.
            beforeSend: function() {
                $('#gsMsg').html(' System is fetching Data...Thank you for waiting');
            },
               data: "id="+id, // serializes the form's elements.
               success: function(data)
               {
                  // alert(s_id)
                    //$('#searchLoading').html('<i class="fa fa-search"></i>')
                     $('#subject_id').val(sub_code)
                     $('#faculty_id').val(id)
                     $('#gsBody').html(data);
                     $('#subBody').attr('style','max-height:100px; overflow-y:scroll')
                     
                     $('#btnBack').show();
                     $('#semBtn').hide();
               }
             });

        return false;
    }
    
    
        function number2string(sNumber)
    {
        //Seperates the components of the number
        var n = sNumber.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    }
    
    function string2number(svariable)
    {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }
</script>    