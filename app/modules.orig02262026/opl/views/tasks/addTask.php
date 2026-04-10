<section id="gvDetails" class="card shadow border-0 mb-4">
    <?php
    echo form_open(base_url('opl/addTask'), [
        'id' => 'addTaskForm',
        'onsubmit' => 'event.preventDefault();'
    ]);
    ?>

    <!-- HEADER -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-tasks mr-2"></i> Add a Task</h5>
            <small class="text-light">Things you want students to do</small>
        </div>
        <div style="min-width: 160px;">
            <select id="inputTerm" class="form-control form-control-sm hasValue">
                <option value="">Grading Period</option>
                <option value="1" <?= $this->session->term == 1 ? 'selected' : '' ?>>First</option>
                <option value="2" <?= $this->session->term == 2 ? 'selected' : '' ?>>Second</option>
                <option value="3" <?= $this->session->term == 3 ? 'selected' : '' ?>>Third</option>
                <option value="4" <?= $this->session->term == 4 ? 'selected' : '' ?>>Fourth</option>
            </select>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body bg-light">
        <div class="form-row">

            <!-- Task Title -->
            <div class="form-group col-md-6">
                <label for="taskTitle">Task Title</label>
                <input type="text" class="form-control hasValue" id="taskTitle" placeholder="Enter task title" required>
            </div>

            <!-- Task Type -->
            <div class="form-group col-md-3">
                <label for="taskType">Task Type</label>
                <select id="taskType" class="form-control hasValue">
                    <?php foreach ($task_type as $tt): ?>
                        <option value="<?= $tt->tt_id ?>"><?= $tt->tt_type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Marking Type -->
            <div class="form-group col-md-3">
                <label for="markType">Marking Type</label>
                <select id="markType" class="form-control hasValue" required>
                    <option value="">Select</option>
                    <option value="0">Point System</option>
                    <option value="1">Comment System</option>
                    <option value="2">Rubric System</option>
                </select>
            </div>

            <!-- Link to Unit -->
            <div class="form-group col-md-6">
                <label for="unitLink">Link to Unit</label>
                <select id="unitLink" class="form-control hasValue">
                    <option value="">Select a Unit</option>
                    <?php foreach ($unitDetails as $ud): ?>
                        <option value="<?= $ud->ou_opl_code ?>"><?= $ud->ou_unit_title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- GS Component -->
            <div class="form-group col-md-3">
                <label for="gsComponent">GS Component</label>
                <select id="gsComponent" class="form-control hasValue" required>
                    <option value="">Select Component</option>
                </select>
            </div>

            <!-- Number of Items -->
            <div class="form-group col-md-3">
                <label for="numItems">Number of Items</label>
                <input type="number" class="form-control hasValue" id="numItems" placeholder="Total score">
            </div>

            <!-- Rubric System (Inline Search Results) -->
            <div class="form-group col-md-6" id="rubricSystem" style="display:none;">
                <label for="rubricBox">Select or Search a Rubric</label>
                <div class="input-group">
                    <input
                        type="text"
                        id="rubricBox"
                        class="form-control"
                        placeholder="Search rubric..."
                        onkeyup="searchARubric(this.value)">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearRubricSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <small class="form-text text-muted">Start typing to search existing rubrics.</small>

                <!-- Inline Search Results -->
                <div id="rubricResults"
                    class="border rounded bg-white mt-2 p-2 shadow-sm"
                    style="display:none; max-height: 200px; overflow-y:auto;">
                </div>

                <input type="hidden" id="ruid" />
            </div>

            <!-- Submission Type -->
            <div class="form-group col-md-6" id="submissionWrapper">
                <label for="submissionType">Submission Type</label>
                <select id="submissionType" class="form-control hasValue">
                    <option value="">Select Type</option>
                    <option value="1" selected>Use Editor</option>
                    <option value="2">File Submission</option>
                    <option value="3">Online Quiz Form</option>
                </select>
            </div>

            <!-- Task Details -->
            <div class="form-group col-md-12" id="onlineEditor">
                <label for="taskDetails">Task Details</label>
                <textarea class="form-control textarea hasValue" id="taskDetails" rows="6" placeholder="Write task details here..."></textarea>
            </div>

            <!-- Quiz Search -->
            <div class="form-group col-md-12" id="quizWrapper" style="display:none;">
                <label for="searchBox">Search a Quiz</label>
                <input type="text" id="searchBox" class="form-control" placeholder="Search quiz..." onkeyup="searchAQuiz(this.value)">
                <div id="searchQuestions" class="border rounded mt-1 p-2 bg-white" style="display:none;"></div>
                <input type="hidden" id="quiz_id" />
            </div>

            <!-- File Upload -->
            <div class="form-group col-md-6">
                <label for="userfile">File Attachment <small class="text-muted">(optional)</small></label>
                <input class="form-control" type="file" name="userfile" id="userfile">
            </div>

            <!-- Start & Deadline -->
            <div class="form-group col-md-3">
                <label>Start Date</label>
                <input type="date" class="form-control hasValue" id="startDate">
            </div>
            <div class="form-group col-md-3">
                <label>Start Time</label>
                <input type="time" class="form-control hasValue timePick" id="timeStart">
            </div>
            <div class="form-group col-md-3">
                <label>Deadline Date</label>
                <input type="date" class="form-control hasValue" id="deadlineDate">
            </div>
            <div class="form-group col-md-3">
                <label>Deadline Time</label>
                <input type="time" class="form-control hasValue timePick" id="timeDeadline">
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="card-footer d-flex justify-content-between align-items-center bg-white">
        <div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="goPublic" onchange="togglePublicIcon(this)">
                <label class="custom-control-label" for="goPublic">
                    <i id="publicIcon" class="fa fa-lock text-danger mr-1"></i>
                    <span id="publicText">Private</span>
                </label>
            </div>
        </div>
        <button type="button" class="btn btn-success btn-sm px-4" onclick="postAndUploadTask()">
            <i class="fas fa-paper-plane"></i> Post Task
        </button>
    </div>

    <?php echo form_close(); ?>
