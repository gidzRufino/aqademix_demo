 <script type="text/javascript">
     $(function() {
         $("#sorter").tablesorter({
             debug: true
         });
         // $('#num_students').html('[ ' + <?php echo $num_of_students; ?> + ' ]');
     });

     function search(value) {
         var sy = $('#inputSY').val();
         var option = $('#searchOption').val();
         $('#verify_icon').removeClass('fa-search')
         $('#verify_icon').addClass('fa-spinner fa-spin');
         if (option == 'profile_students_admission.grade_level_id') {
             var url = '<?php echo base_url() . 'search/getStdByGradeLevel/' ?>' + option + '/' + value + '/' + sy;
         } else {
             url = '<?php echo base_url() . 'search/getStudents/' ?>' + option + '/' + value + '/' + sy;
         }

         $.ajax({
             type: "GET",
             url: url,
             data: "id=" + value, // serializes the form's elements.
             success: function(data) {
                 if (data != "") {
                     $('#studentTable').html(data)
                     $('#verify_icon').removeClass('fa-spinner fa-spin')
                     $('#verify_icon').addClass('fa-search');
                 } else {

                 }


             }
         });

         return false;
     }


     function getSearchOption(value) {
         switch (value) {
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
 </script>

 <?php
    switch ($this->uri->segment(2)) {
        case 'getAllStudentsBySection':
            $gradeSection = $section_id;
            $option = 'section';
            break;
        case 'getAllStudentsByGradeLevel':
            $gradeSection = $grade_id;
            $option = 'level';
            break;

        case "":

            break;

        default:
            $gradeSection = "";
            $option = "default";
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
                 <select id="searchOption" onclick="getSearchOption(this.value)" style="width:150px; margin-right:5px; height:40px;">
                     <option>Select Option</option>
                     <option value="profile_students.st_id">Student ID</option>
                     <option value="profile_students_admission.grade_level_id">Grade Level</option>
                     <option value="profile_students_admission.section_id">Section</option>
                     <option selected="selected" value="lastname">Last Name</option>
                     <option value="firstname">First Name</option>
                     <option value="barangay">Barangay</option>
                     <option value="mun_city">City</option>
                 </select>
             </h5>
         </div>
         <div class="pull-left">
             <div class="form-group pull-right" id="section" style="display: none;">
                 <select onclick="search(this.value)" tabindex="-1" id="inputSection" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                     <option>Search By Section</option>
                     <?php
                        foreach ($section->result() as $sec) {
                        ?>
                         <option value="<?php echo $sec->section_id; ?>"><?php echo $sec->level . ' [ ' . $sec->section . ' ]'; ?></option>
                     <?php } ?>
                 </select>
             </div>
             <div class="form-group pull-right" id="grade" style=" display: none;">
                 <select onclick="search(this.value)" tabindex="-1" id="inputGrade" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                     <option>Search Grade level here</option>
                     <?php
                        foreach ($grade as $level) {
                        ?>
                         <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                     <?php } ?>
                 </select>
             </div>
             <div class="form-group input-group " id="searchBox">
                 <input type="hidden" id="gradeSection" value="<?php echo $gradeSection ?>" />
                 <input style="width:250px;" onkeyup="search(this.value)" class="form-control" id="verify" placeholder="Search" type="text">
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
 <div id="studentTable" class="table-responsive my-3">
    <table class="table table-striped table-hover table-bordered align-middle text-center" style="font-size:13px;">
        <thead class="table-light text-center">
            <tr>
                <th>Image</th>
                <th>USER ID</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>GRADE</th>
                <th>SECTION</th>
                <th>GENDER</th>
                <th>STATUS</th>
                <th>REMARKS <small>(DepEd forms)</small></th>
                <?php
                $access = $this->session->userdata('position_id');
                if (in_array($access,[1,2,43,49]) || $this->session->userdata('position') == 'Admin Officer'):
                ?>
                    <th>Action</th>
                <?php endif; ?>
                <th>School Year</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
            <tr>
                <td>
                    <?php
                        $avatar = ($s->avatar && file_exists('uploads/'.$s->avatar))
                            ? 'uploads/'.$s->avatar
                            : 'images/avatar/'.($s->sex=='Female'?'female.png':'male.png');
                    ?>
                    <img src="<?= base_url($avatar) ?>" class="rounded-circle" style="width:50px; height:50px;">
                </td>
                <td><a href="<?= base_url('registrar/viewDetails/'.base64_encode($s->uid)) ?>"><?= $s->uid ?: $s->user_id ?></a></td>
                <td onclick="document.location='<?= base_url('registrar/viewDetails/'.base64_encode($s->uid)) ?>/'"><?= strtoupper($s->lastname) ?></td>
                <td><?= strtoupper($s->firstname) ?></td>
                <td><?= strtoupper($s->middlename) ?></td>
                <td><?= $s->level ?></td>
                <td><?= $s->section ?></td>
                <td><?= $s->sex ?></td>
                <td>
                    <a href="#adminRemarks" data-toggle="modal">
                        <img onclick="getRemarks('<?= $s->st_id ?>','<?= $s->user_id ?>')"
                             src="<?= base_url($s->stats ? 'images/official.png' : 'images/unofficial.png') ?>"
                             style="width:20px; cursor:pointer;" alt="status">
                    </a>
                </td>
                <td onmouseout="$('#delete_<?= $s->uid ?>').hide()" onmouseover="$('#delete_<?= $s->uid ?>').show()">
                    <?php
                        $remarks = Modules::run('main/getAdmissionRemarks', $s->uid, NULL, $s->school_year);
                        if($remarks->num_rows() > 0) {
                            echo $remarks->row()->code . ' ' . $remarks->row()->remarks . ' - ' . $remarks->row()->remark_date;
                    ?>
                        <button id="delete_<?= $s->uid ?>" type="button" class="btn-close btn-close-white btn-sm ms-1" onclick="deleteAdmissionRemark('<?= $s->uid ?>',<?= $remarks->row()->code_indicator_id ?>)"></button>
                    <?php } ?>
                </td>
                <?php if (in_array($access,[1,2,43,49]) || $this->session->userdata('position') == 'Admin Officer'): ?>
                    <td>
                        <?php if (!$s->rfid || $s->rfid=="NULL"): ?>
                            <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?= $s->u_id ?>','RFID')">Add RFID</a> |
                        <?php else: ?>
                            <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?= $s->u_id ?>','<?= $s->rfid ?>')">Edit RFID</a> |
                        <?php endif; ?>
                        <a href="#deleteIDConfirmation" data-toggle="modal" onclick="showDeleteConfirmation('<?= $s->uid ?>','<?= $s->psid ?>')" class="text-danger">DELETE</a>
                    </td>
                    <td><?= $s->school_year ?> - <?= $s->school_year+1 ?></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal: Add RFID -->
<div class="modal fade" id="addId" tabindex="-1" aria-labelledby="addIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addIdLabel">
                    <i class="fa fa-id-card me-2"></i>Scan Student Identification Card
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="inputCard" class="form-label fw-bold">Card Number:</label>
                    <input type="text" id="inputCard" class="form-control form-control-lg rounded" placeholder="RFID" onclick="this.value=''" required>
                    <input type="hidden" id="stud_id">
                </div>
                <div id="resultSection" class="form-text text-success"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="updateProfile('<?= base64_encode('user_id') ?>','<?= base64_encode('esk_profile') ?>','rfid')" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Delete ID Confirmation -->
<div class="modal fade" id="deleteIDConfirmation" tabindex="-1" aria-labelledby="deleteIDLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteIDLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>Delete Student ID
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_id" class="form-label fw-bold">Enter Employee ID #:</label>
                    <input type="text" id="user_id" class="form-control rounded" placeholder="ID #:" onclick="this.value=''" required>
                    <input type="hidden" id="stud_id">
                    <input type="hidden" id="sy" value="<?= $this->uri->segment(3) ?>">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="deleteAll" onclick="deleteAll($('#sp_stud_id').html())">
                    <label class="form-check-label" for="deleteAll">
                        Delete all data for student ID (<span id="sp_stud_id"></span>)
                    </label>
                </div>
                <div id="resultSection" class="form-text text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="$('#deleteAll').prop('checked', false)" data-bs-dismiss="modal">Close</button>
                <button onclick="deleteROStudent()" class="btn btn-danger">
                    <i class="fa fa-trash me-1"></i> Confirm Delete
                </button>
            </div>
        </div>
    </div>
</div>



 <?php echo Modules::run('main/showAdminRemarksForm') ?>