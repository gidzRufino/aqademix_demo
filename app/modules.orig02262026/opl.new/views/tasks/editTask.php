<!---- Add me to opl/views/tasks ---->
<div class="modal fade" id="editTasks" tabindex="-1" aria-labelledby="editTasksLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editTasksLabel">
                    <i class="fas fa-tasks"></i> Edit Task
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Hidden Field -->
            <input type="hidden" id="taskSy" value="<?= $this->session->school_year; ?>">

            <!-- Body -->
            <div class="modal-body">
                <form id="editTasksForm" class="row g-3">

                    <!-- Task Title -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-heading me-2 text-primary"></i> Task Title
                        </label>
                        <input type="text" class="form-control rounded-pill w-100"
                            id="taskTitle" name="taskTitle"
                            placeholder="Enter task title">
                    </div>

                    <!-- Task Type -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tasks me-2 text-primary"></i> Task Type
                        </label>
                        <select id="taskType" name="taskType" class="form-select rounded-pill w-100">
                            <?php foreach (Modules::run('opl/opl_variables/getTaskType') as $tt): ?>
                                <option value="<?= $tt->tt_id ?>"><?= $tt->tt_type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Grading Term -->
                    <div class="col-12 col-lg-6">
                        <label for="taskTerm" class="form-label fw-semibold">
                            <i class="fas fa-graduation-cap me-2 text-primary"></i> Grading
                        </label>
                        <select id="taskTerm" name="taskTerm" class="form-select rounded-pill w-100">
                            <option>Select Grading</option>
                            <option value="1">1st Grading</option>
                            <option value="2">2nd Grading</option>
                            <option value="3">3rd Grading</option>
                            <option value="4">4th Grading</option>
                        </select>
                    </div>

                    <!-- Subject / Section -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-book-open me-2 text-primary"></i> Subject / Grade / Section
                        </label>
                        <select id="taskGrade" name="taskGrade" class="form-select rounded-pill w-100" onchange="fetchLesson(this.value)">
                            <option value="">Select...</option>
                            <?php foreach (Modules::run('opl/opl_widgets/mySubject', $this->session->username, NULL) as $gl): ?>
                                <option value="<?= $gl->subject_id . '-' . $gl->grade_id . '-' . $gl->section_id ?>">
                                    <?= $gl->subject . ' - ' . $gl->level . ' [' . $gl->section . ']' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Link to Unit -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-link me-2 text-primary"></i> Link to Unit
                        </label>
                        <select id="taskUnitLink" name="taskUnitLink" class="form-select rounded-pill w-100">
                            <?php foreach ($unitDetails as $ud): ?>
                                <option value="<?= $ud->ou_opl_code ?>"><?= $ud->ou_unit_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Submission Type -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-file-alt me-2 text-primary"></i> Submission Type
                        </label>
                        <select class="form-select rounded-pill w-100" name="submissionType" id="submissionType" required>
                            <option value="1">Use Editor</option>
                            <option value="2">File Submission</option>
                            <option value="3">Online Quiz Form</option>
                        </select>
                    </div>

                    <!-- Number of Items -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-list-ol me-2 text-primary"></i> Number of Items
                        </label>
                        <input type="number" class="form-control rounded-pill w-100"
                            id="numItems" name="numItems"
                            placeholder="Enter number of items" min="1">
                    </div>

                    <!-- GS Component -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-list-ol me-2 text-primary"></i> GS Component
                        </label>
                        <select class="form-select rounded-pill w-100"
                            name="gsComponent"
                            id="gsComponent"
                            required>
                            <option value="">Select Component</option>
                        </select>
                    </div>
                    <!-- <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-list-ol me-2 text-primary"></i> GS Component
                        </label>
                        <select class="form-select rounded-pill w-100" name="gsComponent" id="gsComponent" required>
                            <option value="">Select Component</option>
                        </select>
                    </div> -->

                    <!-- Task Details -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-align-left me-2 text-primary"></i> Task Details
                        </label>
                        <textarea class="form-control rounded-3 w-100" id="taskDetails" name="taskDetails" rows="4"
                            placeholder="Write the task details here..."></textarea>
                    </div>

                    <!-- File Attachment -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-paperclip me-2 text-primary"></i> File Attachment <small class="text-muted">(Optional)</small>
                        </label>
                        <input class="form-control rounded-pill w-100" type="file" id="userfile" name="userfile" onchange="uploadFile(this)">
                        <input type="hidden" id="currentAttachment" name="currentAttachment">
                        <small id="attachmentPreview" class="text-muted"></small>
                    </div>

                    <!-- Start Date -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-day me-2 text-primary"></i> Start Date
                        </label>
                        <input type="date" class="form-control rounded-pill w-100" id="taskStartDate" name="taskStartDate">
                    </div>

                    <!-- Start Time -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-clock me-2 text-primary"></i> Start Time
                        </label>
                        <input type="time" class="form-control rounded-pill w-100" id="taskTimeStart" name="taskTimeStart">
                    </div>

                    <!-- Deadline Date -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-check me-2 text-primary"></i> Deadline Date
                        </label>
                        <input type="date" class="form-control rounded-pill w-100" id="taskEndDate" name="taskEndDate">
                    </div>

                    <!-- Deadline Time -->
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-hourglass-end me-2 text-primary"></i> Deadline Time
                        </label>
                        <input type="time" class="form-control rounded-pill w-100" id="taskTimeEnd" name="taskTimeEnd">
                    </div>

                    <input type="hidden" id="taskCode" name="taskCode">
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="goPublic">
                    <label class="form-check-label" for="goPublic">Go Public</label>
                </div>
                <div>
                    <button type="button" class="btn btn-success px-4" onclick="editTasks()">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal" id='deleteTask' tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h1><i class="fa fa-exclamation text-danger"></i></h1>
                <h5>You are deleting the task <span id="task-title"></span>.</h4>
                    <small>Note: This cannot be undone</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteTask(this)">Delete</button>
                <button type="button" class="btn btn-secondary" onclick="$(this).parent().find('#deleteBtn').removeAttr('task-code'), $(this).parent().prev().find('#task-title').html('');" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<script>
    function getComponent(value, component_id) {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/getAssessCatDropdown/' + value + '/' + school_year + '/' + component_id;
        $.ajax({
            type: "GET",
            url: url,
            data: '',
            success: function(data) {
                $('#gsComponent').html(data);
            }
        });
    }

    function uploadFile(input) {
        var file = $(input)[0].files[0],
            fd = new FormData(),
            base = $('#base').val(),
            grade = $("#taskGrade").val(),
            code = $("#taskCode").val();

        fd.append('code', code);
        fd.append("file", file);
        fd.append('grade', grade);
        fd.append("uploadType", "Task");
        fd.append("csrf_test_name", $.cookie("csrf_cookie_name"));

        var url = base + "opl/uploadFile";

        $.ajax({
            url: url,
            dataType: "JSON",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                alert(data.msg);
            }
        })

    }

    $(function() {
        $('.textarea').summernote();
        $('.timePick').clockpicker({
            placement: 'top',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
    });

    function toPDF(btn) {
        var code = $(btn).attr('task-code'),
            base = $("#base").val();
        window.open(base + "/opl/taskPDF/" + code);
    }

    function fetchLesson(value) {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/opl_variables/fetchLesson/' + value + '/' + school_year;
        $.ajax({
            type: "GET",
            url: url,
            data: '',
            success: function(data) {
                $('#taskUnitLink').html(data);
            }
        });
    }

    function showEditModal(btn) {
        let sgls = $(btn).attr("task-sgls"),
            startdate = $(btn).attr('task-start-date'),
            enddate = $(btn).attr('task-end-date'),
            starttime = $(btn).attr('task-start-time'),
            endtime = $(btn).attr('task-end-time'),
            totalitem = $(btn).attr('task-total-item'),
            attachment = $(btn).attr('task-attachments'),
            component = $(btn).attr('task-gsComponent');
        getComponent(sgls, component);
        console.info(startdate);
        $("#editTasks").find("#taskTitle").val($(btn).attr("task-title"));
        $("#editTasks").find("#taskType > [value='" + $(btn).attr("task-type") + "']").attr("selected", "true");
        $("#editTasks").find("#taskTerm > [value='" + $(btn).attr("task-term") + "']").attr("selected", "true");
        // $('#editTasks').find("#gsComponent > [value='" + component + "']").attr("selected", "true");
        // $("#editTasks").find("#taskType").val($(btn).attr("task-type"));
        $("#editTasks").find("#taskDetails").summernote('code', $(btn).attr("task-details"));
        $("#editTasks").find("#taskCode").val($(btn).attr("task-code"));
        $("#editTasks").find("#taskGrade").val(sgls);
        $("#editTasks").find("#taskStartDate ").val(startdate);
        $("#editTasks").find("#taskEndDate").val(enddate);
        $("#editTasks").find("#taskTimeStart").val(starttime);
        $("#editTasks").find("#taskTimeEnd").val(endtime);
        $('#editTasks').find("#numItems").val(totalitem);
        $('#editTasks').find("#currentAttachment").val(attachment);
        $('#editTasks').find("#attachmentPreview").text("Current file: " + attachment);
        fetchLesson(sgls);
        $("#editTasks").modal();
    }

    function editTasks() {
        let formData = new FormData($('#editTasksForm')[0]),
            base = $("#base").val(),
            url = base + "/opl/updateTasks",
            goPublic = 0;

        if ($('#goPublic').is(':checked')) {
            goPublic = 1;
        }

        // Add extra values
        formData.append('isPublic', goPublic);
        formData.append('csrf_test_name', $.cookie('csrf_cookie_name'));

        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false, // required
            processData: false, // required
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                alert(data.message);
                location.reload();
            }
        });
    }

    function showDeleteModal(btn, page = null) {
        let code = $(btn).attr('task-code'),
            title = $(btn).attr('task-title'),
            modal = $("#deleteTask");
        modal.find("#task-title").html(title);
        modal.find("#deleteBtn").attr("task-page", page);
        modal.find("#deleteBtn").attr("task-code", code);
        if (page == 1) {
            let grade = $(btn).attr('task-grade'),
                section = $(btn).attr('task-section'),
                subject = $(btn).attr('task-subject');
            modal.find("#deleteBtn").attr('task-grade', grade);
            modal.find("#deleteBtn").attr('task-section', section);
            modal.find("#deleteBtn").attr('task-subject', subject);
        }
        modal.modal();
    }

    function deleteTask(btn) {
        let code = $(btn).attr('task-code'),
            page = $(btn).attr('task-page');
        base = $("#base").val(),
            url = base + "/opl/deleteTasks";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                code: code,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                alert(data.message);
                if (page == 1) {
                    let grade = $(btn).attr('task-grade'),
                        section = $(btn).attr('task-section'),
                        subject = $(btn).attr('task-subject');
                    document.location = base + "/opl/classBulletin/2020/List/" + grade + "/" + section + "/" + subject;
                } else {
                    location.reload();
                }
            }
        });
    }
</script>
<style>
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: #fff;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
    }

    .modal-title i {
        margin-right: 8px;
    }

    .btn-close-white {
        filter: invert(1);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #4a4a4a;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 0.55rem 0.75rem;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .modal-footer {
        border-top: none;
        background-color: #f8f9fc;
        padding: 1rem 1.5rem;
    }

    .form-check-label {
        font-weight: 500;
    }

    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>