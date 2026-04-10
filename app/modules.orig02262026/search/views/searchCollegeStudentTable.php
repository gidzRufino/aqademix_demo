<div id="studentTable" class="row table-responsive" style="margin:0 1%;">
    <table style="font-size:12px;" class="tablesorter table table-striped">
        <thead style="background:#E6EEEE;">
            <tr>
                <th>USER ID</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>GENDER</th>
                <th>COURSE</th>
                <th>YEAR</th>
                <th>School Year</th>
                <th>Semester</th>
                <td>STATUS</td>
                <?php
                    if($this->session->userdata('is_admin')):
                ?>
                <td>Action</td>
                <?php
                    endif;
                ?>
            </tr> 
        </thead>

        <?php
           
           foreach ($students as $s)
           {
           switch ($s->year_level):
                case 1:
                    $year_level = 'First Year';
                break;
                case 2:
                    $year_level = 'Second Year';
                break;
                case 3:
                    $year_level = 'Third Year';
                break;
                case 4:
                    $year_level = 'Fourth Year';
                break;
                case 5:
                    $year_level = 'Fifth Year';
                break;
            endswitch;
            
            switch ($s->semester):
                case 1: 
                    $semester = 'First';
                break;
                case 2: 
                    $semester = 'Second';
                break;
                case 3: 
                    $semester = 'Summer';
                break;
            endswitch;
        ?>
            <tr>
                <td><a href="<?php echo base_url('college/viewCollegeDetails/'.base64_encode($s->st_id).'/'.$s->semester.'/'.$s->school_year) ?>"><?php echo $s->st_id; ?></a></td>
                <td><?php echo strtoupper($s->lastname); ?></td>
                <td><?php echo strtoupper($s->firstname); ?></td>
                <td><?php echo strtoupper($s->middlename); ?></td>
                <td><?php echo $s->sex; ?></td>
                <td><?php echo $s->short_code; ?></td>
                <td><?php echo $year_level; ?></td>
                <td>
                    <?php echo $s->school_year.' - '.($s->school_year+1) ?>
                </td>
                <td class="text-center"><?php echo $semester; ?></td>
                <td class="text-center">
                    <?php 
                        if($s->status){
                            ?>
                        <a href="#adminRemarks" data-toggle="modal">
                            <img onmouseover="$('#input_sem').val('<?php echo $s->semester ?>'), $('#us_id').val('<?php echo $s->uid ?>', $('#input_sy').val('<?php echo $s->school_year ?>'))"  style="cursor: pointer;width:20px" src="<?php echo base_url() ?>images/official.png" alt="official" />
                        </a>
                        <?php
                        }else{
                        ?>
                        <a href="#adminRemarks" data-toggle="modal">
                            <img onmouseover="$('#input_sem').val('<?php echo $s->semester ?>'), $('#us_id').val('<?php echo $s->uid ?>', $('#input_sy').val('<?php echo $s->school_year ?>'))"  src="<?php echo base_url() ?>images/unofficial.png" alt="official" />
                        </a>
                        <?php
                        }
                    ?>
                </td>
                <?php
                    if($this->session->userdata('is_admin')):
                ?>
                <td style="width:100px;">
                    <?php if($s->rfid==""||$s->rfid=="NULL"):?>
                    <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','RFID')" >Add RFID</a> <br />
                    <?php else: ?>
                    <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','<?php echo $s->rfid ?>')" >Edit RFID</a> <br />
                    <?php endif; ?>
                    <a href="#deleteIDConfirmation" data-toggle="modal" onclick="showDeleteConfirmation('<?php echo $s->uid ?>','<?php echo $s->st_id ?>','<?php echo $s->admission_id ?>')" style="color:#FF3030;" >DELETE</a><br />
                    <a href="#rollOver" data-toggle="modal" 
                       onclick="$('#ro_st_id').val('<?php echo $s->st_id ?>'),
                                $('#ro_user_id').val('<?php echo $s->uid ?>'),
                                $('#curr_grade_id').val('<?php echo $s->year_level ?>'),
                                $('#td_course').html('<?php echo $s->short_code ?>'),
                                $('#ro_course_id').val('<?php echo $s->course_id ?>'),
                                $('#td_year').html('<?php echo $year_level ?>'),
                                $('#sp_name').html('<?php echo strtoupper($s->firstname.' '.$s->lastname); ?>', checkFinance())
                                
                                "  class="text-success" >ROLL OVER</a>
                </td>
                <?php
                    endif;
                ?>
        </tr> 
        <?php 
            } 
            
        ?>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="addId" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="myModalLabel">Scan Students Identification Card</h3>
        </div>
        <div class="modal-body">
          <div class="control-group">
            <label class="control-label" for="input">CARD NUMBER:</label>
            <div class="controls">
              <input type="text" id="inputCard" onclick="this.value=''" placeholder="RFID" required>
              <input type="hidden" id="stud_id" >
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn"  data-dismiss="modal" >Close</button>
          <button onclick="updateProfile('<?php echo base64_encode('user_id') ?>','<?php echo base64_encode('esk_profile')?>','rfid')" class="btn btn-primary">Save </button>
          <div id="resultSection" class="help-block" ></div>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteIDConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal"  aria-hidden="true">&times;</button>
              <h4 id="myModalLabel">[ Delete Roll Over ] : ID Verifications</h4>
            </div>
            <div class="modal-body">
              <div class="control-group">
                <label class="control-label" for="input">ENTER EMPLOYEE ID #:</label>
                <div class="controls">
                  <input type="text" id="user_id" onclick="this.value=''" placeholder="ID #:" required>
                  <input type="hidden" id="stud_id" >
                  <input type="hidden" id="adm_idRO" >
                  <input type="hidden" id="st_uid" >
                  <input type="hidden" id="sy" value="<?php echo $this->uri->segment(3) ?>" >
                </div>
              </div>
                <div class="row-fluid">
                    <h6>Action: <br />To Delete student id( <span id="sp_stud_id"></span> )</h6>
                    <input type="checkbox" id="deleteAll" onclick="deleteAll($('#sp_stud_id').html())"/>
                </div>
            </div>
            <div class="modal-footer">
              <button class="btn" onclick="$('#deleteAll').prop('checked', false)"  data-dismiss="modal" >Close</button>
              <button onclick="deleteROStudent()" class="btn btn-danger">CONFIRM DELETE </button>
              <div id="resultSection" class="help-block" ></div>
            </div>
        </div>
      </div>
    </div>


