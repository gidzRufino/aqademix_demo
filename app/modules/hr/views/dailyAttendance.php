<div class="container-fluid">

  <!-- HEADER -->
  <div class="row mb-4 align-items-end">
    <div class="col-lg-8">
      <h3 class="fw-bold mb-0">Employee's Daily Attendance</h3>
    </div>

    <div class="col-lg-4">
      <label class="form-label fw-semibold">Select Date</label>
      <div class="input-group rounded-pill shadow-sm" style="overflow:hidden;">
                <input type="date" class="form-control border-end-0" style="height:38px;" name="inputAttDate"
                    data-date-format="yyyy-mm-dd" value="<?= $date != null ? $date : date('Y-m-d'); ?>" id="inputAttDate" placeholder="Search for Date" required>
                <button class="btn btn-success" id="btnSearchAttendance" title="Search attendance by date">
                    <i class="fa fa-search"></i>
                </button>
            </div>
      <!-- <div class="input-group">
        <input type="date"
               id="inputAttDate"
               class="form-control"
               value="<?php echo date('Y-m-d', strtotime($date)); ?>"
               max="<?php echo date('Y-m-d'); ?>">
        <button class="btn btn-success" id="btnSearchAttendance">
          <i class="fa fa-search"></i>
        </button>
      </div> -->
      <small class="text-muted">View attendance records for a specific day.</small>
    </div>
  </div>

  <div class="row">

    <!-- PRESENT -->
    <div class="col-lg-9">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-0">Present</h5>
        </div>

        <div class="card-body p-0 attendance-scroll">
          <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
              <thead class="table-light text-center">
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>IN (AM)</th>
                  <th>OUT (AM)</th>
                  <th>IN (PM)</th>
                  <th>OUT (PM)</th>
                </tr>
              </thead>
              <tbody>

              <?php foreach ($presents->result() as $b):

                $time_in = $b->time_in ? date("g:i a", strtotime(str_pad($b->time_in,4,'0',STR_PAD_LEFT))) : '';
                $time_out = $b->time_out ? date("g:i a", strtotime(str_pad($b->time_out,4,'0',STR_PAD_LEFT))) : '';
                $time_in_pm = $b->time_in_pm ? date("g:i a", strtotime($b->time_in_pm)) : '';
                $time_out_pm = $b->time_out_pm ? date("g:i a", strtotime($b->time_out_pm)) : '';
              ?>

                <tr class="presentTR text-center"
                    data-id="<?php echo $b->att_st_id ?>"
                    data-time-in="<?php echo $time_in ?>"
                    data-time-out="<?php echo $time_out ?>"
                    data-time-in-pm="<?php echo $time_in_pm ?>"
                    data-time-out-pm="<?php echo $time_out_pm ?>">
                <td>
                    <img class="rounded-circle" width="45"
                    src="<?php
                        if ($b->avatar && file_exists('uploads/'.$b->avatar))
                        echo base_url().'uploads/'.$b->avatar;
                        else
                        echo base_url().'images/avatar/'.($b->sex=='Female'?'female.png':'male.png');
                    ?>">
                </td>
                <td class="fw-semibold">
                    <?php echo strtoupper($b->firstname.' '.$b->lastname) ?>
                </td>
                <td><?php echo $time_in ?></td>
                <td><?php echo $time_out ?></td>
                <td><?php echo $time_in_pm ?></td>
                <td><?php echo $time_out_pm ?></td>
                </tr>

              <?php endforeach; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ABSENT -->
    <div class="col-lg-3">
      <div class="card shadow-sm border-danger">
        <div class="card-header bg-danger text-white text-center">
          <h5 class="mb-0">Absent</h5>
        </div>

        <div class="card-body attendance-scroll">
        <?php foreach ($employees->result() as $b):
          $ifPresent = Modules::run(
            'attendance/ifPresent',
            $b->employee_id,
            date('d', strtotime($date)),
            date('m', strtotime($date)),
            NULL,
            TRUE
          );
          if (!$ifPresent):
        ?>
          <div class="d-flex align-items-center gap-3 emList py-2"
               data-bs-toggle="modal"
               data-bs-target="#attendanceModal"
               data-id="<?php echo $b->employee_id ?>">
            <img class="rounded-circle" width="40"
              src="<?php
                if ($b->avatar && file_exists('uploads/'.$b->avatar))
                  echo base_url().'uploads/'.$b->avatar;
                else
                  echo base_url().'images/avatar/'.($b->sex=='Female'?'female.png':'male.png');
              ?>">
            <strong><?php echo strtoupper($b->firstname.' '.$b->lastname) ?></strong>
          </div>
        <?php endif; endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>


