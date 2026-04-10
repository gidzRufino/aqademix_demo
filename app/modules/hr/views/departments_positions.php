<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="fa fa-sitemap me-2"></i>
            List of Departments & Positions
        </h5>

        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
            <i class="fa fa-plus"></i> Add Department
        </button>

    </div>


    <div class="card-body">

        <div class="accordion" id="departmentAccordion">

            <?php foreach ($department as $dept):
                $position = Modules::run('hr/getPositionbyDepartment', $dept->dept_id);
            ?>

                <div class="accordion-item">

                    <h2 class="accordion-header" id="heading<?= $dept->dept_id ?>">

                        <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse<?= $dept->dept_id ?>">

                            <strong><?= $dept->department ?></strong>

                        </button>

                    </h2>


                    <div id="collapse<?= $dept->dept_id ?>"
                        class="accordion-collapse collapse"
                        data-bs-parent="#departmentAccordion">

                        <div class="accordion-body">

                            <!-- ACTION BUTTONS -->
                            <div class="mb-3">

                                <button class="btn btn-sm btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPositionModal"
                                    onclick="$('#dept_id').val('<?= $dept->dept_id ?>')">

                                    <i class="fa fa-plus"></i> Add Position
                                </button>

                            </div>


                            <!-- POSITION LIST -->
                            <ul class="list-group" id="<?= $dept->dept_id ?>_ol">

                                <?php foreach ($position as $pos): ?>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">

                                        <?= $pos->position ?>

                                        <span>

                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="openPositionModal('edit','<?php echo $pos->position_id ?>','<?php echo $pos->position ?>','<?php echo $pos->position_dept_id ?>')">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-danger" onclick="openPositionModal('delete','<?php echo $pos->position_id ?>','<?php echo $pos->position ?>','<?php echo $pos->position_dept_id ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </span>

                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<style>
    .popover {
        width: 75%
    }
</style>

<script type="text/javascript">
    $(function() {
        $('[rel="clickoverDept"]').clickover({
            placement: 'bottom',
            html: true
        });
    })


    function saveNewValue() {
        var input = $('#dept_id');
        var data = {
            db_table: input.data('tbl'),
            db_column: input.data('column'),
            pk: input.data('pk'),
            retrieve: input.data('retrieve'),
            dept_id: input.val()
        }

        var db_value = $('#position_name').val()
        var url = "<?php echo base_url() . 'hr/saveNewValue/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "table=" + data.db_table + "&column=" + data.db_column + "&value=" + db_value + "&pk=" + data.pk + "&retrieve=" + data.retrieve + "&dept_id=" + data.dept_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'danger', 'reload');
            }
        });

        return false;

    }

    function saveDepartment(table) {

        var department = $('#add' + table).val();
        var customized_id = $('#id' + table).val();

        var url = "<?php echo base_url() . 'hr/saveDepartment/' ?>";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                department: department,
                customized_id: customized_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: "json",
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'warning', 'reload');
                // location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                showTopAlert('Error', 'danger');
            }
        });

        return false;
    }
</script>