</section>

<!-- RUBRIC SEARCH MODAL -->
<div class="modal fade" id="rubricModal" tabindex="-1" role="dialog" aria-labelledby="rubricModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title" id="rubricModalLabel"><i class="fas fa-th-list"></i> Rubric Library</h6>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="searchRubric">
                <p class="text-muted">Start typing in the rubric search box above to load results here...</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhancements for Bootstrap 3 */
    .rubric-hover:hover {
        background: #f1f5ff;
        cursor: pointer;
        border-radius: 4px;
    }

    #rubricResults::-webkit-scrollbar {
        width: 6px;
    }

    #rubricResults::-webkit-scrollbar-thumb {
        background-color: #ced4da;
        border-radius: 3px;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .textarea {
        border-radius: 0.5rem;
    }

    .shadow-sm {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .bg-primary {
        background: #337ab7;
    }

    /* Bootstrap 3 primary */
    .text-white {
        color: #fff !important;
    }

    .text-light {
        color: #f9f9f9;
    }

    .bg-light {
        background: #f5f5f5;
    }

    .panel-title {
        font-weight: 600;
    }

    .form-group label {
        font-weight: 500;
    }

    /* Rounded inputs and buttons */
    .form-control {
        border-radius: 20px !important;
        padding: 8px 14px;
    }

    .btn {
        border-radius: 20px !important;
        padding: 6px 16px;
    }

    select.form-control {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 12px;
    }

    .bg-primary {
        background: #337ab7;
    }

    /* Bootstrap 3 primary */
    .text-white {
        color: #fff !important;
    }

    .text-light {
        color: #e9f2fa;
    }

    .rounded {
        border-radius: 20px !important;
    }

    .panel-title {
        font-weight: 600;
    }

    /* Header styling */
    .enhanced-header {
        background: linear-gradient(135deg, #337ab7, #265a88);
        color: #fff;
        border-radius: 6px 6px 0 0;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .enhanced-header .panel-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        line-height: 1.2;
    }

    .enhanced-header .glyphicon {
        margin-right: 6px;
    }

    .header-subtext {
        display: block;
        font-size: 12px;
        color: #e9f2fa;
        margin-top: 2px;
    }

    .header-select {
        border-radius: 20px !important;
        border: none;
        padding: 6px 10px;
        width: 100%;
        /* full width on xs */
    }

    @media (min-width: 768px) {
        .header-select {
            width: auto;
            /* auto-fit on sm and up */
        }
    }

    /* Body */
    .enhanced-body {
        background: #fafafa;
        border-radius: 0 0 6px 6px;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 20px !important;
        box-shadow: none;
        transition: border 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #337ab7;
        box-shadow: 0 0 6px rgba(51, 122, 183, 0.4);
    }

    textarea.form-control {
        border-radius: 12px !important;
    }

    label.control-label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    /* Footer */
    .enhanced-footer {
        background: #f9f9f9;
        border-top: 1px solid #e0e0e0;
        padding: 10px 15px;
        border-radius: 0 0 6px 6px;
    }

    /* Flex vertical centering */
    .vcenter {
        display: flex;
        flex-wrap: wrap;
        /* allow stacking */
        align-items: center;
    }

    /* Toggle switch */
    .switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        color: #555;
        margin: 5px 0;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: relative;
        width: 40px;
        height: 20px;
        background: #ccc;
        border-radius: 20px;
        transition: background 0.3s;
        margin-right: 8px;
    }

    .slider:before {
        content: "";
        position: absolute;
        top: 2px;
        left: 2px;
        width: 16px;
        height: 16px;
        background: #fff;
        border-radius: 50%;
        transition: transform 0.3s;
    }

    /* Checked state */
    .switch input:checked+.slider {
        background: #5cb85c;
    }

    .switch input:checked+.slider:before {
        transform: translateX(20px);
    }

    .switch-label {
        font-size: 13px;
    }

    /* Button */
    .footer-btn {
        border-radius: 20px !important;
        padding: 8px 14px;
        font-weight: 600;
        margin: 5px 0;
        transition: background 0.2s, box-shadow 0.2s;
    }

    /* Hover effect */
    .footer-btn:hover {
        background: #449d44;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    /* Mobile: full width button */
    @media (max-width: 767px) {
        .footer-btn {
            display: block;
            width: 100%;
            border-radius: 6px !important;
            /* less pill-like for mobile */
        }
    }

    /* global wrapper */
    .custom-select-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .custom-select-wrapper select {
        position: relative;
        z-index: 1;
        padding-right: 32px;
        /* leave room for caret inside */
    }

    /* caret position */
    .custom-select-wrapper .select-icon {
        position: absolute;
        right: 10px;
        /* move it inside, not outside */
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 14px;
        z-index: 2;
        color: #555;
    }

    /* header-specific caret color (white on dark background) */
    .enhanced-header .custom-select-wrapper .select-icon {
        color: #555 !important;
    }

    /* caret default */
    .custom-select-wrapper .select-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 14px;
        color: #555;
        transition: transform 0.2s ease;
    }

    /* when active (focus), flip it up */
    .custom-select-wrapper.open .select-icon {
        transform: translateY(-50%) rotate(180deg);
    }
</style>


<!-- Hidden values -->
<input type="hidden" id="grade_level_id" value="<?php echo $grade_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $section_id ?>" />
<input type="hidden" id="subject_id" value="<?php echo $subj_id ?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />


<script type="text/javascript">
    // get all custom selects
    const wrappers = document.querySelectorAll('.custom-select-wrapper');

    wrappers.forEach(wrapper => {
        const select = wrapper.querySelector('select');

        // when user clicks the select, flip caret up
        select.addEventListener('mousedown', function() {
            wrapper.classList.add('open');
        });

        // when user changes (picks option), flip caret down
        select.addEventListener('change', function() {
            wrapper.classList.remove('open');
        });
    });

    // close caret if click happens outside any custom-select-wrapper
    document.addEventListener('click', function(e) {
        wrappers.forEach(wrapper => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });
    });

    document.querySelectorAll('.custom-select-wrapper select').forEach(sel => {
        sel.addEventListener('focus', function() {
            this.parentElement.classList.add('open');
        });
        sel.addEventListener('blur', function() {
            this.parentElement.classList.remove('open');
        });
    });

    $(function() {
        // Summernote
        fetchLesson('<?php echo $subj_id . '-' . $grade_id . '-' . $section_id ?>')
        getComponent('<?php echo $subj_id . '-' . $grade_id . '-' . $section_id ?>')
        $('.textarea').summernote();

        $('.timePick').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
        $('#gradeLevel').on('select2:select', function(e) {
            fetchLesson($(this).val());
            getComponent($(this).val());
        });

        // $('#markType').on('select2:select', function(e) {
        $('#markType').on('change', function(e) {
            switch ($(this).val()) {
                case '0':
                    $('#rubricSystem').hide();
                    $('#rubricBox').removeClass('hasValue');
                    $('#submissionWrapper').removeClass('col-lg-3');
                    $('#submissionWrapper').addClass('col-lg-6');
                    break;
                case '1':
                    $('#rubricSystem').hide();
                    $('#rubricBox').removeClass('hasValue');
                    $('#submissionWrapper').removeClass('col-lg-3');
                    $('#submissionWrapper').addClass('col-lg-6');

                    break;
                case '2':
                    $('#rubricSystem').show();
                    $('#rubricBox').addClass('hasValue');
                    $('#submissionWrapper').removeClass('col-lg-6');
                    $('#submissionWrapper').addClass('col-lg-3');
                    break;
            }

        });

        $('#submissionType').on('change', function(e) {
            if ($(this).val() == 3) {
                $('#quizWrapper').show();
            } else {
                $('#quizWrapper').hide();
            }
        });


        // searchARubric = function(value) {

        //     var url = "<?php echo base_url() . 'opl/searchARubric/' ?>" + value + '/' + '<?php echo $school_year ?>';
        //     $.ajax({
        //         type: "GET",
        //         url: url,
        //         data: {
        //             csrf_test_name: $.cookie('csrf_cookie_name')
        //         },
        //         success: function(data) {
        //             $('#searchRubric').show();
        //             $('#searchRubric').html(data);

        //         }
        //     });
        // };


        searchAQuiz = function(value) {

            var url = "<?php echo base_url() . 'opl/qm/searchAQuiz/' ?>" + value + '/' + '<?php echo $school_year ?>';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(data) {
                    $('#searchQuestions').show();
                    $('#searchQuestions').html(data);

                }
            });
        };

    });

    function searchARubric(query) {
        const resultsBox = document.getElementById('rubricResults');
        const hiddenInput = document.getElementById('ruid');
        const searchInput = document.getElementById('rubricBox');

        if (query.trim() === '') {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            hiddenInput.value = '';
            return;
        }

        fetch(`<?= base_url('opl/searchRubric') ?>?q=${encodeURIComponent(query)}`)
            .then(res => {
                if (!res.ok) throw new Error("Network response was not ok");
                return res.json();
            })
            .then(data => {
                resultsBox.innerHTML = '';

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(rubric => {
                        const item = document.createElement('div');
                        item.className = 'rubric-item py-2 px-2 border-bottom rubric-hover';
                        item.innerHTML = `
                        <strong>${rubric.title}</strong><br>
                        <small class="text-muted">${rubric.description || ''}</small>
                    `;
                        item.onclick = () => {
                            searchInput.value = rubric.title;
                            hiddenInput.value = rubric.id;
                            resultsBox.style.display = 'none';
                        };
                        resultsBox.appendChild(item);
                    });
                    resultsBox.style.display = 'block';
                } else {
                    resultsBox.innerHTML = `<p class="text-muted mb-0 px-2">No rubrics found.</p>`;
                    resultsBox.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching rubrics:', error);
                resultsBox.innerHTML = `<p class="text-danger mb-0 px-2">Error loading rubrics.</p>`;
                resultsBox.style.display = 'block';
            });
    }

    function clearRubricSearch() {
        document.getElementById('rubricBox').value = '';
        document.getElementById('rubricResults').style.display = 'none';
        document.getElementById('rubricResults').innerHTML = '';
        document.getElementById('ruid').value = '';
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
                $('#unitLink').html(data);
            }
        });
    }

    function getComponent(value) {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/getAssessCatDropdown/' + value + '/' + school_year;
        $.ajax({
            type: "GET",
            url: url,
            data: '',
            success: function(data) {
                $('#gsComponent').html(data);
            }
        });
    }
    var hasError = 0;

    function formCheck() {

        $('.hasValue').each(function() {
            var val = $(this).val();
            var id = $(this).id;
            if (val == "" || val == null) {
                hasError++;
                $(this).addClass("is-invalid");
                if ($(this).hasClass("textarea")) {
                    $('.note-frame').attr('style', 'border: 1px solid red');
                }
            } else {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");

                if ($(this).hasClass("textarea")) {
                    $('.note-frame').attr('style', 'border: 1px solid green');
                }
            }

        });
        if (hasError > 0) {
            alert('Please Fill up the Form Completely');
        }

    }

    function postAndUploadTask() {
        formCheck();
        if (hasError == 0) {
            if ($('#userfile').get(0).files.length === 0) {
                postTask();
            } else {

                var gopublic = 0;
                var isTaskOnline = 0;
                var onlineLink = 0;
                var markingType = $('#markType').val();
                var taskSubmissionType = $('#submissionType').val();
                var base = $('#base').val();
                var school_year = $('#school_year').val();
                var postDetails = $('#taskDetails').val();
                var postTitle = $('#taskTitle').val();
                // var gradeLevel = $('#gradeLevel').val();
                var gradeLevel = '<?php echo $subj_id . '-' . $grade_id . '-' . $section_id ?>';
                var section_id = $('#section_id').val();
                var subject_id = $('#subject_id').val();
                var fd = new FormData();
                var files = $('#userfile')[0].files[0];



                if ($('#goPublic').is(':checked')) {
                    gopublic = 1;
                }

                if (taskSubmissionType == 3) {
                    isTaskOnline = 1;
                    onlineLink = $('#quiz_id').val();
                }

                fd.append('userfile', files);
                fd.append('hasUpload', 1);
                fd.append('task_is_online', isTaskOnline);
                fd.append('task_online_link', onlineLink);
                fd.append('school_year', school_year);
                fd.append('task_submission', taskSubmissionType);
                fd.append('inputTerm', $('#inputTerm').val());
                fd.append('numItems', $('#numItems').val());
                if (markingType == '2') {
                    fd.append('ruid', $('#ruid').val());
                } else {
                    fd.append('ruid', '');

                }
                fd.append('markingType', markingType);
                fd.append('gsComponent', $('#gsComponent').val());
                fd.append('taskType', $('#taskType').val());
                fd.append('startDate', $('#startDate').val());
                fd.append('timeStart', $('#timeStart').val());
                fd.append('timeDeadline', $('#timeDeadline').val());
                fd.append('deadlineDate', $('#deadlineDate').val());
                fd.append('unitLink', $('#unitLink').val());
                fd.append('postDetails', postDetails);
                fd.append('subGradeSec', gradeLevel);
                fd.append('postTitle', postTitle);
                fd.append('isPublic', gopublic);
                fd.append('csrf_test_name', $.cookie('csrf_cookie_name'));

                var url = base + 'opl/addTask';

                $.ajax({
                    url: url,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loadingModal').modal('show');
                    },
                    success: function(data) {
                        alert(data.msg);
                        document.location = base + '/opl/classBulletin/' + school_year + '/NULL/' + data.grade_id + '/' + data.section_id + '/' + data.subject_id + '/';
                    }
                });
            }
        } else {
            hasError = 0;
        }
    }

    function postTask() {
        var gopublic = 0;
        var isTaskOnline = 0;
        var onlineLink = 0;
        var taskSubmissionType = $('#submissionType').val();
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var postDetails = $('#taskDetails').val();
        var postTitle = $('#taskTitle').val();
        // var gradeLevel = $('#gradeLevel').val();
        var gradeLevel = '<?php echo $subj_id . '-' . $grade_id . '-' . $section_id ?>';
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        var markingType = $('#markType').val();
        if (markingType == '2') {
            var ruid = $('#ruid').val();
        } else {
            ruid = '';
        }
        if ($('#goPublic').is(':checked')) {
            gopublic = 1;
        }

        if (taskSubmissionType == 3) {
            isTaskOnline = 1;
            onlineLink = $('#quiz_id').val();
        }


        var url = base + 'opl/addTask';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                hasUpload: 0,
                task_is_online: isTaskOnline,
                task_online_link: onlineLink,
                school_year: school_year,
                task_submission: taskSubmissionType,
                markingType: markingType,
                ruid: ruid,
                inputTerm: $('#inputTerm').val(),
                numItems: $('#numItems').val(),
                gsComponent: $('#gsComponent').val(),
                taskType: $('#taskType').val(),
                startDate: $('#startDate').val(),
                timeStart: $('#timeStart').val(),
                timeDeadline: $('#timeDeadline').val(),
                deadlineDate: $('#deadlineDate').val(),
                unitLink: $('#unitLink').val(),
                postDetails: postDetails,
                subGradeSec: gradeLevel,
                postTitle: postTitle,
                isPublic: gopublic,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            dataType: 'json',
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                alert(data.msg);
                document.location = base + '/opl/classBulletin/' + school_year + '/NULL/' + data.grade_id + '/' + data.section_id + '/' + data.subject_id + '/';
            }
        });

    }

    function togglePublicIcon(checkbox) {
        var icon = document.getElementById("publicIcon");
        var text = document.getElementById("publicText");

        if (checkbox.checked) {
            icon.className = "fa fa-globe text-success"; // 🌐 green globe
            text.textContent = "Public";
        } else {
            icon.className = "fa fa-lock text-danger"; // 🔒 red lock
            text.textContent = "Private";
        }
    }
</script>