<?php 
    switch ($this->uri->segment(2)){
        case 'getAllStudentsBySection':
            $gradeSection = $section_id;
            $option = 'section';
         break;
        case 'getAllStudentsByGradeLevel':
            $gradeSection = $grade_id;
            $option = 'level';
        break;
    
        case "getStudentByYear" :
            $option = 'default';
        break;
        
        default :
            $gradeSection = "";
            $option ="default";
        break;    
    }
?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">List of Students <small id="num_students"> [ <?php echo $num_of_students.' / '.$allStudents; ?> ] </small>
            <input type="hidden" id="hiddenSection" value="<?php echo $this->uri->segment(3) ?>" />
             <?php if($this->session->userdata('position_id')==1): ?>
                <a href="#importCsv" data-toggle="modal"  id="uploadAssessment" class="btn btn-success pull-right" >
                   <i class="fa fa-upload"></i>
               </a>
            <?php endif; ?>
                <?php if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')){ ?>
                <a href="#printIdModal" style="margin-top:0;" data-toggle="modal" class="btn btn-sm btn-info pull-right">Print ID</a>
                <a id="CSVExportBtn" style="margin:0 10px;" href="<?php echo base_url().'reports/exportToCsv' ?>" class="pull-left btn btn-success hide">Export To CSV </a> 
                <div class="form-group pull-right">
                        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                            <option>School Year</option>
                            <?php 
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($this->uri->segment(3)==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
                        </select>
                 </div>
            <?php } ?>
        </h3>
    </div>
    <div class="row" id="student-table" >

    <?php if($this->session->userdata('is_adviser') || $this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin') || $this->session->userdata('position')=='Admin Officer'):

            $this->load->view('ro_studentTable'); 
        else:
            redirect(base_url('academic/mySubjects'));
        endif;  
    ?>
</div>
     <!-- Modal -->
    <div class="modal fade" id="rollOver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal"  aria-hidden="true">&times;</button>
              <h4 id="myModalLabel">Roll Over to the Next Level</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    
                    <tr><th>Grade Level</th></tr>
                    <?php 
                        $RO = $this->session->userdata('school_year') + 1;
                        foreach ($grade as $level)
                                   {
                    ?>
                    <tr id="tr_<?php echo $level->grade_id ?>">
                        <td><?php echo $level->level ?></td>
                        <?php
                            $section = Modules::run('registrar/getSectionByGradeId', $level->grade_id, $this->session->userdata('school_year') );
                            foreach ($section->result() as $s):
                                $studentsPerSection = Modules::run('registrar/getStudentPerRO',  $this->session->userdata('school_year'), $s->s_id, $this->session->userdata('school_year'));
                                //echo $s->section_id;
                                ?>
                        <td id="td_<?php echo $s->section_id ?>" style="background:#C1FFF9; border:1px solid gray;" onclick="setRO('<?php echo $level->grade_id ?>','<?php echo $s->s_id ?>')" class="pointer text-center"><?php echo $s->section ?> <span id="badge_<?php echo $s->s_id ?>" class="badge text-danger"><?php echo $studentsPerSection ?></span></td>
                                <?php
                            endforeach;
                            ?>
                    </tr>
                    <?php
                    }
?>
                </table>
            </div>
            <div class="modal-footer">
                <input type='hidden' id='curr_grade_id'  />
                <input type='hidden' id='ro_st_id'  />
                <input type='hidden' id='ro_grade_id' />
                <input type='hidden' id='ro_section_id' />
                <input type='hidden' id='ro_prev_sec_selected' />
                <input type='hidden' id='ro_badgeIndicator' />
              <button class="btn btn-warning" onclick="//location.reload()"  data-dismiss="modal" >Close</button>
              <button onclick='saveRO()' class="btn btn-success">CONFIRM </button>
              <div id="resultSection" class="help-block" ></div>
            </div>
        </div>
      </div>
    </div>

    <?php echo Modules::run('main/showAdminRemarksForm') ?>
    </div>
<script type="text/javascript">
    
    function deleteAll(st_id)
    {
        
       var deleteAll=confirm('Are you Sure You want to delete all the record of student # ( '+st_id+' )?');
        if(deleteAll==false)
            {
                $('#deleteAll').prop('checked', false);
            }
    }
    
    function setRO(grade_id, section_id)
    {
        var x
        var grade
        var curr_grade = $('#curr_grade_id').val()
        var loop = parseInt(curr_grade) - 10;
        for(x=0; x<=loop; x++){
            grade = 10+x;
            //alert(grade)
            $('#tr_'+grade).attr('style', 'background:#BCBCBC;')
        }
        var prevSec = $('#ro_prev_sec_selected').val()
        var badge = $('#badge_'+section_id).html()
        var indicator = $('#ro_badgeIndicator').val()
        $('#ro_grade_id').val(grade_id)
        $('#ro_section_id').val(section_id)
        if(indicator<1){
            $('#badge_'+section_id).html(parseInt(badge)+1)
            $('#ro_badgeIndicator').val(1)
            $('#td_'+section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
        }else{
            if(prevSec!=section_id){
                $('#badge_'+section_id).html(parseInt(badge)+1)
                $('#badge_'+prevSec).html(parseInt($('#badge_'+prevSec).html())-1)
                $('#td_'+prevSec).attr('style', 'background:#C1FFF9; border:1px solid gray;')
                $('#td_'+section_id).attr('style', 'background:#3277FF; border:1px solid gray;')
            }
        }
        $('#ro_prev_sec_selected').val(section_id);
    }
    
    function saveRO()
    {
        var grade_id = $('#ro_grade_id').val();
        var section_id = $('#ro_section_id').val()
        var st_id = $('#ro_st_id').val()
        var school_year = $('#inputSY').val()
        
        var url = "<?php echo base_url().'registrar/saveRO/'?>";
        $.ajax({
                       type: "POST",
                       url: url,
                       data: "grade_id="+grade_id+'&section_id='+section_id+'&st_id='+st_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          alert(data);
                          location.reload()
                          //console.log(data)
                       }
                     });

                return false;
    }
    
    function getSection(grade_id)
        {
            var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+grade_id; // the script where you handle the form input.

                $.ajax({
                       type: "GET",
                       url: url,
                       data: "grade_id="+grade_id, // serializes the form's elements.
                       success: function(data)
                       {
                          // location.reload()
                           $('#ro_grade_id').val(grade_id)
                           $('#ro_section_id').html(data);
                       }
                     });

                return false;

        }
    
    
    function printId(section_id, id, frontBack, pageID)
    {
        if(frontBack=='printIdCardBack'){
            var limit = 4;
           
        }else{
            limit = 8;
        }
        document.getElementById(id).href = '<?php echo base_url().'registrar/' ?>'+frontBack+'/'+section_id+'/'+limit+'/'+pageID
    }
    
    function showDeleteConfirmation(st_id, psid)
    {   
        //alert(psid)
       $('#stud_id').val(psid)
       $('#sp_stud_id').html(st_id)
       document.getElementById("user_id").focus()
    } 
    
    function deleteROStudent()
    {
        
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var sy = $('#sy').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            if ($('#deleteAll').is(":checked"))
            {
                       var url = "<?php echo base_url().'registrar/deleteID/'?>"+st_id; 
                       $.ajax({
                            type: "POST",
                            url: url,
                            data: "st_id="+st_id+"&user_id="+user_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                            dataType: 'json',
                            success: function(data)
                            {
                                if(data.status)
                                {
                                    alert(data.msg);
                                    location.reload();
                                }else{
                                    alert(data.msg);
                                    location.reload();
                                }
                            }
                          });

                        return false;
                   
               
            }
            var url = "<?php echo base_url().'registrar/deleteROStudent/'?>"+st_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&user_id="+user_id+'&sy='+sy+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   //dataType: 'json',
                   success: function(data)
                   {
                       alert(data);
                       location.reload();
                       //console.log(data)
                   }
                 });

            return false;
                
        }else{
            location.reload();
        }
        
    }
    function getRemarks(st_id, user_id){
    
    alert('hey')
        $('#st_id').val(st_id);
        $('#us_id').val(user_id);
    }
    
    function getStudentBySection(id)
    {
        var url = "<?php echo base_url().'registrar/getAllStudentsBySection/'?>"+id
        document.location = url;
    }
    function getStudentByLevel(id)
    {
        var url = "<?php echo base_url().'registrar/getAllStudentsByGradeLevel/'?>"+id+'/'; // the script where you handle the form input.
        document.location = url;

    } 
    function getStudentByYear(id)
    {
        var url = "<?php echo base_url().'registrar/getStudentByYear/'?>"+id+'/'; // the script where you handle the form input.
        document.location = url;

    } 
    
    function deleteAdmissionRemark(st_id, code_id)
    {
        var url = "<?php echo base_url().'main/deleteAdmissionRemark/'?>"+st_id+'/'+code_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id, // serializes the form's elements.
                   success: function(data)
                   {
                       location.reload()
                       //$('#inputSection').html(data);
                   }
                 });

            return false;
      
    }
    
    function showAddRFIDForm(id, st_id)
    {
       $('#addId').show();     
       $('#secretContainer').html($('#addId').html())
       $('#secretContainer').fadeIn(500)     
       $('#stud_id').val(id)
       $("#inputCard").attr('placeholder', st_id); 
       document.getElementById("inputCard").focus()
    }  
    
    function updateProfile(pk,table, column)
    {
    var url = "<?php echo base_url().'users/editProfile/'?>"; // the script where you handle the form input.
    var pk_id = $('#stud_id').val();
    var value = $('#inputCard').val()
    $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'id='+pk_id+'&column='+column+'&value='+value+'&tbl='+table+'&pk='+pk+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               alert('RFID Successfully Saved');
               location.reload();
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    }
 
    
    $(document).ready(function() {
      $("#inputGrade").select2({
            minimumInputLength: 2
        });
        
        
      $("#inputSection").select2();
      $("#inputSY").select2();
      
      if($('#hiddenSection').val()!=""){
          $('#CSVExportBtn').show();
            var CSVUrl ="<?php echo base_url().'reports/exportToCsv/'?>"+"Null"+'/'+$('#hiddenSection').val();
            <?php if($this->session->userdata('is_superAdmin')): ?>
            document.getElementById('CSVExportBtn').href = CSVUrl
            <?php endif; ?>
      }
      
      
    });
</script>