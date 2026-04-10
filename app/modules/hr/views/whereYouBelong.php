<?php
$is_admin = $this->session->userdata('is_admin');
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="border-bottom pb-2">Department Heads and Associates</h3>
        </div>
    </div>

    <!-- Controls Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Department -->
                <div class="col-md-3">
                    <label for="inputDepartment" class="form-label fw-semibold">Department</label>
                    <select id="inputDepartment" class="form-select">
                        <option value="">Select department</option>
                        <?php foreach ($department as $dept) { ?>
                            <option value="<?php echo $dept->dept_id; ?>">
                                <?php echo $dept->department ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Department Head -->
                <div class="col-md-4">
                    <label for="inputDepartmentHeads" class="form-label fw-semibold">Department Head</label>
                    <select id="inputDepartmentHeads" class="form-select">
                        <option value="">Select department Head</option>
                        <?php foreach ($employeeList->result() as $EL) { ?>
                            <option value="<?php echo $EL->uid; ?>">
                                <?php echo $EL->lastname . ', ' . $EL->firstname; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Associates -->
                <div class="col-md-4">
                    <label for="inputAssociates" class="form-label fw-semibold">Associates</label>
                    <select id="inputAssociates" class="form-select">
                        <option value="">Select Associates</option>
                        <?php foreach ($employeeList->result() as $EL) { ?>
                            <option value="<?php echo $EL->uid; ?>">
                                <?php echo $EL->lastname . ', ' . $EL->firstname; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-1 d-flex gap-2">
                    <button id="saveAccess"
                        onclick="saveAssociates(document.getElementById('inputDepartment').value, document.getElementById('inputDepartmentHeads').value, document.getElementById('inputAssociates').value)"
                        class="btn btn-primary w-100">
                        Add
                    </button>
                    <button id="selectEm" class="btn btn-danger w-100">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- List Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong>Department Head Assignments</strong>
        </div>
        <div class="card-body" id="whereYouBelong">
            <?php foreach ($whereYouBelong as $WYB) {
                if ($WYB->employee_id != ''):
            ?>
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary">
                            Department Head: <?php echo $WYB->lastname . ', ' . $WYB->firstname ?>
                        </h5>

                        <ol class="ps-3">
                            <?php
                            $assoc = Modules::run('hr/getAssociates', $WYB->employee_id);
                            foreach ($assoc as $assoc) { ?>
                                <li class="mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            value="<?php echo $assoc->dh_id ?>" />
                                        <label class="form-check-label">
                                            <?php echo $assoc->lastname . ', ' . $assoc->firstname ?>
                                        </label>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
            <?php
                endif;
            } ?>
        </div>
    </div>
</div>

<input type="hidden" id="selectedEm" />

<script type="text/javascript">
    function dumpInArray() {
        var arr = [];
        $('#whereYouBelong input[type="checkbox"]:checked').each(function() {
            arr.push($(this).val());
        });
        return arr;
    }

    $('#selectEm').click(function() {
        document.getElementById('selectedEm').value = (dumpInArray().join(","));
        if ($('#selectedEm').val() != "") {
            document.location = '<?php echo base_url() ?>hr/deleteAssociates/' + (dumpInArray().join(","));
        } else {
            alert('Please Select Employee First');
        }
    });

    function saveAssociates(dept, dhHead, associates) {
        var url = "<?php echo base_url() . 'hr/saveDepartmentHeadsAssociates/' ?>";

        $.ajax({
            type: "POST",
            url: url,
            data: "dept_id=" + dept + "&dhHead=" + dhHead + "&associate=" + associates + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#whereYouBelong').html(data);
                $('#notify').fadeOut(3000)
            }
        });

        return false;
    }

    $(document).ready(function() {
        $("#inputAssociates").select2({
            width: '100%'
        });
        $("#inputDepartmentHeads").select2({
            width: '100%'
        });
        $("#inputDepartment").select2({
            width: '100%'
        });
    });
</script>