<section>
    <div class="card card-outline card-blue shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="nav-icon fas fa-tasks"></i> Rubric List</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-striped table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Name of Rubric</th>
                        <th class="text-center" style="width: 150px;">Number of Criteria</th>
                        <th class="text-center" style="width: 150px;">Type</th>
                        <th class="text-center" style="width: 120px;">Scale</th>
                        <th class="text-center" style="width: 150px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $cnt = count($list);
                    if ($cnt != 0):
                        foreach ($list as $rb):
                            $criteria = Modules::run('opl/getRubricCriteria', $rb->ruid, $school_year);
                    ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <i class="fa fa-ellipsis-v text-muted"></i>
                                    <i class="fa fa-ellipsis-v text-muted"></i>
                                </td>
                                <td class="align-middle"
                                    onclick="document.location='<?php echo base_url('opl/rubricDetails/' . $school_year . '/' . $rb->ruid) ?>'"
                                    style="cursor: pointer;">
                                    <?php echo $rb->ru_alias ?>
                                </td>
                                <td class="text-center align-middle"><?php echo $criteria->num_rows() ?></td>
                                <td class="text-center align-middle">
                                    <?php echo ($rb->ru_type ? 'Project Type' : 'In Test Type') ?>
                                </td>
                                <td class="text-center align-middle"><?php echo '1 - ' . $rb->ri_scale ?></td>
                                <td class="text-center align-middle">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info text-white"
                                            title="Edit Rubric"
                                            onclick="openEditModal('<?php echo $rb->ruid ?>','<?= $rb->ru_alias ?>','<?= $rb->ru_type ?>', '<?= $rb->ri_scale ?>')">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger text-white"
                                            title="Delete Rubric"
                                            onclick="deleteRubric('<?php echo $rb->ruid ?>')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td class="text-center" colspan="6">
                                <h5 class="text-muted my-3">No Rubrics Listed</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- =======================
     EDIT RUBRIC MODAL
======================= -->
<div class="modal fade" id="editRubricModal" tabindex="-1" role="dialog" aria-labelledby="editRubricLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="editRubricLabel"><i class="fa fa-edit"></i> Edit Rubric</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRubricForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_ruid" name="ruid">
                    <div class="form-group">
                        <label for="edit_ru_alias">Rubric Name</label>
                        <input type="text" id="edit_ru_alias" name="ru_alias" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ru_type">Rubric Type</label>
                        <select id="edit_ru_type" name="ru_type" class="form-control">
                            <option value="0">In Test Type</option>
                            <option value="1">Project Type</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_ri_scale">Scale</label>
                        <input type="number" id="edit_ri_scale" name="ri_scale" class="form-control" min="1" placeholder="e.g.5 or 10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $this->load->view('tasks/editTask'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('.dateTime').each(function() {
            var id = $(this).attr('task_id');
            var dateTime = $(this).val();
            getCountDown(id, dateTime);
        });

    });


    function getCountDown(id, dateTime) {
        // Set the date we're counting down to
        var countDownDate = new Date(dateTime).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {


            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            var d = (days === 0 ? "" : days + "d ");

            document.getElementById("op_id_" + id).innerHTML = d + hours + "h " +
                minutes + "m ";
            //            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
            //                    + minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
                $('#op_id_' + id).html(dateTime);
            }
        }, 1000);
    };

    function openEditModal(ruid, alias, type, scale) {
        $('#edit_ruid').val(ruid);
        $('#edit_ru_alias').val(alias);
        $('#edit_ru_type').val(type);
        $('#edit_ri_scale').val(scale);
        $('#editRubricModal').modal('show');
    }

    $('#editRubricForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('opl/updateRubric') ?>",
            type: "POST",
            data: $(this).serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(response) {
                $('#editRubricModal').modal('hide');
                alert('Rubric updated successfully!');
                location.reload();
            },
            error: function() {
                alert('Error updating rubric. Please try again.');
            }
        });
    });

    function deleteRubric(ruid) {
        if (confirm('Are you sure you want to delete this rubric?')) {
            // Example AJAX call
            $.ajax({
                url: "<?php echo base_url('opl/deleteRubric') ?>",
                type: "POST",
                data: 'code=' + ruid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function(response) {
                    alert('Rubric deleted successfully!');
                    location.reload();
                },
                error: function() {
                    alert('Failed to delete rubric. Please try again.');
                }
            });
        }
    }
</script>