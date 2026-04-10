
    <!-- <div class="col-lg-4 col-md-6 col-12"> -->
        <div class="card shadow-sm h-100 pointer" onclick="//getAttendanceProgress('<?= $level->row()->section_id ?>','<?= $level->row()->level ?>','<?= $level->row()->section ?>')">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-5 text-center">
                        <?php 
                        $avatar = $advisory->row()->avatar;
                        $sex = $advisory->row()->sex;
                        $avatarPath = ($avatar != '' && file_exists('uploads/'.$avatar)) 
                            ? base_url().'uploads/'.$avatar 
                            : base_url().'images/avatar/'.($sex == 'Female' ? 'female.png' : 'male.png');
                        ?>
                        <img src="<?= $avatarPath ?>" class="rounded-circle mb-2" style="width:75px; height:80px;" alt="Avatar" />
                        <h5 class="mb-0"><?= strtoupper($advisory->row()->firstname) ?></h5>
                        <h5 class="mb-0"><?= strtoupper($advisory->row()->lastname) ?></h5>
                    </div>
                    <div class="col-7" style="border-left: 1px solid #dee2e6;">
                        <div class="display-6 fw-bold">
                            <?= ($numberOfPresents->num_rows() > $numberOfStudents->num_rows() ? $numberOfStudents->num_rows() : $numberOfPresents->num_rows()) ?> / <?= $numberOfStudents->num_rows() ?>
                        </div>
                        <div class="text-muted small">Students Present</div>
                        <hr />
                        <div class="display-6 fw-bold"><?= round($presents/($numberOfSchoolDays)) ?></div>
                        <div class="text-muted small">Average Daily</div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->

    <!-- Modal -->
    <div class="modal fade" id="attendanceProgress" tabindex="-1" aria-labelledby="attendanceProgressLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="attendanceProgressLabel">Monthly Attendance Progress Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <span id="levelSection" class="ms-3"></span>
                </div>
                <div class="modal-body" id="apGraph">
                    <!-- Graph will be loaded here -->
                </div>
            </div>
        </div>
    </div>

<script>
function getAttendanceProgress(id, level, section) {
    $('#levelSection').html(level + ' - ' + section);
    var url = '<?= base_url().'attendance/getApGraph/' ?>';
    $.ajax({
        type: "POST",
        url: url,
        data: 'section_id='+id+"&date="+$('#inputBdate').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
        beforeSend: function() {
            showLoading('apGraph');
        },
        success: function(data) {
            $('#apGraph').html(data);
            var myModal = new bootstrap.Modal(document.getElementById('attendanceProgress'));
            myModal.show();
        }
    });
}
</script>
