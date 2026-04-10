<table style="font-size:12px;" class="tablesorter table table-striped">
    <thead style="background:#E6EEEE;">
        <tr>
            <th>USER ID</th>
            <th>LAST NAME</th>
            <th>FIRST NAME</th>
            <th>MIDDLE NAME</th>
            <th>GRADE</th>
            <th>SECTION</th>
            <th>GENDER</th>
            <td>STATUS</td>
            <td>REMARKS</td>
            <?php
                if($this->session->userdata('is_admin')):
            ?>
            <td>Action</td>
            <?php
                endif;
            ?>
            <td>School Year</td>
        </tr> 
    </thead>

    <?php
    if($this->uri->segment(4)=='undefined' || is_string($this->uri->segment(4))):
        $year = $this->session->userdata('school_year');
    else:
        $year = $this->uri->segment(4);
    endif;
       foreach ($students as $s)
       {
    ?>
        <tr>
            <td><a href="<?php echo base_url('registrar/viewDetails/'.base64_encode($s->st_id)).'/'.$year?>/"><?php echo $s->st_id; ?></a></td>
            <td><?php echo strtoupper($s->lastname); ?></td>
            <td><?php echo strtoupper($s->firstname); ?></td>
            <td><?php echo strtoupper($s->middlename); ?></td>
            <td><?php echo $s->level; ?></td>
            <td><?php echo $s->section; ?></td>
            <td><?php echo $s->sex; ?></td>
            <td id="img_<?php echo $s->uid ?>_td" style="text-align:center"><?php 
                if($s->status){
                    ?>
                <a href="#adminRemarks" data-toggle="modal">
                    <img onclick="getRemarks('<?php echo $s->st_id ?>','<?php echo $s->uid ?>')" style="cursor: pointer;width:20px" src="<?php echo base_url() ?>images/official.png" alt="official" />
                </a>
                <?php
                }else{
                ?>
                <a href="#adminRemarks" data-toggle="modal">
                    <img onclick="getRemarks('<?php echo $s->st_id ?>','<?php echo $s->uid ?>')" style="cursor: pointer;width:20px"  src="<?php echo base_url() ?>images/unofficial.png" alt="official" />
                </a>
                <?php
                }
            ?>
            </td>
            <td onmouseout="$('#delete_<?php echo $s->uid ?>').hide()" onmouseover="$('#delete_<?php echo $s->uid ?>').show()" id="remarks_<?php echo $s->uid ?>_td" >
                <?php
                    $remarks = Modules::run('main/getAdmissionRemarks', $s->uid);
                    if($remarks->num_rows()>0){
                        echo $remarks->row()->code.' '.$remarks->row()->remarks.' - '.$remarks->row()->remark_date;
                        ?>
                    <button id="delete_<?php echo $s->uid ?>" type="button" class="close pull-right hide" onclick="deleteAdmissionRemark('<?php echo $s->uid ?>',<?php echo $remarks->row()->code_indicator_id ?> )">&times;</button>    
                <?php        
                    }
                   // echo $s->st_id;
                ?>

            </td>
            <?php
                if($this->session->userdata('is_admin')):
            ?>
            <td>
                <?php if($s->rfid==""||$s->rfid=="NULL"):?>
                <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','RFID')" >Add RFID</a> |
                <?php else: ?>
                <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','<?php echo $s->rfid ?>')" >Edit RFID</a> |
                <?php endif; ?>
                <a href="#deleteIDConfirmation" data-toggle="modal" onclick="showDeleteConfirmation('<?php echo $s->st_id ?>','<?php echo $s->uid ?>','<?php echo $s->admission_id ?>')" style="color:#FF3030;" >DELETE</a> |
                <a href="#rollOver" data-toggle="modal" onclick="$('#ro_st_id').val('<?php echo $s->uid ?>'),$('#curr_grade_id').val('<?php echo $s->grade_level_id ?>')"  class="text-success" >ROLL OVER</a> |


            </td>
            <?php
                endif;
            ?>
            <td class="col-lg-1">
                <?php echo $s->school_year.' - '.($s->school_year+1) ?>
            </td>
    </tr> 
    <?php 
        } 

    ?>
    </table>

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
                        $RO = $this->session->userdata('school_year');
                        foreach ($grade as $level)
                                   {
                    ?>
                    <tr id="tr_<?php echo $level->grade_id ?>">
                        <td><?php echo $level->level ?></td>
                        <?
                            $section = Modules::run('registrar/getSectionByGradeId', $level->grade_id);
                            
                            
                            foreach ($section->result() as $s):
                                $studentsPerSection = Modules::run('registrar/getStudentPerRO', $RO, $s->s_id);
                                ?>
                        <td id="td_<?php echo $s->section_id ?>" style="background:#C1FFF9; border:1px solid gray;" onclick="setRO('<?php echo $level->grade_id ?>','<?php echo $s->section_id ?>')" class="pointer text-center"><?php echo $s->section ?> <span id="badge_<?php echo $s->section_id ?>" class="badge text-danger"><?php echo $studentsPerSection ?></span></td>
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
              <button class="btn btn-warning" onclick="location.reload()"  data-dismiss="modal" >Close</button>
              <button onclick='saveRO()' class="btn btn-success">CONFIRM </button>
              <div id="resultSection" class="help-block" ></div>
            </div>
        </div>
      </div>
    </div>

<script type="text/javascript">
    
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
    
    function search(value)
      {
          var option = $('#searchOption').val()
          $('#verify_icon').removeClass('fa-search')
          $('#verify_icon').addClass('fa-spinner fa-spin');
          
          var url = '<?php echo base_url().'search/getStudents/' ?>'+option+'/'+value;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                   if(data!=""){
                       $('#studentTable').html(data)   
                       $('#verify_icon').removeClass('fa-spinner fa-spin')
                       $('#verify_icon').addClass('fa-search');
                   }else{
                         
                   }
                   
                     
               }
             });

        return false;
      }
      
      
    function getSearchOption(value)
      {
          switch(value)
          {
              case 'profile_students_admission.grade_level_id':
                  $('#grade').show()
                  $('#searchBox').hide();
                  $('#section').hide()
              break;
              case 'profile_students_admission.section_id':
                  $('#section').show();
                  $('#grade').hide();
                  $('#searchBox').hide();
              break;
              default:
                  $('#grade').hide()
                  $('#section').hide()
                  $('#searchBox').show();
              break;
          }
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
    
    function showDeleteConfirmation(st_id, psid, adm_id)
    {   
        //alert(psid)
       $('#stud_id').val(psid)
       $('#adm_id').val(adm_id)
       $('#sp_stud_id').html(st_id)
       document.getElementById("user_id").focus()
    } 
    
    function deleteROStudent()
    {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val();
        var adm_id = $('#adm_id').val();
        var sy = $('#sy').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            if ($('#deleteAll').is(":checked"))
            {
               
                       var url = "<?php echo base_url().'registrar/deleteID/'?>"+st_id; 
                       $.ajax({
                            type: "POST",
                            url: url,
                            data: "st_id="+st_id+"&user_id="+user_id+'&adm_id='+adm_id, // serializes the form's elements.
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
                   data: "st_id="+st_id+"&user_id="+user_id+'&sy='+sy+'&adm_id='+adm_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
           data: 'id='+pk_id+'&column='+column+'&value='+value+'&tbl='+table+'&pk='+pk, // serializes the form's elements.
           success: function(data)
           {
               alert('RFID Successfully Saved');
               location.reload();
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    }
 
    
    $(document).ready(function() {
      $("#inputGrade").select2({});
        
        
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