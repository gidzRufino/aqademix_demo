<?php
switch ($this->session->userdata('position')) {
    case 'Teacher - I':
    case 'Teacher - II':
    case 'Faculty':
        $this->load->view('teachers_dashboard');
        break;

    default:
?>
<div class="dashboard-page container-fluid py-3">
    <!-- Dashboard Header -->
    <div class="row mb-3 dashboard-section">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1 class="dashboard-title">Dashboard</h1>
                </div>
                <!-- <div class="text-end text-muted">
                    <span><i class="bi bi-calendar-event"></i> Today: <?= date('F d, Y') ?></span>
                    <span><i class="bi bi-clock"></i> Server time: <?= date('h:i A') ?></span>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Main Dashboard -->
    <div class="row dashboard-section g-3">
        <!-- Left Column: Widgets -->
        <div class="col-lg-8 col-12">
        <div class="row g-4">

            <!-- Attendance Widgets -->
            <div class="col-12">
                <div class="row g-3">

                    <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); ?>

                    <?php if ($settings->level_catered == 5): ?>
                        <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresentCollege'); ?>
                    <?php endif; ?>

                    <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfEmployeePresents'); ?>

                </div>
            </div>

            <!-- Finance Graph (Payment vs Collectible) -->
            <?php if ($this->session->userdata('position_id') == 1 || $this->session->userdata('position_id') == 271288): ?>
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3 text-primary">
                                Payment vs Collectible
                            </h5>
                            <?php echo Modules::run('finance/paymentVsCollectibleGraph'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>


        <!-- Right Column -->
<div class="col-xl-4 col-lg-5 col-12 d-flex flex-column gap-4">

<!-- School Calendar -->
<div class="card modern-card">

    <div class="card-body p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div class="d-flex align-items-center gap-2">
                <div class="icon-pill bg-primary text-white">
                    <i class="fa fa-calendar"></i>
                </div>
                <div>
                    <h6 class="fw-semibold mb-0">School Calendar</h6>
                    <small class="text-muted">Academic Schedule</small>
                </div>
            </div>

            <!-- Month Label -->
            <span class="badge bg-primary-subtle text-primary">
                <?php echo date('F Y'); ?>
            </span>

        </div>

        <!-- Calendar Container -->
        <div class="calendar-shell">

            <?php
            /* ===== KEEP YOUR EXISTING LOGIC 100% INTACT ===== */
            $days = 0;
            $gs_start = date('m', strtotime($settings->bosy));
            $yy = date('Y', strtotime($settings->bosy));
            $gs_end = date('m', strtotime($settings->eosy));
            $cc = 12 - ($gs_start - 2);

            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                ($cc == 0 ? 0 : $cc--);
                $year = ($cc == 0 ? ($yy + 1) : $yy);
                $m = $i;
                $mo_in_num = ($m > 12
                    ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12))
                    : $m
                );

                $firstDay = Modules::run(
                    'main/getFirstLastDay',
                    date("F", mktime(0, 0, 0, $mo_in_num, 10)),
                    $year,
                    'first'
                );

                $lastDay = Modules::run(
                    'main/getFirstLastDay',
                    date("F", mktime(0, 0, 0, $mo_in_num, 10)),
                    $year,
                    'last'
                );

                for ($x = $firstDay; $x <= $lastDay; $x++) {
                    $day = date('D', strtotime($year . '-' . $mo_in_num . '-' . $x));
                    $isClass = Modules::run(
                        'calendar/getSpecificDateEvent',
                        date('Y-m-d', strtotime($year . '-' . $mo_in_num . '-' . $x))
                    );
                    $isHoliday = Modules::run(
                        'calendar/isHoliday',
                        date('Y-m-d', strtotime($year . '-' . $mo_in_num . '-' . $x))
                    );

                    if ($day == 'Sat' || $day == 'Sun') {
                        if ($isClass) $days++;
                    } else {
                        if (!$isHoliday) $days++;
                    }
                }

                $monthName = date('F', strtotime(date('Y-' . $mo_in_num . '-01')));
                Modules::run(
                    'reports/insertNumSchoolDays',
                    $monthName,
                    $settings->school_year,
                    $days,
                    2
                );
                $days = 0;
            endfor;

            echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
            ?>

        </div>

    </div>
