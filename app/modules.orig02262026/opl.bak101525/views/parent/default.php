<style>
    :root {
        --primary: #4e73df;
        --primary-dark: #224abe;
        --success: #1cc88a;
        --success-dark: #198754;
        --info: #36b9cc;
        --info-dark: #117a8b;
        --danger: #e63946;
    }

    body {
        background: linear-gradient(120deg, #f4f6f9, #eef1f5);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding-bottom: 40px;
    }

    /* Card enhancements */
    .card {
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        /* Title left, avatars right */
        align-items: center;
        border-bottom: none !important;
        background-color: transparent;
        padding: 12px 16px;
    }

    /* Chart container fix */
    .chart-container {
        position: relative;
        height: 220px;
    }

    /* Navigation avatars on right */
    .card-header .nav-tabs {
        border-bottom: none !important;
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        margin-top: 0;
        /* No overlap */
    }

    /* Profile Avatars Nav */
    .nav-tabs {
        border-bottom: none !important;
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: -30px;
    }

    .nav-tabs .nav-link {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        position: relative;
    }

    /* Glow effect */
    .nav-tabs .nav-link::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 85px;
        height: 85px;
        background: radial-gradient(circle, rgba(0, 123, 255, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        filter: blur(8px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-tabs .nav-link:hover::before,
    .nav-tabs .nav-link.active::before {
        opacity: 1;
    }

    /* Avatar styling */
    .nav-tabs .nav-link img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        background: white;
        position: relative;
        z-index: 1;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        filter: grayscale(100%);
        opacity: 0.75;
    }

    .nav-tabs .nav-link.active img {
        filter: grayscale(0%);
        opacity: 1;
        border: 3px solid var(--primary);
        box-shadow: 0 0 25px rgba(78, 115, 223, 0.6), 0 6px 20px rgba(78, 115, 223, 0.4);
        transform: scale(1.15);
    }

    /* List group items */
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: transparent;
    }

    .alert-list li {
        padding: 6px 0;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Tooltip Styling */
    .tooltip-inner {
        background-color: white !important;
        color: #333 !important;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        border: 1px solid #eee;
    }

    .tooltip.show .tooltip-inner {
        opacity: 1;
    }

    @media (max-width: 768px) {
        .nav-tabs {
            gap: 14px;
        }

        .nav-tabs .nav-link img {
            width: 52px;
            height: 52px;
        }
    }
</style>

<div class="content-area w-100">
    <div class="container-fluid">
        <div class="card text-center">
            <div class="card-header">
                <span class="card-title">Student Dashboard</span>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="tooltip" title="Female">
                            <img src="<?php echo base_url('images/avatar/female.png'); ?>" alt="Female">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="tooltip" title="Male">
                            <img src="<?php echo base_url('images/avatar/male.png'); ?>" alt="Male">
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <!-- Grade Chart -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Grade Trend</span>
                                    <div class="text-right">
                                        <div class="small text-uppercase">Average Grade</div>
                                        <h4 class="mb-0 text-primary">91.4%</h4>
                                    </div>
                                </div>
                                <div class="card-body chart-container">
                                    <canvas id="gradeChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Chart -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Attendance This Month</span>
                                    <div class="text-right">
                                        <div class="small text-uppercase">Attendance Rate</div>
                                        <h4 class="mb-0 text-success">98%</h4>
                                    </div>
                                </div>
                                <div class="card-body chart-container">
                                    <canvas id="attendanceChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Alerts -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">Recent Activity</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span><i class="fas fa-check-circle text-success"></i> Juan submitted <strong>Math Homework #4</strong></span>
                            <span class="text-muted small">2 hrs ago</span>
                        </li>
                        <li class="list-group-item">
                            <span><i class="fas fa-star text-warning"></i> Science quiz result: <strong>92%</strong></span>
                            <span class="text-muted small">Yesterday</span>
                        </li>
                        <li class="list-group-item">
                            <span><i class="fas fa-calendar text-primary"></i> Parent-Teacher Meeting: <strong>Aug 10</strong></span>
                            <span class="text-muted small">Upcoming</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">Alerts / Upcoming Events</div>
                    <div class="card-body">
                        <ul class="alert-list mb-0">
                            <li><i class="fas fa-bell text-danger"></i> Tuition payment deadline: <strong>Aug 15</strong></li>
                            <li><i class="fas fa-clock text-warning"></i> Project submission: <strong>Aug 20</strong></li>
                            <li><i class="fas fa-graduation-cap text-success"></i> Recognition Day: <strong>Sep 5</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            animation: true
        });
    });
    // Grade Chart (Line)
    new Chart(document.getElementById('gradeChart'), {
        type: 'line',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Grade %',
                data: [80, 91, 87, 92],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.15)',
                borderWidth: 3,
                pointBackgroundColor: '#224abe',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#224abe',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => value + '%'
                    }
                }
            }
        }
    });

    // Attendance Chart (Bar)
    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Days Present',
                data: [4, 3, 4, 5],
                backgroundColor: 'rgba(28, 200, 138, 0.85)',
                borderColor: '#198754',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>