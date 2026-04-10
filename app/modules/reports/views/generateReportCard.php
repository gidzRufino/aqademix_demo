<!-- ===================== THEME TOGGLE + STYLES ===================== -->
<style>
  :root {
    --radius: 16px;
  }

  .theme-modern .dash-card {
    border: 0;
    border-radius: var(--radius);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
  }

  .theme-modern .dash-header {
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
    color: #fff;
  }

  .theme-print .dash-card {
    border: 1px solid #000;
    box-shadow: none;
    border-radius: 6px;
  }

  .theme-print .dash-header {
    background: #f8f9fa;
    color: #000;
    border-bottom: 2px solid #000;
  }

  .theme-print table {
    border: 1px solid #000;
  }

  .theme-print table th,
  .theme-print table td {
    border: 1px solid #000;
  }

  .theme-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
  }

  .modal {
    z-index: 2000 !important;
  }

  .modal-backdrop {
    z-index: 1990 !important;
  }
</style>

<div class="theme-toggle">
  <button class="btn btn-dark btn-sm" onclick="setTheme('modern')">Modern</button>
  <button class="btn btn-secondary btn-sm" onclick="setTheme('print')">Print</button>
</div>

<script>
  function setTheme(mode) {
    document.body.classList.remove('theme-modern', 'theme-print');
    document.body.classList.add('theme-' + mode);
  }
  setTheme('modern');
</script>


