<?php 
    switch ($this->uri->segment(2)){
        case 'getAllStudentsBySection':
            $allStudents = Modules::run('registrar/getAllStudentsByLevel', Null, $section_id, NULL, NULL );
         break;
        case 'getAllStudentsByGradeLevel':
             $allStudents = Modules::run('registrar/getAllStudentsForExternal', $grade_id);
        break;
    
        case 'getStudentByYear' :
            $allStudents = Modules::run('registrar/getStudentByYear', $this->uri->segment(3));
            echo 'hey';
        break;
    
        case "" :
            
        break;
        
        default :
            $allStudents = Modules::run('registrar/getAllStudentsForExternal',Null,Null,NULL,1,$this->session->userdata('school_year'));
        break;    
    }
?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">List of Students <small id="num_students"> [ <?php echo $allStudents->num_rows.' / '.$num_of_students; ?> ] </small>
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
                        <select onclick="getStudentBySection(this.value)" tabindex="-1" id="inputSection" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                            <option>Search By Section</option>
                            <?php 
                                      foreach ($section->result() as $sec)
                                   {   
                                  ?>                        
                                <option value="<?php echo $sec->section_id; ?>"><?php echo $sec->section; ?></option>
                                <?php }?>
                        </select>
                 </div>
                <div class="form-group pull-right">
                        <select onclick="getStudentByLevel(this.value)" tabindex="-1" id="inputGrade" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                            <option>Search Grade level here</option>
                            <?php 
                                  foreach ($grade as $level)
                                   {   
                                  ?>                        
                                <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                <?php }?>
                        </select>
                 </div>
                <div class="form-group pull-right">
                        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
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
            <?php } ?>
        </h3>
    </div>
</div> 
<div class="row" id="student-table" >

    <?php if($this->session->userdata('is_adviser') || $this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):

            $this->load->view('studentTable'); 
        else:
            redirect(base_url('academic/mySubjects'));
        endif;  
    ?>
</div>

<!-- Modal -->
<div class="modal fade" id="printIdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"> Print ID Card</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <select id="frontBack">
                  <option value="printIdCard">Front</option>
                  <option value="printIdCardBack">Back</option>

              </select>

              <select id="pageID">
                  <option value="0">Page 1</option>
                  <option value="8">Page 2</option>
                  <option value="16">Page 3</option>
                  <option value="24">Page 4</option>
                  <option value="32">Page 5</option>
                  <option value="40">Page 6</option>
                  <option value="48">Page 7</option>
              </select>              
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a target="_blank" href="#" id="printIdBtn" style="margin-top:0;" onmouseover="printId(<?php echo $this->uri->segment(3) ?>, this.id, $('#frontBack').val(),$('#pageID').val() )" class="btn btn-small btn-info pull-right">Print ID</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="chartDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog "  style="width:90%; margin: 10px auto 0;">
    <div class="modal-content">
      <div class="modal-header clearfix">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <div class="col-lg-4 pull-right">
              <select class="pull-right populate select2-offscreen" onclick="getMMG(this.value, $('#inputSY').val())" tabindex="-1" id="inputMonthReport" style="width:200px">
                        <option >Select Month</option>
                        <option value="annual">Annual</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option> 
                   </select>
          </div>
      </div>
      <div class="modal-body clearfix">
          
          <div id="mmg_details" class="col-lg-12 pull-left clearfix">
              
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Students CSV</h4>
        </div>
             <?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'reports/importStudents', $attributes);
        ?>
        <div class="panel-body">

                    <input style="height:30px" type="file" name="userfile" ><br />
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>
<script type="text/javascript">
    
    function getMMG(value, sy)
    {
         var url = "<?php echo base_url().'registrar/getMMG/'?>"+value+'/'+sy; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "value="+value, // serializes the form's elements.
                   //dataType: 'json',
                   beforeSend: function() {
                        showLoading('mmg_details');
                    },
                   success: function(data)
                   {
                       $('#mmg_details').html(data);
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
    
    function deleteStudent()
    {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var rsure=confirm("Are you Sure You Want to delete student ( "+st_id+" ) from the list?");
        if (rsure==true){
            var url = "<?php echo base_url().'registrar/deleteID/'?>"+st_id; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&user_id="+user_id, // serializes the form's elements.
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
        var url = "<?php echo base_url().'registrar/getAllStudentsBySection/'?>"+id+'/'+$('#inputSY').val();
        document.location = url;
    }
    function getStudentByLevel(id)
    {
        var url = "<?php echo base_url().'registrar/getAllStudentsByGradeLevel/'?>"+id+'/'; // the script where you handle the form input.
        document.location = url;
//        $.ajax({
//               type: "GET",
//               url: url,
//               data: "id="+id, // serializes the form's elements.
//               success: function(data)
//               {
//                   if(data!=""){
//                       $('#student-table').html(data)   
//                   }else{
//                       $('#student-table').html('<h4>Sorry, No Students is Enrolled in this Grade Level')   
//                   }
//                   
//                   $('#CSVExportBtn').show();
//                   var CSVUrl ="<?php //echo base_url().'reports/exportToCsv/'?>"+id+'/';
//                   document.getElementById('CSVExportBtn').href = CSVUrl
//                     
//               }
//             });
//
//        return false;
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
       $("#inputCard").val('')
       window.setTimeout(function () { 
            document.getElementById("inputCard").focus()
        }, 1);
        $('#inputCard').blur(function(){
        //alert('hey')
        window.setTimeout(function () { 
            document.getElementById("inputCard").focus();
        }, 0);
        
    
    })
       
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
      $("#inputGrade").select2({
            minimumInputLength: 2
        });
      $("#inputSection").select2();
      $("#inputMonthReport").select2();
      $("#inputSY").select2();
      
      if($('#hiddenSection').val()!=""){
          $('#CSVExportBtn').show();
            var CSVUrl ="<?php echo base_url().'reports/exportToCsv/'?>"+"Null"+'/'+$('#hiddenSection').val();
            <?php if($this->session->userdata('is_superAdmin')): ?>
            document.getElementById('CSVExportBtn').href = CSVUrl
            <?php endif; ?>
      }
      
    });
    
    
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
    
    function deleteAll(st_id)
    {
        
       var deleteAll=confirm('Are you Sure You want to delete all the record of student # ( '+st_id+' )?');
        if(deleteAll==false)
            {
                $('#deleteAll').prop('checked', false);
            }
    }
</script>
