<!-- Add Section Modal -->
<div id="addSection" class="modal fade" tabindex="-1" aria-labelledby="addSectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addSectionLabel">Add Section</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="txtAddSection" class="form-control" placeholder="Section Name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addSection()">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div id="addEditSection" class="modal fade" tabindex="-1" aria-labelledby="editSectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editSectionLabel">Edit Section</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="eSec" class="form-control" placeholder="Section Name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="editSection()">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div id="addCourse" class="modal fade" tabindex="-1" aria-labelledby="addCourseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="addCourseLabel">Add Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="inputCourse" class="form-label">Course</label>
                    <input type="text" class="form-control" id="inputCourse" placeholder="Course" required>
                </div>
                <div class="mb-3">
                    <label for="inputShortCode" class="form-label">Short Code</label>
                    <input type="text" class="form-control" id="inputShortCode" placeholder="Short Code" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addCourse()">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>