<!-- ===================== DASHBOARD ROOT ===================== -->
<div id="dashboardRoot">

  <!-- ===================== STUDENT HEADER ===================== -->
  <div class="card dash-card mb-4 overflow-hidden">
    <div class="dash-header p-3"></div>

    <div class="card-body p-4">
      <div class="row align-items-center g-4">

        <div class="col-md-2 text-center">
          <img
            src="<?php if ($student->avatar != ""): echo base_url() . 'uploads/' . $student->avatar;
                  else: echo base_url() . 'uploads/noImage.png';
                  endif; ?>"
            class="rounded-circle border border-3"
            style="width:120px;height:120px;object-fit:cover;">
        </div>

        <div class="col-md-6">
          <h3 class="fw-bold mb-1">
            <?php echo $student->firstname . " " . $student->lastname . " " . $sname ?>
          </h3>

          <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-primary">
              <?php echo $student->level ?> — <?php echo $student->section ?>
            </span>
            <span class="badge bg-dark">ID: <?php echo $student->uid ?></span>
          </div>
        </div>

        <div class="col-md-4 text-md-end">
          <button
            class="btn btn-success btn-lg"
            onclick="$('#cardPreview').modal('show'); previewCard('<?php echo base64_encode($student->uid) ?>', <?php echo $sy ?>, <?php echo $term ?>)">
            <i class="fa fa-file-text me-2"></i>
            Generate Card
          </button>
        </div>

      </div>
    </div>
  </div>


  <!-- ===================== MAIN GRID ===================== -->
  <!-- ===================== MAIN GRID ===================== -->
  <div class="row g-4" id="academic_info">

    <!-- ===================== HIDDEN FIELDS ===================== -->
    <input type="hidden" id="student_id" value="<?php echo base64_encode($student->uid) ?>">
    <input type="hidden" id="term" value="<?php echo $term ?>">
    <input type="hidden" id="sy" value="<?php echo $sy ?>">
    <input type="hidden" id="strand" value="<?php echo $strand ?>">

    <?php if ($term == 4): ?>
      <?php $lock = Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy) ? 'fa-lock' : 'fa-unlock'; ?>
    <?php endif; ?>

    <input type="hidden" id="cardLockController" value="0">

    <!-- ===================== ONE MASTER CARD ===================== -->
    <div class="col-12">

      <div class="card dash-card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <span class="fw-bold">
            <i class="fa fa-graduation-cap text-primary me-2"></i>
            Student Card Details
          </span>

          <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm"
              onclick="$('#finalGradeData').html($('#special_table').html())">
              <i class="fa fa-pencil"></i>
            </button>

            <?php if ($term == 4): ?>
              <button class="btn btn-outline-danger btn-sm"
                onclick="lockFinalCard('<?php echo $student->uid ?>',<?php echo $sy ?>)">
                <i id="final_lock" class="fa <?php echo $lock ?>"></i>
              </button>
            <?php endif; ?>
          </div>
        </div>

        <div class="card-body">

          <!-- ================= ROW: GRADES + REMARKS ================= -->
          <div class="row g-4">

            <!-- FINAL GRADES -->
            <div class="col-lg-8">

              <h6 class="fw-bold text-primary mb-3">
                <i class="fa fa-list me-2"></i> Final Grades
              </h6>

              <div class="table-responsive" id="finalGradeData">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Subject</th>
                      <th class="text-center">Rating</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
                    $i = 0;
                    foreach ($subject as $s):
                      $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                      $finalGrade = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
                    ?>

                      <tr>
                        <td class="fw-semibold"><?php echo $singleSub->subject ?></td>
                        <td class="text-center">
                          <?php if ($finalGrade->num_rows() > 0): ?>
                            <span class="badge bg-success fs-6">
                              <?php echo $finalGrade->row()->final_rating ?>
                            </span>
                          <?php else: $i++; ?>
                            <span class="badge bg-secondary">Pending</span>
                          <?php endif; ?>
                        </td>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <input type="hidden" id="no_subject" value="<?php echo $i ?>">

            </div>

            <!-- TEACHER REMARKS -->
            <div class="col-lg-4">

              <?php $remarks = Modules::run('gradingsystem/getCardRemarks', $student->uid, $term, $sy); ?>

              <h6 class="fw-bold text-success mb-3">
                <i class="fa fa-comment me-2"></i> Teacher Remarks
              </h6>

              <textarea id="cardRemarks" class="form-control mb-3" rows="10"><?php
                                                                              echo ($remarks->num_rows() > 0) ? $remarks->row()->remarks : '';
                                                                              ?></textarea>

              <button class="btn btn-success w-100"
                onclick="saveRemarks('<?php echo $student->uid ?>',<?php echo $term ?>,<?php echo $sy ?>)">
                Save Remarks
              </button>

            </div>

          </div>

          <hr class="my-4">

          <!-- ================= ATTENDANCE ================= -->
          <h6 class="fw-bold text-warning mb-3">
            <i class="fa fa-calendar me-2"></i>
            Attendance Summary
          </h6>

          <?php
          $sprDetails = Modules::run('sf10/getSPRrec', $student->uid, $sy, NULL, $student->grade_id);
          echo Modules::run(
            'sf10/getAttendanceDetails',
            $sprDetails->spr_id,
            $sprDetails->school_year,
            $sprDetails->semester,
            $student->uid
          );
          ?>

          <hr class="my-4">

          <!-- ================= OBSERVED VALUES ================= -->
          <?php
          $isSub = 0;
          foreach ($behavior as $cv):
            $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
            if ($bStatements->num_rows() > 0) $isSub++;
          endforeach;
          ?>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-info mb-0">
              <i class="fa fa-eye me-2"></i>
              Observed Values
            </h6>

            <?php if ($isSub): ?>
              <select class="form-select w-auto" id="core_values_select">
                <option value="0">Select Core Values</option>
                <?php foreach ($behavior as $cv): ?>
                  <option value="<?php echo $cv->core_id ?>">
                    <?php echo $cv->core_values ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </div>

          <div class="table-responsive">
            <table class="table table-hover" id="cv"></table>
          </div>

        </div>
      </div>
    </div>

  </div>

  <!-- ===================== HIDDEN MANUAL TABLE ===================== -->
  <div id="special_table" class="d-none">
    <?php
    $data['term'] = $term;
    $data['sy'] = $sy;
    $data['student'] = $student;
    $this->load->view('reportCard/manualEntry', $data);
    ?>
  </div>

  <?php
  $this->load->view('reportCardPreview', $data);
  echo Modules::run(
    'sf10/attendanceManualOveride',
    base64_encode($student->st_id),
    $sy,
    $sprDetails->semester,
    FALSE,
    TRUE
  );
  ?>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchAssessDate").select2();

  });

  $('#core_values_select').change(function() {
    alert($(this).val());
  });

  function getBehaviorStatement(val) {
    alert(val);
    var sy = '<?php echo $sy ?>';
    var term = '<?php echo $term ?>';
    var st_id = '<?php echo $student->st_id ?>';
    var url = '<?php echo base_url() . 'reports/getBehaviorStatement/' ?>' + val + '/' + sy + '/' + term + '/' + st_id;

    $.ajax({
      type: 'GET',
      url: url,
      success: function(data) {
        $('#cv').html(data);
      }
    });
  }

  function deleteINC(id) {
    var url = "<?php echo base_url() . 'reports/deleteINC/' ?>" + id; // the script where you handle the form input.
    $.ajax({
      type: "GET",
      url: url,
      data: "id=" + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        $('#tr_' + id).hide();
      }
    })
  }

  function saveINC(st_id) {
    var url = "<?php echo base_url() . 'reports/saveINC/' ?>"; // the script where you handle the form input.
    var sub = $('#inc_subject').val();
    var grade = $('#inputGrade').val();
    var option = $('#inc_option').val();
    $.ajax({
      type: "POST",
      url: url,
      dataType: 'json',
      data: "level_id=" + grade + '&subject_id=' + sub + '&option=' + option + '&st_id=' + st_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        if (option == 0) {
          var msg = 'Previous Years Completed';
        } else {
          msg = 'Current School Year';
        }

        var result = '<tr><td>' + data.subject + '</td><td>' + data.level + '</td><td>' + msg + '</td></tr>';
        $('#inc_table').append(result);
      }
    });

    return false;
  }

  function submitRating(st_id, rating, grading, school_year, bh_id) {

    var url = "<?php echo base_url() . 'gradingsystem/saveBH/' ?>" + st_id + '/' + rating + '/' + grading + '/' + school_year + '/' + bh_id;
    //        alert(url);
    $.ajax({
      type: "GET",
      url: url,
      data: 'qcode=' + grading, // serializes the form's elements.
      success: function(data) {


      }
    });
  }

  function saveRemarks(st_id, grading, school_year) {
    var remarks = $('#cardRemarks').val();

    var url = "<?php echo base_url() . 'gradingsystem/saveRemarks/' ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: 'st_id=' + st_id + '&grading=' + grading + '&school_year=' + school_year + '&cardRemarks=' + remarks + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        alert('Remarks Save')
      }
    });
  }

  function previewCard(st_id, sy, term) {
    var url = "<?php echo base_url() . 'reports/cardReview/' ?>" + st_id + '/' + sy + '/' + term;
    $.ajax({
      type: "GET",
      url: url,
      data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        if (term == 4) {
          $('#admittedToWrapper').show()
        }
        $('#cardPreviewData').html(data);
      }
    });

    return false;
  }

  // function printCard() {
  //   var st_id = $('#student_id').val();
  //   var strnd = $('#strand').val();
  //   var term = $('#term').val();
  //   var sy = $('#sy').val();
  //   var admittedTo = (term == 4 ? $('#admittedTo').val() : '');
  //   var dateAdmitted = (term == 4 ? $('#dateAdmitted').val() : '')
  //   if (term == 4 && admittedTo == '') {
  //     alert('Admitted To cannot be blank');
  //   } else {
  //     var url = "<?php echo base_url() . 'reports/printReportCard/' ?>" + st_id + '/' + sy + '/' + term + '/' + strnd + '/' + admittedTo + '/' + dateAdmitted;
  //     const iframe = document.createElement('iframe');
  //     iframe.src = url;
  //     iframe.className = 'w-100 border rounded shadow-sm';
  //     document.querySelector('#academic_info').appendChild(iframe);
  //     // window.open(url, '_blank');
  //   }
  // }

  function printCard() {
    var st_id = $('#student_id').val();
    var strnd = $('#strand').val();
    var term = $('#term').val();
    var sy = $('#sy').val();

    var admittedTo = (term == 4 ? $('#admittedTo').val() : '');
    var dateAdmitted = (term == 4 ? $('#dateAdmitted').val() : '');

    if (term == 4 && !admittedTo) {
      alert('Admitted To cannot be blank');
      return; // stop execution
    }
    $('#cardPreview').modal('hide');

    // build safe URL
    var base = "<?php echo base_url('reports/printReportCard'); ?>";
    var url = base + '/' +
      encodeURIComponent(st_id) + '/' +
      encodeURIComponent(sy) + '/' +
      encodeURIComponent(term) + '/' +
      encodeURIComponent(strnd) + '/' +
      encodeURIComponent(admittedTo) + '/' +
      encodeURIComponent(dateAdmitted);

    const container = document.querySelector('#academic_info');

    // clear previous iframe if exists
    container.innerHTML = '';

    const iframe = document.createElement('iframe');
    iframe.src = url;
    iframe.style.width = '100%';
    iframe.style.height = '900px';
    iframe.style.border = '1px solid #dee2e6';
    iframe.style.borderRadius = '8px';

    container.appendChild(iframe);
  }

  function lockFinalCard(st_id, sy) {
    var lockController = $('#cardLockController').val()

    var answer = confirm("Do you really want to Lock the Final Rating? Doing so will prevent you from future Changes.");
    if (answer == true) {
      var url = "<?php echo base_url() . 'gradingsystem/lockFinalCard/' ?>" + st_id + '/' + sy;
      $.ajax({
        type: "GET",
        dataType: 'json',
        url: url,
        data: 'qcode=' + sy, // serializes the form's elements.
        success: function(data) {
          if (data.status) {
            if (lockController == 0) {
              $('#final_lock').removeClass('fa-unlock');
              $('#final_lock').addClass('fa-lock')
              $('#cardLockController').val(1)
            } else {
              $('#final_lock').removeClass('fa-lock');
              $('#final_lock').addClass('fa-unlock')
              $('#cardLockController').val(0)
            }
          } else {
            alert('Unable to Finalize Card')
          }
        }
      });
    }


  }
</script>