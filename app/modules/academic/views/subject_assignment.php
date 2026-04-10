<div class="card shadow-sm border-0 mb-3">

    <div class="card-body">

        <div class="row align-items-center g-3">

            <!-- Title -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-0">
                    <i class="fa fa-chalkboard-teacher text-primary me-2"></i>
                    Teacher's Subject Assignment
                </h5>
            </div>

            <!-- Search Option -->
            <div class="col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Search By</span>

                    <select id="searchOption"
                        class="form-select"
                        onchange="getSearchOption(this.value)">

                        <option>Select Option</option>
                        <option value="employee_id">Teacher</option>
                        <option value="grade_level_id">Grade Level</option>
                        <option value="section_id">Section</option>

                        <?php if ($settings->level_catered == 5): ?>
                            <option value=""
                                onclick="document.location='<?php echo base_url('academic/collegeFacultyAssignment') ?>'">
                                College
                            </option>
                        <?php endif; ?>

                    </select>
                </div>
            </div>

            <!-- Teacher Search -->
            <div class="col-lg-5" id="searchBox">

                <div class="position-relative">

                    <input autocomplete="off"
                        class="form-control form-control-sm"
                        onkeydown="searchTeacher(this.value)"
                        name="searchTeacher"
                        type="text"
                        id="searchTeacher"
                        placeholder="Search Teacher's Family Name">

                    <input type="hidden" id="teacher_id" name="teacher_id" value="0" />

                    <div class="resultOverflow border rounded shadow-sm bg-white position-absolute w-100 mt-1"
                        style="z-index:2000; display:none;"
                        id="teacherSearch">
                    </div>

                </div>

            </div>

        </div>


        <!-- Section Search -->
        <div class="row mt-3">

            <div class="col-lg-4 offset-lg-8 d-none" id="section">

                <select onclick="search(this.value)"
                    id="inputSection"
                    class="form-select form-select-sm">

                    <option>Search By Section</option>

                    <?php foreach ($section->result() as $sec): ?>

                        <option value="<?php echo $sec->section_id; ?>">
                            <?php echo $sec->level . ' [ ' . $sec->section . ' ]'; ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Grade Search -->
            <div class="col-lg-4 offset-lg-8 d-none" id="grade">

                <select onclick="getAssignmentByGradeLevel(this.value)"
                    id="inputGrade"
                    class="form-select form-select-sm">

                    <option>Search Grade level here</option>

                    <?php foreach ($grade as $level): ?>

                        <option value="<?php echo $level->grade_id; ?>">
                            <?php echo $level->level; ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </div>

    </div>

</div>


<!-- Result Container -->

<div id="teacherResult" class="mt-3"></div>
<?php
$data['specs'] = Modules::run('registrar/getSpecialization');
$data['subjects'] = $subjects;
$data['GradeLevel'] = $grade;
//$this->load->view('regModal', $data) 
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#inputGrade").select2({});
        $("#inputSection").select2();
        $("#inputGradeAssign").select2({});
        $("#inputSectionAssign").select2();
        $("#inputSubjectAssign").select2();
    });

    function removeAdvisory(adv_id, user_id) {
        r = confirm('Are you sure you want to remove this advisory?');
        if (r == true) {
            var url = "<?php echo base_url() . 'academic/deleteAdvisory/' ?>" + adv_id + '/' + user_id;
            $.ajax({
                type: "GET",
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#notify_me').html(data.msg)
                    }
                    $('#notify_me').show();
                    $('#notify_me').fadeOut(5000);
                    location.reload();
                }
            });

            return false;
        }

    }

    function removeSubject(id) {
        var teacher = $('#em_id').val();

        showSystemModal('confirm', 'Are you sure you want to remove subject Assigned?', 'Confirm Delete', function() {
            var url = "<?php echo base_url() . 'academic/deleteAssignment/' ?>" + id + '/' + teacher;
            $.ajax({
                type: "GET",
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#subjectsAssignedTable').html(data.data)
                        showTopAlert(data.msg, 'success');
                    } else {
                        showTopAlert('Deleting Subject Failed', 'warning');
                    }
                }
            });

            return false;
        })
    }

    function getSearchOption(value) {
        switch (value) {
            case 'grade_level_id':
                $('#grade').show()
                $('#searchBox').hide();
                $('#section').hide()
                break;
            case 'section_id':
                $('#section').show();
                $('#grade').hide();
                $('#searchBox').hide();
                break;
            default:
                $('#grade').hide()
                $('#section').hide()
                $('#searchBox').show();
                break;
        }
    }

    function searchTeacher(value) {
        var url = "<?php echo base_url() . 'academic/teacherSearch/' ?>";
        if (value == "") {
            $('#citySearch').hide();
            $('#cityId').val('0');
        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend: function() {
                    $('#teacherSearch').show();
                    $('#teacherSearch').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                },
                success: function(data) {
                    $('#teacherSearch').show();
                    $('#teacherSearch').html(data);
                }
            });

            return false;
        }
    }

    function getInfo(value) {
        var url = "<?php echo base_url() . 'academic/getAssignedSubject/' ?>";
        if (value == "") {
            $('#citySearch').hide();
            $('#cityId').val('0');
        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend: function() {
                    $('#teacherResult').show();
                    $('#teacherResult').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                },
                success: function(data) {
                    $('#teacherResult').show();
                    $('#teacherResult').html(data);
                }
            });

            return false;
        }
    }

    function getAssignmentByGradeLevel(value) {
        var url = "<?php echo base_url() . 'academic/getAssignmentByGradeLevel/' ?>";
        if (value == "") {
            $('#citySearch').hide();
            $('#cityId').val('0');
        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend: function() {
                    $('#teacherResult').show();
                    $('#teacherResult').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                },
                success: function(data) {
                    $('#teacherResult').show();
                    $('#teacherResult').html(data);
                }
            });

            return false;
        }
    }

    function selectSection(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#inputSection').html(data);
                $('#inputSectionModal').html(data);
            }
        });

        return false;
    }

    function selectSectionAssign(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.
        var sub_id = $('#inputSubjectAssign').val();
        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#inputSectionAssign').html(data);
                $('#submitAdmission').show();
                $('#submitAdmissionDisabled').hide();
                if (sub_id === '10') {
                    switch (level_id) {
                        case '10':
                        case '11':
                            $('#tle_specs').show();
                            $('#inputSpecialization').select2()
                            break;
                        default:
                            $('#tle_specs').hide();
                            break;
                    }
                }

            }
        });

        return false;
    }

    function getSubjects(grade_id) {
        var url = '<?php echo base_url() . 'academic/getSubjectsPerGradeLvl/' ?>' + grade_id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(d) {
                $('#inputSubjectAssign').html(d);
            }
        })
    }
</script>