</div>

<!-- Notifications -->
<div class="card modern-card">

    <div class="card-body p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div class="d-flex align-items-center gap-2">
                <div class="icon-pill bg-warning text-dark position-relative">
                    <i class="fa fa-bell"></i>

                    <!-- Badge (optional dynamic later) -->
                    <span class="notif-badge"></span>
                </div>
                <div>
                    <h6 class="fw-semibold mb-0">Notifications</h6>
                    <small class="text-muted">Latest updates</small>
                </div>
            </div>

        </div>

        <!-- Notification Widget -->
        <div class="notification-list">
            <?php echo Modules::run('widgets/getWidget', 'notification_widgets', 'dashboard'); ?>
        </div>

    </div>
</div>

</div>

    </div>
</div>

<!-- Optional Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".dashboard-section").forEach(function(el) {
            el.classList.add("is-visible");
        });
    });

document.addEventListener('DOMContentLoaded', () => {
    const notifContainer = document.querySelector('.notification-list');
    const badge = document.querySelector('.notif-badge');

    if (!notifContainer || !badge) return;

    const items = notifContainer.querySelectorAll('.notification-item, li, .list-group-item');

    if (items.length > 0) {
        badge.style.display = 'block';
        badge.title = items.length + ' unread notifications';
    } else {
        badge.style.display = 'none';
    }
});

</script>

<style>
.dashboard-page {
    background: radial-gradient(circle at top left, #f0f5ff 0, #f7f9fc 40%, #eef2f7 100%);
    padding-bottom: 30px;
}

.dashboard-title { font-size: 26px; font-weight: 600; color: #1f2933; letter-spacing: 0.02em; margin-bottom: 0; }
.dashboard-subtitle { color: #6b7280; font-size: 13px; margin-top: 4px; }
.dashboard-section { opacity: 0; transform: translateY(8px); transition: all 0.35s ease-out; }
.dashboard-section.is-visible { opacity: 1; transform: translateY(0); }

@media (max-width: 991px) {
    .dashboard-page .text-end { text-align: start !important; margin-top: 8px; }
}
@media (max-width: 767px) {
    .dashboard-title { font-size: 22px; }
}

/* Icon Pill */
.icon-pill {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

/* ===== CALENDAR VISUAL UPGRADE ===== */

/* General calendar table */
.calendar-shell table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 6px;
}

/* Calendar header (days) */
.calendar-shell th {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--bs-secondary);
    text-align: center;
    padding: 6px 0;
}

/* Calendar cells */
.calendar-shell td {
    background: rgba(0,0,0,0.03);
    border-radius: 10px;
    padding: 8px 0;
    text-align: center;
    font-weight: 500;
    cursor: pointer;
    transition: all .2s ease;
}

/* Hover */
.calendar-shell td:hover {
    background: rgba(13,110,253,0.12);
    transform: scale(1.05);
}

/* Today highlight (common class names) */
.calendar-shell .today,
.calendar-shell .current-day {
    background: rgba(13,110,253,0.25) !important;
    color: #0d6efd;
    font-weight: 700;
}

/* Weekend */
.calendar-shell .sun,
.calendar-shell .sat {
    color: #dc3545;
}

/* Event / class day */
.calendar-shell .has-event,
.calendar-shell .event-day {
    background: rgba(25,135,84,0.2);
    font-weight: 700;
}

/* Holiday */
.calendar-shell .holiday {
    background: rgba(220,53,69,0.15);
    color: #dc3545;
}

/* Dark mode */
[data-bs-theme="dark"] .calendar-shell td {
    background: rgba(255,255,255,0.06);
}

[data-bs-theme="dark"] .calendar-shell td:hover {
    background: rgba(13,110,253,0.25);
}

@media (max-width: 576px) {

.calendar-shell table {
    border-spacing: 4px;
}

.calendar-shell td {
    font-size: 12px;
    padding: 6px 0;
}

.notification-list {
    max-height: 260px;
    overflow-y: auto;
}
}

.event-cell {
    cursor: pointer;
    position: relative;
}

/* Tooltip on hover using title attribute */
.event-cell:hover::after {
    content: attr(title);
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: #212529;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
}

</style>

<?php
}
?>
