<div class="card card-widget card-blue card-outline">
    <div class="card-header">
        <!-- <h6 class="text-center">Answer</h6> -->
        <p style="font-size: medium; text-align:center; color: red"><b>Note:</b> Please review your answer carefully before submitting. Once submitted, your response will be final and cannot be edited or undone.</p>
    </div>
    <div class="card-body">
        <div class="form-group col-12">
            <label for="submissionType">Submission Type</label>
            <select id="submissionType" class="form-control">
                <option value="">Select Submission Type</option>
                <option value="1" <?= ($task->task_submission_type == 1 ? 'selected' : '') ?>>Use Editor</option>
                <option value="2" <?= ($task->task_submission_type == 2 ? 'selected' : '') ?>>File Submission</option>
                <option value="3" <?= ($task->task_submission_type == 3 ? 'selected' : '') ?>>Online Form</option>
            </select>
        </div>

        <div id="fileSubmission" class="form-group col-12" style="<?= ($task->task_submission_type == 2 ? '' : 'display:none') ?>">

            <label for="userfile">Select File to Submit</label><br />
            <input type="file" name="userfile" id="userfile" class="form-control-file" accept=".pdf,.doc,.docx,.jpg,.png"><br>
            <div class="progress" id="progressBarWrapper" style="display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    UPLOADING FILE...
                </div>
            </div><br />
        </div>

        <div id="useEditor" class="form-group col-12" style="<?= ($task->task_submission_type == 1 ? '' : 'display:none') ?>">
            <label for="answerDetails">Answer Details</label>
            <textarea id="answerDetails" placeholder="Place some text here"
                style="width: 100%; height: 300px; font-size: 14px; line-height: 1.5; border: 1px solid #ddd; padding: 10px;"></textarea>
        </div>

        <div class="form-group col-12 text-center mt-3">
            <button id="btnSubmitAnswer" type="button" class="btn btn-primary" disabled>Submit Answer</button>
        </div>
    </div>
</div>

<script>
    $(function() {
        var csrfToken = $.cookie ? $.cookie('csrf_cookie_name') : '';
        var base = $('#base').val();
        if (!base.endsWith('/')) base += '/';

        // Summernote init function
        function initSummernote() {
            if (!$('#answerDetails').next().hasClass('note-editor')) {
                $('#answerDetails').summernote({
                    height: 250,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['codeview']]
                    ]
                });
            }
        }

        function destroySummernote() {
            if ($('#answerDetails').next().hasClass('note-editor')) {
                $('#answerDetails').summernote('destroy');
            }
        }

        function toggleSubmissionType(option) {
            switch (option) {
                case '1': // Editor
                    $('#fileSubmission').hide();
                    $('#useEditor').show();
                    initSummernote();
                    break;
                case '2': // File
                    $('#useEditor').hide();
                    $('#fileSubmission').show();
                    destroySummernote();
                    break;
                case '3': // Online Form (not implemented)
                default:
                    $('#useEditor').hide();
                    $('#fileSubmission').hide();
                    destroySummernote();
            }
            $('#btnSubmitAnswer').prop('disabled', !option);
        }

        $('#submissionType').on('change', function() {
            toggleSubmissionType($(this).val());
        });

        // Initialize based on preselected type
        toggleSubmissionType($('#submissionType').val());

        $('#btnSubmitAnswer').on('click', function() {
            var submissionType = $('#submissionType').val();
            if (!submissionType) return alert('Please select a submission type.');

            if (submissionType === '1') {
                var answerContent = $('#answerDetails').summernote('code');
                if (!answerContent || answerContent === '<p><br></p>') {
                    return alert('Please enter your answer in the editor.');
                }
                submitResponse({
                    task_submission_type: 1,
                    task_details: answerContent
                });

            } else if (submissionType === '2') {
                var fileInput = $('#userfile')[0];
                if (!fileInput.files.length) {
                    return alert('Please select a file to upload.');
                }
                uploadFile(fileInput.files[0]);

            } else {
                alert('Online Form submission is not implemented yet.');
            }
        });

        function submitResponse(data) {
            $('#btnSubmitAnswer').prop('disabled', true).text('Submitting...');
            $.ajax({
                type: "POST",
                url: base + 'opl/student/createResponse',
                data: $.extend(data, {
                    teacher: $('#teacher_id').val(),
                    task_id: '<?= $task->task_code ?>',
                    csrf_test_name: csrfToken
                }),
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function() {
                    alert('Error submitting your answer. Please try again.');
                },
                complete: function() {
                    $('#btnSubmitAnswer').prop('disabled', false).text('Submit Answer');
                }
            });
        }

        function uploadFile(file) {
            var sy = '<?= $this->session->details->school_year ?>'
            var subj_id = '<?= $this->session->oplSessions['subjectDetails']->subject_id ?>'
            var stid = '<?= $this->session->st_id ?>'
            var task_code = '<?= $task->task_code ?>'
            var formData = new FormData();
            formData.append("userfile", file);
            formData.append('csrf_test_name', csrfToken);
            formData.append('submission_type', $('#submissionType').val());
            formData.append('teacher', $('#teacher_id').val());
            formData.append('task_type', $('#task_type').val());
            formData.append('task_code', task_code);
            formData.append('subject_id', subj_id);
            formData.append('st_id', stid);
            formData.append('school_year', sy);
            formData.append('task_id', $('#task_id').val());

            var progressBar = $('#progressBarWrapper .progress-bar');
            $('#progressBarWrapper').show();
            progressBar.css('width', '0%').attr('aria-valuenow', 0);

            $('#btnSubmitAnswer').prop('disabled', true).text('Uploading...');

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            progressBar.css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                url: base + 'opl/student/uploadResponse/',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Upload failed: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error uploading your file. Please try again.');
                },
                complete: function() {
                    $('#progressBarWrapper').hide();
                    $('#btnSubmitAnswer').prop('disabled', false).text('Submit Answer');
                }
            });
        }
    });
</script>