<script type="text/javascript">
    
    $('#num_students').html('[ <?php echo count($students) ?> ]' );
    var admission_id = 0;
    
    function saveCollegeRO()
    {
        var course_id = $('#ro_course_id').val();
        var school_year = $('#inputSY').val()
        var semester = $('#ro_sem').val()
        var user_id = $('#ro_user_id').val()
        var st_id = $('#ro_st_id').val()
        var year_level = $('#curr_grade_id').val()
        
        var url = "<?php echo base_url().'college/saveCollegeRO/'?>";
        $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: "course_id="+course_id+'&semester='+semester+'&year_level='+year_level+'&user_id='+user_id+'&st_id='+st_id+'&school_year='+school_year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          socket.emit('sendNotification', { sendto: data.username,  msg :data.remarks, title:'Roll Over'}, function(data){});
                          alert(data.msg);
                          location.reload();
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
          var semester = $('#inputSem').val();
          var year = $('#inputSY').val();
          $('#verify_icon').removeClass('fa-search')
          $('#verify_icon').addClass('fa-spinner fa-spin');
          
          var url = '<?php echo base_url().'search/getCollegeStudents/' ?>'+option+'/'+value+'/'+year+'/'+semester;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                   if(data!=""){
                       $('#links').hide()
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
       $('#stud_id').val(psid);
       $('#adm_idRO').val(adm_id);
       $('#sp_stud_id').html(st_id)
       document.getElementById("user_id").focus();
       admission_id = adm_id
    } 
    
    function deleteROStudent()
    {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val();
        var adm_id = $('#adm_idRO').val();
        var sy = $('#inputSY').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            if ($('#deleteAll').is(":checked"))
            {
               
                       var url = "<?php echo base_url().'college/deleteID/'?>"+st_id; 
                       $.ajax({
                            type: "POST",
                            url: url,
                            data: "st_id="+st_id+"&user_id="+user_id+'&adm_id='+adm_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                            dataType: 'json',
                            success: function(data)
                            {
                                if(data.status)
                                {
                                    socket.emit('sendNotification', { sendto: data.username,  msg :data.remarks, title:'Delete'}, function(data){});
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
            var url = "<?php echo base_url().'college/deleteROStudent/'?>"+st_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&user_id="+user_id+'&sy='+sy+'&adm_id='+adm_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType: 'json',
                   success: function(data)
                   {
                       socket.emit('sendNotification', { sendto: data.username,  msg :data.remarks, title:'Delete'}, function(data){});
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
