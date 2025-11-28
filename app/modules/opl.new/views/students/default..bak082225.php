<!--<div class="card card-widget">
    <div class="card-header">
        <h6>Quick Post</h6>
    </div>
    <div class="card-body">
        <div class="form-group">
            <textarea class="textarea" id="postDetails" placeholder="Hey! What's Up!"
                      style="font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>

        <button class="btn btn-primary btn-sm" onclick="submitQuickPost()">POST</button>
    </div>
</div>-->
<div class="container-fluid">
    <!-- Header -->
    <div class="row dashboard-header">
        <div class="col-sm-1">
            <img src="https://via.placeholder.com/60" width="60" height="60" alt="Profile">
        </div>
        <div class="col-sm-11">
            <h3>Welcome, John Doe</h3>
            <p>Student ID: 2025001 | Grade: 10 - Section A</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row">
        <div class="col-sm-4">
            <a href="subjects.html" class="panel-stat">
                <i class="fa fa-book"></i>
                <h3>8</h3>
                <small>Total Subjects Enrolled</small>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="assignments.html" class="panel-stat">
                <i class="fa fa-check-circle"></i>
                <h3>15</h3>
                <small>Completed Assignments</small>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="notifications.html" class="panel-stat">
                <i class="fa fa-bell"></i>
                <h3>4</h3>
                <small>Unread Notifications</small>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-tasks"></i> Recent Activities
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="status-completed">
                            <td>1</td>
                            <td><i class="fas fa-book text-primary mr-2"></i> Math Assignment</td>
                            <td>
                                <span class="badge badge-success task-badge"
                                    data-toggle="modal" data-target="#taskModal"
                                    data-title="Math Assignment"
                                    data-status="Completed"
                                    data-status-class="text-success"
                                    data-date="2025-08-15"
                                    data-details="This math assignment was submitted and graded successfully.">
                                    <i class="fas fa-check-circle mr-1"></i> Completed
                                </span>
                            </td>
                            <td>2025-08-15</td>
                        </tr>
                        <tr class="status-pending">
                            <td>2</td>
                            <td><i class="fas fa-flask text-info mr-2"></i> Science Project</td>
                            <td>
                                <span class="badge badge-warning task-badge"
                                    data-toggle="modal" data-target="#taskModal"
                                    data-title="Science Project"
                                    data-status="Pending"
                                    data-status-class="text-warning"
                                    data-date="2025-08-18"
                                    data-details="The project outline has been submitted. Waiting for full report.">
                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                </span>
                            </td>
                            <td>2025-08-18</td>
                        </tr>
                        <tr class="status-missed">
                            <td>3</td>
                            <td><i class="fas fa-pencil-alt text-secondary mr-2"></i> English Essay</td>
                            <td>
                                <span class="badge badge-danger task-badge"
                                    data-toggle="modal" data-target="#taskModal"
                                    data-title="English Essay"
                                    data-status="Missed"
                                    data-status-class="text-danger"
                                    data-date="2025-08-10"
                                    data-details="The essay was not submitted before the deadline.">
                                    <i class="fas fa-times-circle mr-1"></i> Missed
                                </span>
                            </td>
                            <td>2025-08-10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Title:</strong> <span id="taskTitle"></span></p>
                    <p><strong>Status:</strong> <span id="taskStatus" class="font-weight-bold"></span></p>
                    <p><strong>Date:</strong> <span id="taskDate"></span></p>
                    <p><strong>Details:</strong> <span id="taskDetails"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
//  print_r($this->session->userdata());
?>
<?php if (count($post) > 1): ?>
    <style>
        @media (min-width: 34em) {
            .card-columns {
                -webkit-column-count: 1;
                -moz-column-count: 1;
                column-count: 1;
            }
        }

        @media (min-width: 75em) {
            .card-columns {
                -webkit-column-count: 2;
                -moz-column-count: 2;
                column-count: 2;
            }
        }
    </style>
<?php else: ?>
    <style>
        @media (min-width: 34em) {
            .card-columns {
                -webkit-column-count: 1;
                -moz-column-count: 1;
                column-count: 1;
            }
        }
    </style>
