<div class="modal fade" id="addSHSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content shadow border-0 rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">Add Senior High Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-2">
                <label class="form-label small text-muted">Select Subject</label>
                <input
                    type="text"
                    id="addedSHSubjects"
                    class="form-control form-control-lg rounded-3"
                    placeholder="Search or select subject"
                    multiple>
            </div>

            <div class="modal-footer border-0">
                <button
                    class="btn btn-light rounded-3 px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
                <button
                    id="<?php echo $g->grade_id ?>"
                    onclick="saveSubjectPerLevel()"
                    class="btn btn-success rounded-3 px-4">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content shadow border-0 rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-2">
                <label class="form-label small text-muted">Select Subject</label>

                <select
                    id="addedSubjects"
                    class="form-control form-control-lg rounded-3"
                    multiple="multiple"
                    style="width:100%;">
                </select>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button
                    id="<?php echo $g->grade_id ?>"
                    onclick="saveSubjectPerLevel()"
                    class="btn btn-primary rounded-3 px-4">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCollegeSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow border-0 rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">Add College Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-2">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small text-muted">Subject Code</label>
                        <input type="text" id="inputSubjectCode" class="form-control rounded-3" placeholder="e.g. IT101" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">Descriptive Title</label>
                        <input type="text" id="inputDesc" class="form-control rounded-3" placeholder="Subject Title" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">Lecture Units</label>
                        <input type="number" id="inputLectureUnits" class="form-control rounded-3" placeholder="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">Lab Units</label>
                        <input type="number" id="inputLabUnits" class="form-control rounded-3" placeholder="0" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label small text-muted">Pre-Requisite Subject</label>
                        <input type="text" id="inputPreR" class="form-control rounded-3" placeholder="Optional">
                    </div>

                </div>

            </div>

            <div class="modal-footer border-0">
                <button
                    class="btn btn-light rounded-3 px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
                <button
                    id="<?php echo $g->grade_id ?>"
                    onclick="addCollegeSubjects()"
                    class="btn btn-success rounded-3 px-4">
                    Save Subject
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="addNewSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h6 class="modal-title fw-semibold">Add Subject</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Subject Name</label>
                    <input type="text" id="inputAddSubject" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject Code</label>
                    <input type="text" id="AddSubjectCode" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button onclick="addSubject()" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="editSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h6 class="modal-title fw-semibold">Edit Subject</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="sub_id">

                <div class="mb-3">
                    <label class="form-label">Subject Name</label>
                    <input type="text" id="subject" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject Code</label>
                    <input type="text" id="subjectCode" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button onclick="editSubject()" class="btn btn-primary">Update</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="deleteSubject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-danger text-white">
                <h6 class="modal-title">Confirm Delete</h6>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-0">
                    Are you sure you want to delete this subject?<br>
                    <small class="text-muted">This action cannot be undone.</small>
                </p>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button onclick="deleteSubject()" class="btn btn-danger">Delete</button>
            </div>

        </div>
    </div>
</div>

<style>
    .modal-content {
        transition: all 0.2s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .15);
        border-color: #86b7fe;
    }
</style>