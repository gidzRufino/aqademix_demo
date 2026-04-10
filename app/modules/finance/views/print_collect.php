<?php
$stngs = Modules::run('main/getSet');
?>

<div class="container py-4 py-md-5">

  <input type="hidden" name="lastEntry" id="school_sname" value="<?= $stngs->short_name ?>" required>

  <!-- TOP ROW -->
  <div class="row g-4 align-items-center mb-4">

    <!-- LEFT: LOGO + TITLE -->
    <div class="col-12 col-lg-5">
      <div class="d-flex align-items-center gap-3">

        <img src="<?= base_url() ?>images/forms/logo.png"
          alt="School Logo"
          class="img-fluid"
          style="max-height:65px;">

        <div>
          <h4 class="fw-bold mb-1">Statement of Account</h4>
          <p class="text-muted small mb-0">
            Generate and preview student billing reports
          </p>
        </div>

      </div>
    </div>

    <!-- RIGHT: GENERATOR CARD -->
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3 p-md-4">

          <div class="row g-3 align-items-end">

            <!-- Grade Level -->
            <div class="col-12 col-md-4">
              <label class="form-label fw-semibold small text-secondary">Grade Level</label>
              <select name="select_grade_level"
                id="select_grade_level"
                class="form-select">
                <option selected disabled>Select Grade Level</option>
                <?php foreach ($get_level as $gl) { ?>
                  <option value="<?= $gl->grade_id ?>"><?= $gl->level ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Due Date -->
            <div class="col-12 col-md-4">
              <label class="form-label fw-semibold small text-secondary">Due Date</label>
              <input name="duedate"
                id="duedate"
                type="text"
                class="form-control"
                placeholder="Select due date">
            </div>

            <!-- Button -->
            <div class="col-12 col-md-4">
              <button class="btn btn-success w-100 d-flex align-items-center justify-content-center"
                onclick="generate_soa()">
                Generate
              </button>
            </div>

          </div>

        </div>
      </div>
    </div>

  </div>

  <!-- LOADING STATE -->
  <div id="loading" class="text-center py-5 d-none">
    <div class="spinner-border text-success" style="width:2.5rem; height:2.5rem;"></div>
    <div class="mt-3 text-muted">Generating report, please wait...</div>
  </div>

  <!-- REPORT CARD -->
  <div id="d_report" class="card border-0 shadow-sm rounded-4 d-none">
    <div class="card-body p-3 p-md-4">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 id="report_header" class="fw-bold mb-0"></h6>
      </div>

      <div class="ratio ratio-16x9">
        <iframe id="report_iframe"
          class="w-100 border-0 rounded"
          style="display:none;"
          src="">
        </iframe>
      </div>

    </div>
  </div>

</div>

<style>
  body {
    background-color: #f8f9fb;
  }

  .card {
    transition: all 0.2s ease;
  }

  .card:hover {
    transform: translateY(-2px);
  }

  .form-control,
  .form-select {
    border-radius: 10px;
    padding: 10px 12px;
  }

  .btn-success {
    border-radius: 10px;
    padding: 10px;
    font-weight: 500;
  }

  #report_iframe {
    background: #fff;
  }
</style>

<script>
  $(document).ready(function() {

    $('#select_grade_level').select2({
      width: '100%',
      placeholder: "Select Grade Level"
    });

    $('#duedate').datepicker({
      format: 'mm-dd-yyyy',
      autoclose: true
    });

  });

  function generate_soa() {

    let gradelevel = $('#select_grade_level').val();
    let due_date = $('#duedate').val();

    if (!gradelevel) {
      Swal.fire({
        icon: 'warning',
        title: 'Required',
        text: 'Please select grade level'
      });
      return;
    }

    if (!due_date) {
      Swal.fire({
        icon: 'warning',
        title: 'Required',
        text: 'Please select due date'
      });
      return;
    }

    let url = "<?= base_url() ?>finance/print_soa/" + gradelevel + '/' + due_date;

    // Show loading
    $('#loading').removeClass('d-none');
    $('#d_report').addClass('d-none');

    // Set iframe
    $('#report_header').text('Statement of Account');
    $('#report_iframe')
      .hide()
      .attr('src', url)
      .on('load', function() {
        $('#loading').addClass('d-none');
        $('#d_report').removeClass('d-none');
        $('#report_iframe').fadeIn();
      });

    // Open new tab (optional)
    // window.open(url, '_blank');

    document.title = 'Collection Notice';
  }
</script>