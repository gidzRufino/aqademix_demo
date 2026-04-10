<script type="text/javascript">
      $(function(){
            $("#sorter").tablesorter({debug: true});
           // $('#num_students').html('[ '+<?php //echo $num_of_students ?>+' ]');
	});
      
      function search(value, gradeSection, option)
      {
          var SY = $('#inputSY').val()
          $('#verify_icon').removeClass('fa-search')
          $('#verify_icon').addClass('fa-spinner fa-spin');
          if(option=='level'){
              var url = '<?php echo base_url().'search/getStudentByGradeLevel/' ?>'+gradeSection+'/'+value+'/'+SY;
          }
          if(option=='section'){
              var url = '<?php echo base_url().'search/getStudentBySection/' ?>'+gradeSection+'/'+value+'/'+SY;
          }
          if(option=='default'){
              var url = '<?php echo base_url().'search/getStudents/' ?>'+value+'/'+SY;
          }
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
      
      
</script>

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
    
        case "" :
            
        break;
        
        default :
            $gradeSection = "";
            $option ="default";
        break;    
    }
?>
<div class="col-lg-12">
    <div id="links" class="pull-left">
        <?php echo $links; ?>
    </div>
    <div class="pull-right">
        <div class="pull-left">
                <h5 style="margin:0;">Search By:
                <select id="searchOption" style="width:150px; margin-right:5px; height:40px;">
                    <option></option>
                    <option value="st_id">Student ID</option>
                    <option value="grade_id">Grade Level</option>
                    <option value="section_id">Section</option>
                    <option value="lastname">Last Name</option>
                    <option value="firstname">First Name</option>
                    <option value="barangay">Barangay</option>
                    <option value="city">City</option>
                </select>
                 </h5>
            </div>
        <div class="pull-left">
             <div class="form-group input-group ">
                    <input type="hidden" id="gradeSection" value="<?php echo $gradeSection?>" />
                    <input style="width:250px;" onkeyup="search(this.value, $('#gradeSection').val(), '<?php echo $option ?>')" class="form-control" id="verify" placeholder="Search" type="text">
                    <span class="input-group-btn">
                        <button class="btn btn-default">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>   
                        <button href="#chartDetails" data-toggle="modal" class="btn btn-default">
                            <i id="chart_details" class="fa fa-bar-chart"></i>
                        </button>   
                    </span> 
            </div>
        </div>
        
    </div>
</div>
<div id="studentTable" class="row table-responsive" style="margin:0 1%;">
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
                <td>REMARKS <small>( refer to depEd forms )</small></td>
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
           foreach ($students as $s)
           {
        ?>
            <tr>
                <td><a href="<?php echo base_url('registrar/viewDetails/'.base64_encode($s->uid)) ?>"><?php echo $s->uid; ?></a></td>
                <td><?php echo strtoupper($s->lastname); ?></td>
                <td><?php echo strtoupper($s->firstname); ?></td>
                <td><?php echo strtoupper($s->middlename); ?></td>
                <td><?php echo $s->level; ?></td>
                <td><?php echo $s->section; ?></td>
                <td><?php echo $s->sex; ?></td>
                <td id="img_<?php echo $s->uid ?>_td" style="text-align:center"><?php 
                    if($s->stats){
                        ?>
                    <a href="#adminRemarks" data-toggle="modal">
                        <img onclick="getRemarks('<?php echo $s->st_id ?>','<?php echo $s->u_id ?>')" style="cursor: pointer;width:20px" src="<?php echo base_url() ?>images/official.png" alt="official" />
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#adminRemarks" data-toggle="modal">
                        <img onclick="getRemarks('<?php echo $s->st_id ?>','<?php echo $s->u_id ?>')" style="cursor: pointer;width:20px"  src="<?php echo base_url() ?>images/unofficial.png" alt="official" />
                    </a>
                    <?php
                    }
                ?>
                </td>
                <td onmouseout="$('#delete_<?php echo $s->uid ?>').hide()" onmouseover="$('#delete_<?php echo $s->uid ?>').show()" id="remarks_<?php echo $s->uid ?>_td" >
                    <?php
                        $remarks = Modules::run('main/getAdmissionRemarks', $s->uid, NULL, $s->school_year);
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
                    <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->u_id ?>','RFID')" >Add RFID</a> |
                    <?php else: ?>
                    <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->u_id ?>','<?php echo $s->rfid ?>')" >Edit RFID</a> |
                    <?php endif; ?>
                    <a href="#deleteIDConfirmation" data-toggle="modal" onclick="showDeleteConfirmation('<?php echo $s->uid ?>','<?php echo $s->psid ?>')" style="color:#FF3030;" >DELETE</a>

                </td>
                <td>
                    <?php echo $s->school_year.' - '.($s->school_year+1) ?>
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


<?php echo Modules::run('main/showAdminRemarksForm') ?>
