<?php
if ($this->session->isParent): ?>
    <section>
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h5 class="page-header"><i class="nav-icon fas fa-tasks"></i> List of Task</h5>
                <table class="table table-striped table-responsive-sm col-12">
                    <thead>
                        <tr>
                            <th></th>
                            <th>TASK TITLE</th>
                            <th>DATE CREATED</th>
                            <th class="text-center">DEADLINE FOR SUBMISSION</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="taskBody">
                        <?php echo $this->load->view('../students/tr', array('tasks' => $tasks)); ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

<?php else: ?>
    <section>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Title -->
                    <h5 class="page-header m-0 text-primary fw-bold">
                        <i class="nav-icon fas fa-tasks me-2"></i> List of Tasks
                    </h5>

                    <!-- Grading Selector + Search -->
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <label for="taskGrading" class="form-label mb-0 me-2 fw-semibold">Grading:</label>
                        <select id="taskGrading" class="form-select form-select-sm" style="width: 150px;">
                            <option value="1">1st Grading</option>
                            <option value="2">2nd Grading</option>
                            <option value="3">3rd Grading</option>
                            <option value="4">4th Grading</option>
                        </select>

                        <!-- Optional Search -->
                        <div class="input-group input-group-sm ms-2" style="width: 200px;">
                            <input type="text" id="searchTask" class="form-control" placeholder="Search task...">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px;"></th>
                                <th>TASK TITLE</th>
                                <th>START DATE</th>
                                <th class="text-center">DEADLINE</th>
                                <?php if (!$this->session->isOplAdmin): ?>
                                    <th class="text-center">ACTION</th>
                                <?php endif; ?>
                            </tr>
                        </thead>

                        <tbody id="taskBody">
                            <?php
                            // echo $this->load->view('tr', array('tasks' => $tasks));
                            ?>
                            <!-- Example empty state -->
                            <tr>
                                <td colspan="5" class="text-center p-4 text-muted">
                                    <i class="fas fa-tasks fa-2x mb-2"></i>
                                    <div>No tasks available for this grading period</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
<?php
if (!$this->session->isOplAdmin && !$this->session->isParent):
    echo $this->load->view('tasks/editTask');
endif;
?>
<script type="text/javascript">
    $(document).ready(function() {

        fetchtask($('#taskGrading').val())

        $('.dateTime').each(function() {
            var id = $(this).attr('task_id');
            var dateTime = $(this).val();
            getCountDown(id, dateTime);
        });

    });

    $('#taskGrading').on('change', function(e) {
        e.preventDefault()
        fetchtask($(this).val());

    })

    function fetchtask(term) {
        let task = '<?php echo json_encode($tasks) ?>'
        var sy = '<?= $school_year ?>'
        var url = '<?= base_url() . 'opl/displayTaskList' ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'task=' + task + '&term=' + term + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#taskBody').html(data)
            }
        })
    }


    function getCountDown(id, dateTime) {
        // Set the date we're counting down to
        var countDownDate = new Date(dateTime).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {


            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            var d = (days === 0 ? "" : days + "d ");

            document.getElementById("op_id_" + id).innerHTML = d + hours + "h " +
                minutes + "m ";
            //            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
            //                    + minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
                $('#op_id_' + id).html(dateTime);
            }
        }, 1000);
    };


    // $("#searchTask").keyup(function(){
    //     var searchVal = $(this).val();
    //     console.log(searchVal);

    //     var base = $("#base").val()

    //     var url = base + 'opl/searchTask';

    //     if(searchVal != ""){
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: {
    //                 searchTask     : searchVal,
    //                 csrf_test_name  : $.cookie('csrf_cookie_name')
    //             }, // serializes the form's elements.
    //             success: function (data)
    //             {
    //                 $("#taskBody").html(data)

    //             },
    //             error: function (data){ 
    //                 console.log(data.responseText);
    //             }
    //         });
    //     }

    // });
</script>