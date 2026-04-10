<!--Add Subject Modal-->

<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-book me-2"></i>Assign Subject
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-semibold">Grade Level</label>
                        <select id="inputGradeAssign"
                            class="form-select"
                            onclick="selectSectionAssign(this.value), getSubjects(this.value)">
                            <option value="0">Select Grade Level</option>

                            <?php foreach ($GradeLevel as $level): ?>
                                <option value="<?php echo $level->grade_id; ?>">
                                    <?php echo $level->level; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Section</label>
                        <select id="inputSectionAssign" class="form-select">
                            <option>Select Section</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Subject</label>
                        <select id="inputSubjectAssign" class="form-select">
                            <option>Select Subject</option>
                            <option value="add">Add Subject</option>

                            <?php foreach ($subjects as $s): ?>
                                <option value="<?php echo $s->subject_id; ?>">
                                    <?php echo $s->subject; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-12 d-none" id="tle_specs">
                        <label class="form-label fw-semibold">Specialization</label>
                        <select id="inputSpecialization" class="form-select">
                            <option>Select Specialization</option>

                            <?php foreach ($specs as $s): ?>
                                <option value="<?php echo $s->specialization_id; ?>">
                                    <?php echo $s->specialization; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button onclick="setAssignment()" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    Assign Subject
                </button>
            </div>

        </div>
    </div>
</div>

<!--Schedule Modal-->
<div class="modal fade" id="schedule" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa fa-clock me-2"></i>Set Schedule
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="addSchedForm">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Day</label>
                        <select name="inputDay" id="inputDay" class="form-select">
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                        </select>
                    </div>

                    <label class="form-label fw-semibold">From</label>

                    <div class="row g-2 mb-3">

                        <div class="col-4">
                            <select id="inputHourFrom" class="form-select" onclick="setFinalHour()">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo sprintf("%02d", $i) ?>">
                                        <?php echo sprintf("%02d", $i) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <select id="inputMinutesFrom" class="form-select" onclick="setFinalHour()">
                                <?php for ($i = 0; $i < 60; $i++): ?>
                                    <option value="<?php echo sprintf("%02d", $i) ?>">
                                        <?php echo sprintf("%02d", $i) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <select id="inputAmPmFrom" class="form-select" onclick="setFinalHour()">
                                <option>AM</option>
                                <option>PM</option>
                            </select>
                        </div>

                    </div>

                    <label class="form-label fw-semibold">To</label>

                    <div class="row g-2 mb-3">

                        <div class="col-4">
                            <select id="inputHourTo" class="form-select" onclick="setFinalHour()">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo sprintf("%02d", $i) ?>">
                                        <?php echo sprintf("%02d", $i) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <select id="inputMinutesTo" class="form-select" onclick="setFinalHour()">
                                <?php for ($i = 0; $i < 60; $i++): ?>
                                    <option value="<?php echo sprintf("%02d", $i) ?>">
                                        <?php echo sprintf("%02d", $i) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <select id="inputAmPmTo" class="form-select" onclick="setFinalHour()">
                                <option>AM</option>
                                <option>PM</option>
                            </select>
                        </div>

                    </div>

                    <input type="hidden" id="finalTime" name="finalTime">
                    <input type="hidden" id="inputAssignmentID" name="inputAssignmentID">

                </form>

                <div id="resultSection" class="small text-muted"></div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="addSchedSubmit" class="btn btn-success">
                    <i class="fa fa-save me-1"></i>
                    Save Schedule
                </button>
            </div>

        </div>
    </div>
</div>

<!--Advisory Assignment Modal-->
<div class="modal fade" id="advisoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fa fa-user me-2"></i>Advisory Assignment
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Grade Level</label>
                        <select id="inputGradeModal"
                            class="form-select"
                            onclick="selectSection(this.value)">
                            <option>Select Grade Level</option>

                            <?php foreach ($GradeLevel as $level): ?>
                                <option value="<?php echo $level->grade_id; ?>">
                                    <?php echo $level->level; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Section</label>
                        <select id="inputSectionModal" class="form-select">
                            <option>Select Section</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="addAdvisorySubmit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i>
                    Save Advisory
                </button>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    //     function setAssignment()
    //      {
    //          var teacher = $('#em_id').val();
    //          var subject = document.getElementById("inputSubjectAssign").value;
    //          var gradelevel = document.getElementById("inputGradeAssign").value;
    //          var section = document.getElementById("inputSectionAssign").value;
    //         if(subject==='10'){
    //             switch(gradelevel)
    //             {
    //                 case '10':
    //                 case '11':
    //                     var specs = $('#inputSpecialization').val();
    //                 break;
    //             }
    //         }else{ specs = 0; }

    //         var url = "<?php echo base_url() . 'academic/setAssignment' ?>"; // the script where you handle the form input.

    //         $.ajax({
    //                type: "POST",
    //                url: url,
    //                dataType:'json',
    //                data: "teacher="+teacher+'&specs='+specs+"&subject="+subject+"&gradeLevel="+gradelevel+"&section="+section+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
    //                success: function(data)
    //                {
    //                    if(data.status){
    //                        $('#notify_me').html(data.msg)
    //                    }else{
    //                        $('#subjectsAssignedTable').html(data.data)
    //                        $('#notify_me').html(data.msg)
    //                    }
    //                     $('#notify_me').show();
    //                     $('#notify_me').fadeOut(5000);
    // //                   $('#notify_me').html(data);
    // //                   $('#alert-info').fadeOut(5000);
    //                }
    //              });

    //         return false; 
    //      }

    function setFinalHour() {
        var hourFrom = document.getElementById("inputHourFrom").value;
        var minutesFrom = document.getElementById("inputMinutesFrom").value;
        var AmPmFrom = document.getElementById("inputAmPmFrom").value;
        var hourTo = document.getElementById("inputHourTo").value;
        var minutesTo = document.getElementById("inputMinutesTo").value;
        var AmPmTo = document.getElementById("inputAmPmTo").value;

        var finalTime = hourFrom + ":" + minutesFrom + " " + AmPmFrom + " - " + hourTo + ":" + minutesTo + " " + AmPmTo
        document.getElementById("finalTime").value = finalTime

    }

    $(document).ready(function() {

        $("#addSchedSubmit").click(function() {
            $("#addSchedForm").submit();
        });
        $("#addAdvisorySubmit").click(function() {
            var url = "<?php echo base_url() . 'academic/setAdviser/' ?>"
            $.ajax({
                type: "POST",
                url: url,
                data: 'inputFacultyID=' + $('#em_id').val() + "&inputGradeModal=" + $('#inputGradeModal').val() + '&inputSectionModal=' + $('#inputSectionModal').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements. 
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        showTopAlert(data.msg, 'success')
                    } else {
                        showTopAlert(data.msg, 'warning')
                    }
                }
            });

            return false;
        });
        $("#inputGradeModal").select2();
        $("#inputSectionModal").select2();
    });
</script>

<!-- End of Schedule Modal-->