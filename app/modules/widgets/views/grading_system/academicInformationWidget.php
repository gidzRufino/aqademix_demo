<?php
$settings = Modules::run('main/getSet');
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $details->grade_id);
//print_r($subject_ids);
//$subject = explode(',', $subject_ids->subject_id);
switch ($this->session->userdata('term')) {
    case 1:
        $grading = 'first';
        break;
    case 2:
        $grading = 'second';
        break;
    case 3:
        $grading = 'third';
        break;
    case 4:
        $grading = 'fourth';
        break;
    default:
        $grading = 'final';
        break;
}
?>
<div class="card border-0 shadow-lg rounded-4">

    <!-- Header -->
    <div class="card-header bg-white border-0 py-3 shadow-sm">
        <div class="row g-3 align-items-center">

            <!-- Title -->
            <div class="col-lg-4">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fa fa-clipboard-list me-2"></i>
                    Class Record & Progress Overview
                </h5>
                <small class="text-muted">
                    Select grading period and school year to view records
                </small>
            </div>

            <!-- Select Controls -->
            <div class="col-lg-4">
                <div class="d-flex flex-wrap gap-2">
                    <!-- Term Select -->
                    <select id="inputTerm" class="form-select form-select-sm shadow-sm" style="min-width:150px;">
                        <option value="">Select Grading</option>
                        <?php
                        $first = $second = $third = $fourth = "";
                        switch ($this->session->userdata('term')) {
                            case 1:
                                $first = "selected";
                                break;
                            case 2:
                                $second = "selected";
                                break;
                            case 3:
                                $third = "selected";
                                break;
                            case 4:
                                $fourth = "selected";
                                break;
                        }
                        ?>
                        <option <?php echo $first ?> value="1">First Grading</option>
                        <option <?php echo $second ?> value="2">Second Grading</option>
                        <option <?php echo $third ?> value="3">Third Grading</option>
                        <option <?php echo $fourth ?> value="4">Fourth Grading</option>
                    </select>

                    <!-- School Year Select -->
                    <select id="inputSY" class="form-select form-select-sm shadow-sm" style="min-width:150px;">
                        <option value="">School Year</option>
                        <?php foreach ($ro_year as $ro):
                            $roYears = $ro->ro_years + 1;
                            $selected = ($this->session->userdata('school_year') == $ro->ro_years) ? 'selected' : '';
                        ?>
                            <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>">
                                <?php echo $ro->ro_years . ' - ' . $roYears; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-lg-4 text-lg-end">
                <div class="btn-group">
                    <button id="btnClassRecord" class="btn btn-primary btn-sm view-btn active"
                        disabled
                        onclick="loadClassRecord()">
                        <i class="fa fa-table me-1"></i>Class Record
                    </button>

                    <?php if ($this->session->userdata('usertype') != 4): ?>
                        <button id="btnProgressReport" class="btn btn-outline-primary btn-sm view-btn"
                            disabled
                            onclick="loadProgressReport()">
                            <i class="fa fa-chart-bar me-1"></i>Progress Report
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="card border-0 shadow-sm" id="acadInfoBody">
        <div class="card-header bg-gradient bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-book me-2 text-primary"></i>Academic Performance
            </h5>
            <span class="badge bg-primary-subtle text-primary fw-semibold">
                <?php echo ucfirst($grading); ?> Grading
            </span>
        </div>

        <div class="card-body">
            <?php
            $subjectsData = [];
            foreach ($subject as $s):
                $singleSub = Modules::run('academic/getSpecificSubjects', $s);
                $assessment = Modules::run('gradingsystem/getPartialAssessment', $details->uid, $details->section_id, $s, $details->year);
                $finalAssessment += $assessment->$grading;

                $subjectsData[] = [
                    'name' => $singleSub->subject,
                    'grade' => $assessment->$grading
                ];
            endforeach;

            if ($finalAssessment > 0):
            ?>

                <!-- Summary -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 bg-light h-100">
                            <div class="text-muted small">Total Subjects</div>
                            <div class="fs-3 fw-bold text-primary">
                                <?php echo count($subjectsData); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 bg-light h-100">
                            <div class="text-muted small">Average Grade</div>
                            <div class="fs-3 fw-bold text-success">
                                <?php
                                $avg = round($finalAssessment / count($subjectsData), 2);
                                echo $avg;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-4 p-3 bg-light h-100">
                            <div class="text-muted small">Overall Status</div>
                            <div class="fs-5 fw-semibold <?php echo ($avg >= 75) ? 'text-success' : 'text-danger'; ?>">
                                <?php echo ($avg >= 75) ? 'Passing' : 'Needs Improvement'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subject Grades Grid -->
                <div class="row g-3">
                    <?php foreach ($subjectsData as $sub): ?>
                        <div class="col-md-4 col-lg-3">
                            <div class="border rounded-4 p-3 h-100 bg-white shadow-sm subject-card">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="fw-semibold text-dark small text-truncate" title="<?php echo $sub['name']; ?>">
                                        <?php echo $sub['name']; ?>
                                    </div>
                                    <span class="badge 
                                    <?php
                                    if ($sub['grade'] >= 90) echo 'bg-success';
                                    elseif ($sub['grade'] >= 85) echo 'bg-primary';
                                    elseif ($sub['grade'] >= 80) echo 'bg-info text-dark';
                                    elseif ($sub['grade'] >= 75) echo 'bg-warning text-dark';
                                    else echo 'bg-danger';
                                    ?>">
                                        <?php echo $sub['grade']; ?>
                                    </span>
                                </div>

                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar 
                                    <?php
                                    if ($sub['grade'] >= 90) echo 'bg-success';
                                    elseif ($sub['grade'] >= 85) echo 'bg-primary';
                                    elseif ($sub['grade'] >= 80) echo 'bg-info';
                                    elseif ($sub['grade'] >= 75) echo 'bg-warning';
                                    else echo 'bg-danger';
                                    ?>"
                                        role="progressbar"
                                        style="width: <?php echo $sub['grade']; ?>%">
                                    </div>
                                </div>

                                <div class="mt-3 small text-muted">
                                    Partial Number Grade
                                </div>
                                <div class="fs-5 fw-bold text-dark">
                                    <?php echo $sub['grade']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                    <div class="mb-3">
                        <i class="fa fa-folder-open text-warning" style="font-size: 48px;"></i>
                    </div>
                    <h5 class="fw-semibold mb-1">No Academic Records Found</h5>
                    <p class="text-muted mb-0">Grades for this grading period are not yet available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Subject Tabs -->
    <div class="card-footer bg-white border-0 d-none" id="acadInfoFooter">
        <div class="d-flex flex-wrap gap-2" id="subjectBtnGroup">
            <?php foreach ($subject_ids as $s):
                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            ?>
                <button type="button"
                    class="btn btn-outline-primary btn-sm subject-btn"
                    id="<?php echo $singleSub->subject_id ?>"
                    onclick="activateSubjectBtn(this); getSubjectProgressReport(this.id,$('#inputTerm').val(),'<?php echo base64_encode($details->st_id) ?>',$('#inputSY').val())">
                    <i class="fa fa-book me-1"></i><?php echo $singleSub->short_code; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#frontBack').select2();
        $(".printCC").clickover({
            placement: 'left',
            html: true
        });
    });

    function setActiveView(btnId) {
        document.querySelectorAll('.view-btn').forEach(b => {
            b.classList.remove('active');
            b.classList.add('btn-outline-primary');
            b.classList.remove('btn-primary');
        });

        const activeBtn = document.getElementById(btnId);
        activeBtn.classList.add('active');
        activeBtn.classList.remove('btn-outline-primary');
        activeBtn.classList.add('btn-primary');
    }

    function loadClassRecord() {
        setActiveView('btnClassRecord');
        document.getElementById('acadInfoFooter').classList.add('d-none');

        getClassRecord(
            '<?php echo base64_encode($details->st_id) ?>',
            '<?php echo $details->grade_id ?>',
            $('#inputTerm').val(),
            '<?php echo $details->section_id ?>',
            $('#inputSY').val()
        );
    }

    function loadProgressReport() {
        setActiveView('btnProgressReport');
        document.getElementById('acadInfoFooter').classList.remove('d-none');

        getProgressReport(
            '<?php echo base64_encode($details->st_id) ?>',
            $('#inputTerm').val(),
            $('#inputSY').val()
        );
    }

    function toggleActionButtons() {
        const term = document.getElementById('inputTerm').value;
        const sy = document.getElementById('inputSY').value;

        const enable = term !== '' && sy !== '';

        document.getElementById('btnClassRecord').disabled = !enable;
        <?php if ($this->session->userdata('usertype') != 4): ?>
            document.getElementById('btnProgressReport').disabled = !enable;
        <?php endif; ?>
    }

    // Listen for selection changes
    document.getElementById('inputTerm').addEventListener('change', toggleActionButtons);
    document.getElementById('inputSY').addEventListener('change', toggleActionButtons);

    // Run on load in case values are preselected
    document.addEventListener('DOMContentLoaded', toggleActionButtons);

    function getClassRecord(st_id, details, term, section_id, school_year) {
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualClassRecord/' ?>" + st_id + '/' + details + '/' + section_id + '/' + term + '/' + school_year
        $('#acadInfoBody').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>');

        $.ajax({
            type: "GET",
            url: url,
            //dataType:'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data)
                $('#acadInfoFooter').addClass('hide')
            }
        })
    }

    function getProgressReport(st_id, term, school_year) {
        //alert(school_year)
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualProgressChart/' ?>" + st_id + '/' + term + '/' + school_year
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data.main)
                $('#acadInfoFooter').removeClass('hide')
            }
        })
    }

    function printIndividualCC(page) {
        var st_id = '<?php echo base64_encode($details->st_id) ?>';
        var term = $('#inputTerm').val();
        var SY = $('#inputSY').val();
        var gl = '<?php echo $details->grade_id ?>';
        var section = '<?php echo $details->section_id ?>'
        if (page != 'none') {
            var url = '<?php echo base_url() . 'reports/class_card/printIndividual/' ?>' + st_id + '/' + term + '/' + SY + '/' + gl + '/' + section
            window.open(url, '_blank');
        }

    }

    function getSubjectProgressReport(subject_id, term, st_id, school_year) {
        //console.log(subject_id)
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualProgressChart/' ?>" + st_id + '/' + term + '/' + school_year + '/' + subject_id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data.main)
                //$('#gpa').html(data.gpa)
            }
        })
    }

    function activateSubjectBtn(el) {
        // remove active from all buttons
        document.querySelectorAll('#subjectBtnGroup .subject-btn')
            .forEach(btn => btn.classList.remove('active'));

        // add active to clicked button
        el.classList.add('active');
    }
</script>

<style>
    .subject-card {
        transition: all .2s ease;
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .subject-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, .08);
    }

    .subject-btn {
        transition: all .2s ease;
        border-radius: 20px;
        padding: 6px 14px;
        font-weight: 500;
    }

    .subject-btn.active {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff !important;
        border-color: #0b5ed7;
        box-shadow: 0 4px 10px rgba(13, 110, 253, .25);
        transform: translateY(-1px);
    }

    .subject-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, .08);
    }

    .view-btn.active {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff !important;
        border-color: #0b5ed7;
        box-shadow: 0 4px 10px rgba(13, 110, 253, .25);
    }

    .view-btn:not(.active) {
        background: #fff;
    }
</style>