<?php
print_r($this->session->details->school_year);

function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}

// function timeAgo($datetime, $full = false)
// {
//     $now = new DateTime();
//     $ago = new DateTime($datetime);
//     $diff = $now->diff($ago);

//     $diff->w = floor($diff->d / 7);
//     $diff->d -= $diff->w * 7;

//     $string = [
//         'y' => 'year',
//         'm' => 'month',
//         'w' => 'week',
//         'd' => 'day',
//         'h' => 'hour',
//         'i' => 'minute',
//         's' => 'second',
//     ];

//     $result = [];
//     foreach ($string as $k => $v) {
//         if ($diff->$k) {
//             $result[] = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
//         }
//     }

//     if (!$full) $result = array_slice($result, 0, 2); // show only first 2 units
//     return $result ? implode(' and ', $result) . ' ago' : 'just now';
// }

if (count($post) > 1):
    $col = 'col-lg-6';
else:
    $col = 'col-lg-12';
endif;

foreach ($post as $p):
    if ($p->op_target_type == 2):
?>

        <section class="<?php echo $col; ?> float-left">
            <div class="card card-widget">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $p->avatar; ?>" alt="User Image">
                        <span class="username"><a href="#"><?php echo ucwords(strtolower($p->firstname . ' ' . $p->lastname)); ?></a></span>
                        <span class="description">Shared publicly - <?php echo date('F d, Y g:i a', strtotime($p->op_timestamp)) ?> </span>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo $p->op_post; ?>
                </div>
            </div>
        </section>
<?php
    endif;
