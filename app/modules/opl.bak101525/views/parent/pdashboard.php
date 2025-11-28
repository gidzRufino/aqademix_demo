<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parent Portal Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            width: 260px;
            background-color: #ffffff;
            color: #333;
            border-right: 1px solid #dee2e6;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.03);
        }

        .sidebar .sidebar-header {
            padding: 1.5rem;
            font-size: 1.4rem;
            text-align: center;
            background-color: #f8f9fa;
            letter-spacing: 1px;
            border-bottom: 1px solid #dee2e6;
            color: #007bff;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 0.9rem 1.5rem;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9f5ff;
            color: #007bff;
            border-left: 3px solid #007bff;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            min-width: 20px;
            color: #6c757d;
        }

        .sidebar-footer {
            padding: 1rem;
            font-size: 0.85rem;
            color: #6c757d;
            background-color: #f8f9fa;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }


        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -260px;
                z-index: 1030;
                transition: left 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .content-area {
                padding-top: 60px;
            }
        }

        .content-area {
            flex-grow: 1;
            padding: 2rem;
        }

        .navbar-toggler {
            border: none;
            outline: none;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>
</head>

<body>
    <!-- Mobile Navbar -->
    <nav class="navbar navbar-dark bg-dark d-lg-none">
        <button class="navbar-toggler" type="button" id="sidebarToggle">
            <i class="fas fa-bars text-white"></i>
        </button>
        <span class="navbar-brand mb-0 h1 ml-2">Parent Portal</span>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebarMenu">
            <div class="sidebar-header">
                <i class="fas fa-user-shield"></i> Parent Portal
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user-graduate"></i> Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i> Grades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-calendar-check"></i> Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
            <div class="sidebar-footer mt-auto">&copy; 2025 School System</div>
        </nav>

        <!-- Content Area -->
        <div class="content-area w-100">
            <div class="container-fluid">
                <div class="mb-4">
                    <h2 class="font-weight-bold">Welcome back, Parent!</h2>
                    <p class="text-muted">Here's a quick overview of your child's academic progress.</p>
                </div>

                <!-- Stat Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-left-primary h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-primary text-uppercase mb-1">Average Grade</div>
                                    <h4 class="mb-0">91.4%</h4>
                                </div>
                                <i class="fas fa-chart-line fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-left-success h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-success text-uppercase mb-1">Attendance Rate</div>
                                    <h4 class="mb-0">98%</h4>
                                </div>
                                <i class="fas fa-calendar-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-left-info h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-info text-uppercase mb-1">New Messages</div>
                                    <h4 class="mb-0">3</h4>
                                </div>
                                <i class="fas fa-envelope fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white font-weight-bold">Grade Trend</div>
                            <div class="card-body chart-container">
                                <canvas id="gradeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white font-weight-bold">Attendance This Month</div>
                            <div class="card-body chart-container">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Alerts -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white font-weight-bold">Recent Activity</div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fas fa-check-circle text-success mr-2"></i> Juan submitted <strong>Math Homework #4</strong>
                                    <span class="float-right text-muted small">2 hrs ago</span>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-star text-warning mr-2"></i> Science quiz result: <strong>92%</strong>
                                    <span class="float-right text-muted small">Yesterday</span>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-calendar text-primary mr-2"></i> Parent-Teacher Meeting: <strong>Aug 10</strong>
                                    <span class="float-right text-muted small">Upcoming</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white font-weight-bold">Alerts / Upcoming Events</div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-bell text-danger mr-2"></i> Tuition payment deadline: <strong>Aug 15</strong></li>
                                    <li><i class="fas fa-clock text-warning mr-2"></i> Project submission: <strong>Aug 20</strong></li>
                                    <li><i class="fas fa-graduation-cap text-success mr-2"></i> Recognition Day: <strong>Sep 5</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $('#sidebarToggle').on('click', function() {
            $('#sidebarMenu').toggleClass('show');
        });

        // Grade Chart
        new Chart(document.getElementById('gradeChart'), {
            type: 'line',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{
                    label: 'Grade %',
                    data: [89, 91, 93, 92],
                    borderColor: '#007bff',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Attendance Chart
        new Chart(document.getElementById('attendanceChart'), {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Days Present',
                    data: [5, 5, 4, 5],
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>