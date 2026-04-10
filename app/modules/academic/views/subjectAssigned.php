<?php echo Modules::run('academic/viewTeacherInfo', $id, null); ?>

<div class="col-12 p-0">

    <div class="card border-0 shadow-sm">

        <!-- Header -->
        <div class="card-header bg-white border-bottom">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">

                <h6 class="fw-bold mb-0 text-primary">
                    <i class="fa fa-book me-2"></i>
                    Subjects Assigned
                </h6>

                <div class="d-flex gap-2">

                    <button onclick="$('#addSubjectModal').modal('show')"
                        class="btn btn-sm btn-primary">

                        <i class="fa fa-plus me-1"></i>
                        Add Subject

                    </button>

                    <button onclick="$('#advisoryModal').modal('show')"
                        class="btn btn-sm btn-outline-primary">

                        <i class="fa fa-user-plus me-1"></i>
                        Add Advisory

                    </button>

                </div>

            </div>

        </div>

        <!-- Body -->
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">#</th>
                            <th>Subject</th>
                            <th width="140">Grade Level</th>
                            <th width="140">Section</th>
                            <th width="160">Schedule</th>
                            <th width="70"></th>
                        </tr>
                    </thead>

                    <tbody id="subjectsAssignedTable">

                        <?php
                        $i = 1;
                        $gs_settings = Modules::run('gradingsystem/getSet', $this->session->userdata('school_year'));

                        foreach ($assignment as $as):

                            $specs = (($as->specialization == "") ? "" : ' ( ' . $as->specialization . ' ) ');
                        ?>

                            <tr id="as_<?php echo $as->ass_id ?>">

                                <td class="text-center text-muted">
                                    <?php echo $i++ ?>
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        <?php echo $as->subject ?>
                                    </div>

                                    <?php if ($specs): ?>
                                        <span class="badge bg-secondary-subtle text-secondary border mt-1">
                                            <?php echo $as->specialization ?>
                                        </span>
                                    <?php endif; ?>

                                </td>

                                <td>

                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        <?php echo $as->level ?>
                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        <?php echo $as->section ?>
                                    </span>

                                </td>

                                <td>

                                    <span class="text-muted small">
                                        <i class="fa fa-clock me-1"></i>
                                        Coming Soon
                                    </span>

                                </td>

                                <td class="text-end">

                                    <button title="Delete Subject Assigned"
                                        onclick="removeSubject('<?php echo $as->ass_id ?>')"
                                        class="btn btn-sm btn-outline-danger">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript">
    function setAssignment() {
        var teacher = $('#em_id').val();
        var subject = document.getElementById("inputSubjectAssign").value;
        var gradelevel = document.getElementById("inputGradeAssign").value;
        var section = document.getElementById("inputSectionAssign").value;
        if (subject === '10') {
            switch (gradelevel) {
                case '10':
                case '11':
                    var specs = $('#inputSpecialization').val();
                    break;
            }
        } else {
            specs = 0;
        }

        var url = "<?php echo base_url() . 'academic/setAssignment' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "teacher=" + teacher + '&specs=' + specs + "&subject=" + subject + "&gradeLevel=" + gradelevel + "&section=" + section + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#addSubjectModal').modal('hide');
                if (data.status) {
                    showTopAlert(data.msg, 'success');
                    $('#subjectsAssignedTable').html(data.data)
                } else {
                    $('#subjectsAssignedTable').html(data.data)
                    showTopAlert(data.msg, 'warning');
                }
            }
        });

        return false;
    }
</script>