endforeach;
?>
<div class="container-fluid py-3">

    <!-- Announcement Carousel -->
    <div id="announcementCarousel"
        class="carousel slide carousel-fade shadow rounded overflow-hidden mb-4 mx-auto"
        data-ride="carousel" data-interval="5000" data-pause="hover" style="max-width: 100%;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="announcement-bar p-2 text-white text-center">
                    <i class="fas fa-users me-2"></i>
                    PTA Meeting – Aug 25, 3:00 PM at School Hall
                </div>
            </div>
            <div class="carousel-item">
                <div class="announcement-bar p-2 text-white text-center bg-success-gradient">
                    <i class="fas fa-file-alt me-2"></i>
                    Midterm Exams start Sept 1 – Prepare early!
                </div>
            </div>
            <div class="carousel-item">
                <div class="announcement-bar p-2 text-white text-center bg-danger-gradient">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Tuition Reminder – Payment deadline Aug 30
                </div>
            </div>
        </div>
    </div>

    <!-- Students Section -->
    <h5 class="mb-3 fw-bold text-secondary"><i class="fas fa-child text-primary"></i> My Children</h5>
    <div class="row g-3 mb-4">

        <?php foreach ($students as $s):
            $col = ($total_kids < 3 ? 'col-lg-6' : 'col-lg-4');
            $avatar = getAvatarUrl($s['avatar'], $s['gender']);
            // echo $s['user_id'];
        ?>
            <div class="<?= $col ?> col-md-6 col-12 mb-4">
                <div class="student-card shadow-lg h-100 rounded-3 overflow-hidden">
                    <!-- Header -->
                    <div class="student-header text-white p-3">
                        <div class="d-flex align-items-center">
                            <img src="<?= $avatar ?>" class="rounded-circle border border-light me-3" width="80" height="80" alt="Student">
                            <div>
                                <h6 class="fw-bold mb-1"><?= ucwords(strtolower($s['name'])) ?></h6>
                                <small class="opacity-75"><?= $s['level_section'] ?></small><br>
                                <small class="opacity-75"><?= $s['sid'] ?></small>
                            </div>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-3">
                        <ul class="list-unstyled student-info mb-3">
                            <li><i class="fas fa-check-circle text-success"></i> Attendance: <b><?= $s['att_percent'] ?> %</b></li>
                            <li><i class="fas fa-tasks text-info"></i> Pending Tasks: <b><?= $s['pending'] ?></b></li>
                            <li><i class="fas fa-credit-card text-danger"></i> Amount Due: <b><?= "&#8369;" . number_format($s['amt_due'], 2, '.', ',') ?></b></li>
                        </ul>

                        <div class="teacher-msg bg-light p-2 rounded mb-3 shadow-sm">
                            <i class="fas fa-envelope text-primary"></i>
                            <b>Messages:</b>
                            <!-- <ul class="small ps-3 mt-2 mb-0">
                                <li>John is doing well in Science, keep it up!</li>
                                <li>Needs more practice in Math homework.</li>
                            </ul> -->
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <a href="#" class="btn btn-sm btn-outline-primary flex-fill mx-1" data-toggle="modal" data-target="#gradesModal<?= $s['sid'] ?>"><i class="fas fa-file-alt"></i> Report</a>
                            <a href="#"
                                class="btn btn-sm btn-outline-success flex-fill mx-1"
                                data-toggle="modal"
                                data-target="#taskModal<?= $s['sid'] ?>">
                                <i class="fas fa-book"></i> Tasks
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-danger flex-fill mx-1" data-toggle="modal" data-target="#attendanceModal<?= $s['sid'] ?>"><i class="fas fa-calendar"></i> Attendance</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grades Modal -->
            <div class="modal fade" id="gradesModal<?= $s['sid'] ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#1565c0; color:#fff;">
                            <h4 class="modal-title"><i class="fa fa-graduation-cap"></i> Grades per Subject per Quarter</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <canvas id="gradesChartModal<?= $s['sid'] ?>" style="height:350px;"></canvas>
                        </div>
                    </div>
                </div>
                <script>
                    var gradesChartInstance = null;

                    $('#gradesModal<?= $s['sid'] ?>').on('shown.bs.modal', function() {
                        var ctx = document.getElementById('gradesChartModal<?= $s['sid'] ?>').getContext('2d');
                        if (gradesChartInstance) gradesChartInstance.destroy();
                        gradesChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                // labels: ['Math', 'Science', 'English', 'History', 'PE'],
                                labels: [<?= $s['subjectList'] ?>],
                                datasets: [{
                                        label: "Q1",
                                        // data: [85, 90, 88, 92, 87, 91, 90],
                                        data: [<?= $s['first'] ?>],
                                        backgroundColor: "#42a5f5"
                                    },
                                    {
                                        label: "Q2",
                                        // data: [88, 93, 84, 89, 90, 88, 91],
                                        data: [<?= $s['second'] ?>],
                                        backgroundColor: "#66bb6a"
                                    },
                                    {
                                        label: "Q3",
                                        // data: [90, 95, 86, 91, 92, 93, 92],
                                        data: [<?= $s['third'] ?>],
                                        backgroundColor: "#ffa726"
                                    },
                                    {
                                        label: "Q4",
                                        // data: [92, 97, 89, 94, 95, 95, 89],
                                        data: [<?= $s['fourth'] ?>],
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
                </script>
            </div>

            <!-- Task Modal -->
            <div class="modal fade" id="taskModal<?= $s['sid'] ?>" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel<?= $s['sid'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content rounded-3 shadow">

                        <!-- Header -->
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="taskModalLabel<?= $s['sid'] ?>">
                                <i class="fas fa-book-open"></i> <?= ucwords(strtolower($s['name'])) ?> – Tasks
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <div class="row">

                                <!-- Pending Tasks (Left Column) -->
                                <div class="col-md-6 border-right">
                                    <h6 class="fw-bold text-warning mb-3"><i class="fas fa-hourglass-half"></i> Pending Tasks</h6>
                                    <?php if ($s['pending'] != 0): ?>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($s['tasks'] as $index => $task):
                                                if ($task['status'] == 'Pending'):
                                                    $dueID = "countdown_" . $s['sid'] . "_" . $index;
                                            ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center pointer" onclick="location.href='<?= $task['link'] ?>'">
                                                        <div>
                                                            <i class="fas fa-tasks text-success"></i> <?= $task['task_title'] ?>
                                                            <br><small class="text-danger fw-bold" id="<?= $dueID ?>"></small>
                                                        </div>
                                                        <span class="badge badge-primary badge-pill <?= ($task['status'] == 'Completed') ? 'bg-success' : 'bg-warning text-dark' ?>"><?= $task['status'] ?></span>
                                                    </li>
                                                    <script>
                                                        (function() {
                                                            const countdownEl = document.getElementById("<?= $dueID ?>");
                                                            const dueDate = new Date("<?= $task['due_date'] ?>").getTime();

                                                            function updateCountdown() {
                                                                const now = new Date().getTime();
                                                                const distance = dueDate - now;

                                                                if (distance <= 0) {
                                                                    countdownEl.innerHTML = "⏰ Due!";
                                                                    countdownEl.className = "text-muted fw-bold";
                                                                    return;
                                                                }

                                                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                // Set text
                                                                countdownEl.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s left`;

                                                                // Color coding
                                                                countdownEl.className = "fw-bold"; // reset
                                                                if (days > 3) {
                                                                    countdownEl.classList.add("text-success"); // green
                                                                } else if (days >= 1) {
                                                                    countdownEl.classList.add("text-warning"); // orange
                                                                } else {
                                                                    countdownEl.classList.add("text-danger"); // red
                                                                }
                                                            }

                                                            updateCountdown();
                                                            setInterval(updateCountdown, 1000);
                                                        })();
                                                    </script>
                                            <?php
                                                endif;
                                            endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-check-circle"></i> No pending tasks 🎉
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Completed Tasks (Right Column) -->
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-check"></i> Completed Tasks</h6>
                                    <?php if ($s['completed'] != 0): ?>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($s['tasks'] as $task):
                                                if ($task['status'] == 'Completed'):
                                            ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-check text-success"></i>
                                                            <span><?= $task['task_title'] ?></span>
                                                            <br><small class="text-muted"><?= $task['description'] ?></small>
                                                            <br><small class="text-muted">Date Submitted: <?= date('F j, Y g:i:s a', strtotime($task['dateTime'])) ?></small>
                                                        </div>
                                                    </li>
                                            <?php
                                                endif;
                                            endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <div class="alert alert-light">
                                            <i class="fas fa-archive"></i> No completed tasks yet.
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Attendance Modal -->
            <div class="modal fade" id="attendanceModal<?= $s['sid'] ?>" tabindex="-1">
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
                                <div id="progress-circle<?= $s['sid'] ?>" data-percentage="<?= $s['att_percent'] ?>">
                                    <span class="progress-value" style="font-size: 22px; font-weight: bold;"><?= $s['att_percent'] ?>%</span>
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
                                        <h3 class="stat-value"><?= $s['totalDays'] ?></h3>
                                        <span class="stat-label">Total Days</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card" style="background:#ffebee; border-left:5px solid #d32f2f;">
                                        <i class="fa fa-user-times fa-2x text-danger"></i>
                                        <h3 class="stat-value"><?= ($s['totalDays'] - $s['totalPresent']) ?></h3>
                                        <span class="stat-label">Absent</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card" style="background:#e3f2fd; border-left:5px solid #1565c0;">
                                        <i class="fa fa-check-circle fa-2x text-primary"></i>
                                        <h3 class="stat-value"><?= $s['totalPresent'] ?></h3>
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
                <script>
                    $('#attendanceModal<?= $s['sid'] ?>').on('shown.bs.modal', function() {
                        var circle = document.querySelector("#progress-circle<?= $s['sid'] ?>");
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
                </script>
                <style>
                    #progress-circle<?= $s['sid'] ?> {
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

                    #progress-circle<?= $s['sid'] ?>.progress-value {
                        position: absolute;
                        font-size: 22px;
                        font-weight: bold;
                    }
                </style>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // John Charts
    new Chart(document.getElementById("attendanceChart1"), {
        type: "line",
        data: {
            labels: ["Jun", "Jul", "Aug"],
            datasets: [{
                label: "Attendance %",
                data: [92, 94, 95],
                borderColor: "#007bff",
                backgroundColor: "rgba(0,123,255,0.1)",
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    min: 80,
                    max: 100
                }
            }
        }
    });

    new Chart(document.getElementById("gradesChart1"), {
        type: "bar",
        data: {
            labels: ["Q1", "Q2", "Q3", "Q4"],
            datasets: [{
                label: "Average Grade",
                data: [88, 91, 89, 90],
                backgroundColor: "#007bff",
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100
                }
            }
        }
    });

    // Jane Charts
    new Chart(document.getElementById("attendanceChart2"), {
        type: "line",
        data: {
            labels: ["Jun", "Jul", "Aug"],
            datasets: [{
                label: "Attendance %",
                data: [95, 96, 97],
                borderColor: "#28a745",
                backgroundColor: "rgba(40,167,69,0.1)",
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    min: 80,
                    max: 100
                }
            }
        }
    });

    new Chart(document.getElementById("gradesChart2"), {
        type: "bar",
        data: {
            labels: ["Q1", "Q2", "Q3", "Q4"],
            datasets: [{
                label: "Average Grade",
                data: [90, 92, 91, 93],
                backgroundColor: "#28a745",
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100
                }
            }
        }
    });
</script>

<style>
    body {
        background: #f7faff;
        font-family: 'Segoe UI', sans-serif;
    }

    .student-card {
        transition: all 0.3s ease;
    }

    .student-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.15);
    }

    .student-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .announcement-bar {
        font-size: 1rem;
        font-weight: 500;
        background: linear-gradient(135deg, #007bff, #00b4d8);
        letter-spacing: 0.5px;
        animation: fadeSlide 8s infinite;
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #28a745, #6dd47e);
    }

    .bg-danger-gradient {
        background: linear-gradient(135deg, #ff6b6b, #c92a2a);
    }

    .student-info li {
        font-size: 0.95rem;
        margin-bottom: 6px;
    }

    .teacher-msg {
        font-size: 0.9rem;
        border-left: 4px solid #007bff;
    }

    .btn-sm {
        font-size: 0.85rem;
        border-radius: 25px;
        transition: all 0.2s;
    }

    .btn-sm:hover {
        transform: scale(1.05);
    }

    @keyframes fadeSlide {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }

        10%,
        90% {
            opacity: 1;
            transform: translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateY(10px);
        }
    }

    @media (max-width: 576px) {
        .student-card {
            text-align: center;
        }

        .student-card .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .student-card img {
            margin-bottom: 10px;
        }

        .student-card .d-flex.justify-content-between {
            flex-direction: column;
        }

        .student-card .btn {
            margin-bottom: 5px;
        }
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
</style>