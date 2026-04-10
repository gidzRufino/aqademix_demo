<?php
// print_r($taskList);
// echo $ua_student->row()->secret_key;

function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}

function timeAgo($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    $result = [];
    foreach ($string as $k => $v) {
        if ($diff->$k) {
            $result[] = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        }
    }

    if (!$full) $result = array_slice($result, 0, 2); // show only first 2 units
    return $result ? implode(' and ', $result) . ' ago' : 'just now';
}

$avatar = getAvatarUrl($this->session->details->avatar, $this->session->details->sex);
$name = ucwords(strtolower($this->session->details->firstname . ' ' . $this->session->details->lastname));
$levelSection = $section->level . ' - ' . $section->section;
$bdate = new DateTime($this->session->details->temp_bdate);
$currentDate = new DateTime('now');
$age = $currentDate->diff($bdate);

$tasks = [
    [
        'subject' => 'Math',
        'title' => 'Algebra Homework',
        'due_date' => '2025-08-28',
        'status' => 'Pending'
    ],
    [
        'subject' => 'Science',
        'title' => 'Lab Report',
        'due_date' => '2025-08-26',
        'status' => 'Completed'
    ]
];
?>
<style>
    body {
        background: #f7f9fc;
    }

    .container {
        margin-top: 30px;
    }

    /* Profile Card */
    .widget-user {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
    }

    .widget-user-header {
        background: linear-gradient(120deg, #6fb1fc, #4364f7, #0052d4);
        height: 180px;
        text-align: center;
        position: relative;
    }

    .widget-user-header img {
        border: 6px solid #fff;
        margin: auto;
        position: absolute;
        bottom: -65px;
        left: 0;
        right: 0;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.25);
    }

    .widget-user .box-footer {
        padding-top: 80px;
        text-align: center;
        background: #fff;
        border-radius: 0 0 18px 18px;
    }

    .description-header {
        margin: 6px 0 2px;
        font-weight: 700;
    }

    /* Pastel action buttons */
    .btn-pill {
        border-radius: 30px;
        padding: 10px 20px;
        margin: 6px;
        border: none;
    }

    .btn-grades {
        background: #e3f2fd;
        color: #1565c0;
    }

    .btn-attend {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-report {
        background: #e1f5fe;
        color: #0277bd;
    }

    .btn-subjects {
        background: #fff8e1;
        color: #ef6c00;
    }

    .btn-message {
        background: chocolate;
        color: white;
    }

    .btn-message:hover {
        background: darkred;
        color: white;
    }

    /* Card shell */
    .card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* ===== Clean Timeline (no AdminLTE dependency) ===== */
    .timeline {
        padding-left: 1.5rem;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 7px;
        /* aligns with badge center */
        width: 2px;
        height: 100%;
        background: #dee2e6;
    }

    /* Hover effect on timeline cards */
    .timeline-card:hover {
        transform: translateY(-2px);
        transition: 0.2s ease;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    /* Badge hover effect */
    .timeline-badge {
        transition: transform 0.2s ease;
    }

    .timeline-badge:hover {
        transform: scale(1.3);
    }

    /* Modal headers */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header .close {
        color: #fff;
        opacity: 1;
    }

    .progress-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(#2e7d32 0%, #e0e0e0 0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        position: relative;
    }

    .progress-circle .progress-value {
        position: absolute;
        font-size: 22px;
        font-weight: bold;
    }

    .legend .badge-legend {
        font-size: 12px;
        margin: 3px;
        padding: 5px 8px;
        opacity: 0.6;
        transition: all 0.3s;
    }

    .legend .highlight {
        border: 2px solid #000;
        opacity: 1;
        transform: scale(1.1);
    }

    .badge-legend.excellent {
        background: #2e7d32;
        color: #fff;
    }

    .badge-legend.warning {
        background: #f57c00;
        color: #fff;
    }

    .badge-legend.critical {
        background: #d32f2f;
        color: #fff;
    }

    .stat-card {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .stat-card .stat-value {
        margin: 5px 0 0;
        font-weight: bold;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: #555;
    }

    /* Subjects css */
    .subject-list .list-group-item {
        transition: all 0.25s ease-in-out;
        border: none;
        border-bottom: 1px solid #f1f1f1;
    }

    .subject-list .list-group-item:last-child {
        border-bottom: none;
    }

    .subject-list .list-group-item:hover {
        background: #fff8f1;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        cursor: pointer;
    }

    .subject-list img {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border: 2px solid #eee;
    }

    .subject-item:hover {
        background: #f9f9f9;
        transform: translateY(-1px);
        transition: 0.2s ease-in-out;
    }

    .subject-icon {
        transition: transform 0.3s ease;
    }

    .subject-item:hover .subject-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .teacher-avatar:hover {
        transform: scale(1.1);
        transition: 0.2s ease-in-out;
    }


    /* Animate modal content pop-in */
    #subjectsModal .modal-content {
        animation: popIn 0.35s ease;
    }

    @keyframes popIn {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Subject icon animation */
    .subject-icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .subject-item:hover .subject-icon {
        transform: scale(1.15) rotate(8deg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Gentle pulse on hover */
    .subject-icon:hover {
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.08);
        }

        100% {
            transform: scale(1);
        }
    }

    .task-item {
        cursor: pointer;
        transition: background 0.25s, transform 0.15s;
    }

    .task-item:hover {
        background: #fff8e1;
        transform: translateX(4px);
    }

    /* --- Message Style --- */
    /* Highlight on hover */
    .list-group-item:hover {
        background-color: #f8f9fa;
        /* light gray */
    }

    /* Unread message row */
    .list-group-item.unread {
        background-color: #e9f3ff;
        /* light blue */
        font-weight: 500;
        /* semi-bold text for sender */
    }

    /* Avatar fix (always circular and aligned) */
    .msg-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.25);
        object-fit: cover;
        display: block;
    }

    /* Unread dot */
    .unread-indicator {
        width: 10px;
        height: 10px;
        background-color: #007bff;
        /* Bootstrap primary color */
        border-radius: 50%;
        flex-shrink: 0;
    }
</style>
<!-- Elegant Student Dashboard -->

<div class="container">

    <!-- Student Profile Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="widget-user">
                <div class="widget-user-header">
                    <img src="<?= $avatar ?>" alt="Student Avatar" />
                </div>
                <div class="box-footer">
                    <h2 style="margin-bottom:3px; font-weight:700; color:#333;"><?= $name ?></h2>
                    <h5 style="color:#888; margin: bottom 3px;"><?= $levelSection ?></h5>
                    <h5 style="color:#888; margin-bottom:25px;">Student ID: <?= $this->session->details->st_id ?></h5>

                    <!-- Quick Actions -->
                    <div style="margin-bottom:25px;">
                        <button class="btn btn-pill btn-grades" data-toggle="modal" data-target="#gradesModal">
                            <i class="fa fa-graduation-cap"></i> View Grades
                        </button>
                        <button class="btn btn-pill btn-attend" data-toggle="modal" data-target="#attendanceModal">
                            <i class="fa fa-calendar"></i> Attendance
                        </button>
                        <button class="btn btn-pill btn-report" data-toggle="modal" data-target="#reportCardModal">
                            <i class="fa fa-file"></i> Report Card
                        </button>
                        <button class="btn btn-pill btn-subjects" data-toggle="modal" data-target="#subjectsModal">
                            <i class="fa fa-book"></i> Subjects
                        </button>
                        <button class="btn btn-pill btn-message position-relative" data-toggle="modal" data-target="#messageModal">
                            <i class="fa fa-envelope"></i> Message
                            <span id="msgBadge" class="badge badge-danger position-absolute"
                                style="top: -6px; right: -10px; border-radius: 50%; font-size: 0.75rem; padding: 0.35em 0.55em;">
                                3
                            </span>
                        </button>

                        <!-- 🔽 New Change Password button -->
                        <button class="btn btn-pill btn-warning" data-toggle="modal" data-target="#passwordUpdateModal">
                            <i class="fa fa-lock"></i> Change Password
                        </button>
                    </div>
                </div> <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!-- Tasks / Assignments & Recent Activities -->
    <div class="row mt-4">

        <!-- Tasks / Assignments -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-white border-0 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #fff3e0, #ffe0b2);">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fa fa-tasks text-warning me-2"></i> Tasks / Assignments
                    </h5>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        <?php
                        if (count($taskList) > 0):
                            foreach ($taskList as $tl): ?>
                                <?php foreach ($tl['listTask'] as $l): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start border-0 border-bottom pointer task-item"
                                        onclick="location.href='<?= $l['link'] ?>'">
                                        <div>
                                            <h6 class="fw-semibold mb-1 text-dark">
                                                <i class="fa fa-book text-warning me-2"></i>
                                                <span class="text-secondary"><?= $tl['t_subject'] ?>:</span> <?= $l['task_title'] ?>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fa fa-calendar me-1"></i>
                                                Due: <?= date("M d, Y", strtotime($l['due_date'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge rounded-pill <?= ($l['status'] == 'Completed') ? 'bg-success' : 'bg-warning text-dark' ?>">
                                            <?= $l['status'] ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                        <?php endforeach;
                        else:
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start border-0 border-bottom pointer task-item" style="color: gray;">No Task / Assignments Posted</li>';
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="card-header text-white p-3" style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-clock-o me-2"></i> Recent Activities
                    </h5>
                </div>

                <!-- Body -->
                <div class="card-body p-3 bg-light">
                    <ul class="timeline list-unstyled position-relative">
                        <?php foreach ($activities as $a): ?>
                            <li class="timeline-item mb-4 position-relative">
                                <!-- Badge -->
                                <span class="timeline-badge position-absolute top-0 start-0 translate-middle bg-info border border-white rounded-circle shadow-sm" style="width: 14px; height: 14px;"></span>

                                <!-- Card -->
                                <div class="timeline-card shadow-sm p-3 rounded-3 bg-white border-start border-3 border-info">
                                    <div class="small text-muted mb-1">
                                        <i class="fa fa-clock-o me-1"></i> <?= timeAgo($a['dateTime']) ?>
                                    </div>
                                    <div class="fw-semibold text-dark mb-1">
                                        <i class="fa fa-book text-info me-2"></i> <?= $a['taskTitle'] ?>
                                    </div>
                                    <div class="text-muted"><?= $a['description'] ?></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.container -->

<!-- ================== MODALS ================== -->

<!-- Grades Modal -->
<div class="modal fade" id="gradesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#1565c0; color:#fff;">
                <h4 class="modal-title"><i class="fa fa-graduation-cap"></i> Grades per Subject per Quarter</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <canvas id="gradesChartModal" style="height:350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header" style="background:#2e7d32; color:#fff;">
                <h4 class="modal-title">
                    <i class="fa fa-calendar-check-o"></i> Attendance Summary
                </h4>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
            </div>
            <div class="modal-body">

                <!-- Circular Attendance Percentage -->
                <div class="text-center" style="margin-bottom:25px;">
                    <div class="progress-circle" data-percentage="<?= $attPercentage ?>">
                        <span class="progress-value"><?= $attPercentage ?>%</span>
                    </div>
                    <small class="text-muted">Attendance Percentage</small>

                    <!-- Legend -->
                    <div class="legend" style="margin-top:15px;">
                        <span class="badge badge-legend excellent">90%+ Excellent</span>
                        <span class="badge badge-legend warning">75–89% Warning</span>
                        <span class="badge badge-legend critical">Below 75% Critical</span>
                    </div>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="stat-card" style="background:#e8f5e9; border-left:5px solid #2e7d32;">
                            <i class="fa fa-calendar fa-2x text-success"></i>
                            <h3 class="stat-value"><?= $totalDays ?></h3>
                            <span class="stat-label">Total Days</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card" style="background:#ffebee; border-left:5px solid #d32f2f;">
                            <i class="fa fa-user-times fa-2x text-danger"></i>
                            <h3 class="stat-value"><?= ($totalDays - $totalPresent) ?></h3>
                            <span class="stat-label">Absent</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card" style="background:#e3f2fd; border-left:5px solid #1565c0;">
                            <i class="fa fa-check-circle fa-2x text-primary"></i>
                            <h3 class="stat-value"><?= $totalPresent ?></h3>
                            <span class="stat-label">Present</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Report Card Modal -->
<div class="modal fade" id="reportCardModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#0277bd; color:#fff;">
                <h4 class="modal-title"><i class="fa fa-file-pdf-o"></i> Report Card</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="text-align:center;">
                <iframe src="" width="100%" height="500px" style="border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subjectsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="modal-header text-white py-3"
                style="background: linear-gradient(135deg, #ef6c00, #f57c00);">
                <h5 class="modal-title mb-0 d-flex align-items-center">
                    <i class="fa fa-book mr-2"></i> <span class="fw-bold">Subjects & Teachers</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size:1.6rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body p-0">
                <div class="list-group list-group-flush subject-list">
                    <?php
                    // Predefined icons & gradients
                    $subjectIcons = [
                        'MATH' => ['fa-calculator', 'linear-gradient(135deg, #42a5f5, #1e88e5)'],
                        'SCIENCE'     => ['fa-flask', 'linear-gradient(135deg, #66bb6a, #43a047)'],
                        'LANGUAGE'     => ['fa-book-open', 'linear-gradient(135deg, #ab47bc, #8e24aa)'],
                        'FILIPINO'     => ['fa-landmark', 'linear-gradient(135deg, #ff7043, #f4511e)'],
                        'MAPEH'          => ['fa-dumbbell', 'linear-gradient(135deg, #26c6da, #00acc1)'],
                        'PHONICS'         => ['fa-laptop-code', 'linear-gradient(135deg, #5c6bc0, #3949ab)'],
                        'CIVICS'       => ['fa-music', 'linear-gradient(135deg, #ec407a, #d81b60)']
                    ];

                    // Pastel gradient fallback colors
                    $pastelColors = [
                        'linear-gradient(135deg, #ffd54f, #ffb300)',
                        'linear-gradient(135deg, #81d4fa, #29b6f6)',
                        'linear-gradient(135deg, #a5d6a7, #66bb6a)',
                        'linear-gradient(135deg, #ce93d8, #8e24aa)',
                        'linear-gradient(135deg, #ffab91, #f4511e)',
                        'linear-gradient(135deg, #f48fb1, #d81b60)',
                        'linear-gradient(135deg, #b39ddb, #5e35b1)'
                    ];
                    ?>

                    <?php foreach ($subjectTeacher as $st): ?>
                        <?php
                        $faAvatar = $st['is_assigned'] ? getAvatarUrl($st['f_avatar'], $st['f_gender']) : '';

                        // Pick icon & background if available
                        if (isset($subjectIcons[$st['f_subject']])) {
                            $icon = '<i class="fa ' . $subjectIcons[$st['f_subject']][0] . '"></i>';
                            $bg   = $subjectIcons[$st['f_subject']][1];
                        } else {
                            // Use first letter as fallback "icon"
                            $firstLetter = strtoupper(substr($st['f_subject'], 0, 1));
                            $icon = "<span style='font-size:0.9rem; font-weight:bold;'>$firstLetter</span>";
                            $bg   = $pastelColors[array_rand($pastelColors)];
                        }
                        ?>

                        <div class="list-group-item d-flex align-items-center justify-content-between px-3 py-2 border-0 border-bottom subject-item">

                            <!-- Subject -->
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white mr-3 shadow-sm subject-icon"
                                    style="width:42px; height:42px; background: <?= $bg ?>;">
                                    <?= $icon ?>
                                </div>
                                <span class="fw-semibold"><?= $st['f_subject'] ?></span>
                            </div>

                            <!-- Teacher -->
                            <div class="d-flex align-items-center">
                                <?php if ($st['is_assigned']): ?>
                                    <span class="text-muted small mr-2"><?= $st['f_name'] ?></span>
                                    <img src="<?= $faAvatar ?>" class="rounded-circle border shadow-sm teacher-avatar"
                                        style="width:40px; height:40px;" alt="<?= $st['f_name'] ?>">
                                <?php else: ?>
                                    <span class="badge badge-pill badge-warning px-2 py-1">No Faculty Assigned</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Password Update Modal -->
<div id="passwordUpdateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background:#f57c00; color:white;">
                <h4 class="modal-title"><i class="fa fa-lock"></i> Update Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form>
                    <!-- Current Password -->
                    <?php if ($ua_student):
                    ?>
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-default toggle-password" type="button" data-target="#currentPassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    <?php endif;
                    ?>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            <span class="input-group-btn">
                                <button class="btn btn-default toggle-password" type="button" data-target="#newPassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            <span class="input-group-btn">
                                <button class="btn btn-default toggle-password" type="button" data-target="#confirmPassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div id="passwordMessage" class="text-danger" style="display:none;"></div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="updatePassword">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<!-- Unread Messages Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content rounded-lg shadow">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="messageModalLabel">
                    <i class="fa fa-envelope"></i> Unread Messages
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-3">
                <ul id="msgList" class="list-group list-group-flush">
                    <?php
                    if ($messages):
                        foreach ($messages as $m): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center unread" onclick="window.location.href = '<?php echo base_url() . 'opl/messages/readMsge/' . base64_encode($m['opl_msg_id']) . '/' . $m['subject_id'] . '/' . $m['grade_id'] . '/' . $m['section_id'] . '/0/' . $m['opl_msg_id'] . '/' . $this->session->details->st_id ?>'">
                                <div class="list-group-item list-group-item-action d-flex align-items-center border-0 py-2 px-3"
                                    style="cursor:pointer;">

                                    <!-- Avatar -->
                                    <div class="msg-avatar flex-shrink-0 me-3">
                                        <img src="<?= getAvatarUrl($m['s_avatar'], $m['s_gender']) ?>"
                                            alt="Student Avatar"
                                            class="rounded-circle shadow-sm"
                                            style="width:45px; height:45px; object-fit:cover; display:block;">
                                    </div>

                                    <!-- Text content -->
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="text-truncate"><?= $m['sender'] ?></strong>
                                            <small class="text-muted ms-2"><?= date('h:i A', strtotime($m['date_sent'])) ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted d-block text-truncate"><?= $m['subject_msg'] ?></small>
                                            <span class="badge badge-primary badge-pill ms-2">New</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;
                    else: ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center unread">No new Message</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php if ($messages): ?>
                    <button type="button" class="btn btn-primary">View All Messages</button>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
    var gradesChartInstance = null;

    $('#gradesModal').on('shown.bs.modal', function() {
        var ctx = document.getElementById('gradesChartModal').getContext('2d');
        if (gradesChartInstance) gradesChartInstance.destroy();
        gradesChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: ['Math', 'Science', 'English', 'History', 'PE'],
                labels: [<?= $subjectList ?>],
                datasets: [{
                        label: "Q1",
                        // data: [85, 90, 88, 92, 87, 91, 90],
                        data: [<?= $first ?>],
                        backgroundColor: "#42a5f5"
                    },
                    {
                        label: "Q2",
                        // data: [88, 93, 84, 89, 90, 88, 91],
                        data: [<?= $second ?>],
                        backgroundColor: "#66bb6a"
                    },
                    {
                        label: "Q3",
                        // data: [90, 95, 86, 91, 92, 93, 92],
                        data: [<?= $third ?>],
                        backgroundColor: "#ffa726"
                    },
                    {
                        label: "Q4",
                        // data: [92, 97, 89, 94, 95, 95, 89],
                        data: [<?= $fourth ?>],
                        backgroundColor: "#ef5350"
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Grades per Subject per Quarter",
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }).on('hidden.modal', function() {
        if (gradesChartInstance) {
            gradesChartInstance.destroy();
            gradesChartInstance = null;
        }
    });

    $('#attendanceModal').on('shown.bs.modal', function() {
        var circle = document.querySelector(".progress-circle");
        var target = parseInt(circle.getAttribute("data-percentage"));
        var valueEl = circle.querySelector(".progress-value");
        var current = 0;

        // Reset legend highlights
        document.querySelectorAll(".badge-legend").forEach(el => el.classList.remove("highlight"));

        // pick color + matching legend
        var textColor = "black";
        var color = "#2e7d32";
        var legendClass = ".excellent";
        if (target < 75) {
            color = "#d32f2f";
            legendClass = ".critical";
        } else if (target < 90) {
            color = "#f57c00";
            legendClass = ".warning";
        }

        // highlight matching legend
        document.querySelector(".badge-legend" + legendClass).classList.add("highlight");

        // animate circle
        var interval = setInterval(function() {
            if (current >= target) {
                clearInterval(interval);
            } else {
                current++;
                circle.style.background =
                    "conic-gradient(" + color + " " + current + "%, #e0e0e0 0)";
                valueEl.textContent = current + "%";
                valueEl.style.color = textColor;
            }
        }, 20);
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Toggle show/hide password
    $(document).on('click', '.toggle-password', function() {
        var target = $($(this).data('target'));
        var type = target.attr('type') === 'password' ? 'text' : 'password';
        target.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    //Handle submit
    $("#updatePassword").on("click", function(e) {
        e.preventDefault();
        var pass = '<?= ($ua_student ? $ua_student->row()->secret_key : '') ?>'
        var currentPass = $('#currentPassword').val();
        var newPass = $("#newPassword").val();
        var confirmPass = $("#confirmPassword").val();
        var st_id = '<?= base64_encode($this->session->details->st_id) ?>';

        if (pass !== '') {
            if (pass !== currentPass) {
                $("#passwordMessage").text("Current Password is Incorrect").show();
                return false;
            }
        }

        if (newPass !== confirmPass) {
            $("#passwordMessage").text("New passwords do not match.").show();
            return false;
        }

        $("#passwordMessage").hide();

        // 🔽 Replace with AJAX call to your backend
        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'opl/student/changePass' ?>',
            data: 'st_id=' + st_id + '&newpass=' + newPass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                alert("Password updated successfully!");
                $('#passwordUpdateModal').modal('hide');
            }
        })
    });

    function updateBadge(count) {
        const badge = document.getElementById("msgBadge");
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = "inline-block"; // show
        } else {
            badge.style.display = "none"; // hide when 0
        }
    }

    // Example usage:
    updateBadge(<?= $unread ?>);
</script>