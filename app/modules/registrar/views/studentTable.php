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
    $access = $this->session->userdata('position_id');
    ?>
 <div class="col-lg-12">
     <div id="links" class="float-start">
         <?= $links; ?>
     </div>

     <!-- ====== FILTERS ====== -->
     <div class="d-flex flex-wrap gap-2 mb-3 align-items-center justify-content-end">

         <select id="searchOption"
             class="form-select form-select-sm"
             style="width:150px;"
             onchange="getSearchOption(this.value)">
             <option>Select Option</option>
             <option value="profile_students.st_id">Student ID</option>
             <option value="profile_students_admission.grade_level_id">Grade Level</option>
             <option value="profile_students_admission.section_id">Section</option>
             <option selected value="lastname">Last Name</option>
             <option value="firstname">First Name</option>
             <option value="barangay">Barangay</option>
             <option value="mun_city">City</option>
         </select>

         <!-- Section Filter -->
         <select id="inputSection"
             class="form-select form-select-sm d-none"
             style="width:200px;"
             onchange="search(this.value)">
             <option>Search By Section</option>
             <?php foreach ($section->result() as $sec): ?>
                 <option value="<?= $sec->section_id ?>">
                     <?= $sec->level . ' [ ' . $sec->section . ' ]' ?>
                 </option>
             <?php endforeach; ?>
         </select>

         <!-- Grade Filter -->
         <select id="inputGrade"
             class="form-select form-select-sm d-none"
             style="width:180px;"
             onchange="search(this.value)">
             <option>Search Grade level here</option>
             <?php foreach ($grade as $level): ?>
                 <option value="<?= $level->grade_id ?>">
                     <?= $level->level ?>
                 </option>
             <?php endforeach; ?>
         </select>

         <!-- Search Box -->
         <div class="input-group" style="width:260px;">
             <input type="hidden" id="gradeSection" value="<?= $gradeSection ?>" />
             <input type="text"
                 class="form-control"
                 placeholder="Search"
                 id="verify"
                 onkeyup="search(this.value)">

             <button class="btn btn-outline-secondary" type="button">
                 <i class="fa fa-search"></i>
             </button>

             <button class="btn btn-outline-secondary"
                 type="button"
                 data-bs-toggle="modal"
                 data-bs-target="#chartDetails">
                 <i class="fa fa-bar-chart"></i>
             </button>
         </div>

     </div>

     <!-- ====== STUDENT TABLE CARD ====== -->
     <div class="card shadow-sm border-0">
         <div class="card-body p-0">

             <div id="studentTable" class="table-responsive">
                 <table class="table table-hover align-middle mb-0" style="font-size:14px;">

                     <thead class="table-light">
                         <tr class="text-center">
                             <th>Student</th>
                             <th>User ID</th>
                             <th>Grade</th>
                             <th>Section</th>
                             <th>Gender</th>
                             <th>Status</th>
                             <th>Remarks</th>
                             <?php if (in_array($access, [1, 2, 43, 49]) || $this->session->userdata('position') === 'Admin Officer'): ?>
                                 <th style="min-width:160px;">Actions</th>
                                 <th>School Year</th>
                             <?php endif; ?>
                         </tr>
                     </thead>

                     <tbody>
                         <?php foreach ($students as $s):
                                $nxt_lvl = Modules::run('registrar/getlevelByOrder', ($s->order == 15 ? $s->order : ($s->order + 1)));
                                $name = strtoupper($s->firstname . ' ' . $s->lastname);
                            ?>
                             <tr class="text-center">

                                 <!-- ===== Student Column (Avatar + Name) ===== -->
                                 <td class="text-start">
                                     <div class="d-flex align-items-center gap-3">
                                         <?php
                                            $avatar = ($s->avatar && file_exists('uploads/' . $s->avatar))
                                                ? 'uploads/' . $s->avatar
                                                : 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png');
                                            ?>

                                         <img src="<?= base_url($avatar) ?>"
                                             class="rounded-circle border"
                                             style="width:48px; height:48px; object-fit:cover;">

                                         <div>
                                             <div class="fw-semibold"
                                                 style="cursor:pointer"
                                                 onclick="document.location='<?= base_url('registrar/viewDetails/' . base64_encode($s->uid)) ?>/'">
                                                 <?= strtoupper($s->lastname) ?>,
                                             </div>
                                             <small class="text-muted">
                                                 <?= strtoupper($s->firstname . ' ' . $s->middlename) ?>
                                             </small>
                                         </div>
                                     </div>
                                 </td>

                                 <!-- ===== User ID ===== -->
                                 <td>
                                     <a class="fw-semibold text-decoration-none"
                                         href="<?= base_url('registrar/viewDetails/' . base64_encode($s->uid)) ?>">
                                         <?= $s->uid ?: $s->user_id ?>
                                     </a>
                                 </td>

                                 <!-- ===== Grade ===== -->
                                 <td>
                                     <span class="badge bg-primary-subtle text-primary">
                                         <?= $s->level ?>
                                     </span>
                                 </td>

                                 <!-- ===== Section ===== -->
                                 <td>
                                     <span class="badge bg-info-subtle text-info">
                                         <?= $s->section ?>
                                     </span>
                                 </td>

                                 <!-- ===== Gender ===== -->
                                 <td>
                                     <span class="badge bg-secondary">
                                         <?= $s->sex ?>
                                     </span>
                                 </td>

                                 <!-- ===== Status ===== -->
                                 <td>
                                     <a href="#adminRemarks" data-bs-toggle="modal">
                                         <img onclick="getRemarks('<?= $s->st_id ?>','<?= $s->user_id ?>')"
                                             src="<?= base_url($s->stats ? 'images/official.png' : 'images/unofficial.png') ?>"
                                             style="width:22px; cursor:pointer;">
                                     </a>
                                 </td>

                                 <!-- ===== Remarks ===== -->
                                 <td class="text-start"
                                     onmouseout="$('#delete_<?= $s->uid ?>').hide()"
                                     onmouseover="$('#delete_<?= $s->uid ?>').show()">

                                     <?php
                                        $remarks = Modules::run('main/getAdmissionRemarks', $s->uid, NULL, $s->school_year);
                                        if ($remarks->num_rows() > 0):
                                            echo $remarks->row()->code . ' ' .
                                                $remarks->row()->remarks . ' - ' .
                                                $remarks->row()->remark_date;
                                        ?>
                                         <button id="delete_<?= $s->uid ?>"
                                             type="button"
                                             class="btn-close btn-sm ms-2"
                                             style="display:none"
                                             onclick="deleteAdmissionRemark('<?= $s->uid ?>',<?= $remarks->row()->code_indicator_id ?>)">
                                         </button>
                                     <?php endif; ?>
                                 </td>

                                 <!-- ===== Actions ===== -->
                                 <?php if (in_array($access, [1, 2, 43, 49]) || $this->session->userdata('position') === 'Admin Officer'): ?>
                                     <td>
                                         <div class="d-flex justify-content-center gap-1 flex-wrap">

                                             <?php if (!$s->rfid || $s->rfid === "NULL"): ?>
                                                 <button class="btn btn-sm btn-outline-primary"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#addId"
                                                     onclick="showAddRFIDForm('<?= $s->u_id ?>','RFID', '<?= $name ?>')">
                                                     Add RFID
                                                 </button>
                                             <?php else: ?>
                                                 <button class="btn btn-sm btn-outline-secondary"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#addId"
                                                     onclick="showAddRFIDForm('<?= $s->u_id ?>','<?= $s->rfid ?>', '<?= $name ?>')">
                                                     Edit RFID
                                                 </button>
                                             <?php endif; ?>

                                             <button class="btn btn-sm btn-outline-danger"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#deleteIDConfirmation"
                                                 onclick="showDeleteConfirmation('<?= $s->uid ?>','<?= $s->psid ?>')">
                                                 Delete
                                             </button>
                                             <button class="btn btn-sm btn-outline-success"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#rollOver"
                                                 onclick="
                                                    $('#ro_st_id').val('<?= $s->uid ?>');
                                                    $('#curr_grade_id').val('<?= $s->grade_id ?>');
                                                    $('#ro_grade_id').val('<?= $nxt_lvl->grade_id ?>');
                                                    $('#curr_lDesc').html('<?= $s->level ?>');
                                                    $('#stName').html('<?= $name ?>');
                                                    $('#new_lDesc').html('<?= $nxt_lvl->level ?>');">
                                                 Roll Over
                                             </button>
                                         </div>
                                     </td>

                                     <!-- ===== School Year ===== -->
                                     <td>
                                         <span class="badge bg-dark">
                                             <?= $s->school_year ?> - <?= $s->school_year + 1 ?>
                                         </span>
                                     </td>
                                 <?php endif; ?>

                             </tr>
                         <?php endforeach; ?>
                     </tbody>

                 </table>
             </div>
         </div>
     </div>

     <?php echo Modules::run('main/showAdminRemarksForm') ?>