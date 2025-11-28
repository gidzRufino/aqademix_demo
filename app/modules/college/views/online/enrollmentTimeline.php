<?php
$pYear = date('Y');
$presentSY = $this->session->school_year;
?>
<div class="col-lg-12 col-xs-12" style="margin:10px auto; float: none !important">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <?php if ($this->eskwela->getSet()->level_catered == 4): ?>
            <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url('college') ?>'">
            <?php else: ?>
                <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url() ?>'">
                <?php endif; ?>
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:50px; background: white; margin:0 auto;" />
                </div>
                <div class="col-lg-5 col-xs-10">
                    <h1 class="text-left no-margin" style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                    <h6 class="text-left" style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
                </div>

                <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
                <?php if ($school_year != NULL): ?>
                    <h5 class="text-right" style="color:black;">S.Y. <?php echo $school_year . ' - ' . ($school_year + 1) ?><?php echo ($semester == 1 ? ' - First Semester' : ($semester == 2 ? ' - Second Semester' : ($semester == 3 ? ' - Summer' : ''))) ?></h5>
                <?php endif; ?>
            </div>

            <div class="col-md-12"><br>
                <?php if ($school_year != NULL && $semester != NULL): ?>
                    <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('college/enrollment/monitor') ?>'">Enrollment Monitor Menu</button>
                    <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('main/dashboard') ?>'">Dashboard</button>
                <?php else: ?>
                    <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('main/dashboard/') ?>'">Dashboard</button>
                <?php endif; ?>
                <h3 class="pull-left">Enrollment Timeline</h3>
            </div>

            <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px;">
                <?php if ($school_year != NULL && $semester != NULL): ?>

                    <!-- Filter Section -->
                    <div class="col-lg-12 col-xs-12" style="margin-bottom:20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter by Status:</label>
                                <select class="form-control" id="statusFilter" onchange="filterByStatus()">
                                    <option value="">All Statuses</option>
                                    <option value="0">Registration</option>
                                    <option value="3">For Payment</option>
                                    <option value="4">Payment Evaluation</option>
                                    <option value="5">Payment Confirmation</option>
                                    <option value="6">For Evaluation</option>
                                    <option value="1">Officially Enrolled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Search Student:</label>
                                <input type="text" class="form-control" id="searchStudent" placeholder="Search by name..." onkeyup="searchStudent()">
                            </div>
                            <div class="col-md-6">
                                <label>&nbsp;</label><br>
                                <span class="badge badge-info">Total Enrollees: <strong id="totalCount"><?php echo count($allEnrollees) ?></strong></span>
                                <span class="badge badge-warning" id="filteredCount" style="display:none;">Filtered: <strong id="filteredNum">0</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Timeline for Each Student -->
                    <div class="col-lg-12 col-xs-12" id="timelineContainer">
                        <?php if (!empty($allEnrollees)): ?>
                            <?php foreach ($allEnrollees as $index => $student): ?>
                                <?php
                                // Determine status label and color
                                $statusLabel = '';
                                $statusColor = '';
                                $statusIcon = '';

                                // Get current status
                                $currentStatus = isset($student->status) ? $student->status : 0;

                                // Determine status label and color based on current status
                                switch ($currentStatus):
                                    case 0:
                                        $statusLabel = 'Registration';
                                        $statusColor = 'default';
                                        $statusIcon = 'fa-user';
                                        break;
                                    case 3:
                                        $statusLabel = 'For Payment';
                                        $statusColor = 'warning';
                                        $statusIcon = 'fa-money';
                                        break;
                                    case 4:
                                        $statusLabel = 'Payment Evaluation';
                                        $statusColor = 'danger';
                                        $statusIcon = 'fa-credit-card';
                                        break;
                                    case 5:
                                        $statusLabel = 'Payment Confirmation';
                                        $statusColor = 'info';
                                        $statusIcon = 'fa-check-circle';
                                        break;
                                    case 6:
                                        $statusLabel = 'For Evaluation';
                                        $statusColor = 'primary';
                                        $statusIcon = 'fa-hourglass-half';
                                        break;
                                    case 1:
                                        $statusLabel = 'Officially Enrolled';
                                        $statusColor = 'success';
                                        $statusIcon = 'fa-award';
                                        break;
                                    default:
                                        $statusLabel = 'Unknown';
                                        $statusColor = 'secondary';
                                        $statusIcon = 'fa-question';
                                        break;
                                endswitch;

                                // Determine which stages are completed
                                $registrationComplete = ($currentStatus >= 0);
                                $paymentComplete = ($currentStatus >= 3);
                                $confirmationComplete = ($currentStatus >= 5 || $currentStatus == 1);
                                $enrolledComplete = ($currentStatus == 1);

                                // Student name and details
                                $firstName = isset($student->firstname) ? $student->firstname : 'N/A';
                                $lastName = isset($student->lastname) ? $student->lastname : 'N/A';
                                $studentName = strtoupper($lastName . ', ' . $firstName);
                                $studentLevel = isset($student->course) ? $student->course : (isset($student->level) ? $student->level : 'N/A');
                                $studentId = isset($student->st_id) ? $student->st_id : '';
                                $dateAdmitted = 'N/A';
                                if (isset($student->date_admitted) && $student->date_admitted != NULL && $student->date_admitted != '0000-00-00'):
                                    $dateAdmitted = date('M d, Y', strtotime($student->date_admitted));
                                endif;
                                ?>

                                <div class="panel panel-default student-timeline-card"
                                    data-status="<?php echo $currentStatus ?>"
                                    data-name="<?php echo strtolower($firstName . ' ' . $lastName) ?>"
                                    style="margin-bottom: 20px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <!-- Student Information -->
                                            <div class="col-md-3">
                                                <h5><strong><?php echo $studentName ?></strong></h5>
                                                <p class="text-muted">
                                                    <i class="fa fa-graduation-cap"></i> <?php echo $studentLevel ?><br>
                                                    <i class="fa fa-calendar"></i> <?php echo $dateAdmitted ?><br>
                                                    <span class="label label-<?php echo $statusColor ?>">
                                                        <i class="fa <?php echo $statusIcon ?>"></i> <?php echo $statusLabel ?>
                                                    </span>
                                                </p>
                                                <?php if ($studentId): ?>
                                                    <a href="<?php echo base_url('college/enrollment/monitor') . '/' . $semester . '/' . $school_year . '/' . (isset($student->course) ? 5 : 1) . '/' . base64_encode($studentId) ?>"
                                                        class="btn btn-xs btn-primary">
                                                        <i class="fa fa-eye"></i> View Details
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Timeline Progress -->
                                            <div class="col-md-9">
                                                <div class="enrollment-timeline">
                                                    <!-- Registration Stage -->
                                                    <div class="timeline-step <?php echo $registrationComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 0) ? 'active' : '' ?>">
                                                        <div class="timeline-step-icon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <div class="timeline-step-content">
                                                            <h6>Registration</h6>
                                                            <small>Application Submitted</small>
                                                        </div>
                                                    </div>

                                                    <!-- Payment Stage -->
                                                    <div class="timeline-step <?php echo $paymentComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 3 || $currentStatus == 4) ? 'active' : '' ?>">
                                                        <div class="timeline-step-icon">
                                                            <i class="fa fa-money"></i>
                                                        </div>
                                                        <div class="timeline-step-content">
                                                            <h6>Payment</h6>
                                                            <small>Make Payment</small>
                                                        </div>
                                                    </div>

                                                    <!-- Confirmation Stage -->
                                                    <div class="timeline-step <?php echo $confirmationComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 5 || $currentStatus == 6) ? 'active' : '' ?>">
                                                        <div class="timeline-step-icon">
                                                            <i class="fa fa-check-circle"></i>
                                                        </div>
                                                        <div class="timeline-step-content">
                                                            <h6>Confirmation</h6>
                                                            <small>Payment Verified</small>
                                                        </div>
                                                    </div>

                                                    <!-- Officially Enrolled Stage -->
                                                    <div class="timeline-step <?php echo $enrolledComplete ? 'completed' : '' ?> <?php echo ($currentStatus == 1) ? 'active' : '' ?>">
                                                        <div class="timeline-step-icon">
                                                            <i class="fa fa-award"></i>
                                                        </div>
                                                        <div class="timeline-step-content">
                                                            <h6>Officially Enrolled</h6>
                                                            <small>Enrollment Complete</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No enrollees found for the selected semester and school year.
                            </div>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> Please select a semester and school year to view enrollment timeline.
                    </div>
                <?php endif; ?>
            </div>
    </div>

    <style type="text/css">
        .enrollment-timeline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            padding: 20px 0;
        }

        .enrollment-timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background: #e0e0e0;
            z-index: 0;
            transform: translateY(-50%);
        }

        .timeline-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .timeline-step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 10px;
            border: 3px solid #fff;
            transition: all 0.3s ease;
        }

        .timeline-step.completed .timeline-step-icon {
            background: #5cb85c;
            color: #fff;
            border-color: #5cb85c;
        }

        .timeline-step.active .timeline-step-icon {
            background: #f0ad4e;
            color: #fff;
            border-color: #f0ad4e;
            animation: pulse 2s infinite;
        }

        .timeline-step.active.completed .timeline-step-icon {
            background: #5cb85c;
            border-color: #5cb85c;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(240, 173, 78, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(240, 173, 78, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(240, 173, 78, 0);
            }
        }

        .timeline-step-content {
            text-align: center;
        }

        .timeline-step-content h6 {
            margin: 5px 0;
            font-weight: bold;
            color: #333;
        }

        .timeline-step.completed .timeline-step-content h6 {
            color: #5cb85c;
        }

        .timeline-step.active .timeline-step-content h6 {
            color: #f0ad4e;
            font-weight: bold;
        }

        .timeline-step-content small {
            color: #999;
            font-size: 11px;
        }

        .student-timeline-card {
            transition: all 0.3s ease;
        }

        .student-timeline-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .student-timeline-card.hidden {
            display: none;
        }

        /* Progress line between completed steps */
        .enrollment-timeline .timeline-step.completed::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 3px;
            background: #5cb85c;
            z-index: -1;
            transform: translateY(-50%);
        }

        .enrollment-timeline .timeline-step:first-child.completed::after {
            left: 50%;
            width: 50%;
        }

        .enrollment-timeline .timeline-step:last-child.completed::after {
            width: 0;
        }

        @media (max-width: 768px) {
            .enrollment-timeline {
                flex-direction: column;
                align-items: flex-start;
            }

            .enrollment-timeline::before {
                display: none;
            }

            .timeline-step {
                width: 100%;
                flex-direction: row;
                margin-bottom: 15px;
                padding-left: 20px;
            }

            .timeline-step-icon {
                margin-right: 15px;
                margin-bottom: 0;
            }

            .timeline-step-content {
                text-align: left;
            }
        }
    </style>

    <script type="text/javascript">
        function filterByStatus() {
            var statusFilter = document.getElementById('statusFilter').value;
            var cards = document.querySelectorAll('.student-timeline-card');
            var visibleCount = 0;

            cards.forEach(function(card) {
                var cardStatus = card.getAttribute('data-status');
                if (statusFilter === '' || cardStatus === statusFilter) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Update filtered count
            if (statusFilter !== '') {
                document.getElementById('filteredCount').style.display = 'inline-block';
                document.getElementById('filteredNum').textContent = visibleCount;
            } else {
                document.getElementById('filteredCount').style.display = 'none';
            }
        }

        function searchStudent() {
            var searchTerm = document.getElementById('searchStudent').value.toLowerCase();
            var cards = document.querySelectorAll('.student-timeline-card');
            var statusFilter = document.getElementById('statusFilter').value;
            var visibleCount = 0;

            cards.forEach(function(card) {
                var cardName = card.getAttribute('data-name');
                var cardStatus = card.getAttribute('data-status');

                var matchesSearch = cardName.includes(searchTerm);
                var matchesStatus = (statusFilter === '' || cardStatus === statusFilter);

                if (matchesSearch && matchesStatus) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Update filtered count
            if (searchTerm !== '' || statusFilter !== '') {
                document.getElementById('filteredCount').style.display = 'inline-block';
                document.getElementById('filteredNum').textContent = visibleCount;
            } else {
                document.getElementById('filteredCount').style.display = 'none';
            }
        }

        // Combine both filters
        document.getElementById('statusFilter').addEventListener('change', function() {
            filterByStatus();
            searchStudent();
        });

        document.getElementById('searchStudent').addEventListener('keyup', function() {
            searchStudent();
        });
    </script>