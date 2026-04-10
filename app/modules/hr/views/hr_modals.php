<div class="modal fade" id="addDepartmentModal">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-building me-2"></i>Add Department
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Department Name</label>
                    <input type="text" id="addDepartment" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Custom ID (Optional)</label>
                    <input type="text" id="idDepartment" class="form-control">
                </div>

                <small class="text-muted">
                Use this with caution.
                </small>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <button class="btn btn-success" onclick="saveDepartment('Department')">
                    <i class="fa fa-save"></i> Save
                </button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addPositionModal">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-briefcase me-2"></i>Add Position
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="dept_id" data-tbl="profile_position" data-column="position" data-pk="position_id" data-retrieve="getPosition">

                <div class="mb-3">
                    <label class="form-label">Position Name</label>
                    <input type="text" id="position_name" class="form-control">
                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <button class="btn btn-success" onclick="saveNewValue()">
                    <i class="fa fa-save"></i> Save
                </button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="shiftModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    <i class="fa fa-clock-o me-2"></i>
                    Edit Time Shift
                </h5>

                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <input type="hidden" id="ps_id" name="ps_id">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Group Name
                    </label>

                    <input
                        type="text"
                        id="ps_department"
                        name="ps_department"
                        class="form-control"
                        placeholder="Enter group name">
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Time In [AM]
                        </label>

                        <input
                            type="time"
                            id="ps_from"
                            name="ps_from"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Time Out [AM]
                        </label>

                        <input
                            type="time"
                            id="ps_to"
                            name="ps_to"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Time In [PM]
                        </label>

                        <input
                            type="time"
                            id="ps_from_pm"
                            name="ps_from_pm"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Time Out [PM]
                        </label>

                        <input
                            type="time"
                            id="ps_to_pm"
                            name="ps_to_pm"
                            class="form-control">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-light border" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success" onclick="saveShifts()">
                    <i class="fa fa-save me-1"></i> Save Changes
                </button>

            </div>

        </div>

    </div>
</div>