<style>
    .emList:hover {
  cursor: pointer;
  background-color: #dc3545;
  color: #fff;
  border-radius: .25rem;
}

.presentTR:hover {
  cursor: pointer;
  background-color: #fd7e14;
  color: #fff;
}

.attendance-scroll {
  max-height: 450px;
  overflow-y: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

const modalEl = document.getElementById('attendanceModal');
const bsModal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });

// Populate hours/minutes, optionally with defaults
function populateTimeDropdowns(defaultHour = '', defaultMin = '', defaultAMPM = '') {
  let hr = '', min = '';
  for (let i = 1; i <= 12; i++) {
    const selected = i === parseInt(defaultHour) ? ' selected' : '';
    hr += `<option value="${String(i).padStart(2,'0')}"${selected}>${String(i).padStart(2,'0')}</option>`;
  }
  for (let i = 0; i <= 59; i++) {
    const selected = i === parseInt(defaultMin) ? ' selected' : '';
    min += `<option value="${String(i).padStart(2,'0')}"${selected}>${String(i).padStart(2,'0')}</option>`;
  }
  modalEl.querySelector('#modal_hr').innerHTML = hr;
  modalEl.querySelector('#modal_min').innerHTML = min;

  // Set AM/PM only if provided
  if (defaultAMPM) modalEl.querySelector('#modal_ampm').value = defaultAMPM;
}

// Helper to parse time string "9:15 am" => [9, 15, "AM"]
function parseTime(timeStr) {
  if (!timeStr) return ['', '', ''];
  let [time, ampm] = timeStr.split(' ');
  let [hour, min] = time.split(':');
  return [parseInt(hour), parseInt(min), ampm.toUpperCase()];
}

// Click listener for Present rows
document.querySelectorAll('.presentTR').forEach(tr => {
  tr.addEventListener('click', function () {
    modalEl.querySelector('#modal_id').value = this.getAttribute('data-id');

    // Fetch default time from the row
    const timeIn = this.getAttribute('data-time-in');
    const [hour, min, ampm] = parseTime(timeIn);

    populateTimeDropdowns(hour, min, ampm);

    bsModal.show();
  });
});

// Click listener for Absent rows
document.querySelectorAll('.emList').forEach(div => {
  div.addEventListener('click', function () {
    modalEl.querySelector('#modal_id').value = this.getAttribute('data-id');

    // No default time for absent, populate empty dropdowns
    populateTimeDropdowns(); // all empty

    bsModal.show();
  });
});

// Save button
const saveBtn = document.getElementById('modalSaveBtn');
if (saveBtn) {
  saveBtn.addEventListener('click', function () {
    const id = modalEl.querySelector('#modal_id').value;
    saveTime(id); // your existing AJAX function
  });
}

// Reset modal on close
modalEl.addEventListener('hidden.bs.modal', function () {
  modalEl.querySelector('#modal_id').value = '';
  modalEl.querySelector('#modal_hr').innerHTML = '';
  modalEl.querySelector('#modal_min').innerHTML = '';
  modalEl.querySelector('#modal_ampm').value = 'AM';
});

});

function saveTime(id) {
  const hour = $('#modal_hr').val();
  const min = $('#modal_min').val();
  const ampm = $('#modal_ampm').val();
  const inout = $('#modal_inout').val();
  const date = $('#inputAttDate').val();
  var url = '<?php echo base_url().'hr/saveManualHrAttendance/' ?>';

  if (!hour || !min || !ampm) {
    alert('Please select complete time.');
    return;
  }

  $.ajax({
    type: 'POST',
    url: url,
    data: {
        t_id: id,
        hour: hour,
        min: min,
        ampm: ampm,
        inout: inout,
        date: date,
        uid: id,
        csrf_test_name: $.cookie('csrf_cookie_name')
    },
        success: function (data){
            $('#present_em').html(data)
            location.reload();
        },
        error: function(data) {
            alert('error')
        }
  });
}

$('#btnSearchAttendance').on('click', function () {
  if ($('#inputAttDate').val()) {
    window.location =
      "<?php echo base_url().'hr/getDailyAttendance/' ?>" + $('#inputAttDate').val();
  }
});
</script>
