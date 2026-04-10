<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fa fa-cogs me-2"></i> Settings
        </h5>
    </div>

    <div class="card-body">

        <h4 class="fw-semibold text-secondary mb-4">
            <i class="fa fa-clock-o me-2"></i> Time Shifting Management
        </h4>

        <div class="table-responsive">

            <table id="timeTable" class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Group Name</th>
                        <th>Time In [AM]</th>
                        <th>Time Out [AM]</th>
                        <th>Time In [PM]</th>
                        <th>Time Out [PM]</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($time_settings as $ts): ?>

                        <tr>

                            <td class="fw-semibold">
                                <?php echo $ts->ps_department ?>
                            </td>

                            <td id="time_in_td_<?php echo $ts->ps_id ?>">
                                <span class="badge bg-success-subtle text-success">
                                    <?php echo date('g:i A', strtotime($ts->ps_from)) ?>
                                </span>
                            </td>

                            <td id="time_out_td_<?php echo $ts->ps_id ?>">
                                <span class="badge bg-danger-subtle text-danger">
                                    <?php echo date('g:i A', strtotime($ts->ps_to)) ?>
                                </span>
                            </td>

                            <td id="time_out_td_<?php echo $ts->ps_id ?>">
                                <span class="badge bg-success-subtle text-success">
                                    <?php echo date('g:i A', strtotime($ts->ps_from_pm)) ?>
                                </span>
                            </td>

                            <td id="time_out_td_<?php echo $ts->ps_id ?>">
                                <span class="badge bg-danger-subtle text-danger">
                                    <?php echo date('g:i A', strtotime($ts->ps_to_pm)) ?>
                                </span>
                            </td>

                            <td class="text-center">

                                <?php if ($this->session->userdata('is_admin')): ?>

                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        onclick="openShiftModal(
                                    '<?php echo $ts->ps_id ?>',
                                    '<?php echo $ts->ps_department ?>',
                                    '<?php echo date('H:i', strtotime($ts->ps_from)) ?>',
                                    '<?php echo date('H:i', strtotime($ts->ps_to)) ?>',
                                    '<?php echo date('H:i', strtotime($ts->ps_from_pm)) ?>',
                                    '<?php echo date('H:i', strtotime($ts->ps_to_pm)) ?>'
                                )">

                                        <i class="fa fa-edit"></i>

                                    </button>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<script type="text/javascript">
    function saveShifts() {
        var formData = {};

        $('#shiftModal .modal-body input').each(function() {
            formData[$(this).attr('name')] = $(this).val();
        });

        // ADD CSRF TOKEN
        var csrfName = $('#csrf_name').val();
        var csrfHash = $('#csrf_hash').val();

        formData[csrfName] = csrfHash;

        $.ajax({
            url: '<?= base_url() . 'hr/payroll/updatePayrollShift' ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    if (response.csrfHash) {
                        $('#csrf_hash').val(response.csrfHash);
                    }
                    showTopAlert(response.msg, response.status ? 'success' : 'danger', 'reload');
                }
            }
        })
    }

    var types = 0;



    function editTime(id, time_in, time_out) {
        if ($('#timeBtn_' + id).hasClass('saveBtn')) {
            $('#timeBtn_' + id).addClass('fa-pencil-square-o');
            $('#timeBtn_' + id).removeClass('saveBtn');
            $('#timeBtn_' + id).removeClass('fa-save');
            $('#time_in_td_' + id).removeClass('CellEditing');
            $('#time_in_td_' + id).html($('#time_in_td_' + id + ' input').val());
            $('#time_out_td_' + id).removeClass('CellEditing');
            $('#time_out_td_' + id).html($('#time_out_td_' + id + ' input').val());
        } else {
            $('#time_in_td_' + id).addClass('CellEditing');
            $('#time_in_td_' + id).html("<input type='text' style='height:30px; text-align:center' value='" + time_in + "' />");
            $('#time_out_td_' + id).addClass('CellEditing');
            $('#time_out_td_' + id).html("<input type='text' style='height:30px; text-align:center' value='" + time_out + "' />");

            $('#timeBtn_' + id).addClass('saveBtn');
            $('#timeBtn_' + id).removeClass('fa-pencil-square-o');
            $('#timeBtn_' + id).addClass('fa-save');
        }


    }

    function openShiftModal(id, group, timeIn, timeOut, timeInPM, timeOutPM) {
        $('#ps_id').val(id);
        $('#ps_department').val(group);
        $('#ps_from').val(timeIn);
        $('#ps_to').val(timeOut);
        $('#ps_from_pm').val(timeInPM);
        $('#ps_to_pm').val(timeOutPM);


        var modal = new bootstrap.Modal(document.getElementById('shiftModal'));
        modal.show();
    }
</script>