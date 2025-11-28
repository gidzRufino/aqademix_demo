<?php
if ($this->uri->segment(2) == 'college'):
    $grade_id = NULL;
endif;
if ($this->uri->segment(2) == 'classBulletin' || $this->uri->segment(3) == 'classBulletin'): ?>
    <!-- Task Submitted Progress -->
    <div class="row">
        <!-- Task Submitted Progress -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 rounded-4 task-progress-card h-100">
                <div class="card-header bg-transparent border-0 d-flex align-items-center p-3">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mr-2"
                        style="width:40px; height:40px;">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <h6 class="mb-0 font-weight-bold text-dark">Task Submission Progress</h6>
                </div>

                <div class="card-body text-center">
                    <!-- Circular Progress -->
                    <div class="progress-circle mx-auto mb-3" id="taskProgressCircle">
                        <span id="taskProgressLabel">0%</span>
                        <svg>
                            <circle cx="50" cy="50" r="46"></circle>
                            <circle cx="50" cy="50" r="46" id="taskProgressCircleBar"></circle>
                        </svg>
                    </div>

                    <!-- Counter Info -->
                    <h5 class="font-weight-bold text-dark mb-1">
                        <span id="submittedTasksCounter">0</span> /
                        <span id="totalStudentsCounter">0</span>
                    </h5>
                    <small class="text-muted d-block mb-3">Tasks completed out of Total Tasks</small>

                    <!-- Loader -->
                    <div class="mb-3" id="taskSubmittedLoader">
                        <i class="fas fa-sync-alt fa-spin text-primary"></i>
                    </div>

                    <!-- Modal Trigger Button -->
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3"
                        data-toggle="modal" data-target="#taskProgressModal">
                        <i class="fa fa-eye mr-1"></i> View Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Discussion Board -->
        <div class="col-md-8 mb-4">
            <div class="card shadow border-0 rounded-4 discussion-card h-100">
                <div class="card-header bg-transparent border-0 d-flex align-items-center p-3">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mr-2"
                        style="width:40px; height:40px;">
                        <i class="fa fa-comments"></i>
                    </div>
                    <h6 class="mb-0 font-weight-bold text-dark">Discussion Board</h6>
                </div>
                <div class="card-body">
                    <div id="discussionHolder" style="max-height: 400px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- Default View -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="row">

                <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="p-3 text-center rounded-lg shadow-sm border bg-white">
                        <small class="text-muted d-block">Number of Classes</small>
                        <strong class="h4 d-block mt-2 text-dark">8</strong>
                    </div>
                </div>

                <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="p-3 text-center rounded-lg shadow-sm border bg-white">
                        <small class="text-muted d-block">Submitted Quizzes</small>
                        <strong class="h4 d-block mt-2 text-danger">10 / 20</strong>
                    </div>
                </div>

                <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="p-3 text-center rounded-lg shadow-sm border bg-white">
                        <small class="text-muted d-block">Submitted Assignments</small>
                        <strong class="h4 d-block mt-2 text-warning">11 / 20</strong>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="p-3 text-center rounded-lg shadow-sm border bg-white">
                        <small class="text-muted d-block">Students Online</small>
                        <strong class="h4 d-block mt-2 text-success">12</strong>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php endif; ?>
