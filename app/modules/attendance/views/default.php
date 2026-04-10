<div id="attend_widget" class="card border-0 shadow-lg rounded-4 mt-3 overflow-hidden" style="max-height:450px;">

  <!-- Header / Month Navigator -->
  <!-- Header / Month Navigator -->
  <div class="bg-primary bg-gradient text-white p-3 position-sticky top-0" style="z-index:5;">
    <div class="d-flex align-items-center justify-content-between">

      <input type="hidden" id="m_id" value="<?php echo date('m') ?>" />
      <input type="hidden" id="y_id" value="<?php echo ($this->uri->segment(4) == NULL ? $this->session->userdata('school_year') : $this->uri->segment(4)); ?>" />

      <!-- Prev -->
      <button onclick="getAttendance(parseInt($('#m_id').val()) - 1)"
        class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
        style="width:42px;height:42px;">
        <i class="fa fa-chevron-left"></i>
      </button>

      <!-- Month Display (transparent, no bg) -->
      <div class="text-center flex-grow-1">
        <div class="small opacity-75">Monthly Attendance</div>
        <span id="monthName"
          onclick="getAttendance(parseInt(<?php echo date('m') ?>))"
          class="fw-bold fs-4 text-white"
          style="cursor:pointer;">
          <?php echo date('F') ?>
        </span>
      </div>

      <!-- Next -->
      <button onclick="getAttendance(parseInt($('#m_id').val()) + 1)"
        class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
        style="width:42px;height:42px;">
        <i class="fa fa-chevron-right"></i>
      </button>

    </div>
  </div>

  <!-- Body -->
  <div id="attendance_container" class="bg-body overflow-auto" style="max-height:370px;">
    <div class="p-3">
      <?php
      $yr = $this->session->userdata('school_year');
      if (date('m') > 1 && date('m') < 7) {
        $yr = $yr + 1;
      }
      echo Modules::run('attendance/monthly', $option, base64_encode($students->uid), date('m'), $yr);
      ?>
    </div>
  </div>

</div>

<script type="text/javascript">
  function showAttendanceLoader() {
    $('#attendance_container').html(`
    <div class="d-flex flex-column align-items-center justify-content-center py-5">
      <div class="spinner-border text-primary mb-2"></div>
      <small class="text-muted">Loading attendance...</small>
    </div>
  `);
  }

  function getAttendance(month) {
    // var year = $('#y_id').val();
    year = <?php echo $this->session->userdata('school_year') ?>;
    if (month < 1) {
      month = month + 12;
      // year = parseInt(year)
    }
    if (month > 12) {
      month = month - 12;
      year = year + 1;
    }
    if (month < 10) {
      month = '0' + month;
    }
    if (month > 0 && month < 7) {
      year = year + 1;
    }

    getMonthName(month);
    $('#m_id').val(month);
    $('#y_id').val(year);
    // alert(month)
    var url = "<?php echo base_url() . 'attendance/monthly/individual/' . base64_encode($students->uid) ?>/" + month + '/' + year; // the script where you handle the form input.
    showAttendanceLoader();

    $.ajax({
      type: "POST",
      url: url,
      //dataType: 'json',
      data: "level_id=" + '' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        document.getElementById('attendance_container').innerHTML = data;
      }
    });

    return false;

  }

  function getMonthName(m_id) {
    var url = "<?php echo base_url() . 'main/monthName/' ?>" + m_id; // the script where you handle the form input.

    $.ajax({
      type: "POST",
      url: url,
      //dataType: 'json',
      data: "level_id=" + '' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
      success: function(data) {
        document.getElementById('monthName').innerHTML = data;
      }
    });

    return false;
  }
</script>