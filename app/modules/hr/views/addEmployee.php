<?php
$sy = $settings->school_year;
$is_admin = $this->session->userdata('is_admin');
?>
<div class="container-fluid py-4">

  <!-- Page Header -->
  <?php
  $attributes = array('class' => '', 'id' => 'addEmployeeForm');
  echo form_open(base_url() . 'hr/saveProfile', $attributes);
  ?>
  <div class="page-header shadow-sm rounded-4 p-3 mb-4 d-flex justify-content-between align-items-center flex-wrap">
    <div>
      <h3 class="fw-bold mb-0">Add Employee</h3>
      <small class="text-muted">
        School Year: <strong><?php echo $sy ?></strong>
      </small>
    </div>
    <div class="mt-2 mt-md-0">
      <button type="button" onclick="document.location='<?php echo base_url('main/dashboard') ?>'" class="btn btn-outline-secondary me-2 px-4">
        <i class="fa fa-times"></i> Cancel
      </button>
      <button id="saveAdmission" type="button" class="btn btn-success px-4 shadow-sm">
        <i class="fa fa-save"></i> Save Employee
      </button>
    </div>
  </div>

  <!-- PERSONAL INFORMATION -->
  <div class="card custom-card border-0 mb-4">
    <div class="card-header bg-success-subtle text-success fw-semibold">
      <i class="fa fa-user me-2"></i> Personal Information
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Employee ID</label>
          <small class="text-muted">[ Auto Generated ID ]</small>
          <input type="text" class="form-control" name="inputIdNum" id="inputIdNum" placeholder="Enter Employee ID" maxlength="11">
        </div>

        <div class="col-md-3">
          <label class="form-label">First Name</label>
          <?php echo form_input(['name' => 'inputFirstName', 'id' => 'inputFirstName', 'class' => 'form-control']); ?>
        </div>

        <div class="col-md-3">
          <label class="form-label">Middle Name</label>
          <?php echo form_input(['name' => 'inputMiddleName', 'id' => 'inputMiddleName', 'class' => 'form-control']); ?>
        </div>

        <div class="col-md-3">
          <label class="form-label">Last Name</label>
          <?php echo form_input(['name' => 'inputLastName', 'id' => 'inputLastName', 'class' => 'form-control']); ?>
        </div>

        <div class="col-md-3">
          <label class="form-label">Date of Birth</label>
          <input class="form-control" type="date" name="empInputBdate" id="empInputBdate" placeholder="YYYY-MM-DD">
        </div>

        <div class="col-md-3">
          <label class="form-label">Gender</label>
          <select name="inputGender" id="inputGender" class="form-select">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Status</label>
          <?php echo form_dropdown(
            'inputStatus',
            ['' => 'Select Status', 'Single' => 'Single', 'Married' => 'Married', 'Widow' => 'Widow'],
            '',
            'id="inputStatus" class="form-select"'
          ); ?>
        </div>

        <div class="col-md-3">
          <label class="form-label">Nationality</label>
          <?php echo form_input(['name' => 'inputNationality', 'id' => 'inputNationality', 'class' => 'form-control']); ?>
        </div>

        <div class="col-md-3">
          <label class="form-label">Religion</label>
          <select name="inputReligion" id="inputReligion" class="form-select">
            <option value="">Select Religion</option>
            <?php foreach ($religion as $r):
              if ($r->religion != ''): ?>
                <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>
            <?php
              endif;
            endforeach; ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTACT INFORMATION -->
  <div class="card custom-card border-0 mb-4">
    <div class="card-header bg-primary-subtle text-primary fw-semibold">
      <i class="fa fa-address-book me-2"></i> Contact Information
    </div>
    <div class="card-body">

      <h6 class="section-label">Address Details</h6>
      <div class="row g-3 mb-3">
        <div class="col-md-3">
          <label class="form-label">Street</label>
          <input class="form-control" name="inputStreet" id="inputStreet">
        </div>
        <div class="col-md-3">
          <label class="form-label">Barangay</label>
          <input class="form-control" name="inputBarangay" id="inputBarangay">
        </div>
        <div class="col-md-3">
          <label class="form-label">City / Municipality</label>
          <select onchange="getProvince(this.value)" id="inputMunCity" name="inputMunCity" class="form-select">
            <?php foreach ($cities as $city): ?>
              <option value="<?php echo $city->cid ?>">
                <?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Province</label>
          <input class="form-control" name="inputProvince" id="inputProvince">
          <input type="hidden" name="inputPID" id="inputPID">
        </div>

        <div class="col-md-3">
          <label class="form-label">Postal Code</label>
          <input class="form-control" name="inputPostal" id="inputPostal">
        </div>

        <div class="col-md-3">
          <label class="form-label">Contact Number</label>
          <input class="form-control" name="inputPhone" id="inputPhone">
        </div>

        <div class="col-md-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="inputEmail" id="inputEmail">
        </div>
      </div>

      <div class="emergency-box p-3 rounded-3">
        <h6 class="fw-bold text-danger mb-3">
          <i class="fa fa-exclamation-triangle me-1"></i> In Case of Emergency
        </h6>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Contact Name</label>
            <?php echo form_input(['name' => 'inputInCaseName', 'id' => 'inputInCaseName', 'class' => 'form-control']); ?>
          </div>
          <div class="col-md-3">
            <label class="form-label">Relation</label>
            <?php echo form_input(['name' => 'inputInCaseRelation', 'id' => 'inputInCaseRelation', 'class' => 'form-control']); ?>
          </div>
          <div class="col-md-3">
            <label class="form-label">Contact Number</label>
            <?php echo form_input(['name' => 'inputInCaseContact', 'id' => 'inputInCaseContact', 'class' => 'form-control']); ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- ACADEMIC INFORMATION -->
  <div class="card custom-card border-0 mb-4">
    <div class="card-header bg-warning-subtle text-warning fw-semibold">
      <i class="fa fa-graduation-cap me-2"></i> Academic Information
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Course</label>
          <input class="form-control" name="inputCourse" id="inputCourse">
          <input type="hidden" id="courseId" name="courseId" value="0" />
          <div class="border bg-white mt-1 small p-2 d-none" id="courseSearch"></div>
        </div>

        <?php $year = date('Y') - 40; ?>
        <div class="col-md-3">
          <label class="form-label">Year Graduated</label>
          <select name="inputYearGraduated" id="inputYearGraduated" class="form-select">
            <option value="">Select Year</option>
            <?php for ($x = $year; $x <= date('Y'); $x++): ?>
              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Name of School</label>
          <input class="form-control" onkeydown="searchSchool(this.value)" name="inputNameOfSchool" id="inputNameOfSchool">
          <input type="hidden" id="collegeId" name="collegeId" value="0" />
          <div class="border bg-white mt-1 small p-2 d-none" id="collegeSearch"></div>
        </div>

        <div class="col-md-3">
          <label class="form-label">Address of School</label>
          <?php echo form_input(['name' => 'inputAddressOfSchool', 'id' => 'inputAddressOfSchool', 'class' => 'form-control']); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- HR INFORMATION -->
  <div class="card custom-card border-0 mb-4">
    <div class="card-header bg-danger-subtle text-danger fw-semibold">
      <i class="fa fa-briefcase me-2"></i> HR Information
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Date Hired</label>
          <input class="form-control" type="date" name="inputDateHired" id="inputDateHired" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD">
        </div>

        <div class="col-md-3">
          <label class="form-label">Department</label>
          <select onchange="getPosition(this.value)" name="inputDepartment" id="inputDepartment" class="form-select">
            <option value="0">Select Department</option>
            <?php foreach ($position as $p): ?>
              <option value="<?php echo $p->dept_id; ?>"><?php echo $p->department; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Position</label>
          <select name="inputPosition" id="inputPosition" class="form-select">
            <option value="0"></option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Employment Status</label>
          <select name="inputEmploymentStatus" id="inputEmploymentStatus" class="form-select">
            <option value="0">Select Status</option>
            <option value="Regular">Regular</option>
            <option value="Contractual">Contractual</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">PRC ID:</label>
          <input class="form-control" type="text" name="inputPRC" id="inputPRC">
        </div>
      </div>
    </div>
  </div>

  <!-- STATUTORY BENEFITS -->
  <div class="card custom-card border-0 mb-5">
    <div class="card-header bg-secondary-subtle text-secondary fw-semibold">
      <i class="fa fa-id-card me-2"></i> Statutory Benefits
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">SSS #</label>
          <?php echo form_input(['name' => 'inputSSS', 'id' => 'inputSSS', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">PhilHealth #</label>
          <?php echo form_input(['name' => 'inputPH', 'id' => 'inputPH', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">Pag-Ibig #</label>
          <?php echo form_input(['name' => 'inputPagIbig', 'id' => 'inputPagIbig', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-3">
          <label class="form-label">TIN</label>
          <?php echo form_input(['name' => 'inputTin', 'id' => 'inputTin', 'class' => 'form-control']); ?>
        </div>
      </div>
    </div>
  </div>

  <?php echo form_close(); ?>
</div>

<style>
  .page-header {
    background: #fff;
    border-left: 5px solid #198754;
  }

  .custom-card {
    border-radius: 18px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
  }

  .section-label {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 10px;
    border-left: 4px solid #dee2e6;
    padding-left: 10px;
  }

  .emergency-box {
    background: #fff5f5;
    border: 1px dashed #f1aeb5;
  }

  .form-label {
    font-weight: 500;
  }
</style>
<script>
  $(document).ready(function() {

    // ================== Initialize Select2 ==================
    $("#inputGender, #inputStatus, #inputEmploymentStatus, #inputReligion, #inputDepartment, #inputPosition, #inputMunCity").select2({
      placeholder: 'Select an option',
      allowClear: true
    });

    // ================== Initialize Datepickers ==================
    $("#empInputBdate, #inputDateHired").attr('type', 'date'); // fallback

    // ================== Auto-generate Employee ID ==================
    function generateID() {
      var url = "<?php echo base_url('hr/generateId') ?>";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          value: $('#inputDateHired').val(),
          csrf_test_name: $.cookie('csrf_cookie_name')
        },
        success: function(data) {
          $('#inputIdNum').val(data);
        }
      });
    }
    generateID();
    $('#inputDateHired').on('change', generateID);

    // ================== Get Province on City Change ==================
    window.getProvince = function(cityId) {
      var url = "<?php echo base_url('main/getProvince/') ?>" + cityId;
      $.ajax({
        type: "GET",
        url: url,
        data: {
          csrf_test_name: $.cookie('csrf_cookie_name')
        },
        dataType: "json",
        success: function(data) {
          $('#inputProvince').val(data.name);
          $('#inputPID').val(data.id);
        }
      });
    };

    // ================== Get Position based on Department ==================
    window.getPosition = function(deptId) {
      var url = "<?php echo base_url('hr/getPosition/') ?>" + deptId;
      $.ajax({
        type: "POST",
        url: url,
        data: {
          dept_id: deptId,
          csrf_test_name: $.cookie('csrf_cookie_name')
        },
        success: function(data) {
          $('#inputPosition').html(data).trigger('change');
        }
      });
    };

    // ================== Search Course ==================
    window.searchCourse = function(value) {
      var url = "<?php echo base_url('hr/searchCourse') ?>";
      if (value == "") {
        $('#courseSearch').addClass('d-none').hide();
        $('#courseId').val('0');
        return;
      }
      $.ajax({
        type: "POST",
        url: url,
        data: {
          value: value,
          csrf_test_name: $.cookie('csrf_cookie_name')
        },
        success: function(data) {
          $('#courseSearch').removeClass('d-none').show().html(data);
        }
      });
    };

    // ================== Search College ==================
    window.searchSchool = function(value) {
      var url = "<?php echo base_url('hr/searchCollege') ?>";
      if (value == "") {
        $('#collegeSearch').addClass('d-none').hide();
        $('#collegeId').val('0');
        return;
      }
      $.ajax({
        type: "POST",
        url: url,
        data: {
          value: value,
          csrf_test_name: $.cookie('csrf_cookie_name')
        },
        success: function(data) {
          $('#collegeSearch').removeClass('d-none').show().html(data);
        }
      });
    };

    // ================== Save Employee ==================
    $("#saveAdmission").click(function(e) {
      e.preventDefault();

      // Remove previous errors
      $(".error").remove();
      $(".is-invalid").removeClass("is-invalid");

      function showError(input, message) {
        $(input).addClass("is-invalid");
        if ($(input).next(".error").length === 0) {
          $(input).after('<div class="error text-danger small mt-1">' + message + '</div>');
        }
      }

      // Gather form values
      var id = $.trim($('#inputIdNum').val());
      var fname = $.trim($("#inputFirstName").val());
      var lname = $.trim($("#inputLastName").val());
      var dept = $('#inputDepartment').val();
      var position = $('#inputPosition').val();
      var eStat = $('#inputEmploymentStatus').val();
      var hasError = false;

      // ===== Validations =====
      if (!id) {
        showError('#inputIdNum', 'ID number is required');
        hasError = true;
      }
      if (!fname) {
        showError('#inputFirstName', 'First Name is required');
        hasError = true;
      }
      if (!lname) {
        showError('#inputLastName', 'Last Name is required');
        hasError = true;
      }
      if (!dept || dept == 0) {
        showError('#inputDepartment', 'Department is required');
        hasError = true;
      }
      if (!position || position == 0) {
        showError('#inputPosition', 'Position is required');
        hasError = true;
      }
      if (!eStat || eStat == 0) {
        showError('#inputEmploymentStatus', 'Employment Status is required');
        hasError = true;
      }

      if (hasError) {
        $('html, body').animate({
          scrollTop: $(".is-invalid:first").offset().top - 120
        }, 400);
        return false;
      }

      // Disable button while submitting
      var btn = $(this);
      btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

      var url = "<?php echo base_url('hr/saveProfile') ?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $("#addEmployeeForm").serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
        success: function(data) {
          alert(data);
          btn.prop("disabled", false).html('<i class="fa fa-save"></i> Save Employee');
        },
        error: function(xhr) {
          alert("An error occurred while saving. Please try again.");
          btn.prop("disabled", false).html('<i class="fa fa-save"></i> Save Employee');
        }
      });

    });

  });
</script>