<?php endif; ?>
<section class="card-columns">
    <?php
    //print_r($this->session->details);

    //if (count($post) > 1):
    //    $col = 'col-lg-6';
    //else:
    //    $col = 'col-lg-12';
    //endif;


    foreach ($post as $p):
        $avatar = site_url('images' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . $this->eskwela->getSet()->set_logo);
        if ($p->avatar != NULL || $p->avatar != ""):
            if (file_exists(FCPATH . "uploads" . DIRECTORY_SEPARATOR . $p->avatar)):
                $avatar = site_url('uploads' . DIRECTORY_SEPARATOR . $p->avatar);
            endif;
            if (file_exists(FCPATH . "uploads" . $this->session->school_year . DIRECTORY_SEPARATOR . 'faculty' . DIRECTORY_SEPARATOR . $p->avatar)):
                $avatar = site_url('uploads' . $this->session->school_year . DIRECTORY_SEPARATOR . 'faculty' . DIRECTORY_SEPARATOR . $p->avatar);
            endif;
        endif;
        $name = ucwords(strtolower($p->firstname . ' ' . $p->lastname));
        if ($p->empid == NULL):
            $student = Modules::run('opl/getStudent', $p->op_owner_id);
            $name = $student->firstname . " " . $student->lastname;
            if (file_exists(FCPATH . "uploads" . $this->session->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $student->avatar)):
                $avatar = site_url('uploads' . $this->session->school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $student->avatar);
            endif;
            $query = $this->db->last_query();
        endif;
    ?>

        <div class="card direct-chat direct-chat-primary">
            <div class="card-header ui-sortable-handle">
                <div class="user-block" hide-query="<?php echo $query; ?>">
                    <img class="img-circle" width="50" src="<?php echo $avatar ?>" alt="User Image">
                    <span class="username"><a href="#"><?php echo $name; ?></a></span>
                    <span class="description">Shared publicly - <time class="timeago" datetime="<?php echo $p->op_timestamp; ?>"><?php echo date('F d, Y g:i a', strtotime($p->op_timestamp)) ?></time> </span>

                </div>
                <?php if ($p->op_owner_id == $this->session->username || $this->session->isOplAdmin || strcmp($this->session->position, "School Administrator") == 0): ?>
                    <button type="button" class="btn btn-outline-danger btn-xs float-right" title="Delete Posts" post-id="<?php echo $p->op_id; ?>" onclick="readyDelete(this)"><i class="fa fa-trash fa-xs"></i></button>
                <?php endif; ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body m-2">
                <?php echo $p->op_post; ?>
            </div>
            <!-- /.card-body -->
            <div class="card-footer pt-1 pb-1" style="background: #F0F0F0">
                <a class="text-xs text-primary" style="cursor: pointer;"><i class="fa fa-thumbs-up fa-xs"></i> Like</a>
            </div>
            <!-- /.card-footer-->
        </div>
    <?php endforeach; ?>
</section>
<script type='text/javascript'>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('.task-badge').on('click', function() {
            $('#taskTitle').text($(this).data('title'));
            $('#taskDate').text($(this).data('date'));
            $('#taskDetails').text($(this).data('details'));

            // Update status with color
            var statusText = $(this).data('status');
            var statusClass = $(this).data('status-class');
            $('#taskStatus').removeClass().addClass('font-weight-bold ' + statusClass).text(statusText);
        });
    });

    $(function() {
        $('.textarea').summernote({
            placeholder: "Hey! What's Up! Anything Interesting?"
        });

        submitQuickPost = function(btn) {
            var base = $('#base').val();
            var post = $('#postDetails').val();
            var url = base + 'opl/submitQuickPost';
            var subject = $(btn).attr('sub-id');

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    postDetails: post,
                    targets: subject,
                    type: 4,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function() {
                    $('#loadingModal').modal('show');
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });

        }

    });
</script>
<style>
    body {
        background: #f4f6f9;
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 14px;
    }

    .dashboard-header {
        background: #337ab7;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
    }

    .dashboard-header img {
        border-radius: 50%;
        margin-right: 15px;
    }

    .panel-stat {
        display: block;
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 6px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        text-decoration: none;
        color: inherit;
    }

    .panel-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    .panel-stat i {
        font-size: 40px;
        margin-bottom: 10px;
        color: #337ab7;
    }

    .panel-stat h3 {
        margin: 5px 0 0 0;
        font-weight: bold;
    }

    .panel-stat small {
        color: #888;
    }
</style>