<!-- Modal for Task Progress Details -->
<div class="modal fade" id="taskProgressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-tasks mr-2 text-primary"></i> Task Progress Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="taskList">

            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    /* Limit card width and center */
    .task-progress-card {
        width: 100%;
    }

    /* Circle Progress */
    .progress-circle {
        position: relative;
        width: 120px;
        height: 120px;
        display: inline-block;
    }

    .progress-circle svg {
        transform: rotate(-90deg);
        width: 120px;
        height: 104px;
    }

    .progress-circle circle {
        fill: none;
        stroke-width: 10;
        stroke-linecap: round;
    }

    .progress-circle circle:first-child {
        stroke: #f0f0f0;
    }

    .progress-circle circle:last-child {
        stroke: #007bff;
        stroke-dasharray: 289;
        stroke-dashoffset: 289;
        transition: stroke-dashoffset 0.8s ease, stroke 0.5s ease;
    }

    .progress-circle span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
    }

    /* Main discussion card */
    .discussion-card {
        background: #fff;
        border-left: 4px solid #007bff;
    }

    /* Each discussion item */
    .discussion-item {
        background: #ffffff;
        border: 1px solid #e4e6ef;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }

    .discussion-item:hover {
        background: #f8faff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .discussion-details {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .discussion-startDate {
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Comment section */
    .comment-list {
        display: none;
        /* hidden by default */
        margin-top: 12px;
        padding-left: 12px;
        border-left: 3px solid #007bff;
        transition: all 0.3s ease;
    }

    .comment-item {
        background: #f9fafc;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    .comment-item strong {
        color: #007bff;
        font-weight: 600;
    }

    .comment-date {
        font-size: 0.75rem;
        color: #999;
    }

    /* Replies */
    .reply-list {
        margin-top: 8px;
        margin-left: 14px;
        padding-left: 14px;
        border-left: 2px dashed #adb5bd;
    }

    .reply-item {
        background: #eef6f9;
        border-radius: 8px;
        padding: 8px 10px;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }

    .reply-item strong {
        color: #28a745;
        font-weight: 600;
    }

    .reply-date {
        font-size: 0.7rem;
        color: #888;
    }

    /* Arrow rotation */
    .toggle-arrow {
        transition: transform 0.3s ease;
    }

    .toggle-arrow.rotated {
        transform: rotate(90deg);
        /* right → down */
    }

    /* Highlight active discussion */
    .discussion-item.active-discussion {
        border-color: #007bff;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.15);
        background: #f8fbff;
    }

    /* discussion details button */
    .view-details-btn {
        background: #007bff;
        border: none;
        transition: all 0.2s ease;
    }

    .view-details-btn:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }
</style>

<script>
    $(document).ready(function() {
        updateStudentCount();
        updateQuizzes();
        updateSubmitted();
        updateTaskSubmittedRatio();
        getDiscussionList();
    });

    function updateQuizzes() {
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getTasksByType";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: {
                grade: <?php echo ($grade_id != NULL) ? $grade_id : 'null'; ?>,
                section: '<?php echo $section_id; ?>',
                subject: <?php echo $subject_id; ?>,
                task_type: "1",
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                if (data.hasUpdate == true) {
                    $("#submittedQuizCounter").html(data.submitted + " / " + data.total);
                    if ($("#submittedQuizCounterLoader").is(":visible")) {
                        $("#submittedQuizCounterLoader").hide();
                    }
                }
            }
        })
    }

    function updateSubmitted() {
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getTasksByType";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: {
                grade: <?php echo ($grade_id != NULL) ? $grade_id : 'null'; ?>,
                section: '<?php echo $section_id; ?>',
                subject: <?php echo $subject_id; ?>,
                task_type: "2",
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                if (data.hasUpdate == true) {
                    $("#submittedAssignmentCounter").html(data.submitted + " / " + data.total);
                    if ($("#submittedAssignmentCounterLoader").is(":visible")) {
                        $("#submittedAssignmentCounterLoader").hide();
                    }
                }
            }
        })
    }

    function updateStudentCount() {
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getStudentOnlinePresent";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                section: '<?php echo $section_id; ?>',
                grade: <?php echo ($grade_id != NULL) ? $grade_id : 'null'; ?>,
                count: $("#studentCounter").html(),
                csrf_test_name: $.cookie("csrf_cookie_name")
            },
            success: function(data) {
                if (data.hasUpdate = true) {
                    $("#studentCounter").html(data.count);
                    if ($("#studentCounterLoader").is(":visible")) {
                        $("#studentCounterLoader").hide();
                    }
                }
            }
        });
    }

    setInterval(function() {
        updateTaskSubmittedRatio();
    }, 10000);

    function updateTaskSubmittedRatio() {
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getTaskSubmittedRatio";

        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                section: '<?= $section_id; ?>',
                grade: <?= $grade_id; ?>,
                subject: <?= $subject_id; ?>,
                teacher: <?= $faculty_id; ?>,
                csrf_test_name: $.cookie("csrf_cookie_name")
            },
            success: function(data) {
                if (data.hasUpdate === true) {
                    $("#submittedTasksCounter").html(data.completed);
                    $("#totalStudentsCounter").html(data.total_task);

                    // Calculate percentage
                    let percentage = (data.totalStudents > 0) ?
                        Math.round((data.submitted / data.totalStudents) * 100) : 0;

                    // Update circle progress
                    let circle = document.querySelector("#taskProgressCircleBar");
                    let dashArray = 289; // circumference for r=46
                    let offset = dashArray - (dashArray * percentage / 100);
                    circle.style.strokeDashoffset = offset;

                    // Color logic
                    if (percentage < 50) {
                        circle.style.stroke = "#dc3545"; // Red
                    } else if (percentage < 80) {
                        circle.style.stroke = "#ffc107"; // Yellow
                    } else {
                        circle.style.stroke = "#28a745"; // Green
                    }

                    // Label update
                    $("#taskProgressLabel").text(percentage + "%");

                    // Hide loader
                    if ($("#taskSubmittedLoader").is(":visible")) {
                        $("#taskSubmittedLoader").hide();
                    }

                    let taskBody = $('#taskList');
                    taskBody.html(''); // clear old content first

                    if (data.pTask && data.pTask.length > 0) {
                        data.pTask.forEach(task => {
                            let percent = (task.total_students > 0) ?
                                Math.round((task.total_submitted / task.total_students) * 100) :
                                0;

                            let barClass = "bg-success";
                            if (percent < 50) {
                                barClass = "bg-danger";
                            } else if (percent < 80) {
                                barClass = "bg-warning";
                            }

                            taskBody.append(`
                                <div class="card border-0 shadow-sm rounded mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                            <!-- Left: Subject, Title + View Details -->
                                            <div class="d-flex align-items-center text-left flex-wrap">
                                                <div class="mr-2">
                                                    <h6 class="font-weight-bold mb-1 text-dark">
                                ${task.task_title}
                                                    </h6>
                                                    <small class="text-primary font-weight-bold">${task.deadline}</small>
                                                </div>
                                                <button class="btn btn-sm btn-link text-primary font-weight-bold ml-2 p-0" onclick="window.location.href = '<?= base_url() . 'opl/viewTaskDetails/' ?>${task.task_code}/${task.grade_id}/${task.section_id}/${task.subj_id}/${task.sy}'">
                                                    <i class="fas fa-eye text-primary"></i> View Details
                                                </button>
                                            </div>

                                            <!-- Right: Badge -->
                                            <span class="badge ${barClass} px-3 py-2">
                                ${task.total_submitted}/${task.total_students}
                                            </span>
                                        </div>

                                        <div class="progress mb-3" style="height: 20px; width: 100%">
                                            <div class="progress-bar ${barClass}"
                                                role="progressbar"
                                                style="width: ${percent}%;"
                                                aria-valuenow="${percent}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                ${percent}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        taskBody.html('<p class="text-muted text-center">No tasks available</p>');
                    }
                }
            }
        });
    }

    function getDiscussionList() {
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getDiscussion";

        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                section: '<?= $section_id; ?>',
                grade: <?= $grade_id; ?>,
                subject: <?= $subject_id; ?>,
                teacher: <?= $faculty_id; ?>,
                csrf_test_name: $.cookie("csrf_cookie_name")
            },
            success: function(data) {
                if (data.hasDiscussion === true) {
                    let discussionBody = $('#discussionHolder');
                    discussionBody.html('');

                    if (data.discussion && data.discussion.length > 0) {
                        data.discussion.forEach((discuss, index) => {
                            disUrl = base + 'opl/discussionDetails/' + discuss.sys_code + '/' + discuss.sy
                            discussionBody.append(`
                                <div class="discussion-item">
                                    <div class="message-info">
                                        <div class="discussion-details">${discuss.title}</div>
                                        <div class="discussion-startDate">Date Posted: ${discuss.start_date}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <button class="btn btn-sm btn-outline-primary read-btn rounded-pill px-3 d-flex align-items-center" data-target="commentList${index}">
                                            <i class="fa fa-chevron-right mr-2 toggle-arrow"></i> ${discuss.com_count} Comments
                                        </button>

                                        <button class="btn btn-sm btn-primary view-details-btn rounded-pill px-3" onclick="window.location.href='${disUrl}'" data-id="${discuss.id}">
                                            <i class="fa fa-eye mr-1"></i> View Details
                                        </button>
                                    </div>
                                </div>

                                <!-- Hidden comment list -->
                                <div class="comment-list" id="commentList${index}" style="display:none;">
                                    ${
                                        (discuss.comment && discuss.comment.length > 0)
                                        ? discuss.comment.map((c, cIndex) => `
                                            <div class="comment-item">
                                                <strong>${c.sender}</strong>: ${c.msg}
                                                <div class="comment-date">${c.date_sent}</div>

                                                <!-- Replies under comment -->
                                                <div class="reply-list">
                                                    ${
                                                        (c.reply && c.reply.length > 0)
                                                        ? c.reply.map(r => `
                                                            <div class="reply-item">
                                                                <strong class="text-success">${r.sender}</strong>
                                                                <span>${r.msg}</span>
                                                                <div class="reply-date">${r.date_sent}</div>
                                                            </div>
                                                        `).join('')
                                                        : '' // no "No replies yet"
                                                    }
                                                </div>
                                            </div>
                                        `).join('')
                                        : `<p class="text-muted small">No comments yet</p>`
                                    }
                                </div>
                            `)
                        });

                        // toggle comments dropdown
                        $(document).on('click', '.read-btn', function() {
                            var targetId = $(this).data('target');
                            var targetList = $('#' + targetId);
                            var parentCard = $(this).closest('.discussion-item');

                            // Collapse all others
                            $('.comment-list').not(targetList).slideUp();
                            $('.read-btn .toggle-arrow').removeClass('rotated');
                            $('.discussion-item').removeClass('active-discussion');

                            // Toggle current
                            targetList.slideToggle(() => {
                                if (targetList.is(':visible')) {
                                    $(this).find('.toggle-arrow').addClass('rotated');
                                    parentCard.addClass('active-discussion');
                                } else {
                                    $(this).find('.toggle-arrow').removeClass('rotated');
                                    parentCard.removeClass('active-discussion');
                                }
                            });
                        });

                        $(document).on('click', '.view-details-btn', function() {
                            var discussionId = $(this).data('id');

                            // Example: open modal (replace with actual implementation)
                            $('#discussionModal .modal-body').html(
                                `<p>Loading details for discussion ID: <strong>${discussionId}</strong>...</p>`
                            );
                            $('#discussionModal').modal('show');

                            // Optional: Fetch full discussion details via AJAX
                            /*
                            $.get('/discussion/details/' + discussionId, function(data) {
                                $('#discussionModal .modal-body').html(data);
                            });
                            */
                        });

                    }
                }
            }
        });
    }
</script>