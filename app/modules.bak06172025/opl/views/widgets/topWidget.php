<?php 
    if($this->uri->segment(2)=='college'):
        $grade_id = NULL;
    endif;
    if($this->uri->segment(2)=='classBulletin' || $this->uri->segment(3) == 'classBulletin'): ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger">
                            <i class="fa fa-quidditch"></i>
                        </span>
                        <span class="info-box-content">
                            <span class="info-box-text">Submitted Quizzes</span>
                            <h3 class="info-box-number text-right" id="submittedQuizCounter">0 / 0</h3>
                        </span>
                        <div class="overlay dark" id="submittedQuizCounterLoader">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div><!--/.col-->
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning">
                            <i class="fa fa-tasks"></i>
                        </span>
                        <span class="info-box-content">
                            <span class="info-box-text">Submitted Assignments</span>
                            <h3 class="info-box-number text-right" id="submittedAssignmentCounter">0 / 0</h3>
                        </span>
                        <div class="overlay dark" id="submittedAssignmentCounterLoader">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div><!--/.col-->
                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            <i class="fa fa-users"></i>
                        </span>
                        <span class="info-box-content">
                            <span class="info-box-text">Number of Students Online</span>
                            <h3 class="info-box-number text-right" id="studentCounter">0</h3>
                        </span>
                        <div class="overlay dark" id="studentCounterLoader">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div><!--/.col-->

            </div><!--/.row-->
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
                        <small class="text-muted">Number of Classes</small><br>
                        <strong class="h4">8</strong>
                    </div>
                </div><!--/.col-->
                <div class="col-sm-3">
                    <div class="callout callout-danger b-t-1 b-r-1 b-b-1">
                        <small class="text-muted">Submitted Quizes</small><br>
                        <strong class="h4">10 / 20</strong>
                    </div>
                </div><!--/.col-->
                <div class="col-sm-3">
                    <div class="callout callout-warning b-t-1 b-r-1 b-b-1">
                        <small class="text-muted">Submitted Assignments</small><br>
                        <strong class="h4">11 / 20</strong>
                    </div>
                </div><!--/.col-->
                <div class="col-sm-3">
                    <div class="callout callout-success b-t-1 b-r-1 b-b-1">
                        <small class="text-muted">Number of Students Online</small><br>
                        <strong class="h4">12</strong>
                    </div>
                </div><!--/.col-->

            </div><!--/.row-->
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function(){
        updateStudentCount();
        updateQuizzes();
        updateSubmitted();
    });

    function updateQuizzes(){
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getTasksByType";
        $.ajax(
            {
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
                success: function(data){
                    if(data.hasUpdate == true){
                        $("#submittedQuizCounter").html(data.submitted+" / "+data.total);
                        if($("#submittedQuizCounterLoader").is(":visible")){
                            $("#submittedQuizCounterLoader").hide();
                        }
                    }
                }
            }
        )
    }

    function updateSubmitted(){
        var base = $("#base").val(),
            url = base + "opl/opl_widgets/getTasksByType";
        $.ajax(
            {
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
                success: function(data){
                    if(data.hasUpdate == true){
                        $("#submittedAssignmentCounter").html(data.submitted+" / "+data.total);
                        if($("#submittedAssignmentCounterLoader").is(":visible")){
                            $("#submittedAssignmentCounterLoader").hide();
                        }
                    }
                }
            }
        )
    }

    function updateStudentCount(){
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
            success: function(data){
                if(data.hasUpdate = true){
                    $("#studentCounter").html(data.count);
                    if($("#studentCounterLoader").is(":visible")){
                        $("#studentCounterLoader").hide();
                    }
                }
            }
        });
    }
</script>