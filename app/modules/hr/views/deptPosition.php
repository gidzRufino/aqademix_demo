<!-- Edit/Delete Position Modal -->
<div class="modal fade" id="positionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-gradient bg-primary text-white">

                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-briefcase fa-lg"></i>
                    <div>
                        <h5 class="modal-title mb-0" id="positionModalTitle"></h5>
                        <small class="opacity-75">Department Position Management</small>
                    </div>
                </div>

                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- HIDDEN DATA -->
            <input type="hidden" id="editOption">
            <input type="hidden" id="posID">

            <!-- BODY -->
            <div class="modal-body px-4 py-4">

                <div class="card border-0 bg-light rounded-3 p-3">

                    <!-- CURRENT POSITION -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">
                            <i class="fa fa-user-tie me-1"></i> Current Position
                        </label>

                        <input
                            type="text"
                            id="currentPosition"
                            class="form-control form-control-lg bg-white"
                            readonly>
                    </div>

                    <!-- EDIT FIELD -->
                    <div class="mb-3" id="editField">
                        <label class="form-label fw-semibold text-secondary">
                            <i class="fa fa-edit me-1"></i> New Position Name
                        </label>

                        <input
                            type="text"
                            id="newPosition"
                            class="form-control form-control-lg"
                            placeholder="Enter new position name">
                    </div>

                </div>

                <!-- DELETE WARNING -->
                <div id="deleteWarning"
                    class="alert alert-danger mt-4 d-none d-flex align-items-center">

                    <i class="fa fa-exclamation-triangle fa-lg me-3"></i>

                    <div>
                        <strong>Warning:</strong><br>
                        This action will permanently delete this position.
                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer px-4 py-3">

                <button class="btn btn-light border"
                    data-bs-dismiss="modal">

                    <i class="fa fa-times me-1"></i>
                    Cancel

                </button>

                <button class="btn btn-success px-4"
                    id="actionBtn">

                    <i class="fa fa-check me-1"></i>
                    Confirm

                </button>

            </div>

        </div>
    </div>
</div>

<script type='text/javascript'>
    function newPosition(id, value) {
        $('#newPosition').attr('disabled', false);
        $('#newPosition').val(value);
        $('#posID').val(id);
    }

    function updatePosition(action, pid, pDesc) {
        var url = "<?php echo base_url('hr/editDeptPosition'); ?>/" +
            pid + "/" +
            encodeURIComponent(pDesc) + "/" +
            action;

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",

            success: function(response) {
                showTopAlert(
                    response.msg,
                    response.status ? "success" : "danger",
                    "reload"
                );
            },

            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while updating the position.");
            }
        });
    }

    function openPositionModal(action, id, position, dept) {
        $('#editOption').val(action);
        $('#posID').val(id);

        $('#currentPosition').val(position);
        $('#newPosition').val(position);

        if (action === 'edit') {
            $('#positionModalTitle').text('Edit Position');

            $('#editField').show();
            $('#deleteWarning').addClass('d-none');

            $('#actionBtn')
                .removeClass('btn-danger')
                .addClass('btn-success')
                .html('<i class="fa fa-save me-1"></i> Update');
        } else {
            $('#positionModalTitle').text('Delete Position');

            $('#editField').hide();
            $('#deleteWarning').removeClass('d-none');

            $('#actionBtn')
                .removeClass('btn-success')
                .addClass('btn-danger')
                .html('<i class="fa fa-trash me-1"></i> Delete');
        }

        new bootstrap.Modal('#positionModal').show();
    }

    $('#positionList').on('change', function() {

        let id = $('option:selected', this).data('id');
        let value = this.value;

        $('#posID').val(id);
        $('#newPosition').val(value);

    });

    $('#actionBtn').click(function() {

        let action = $('#editOption').val();
        let posID = $('#posID').val();
        let newPosition = $('#newPosition').val();

        updatePosition(action, posID, newPosition);

    });
</script>