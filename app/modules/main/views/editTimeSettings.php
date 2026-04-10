<div id="addressInfo">

    <?php
    $timeInAM = $optionToEdit == 'a' ? $query->row()->ps_from : $query->row()->time_in;
    $timeOutAM = $optionToEdit == 'a' ? $query->row()->ps_to : $query->row()->time_out;
    $timeInPM = $optionToEdit == 'a' ? $query->row()->ps_from_pm : $query->row()->time_in_pm;
    $timeOutPM = $optionToEdit == 'a' ? $query->row()->ps_to_pm : $query->row()->time_out_pm;
    $id = $optionToEdit == 'a' ? $query->row()->ps_id : $query->row()->section_id;
    ?>
    <!-- Title -->
    <div class="mb-3">
        <h5 class="fw-semibold mb-0">
            Edit <?php echo $section ?> Time Settings
        </h5>
        <small class="text-muted">Update AM and PM schedule</small>
    </div>

    <input type="hidden" id="editOption" value="<?php echo $optionToEdit ?>" />

    <!-- FORM -->
    <div class="row g-3">

        <!-- AM IN -->
        <div class="col-md-6 col-12">
            <div class="form-floating">
                <input type="time" class="form-control" id="inAM"
                    value="<?php echo $timeInAM ?>">
                <label>Time In (AM)</label>
            </div>
        </div>

        <!-- AM OUT -->
        <div class="col-md-6 col-12">
            <div class="form-floating">
                <input type="time" class="form-control" id="outAM"
                    value="<?php echo $timeOutAM ?>">
                <label>Time Out (AM)</label>
            </div>
        </div>

        <!-- PM IN -->
        <div class="col-md-6 col-12">
            <div class="form-floating">
                <input type="time" class="form-control" id="inPM"
                    value="<?php echo $timeInPM ?>">
                <label>Time In (PM)</label>
            </div>
        </div>

        <!-- PM OUT -->
        <div class="col-md-6 col-12">
            <div class="form-floating">
                <input type="time" class="form-control" id="outPM"
                    value="<?php echo $timeOutPM ?>">
                <label>Time Out (PM)</label>
            </div>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="d-flex justify-content-end gap-2 mt-4">
        <button class="btn btn-light" data-bs-dismiss="modal">
            Cancel
        </button>

        <button class="btn btn-primary"
            onclick="editTimeSettings(<?php echo $id ?>)">
            <i class="fa fa-save me-1"></i> Save Changes
        </button>
    </div>

</div>
<script>
    function editTimeSettings(id) {
        let option = '<?= $optionToEdit ?>';

        let data = {
            id: id,
            option: option,
            inAM: $('#inAM').val(),
            outAM: $('#outAM').val(),
            inPM: $('#inPM').val(),
            outPM: $('#outPM').val(),
            csrf_test_name: $.cookie('csrf_cookie_name')
        };

        console.log(data);
        $.ajax({
            type: 'POST',
            url: "<?= base_url('main/editTimeSettings') ?>",
            data: data,
            dataType: 'json',

            success: function(res) {
                if (res.status) {

                    // Update UI instantly
                    $('#' + id + '_ami').text(data.inAM);
                    $('#' + id + '_amo').text(data.outAM);
                    $('#' + id + '_pmi').text(data.inPM);
                    $('#' + id + '_pmo').text(data.outPM);

                    // Close modal
                    showTopAlert(res.msg, 'success');
                    $('#editTimeModal').modal('hide');

                } else {
                    showTopAlert(res.msg, 'danger');
                }
            },

            error: function() {
                showTopAlert('Something went wrong', 'danger');
            }
        });
    }
</script>