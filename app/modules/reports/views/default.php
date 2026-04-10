<div class="container-fluid py-4">

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            <!-- ===== HEADER ===== -->
            <div class="row align-items-center g-3 mb-4">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-1">Reports Center</h3>
                    <div class="text-muted small">Generate academic and registrar reports</div>
                </div>

                <div class="col-lg-3">
                    <label class="form-label small text-muted">School Year</label>
                    <select id="inputSY" class="form-select">
                        <?php foreach ($ro_year as $ro): ?>
                            <option value="<?= $ro->ro_years ?>" <?= ($this->session->userdata('school_year') == $ro->ro_years) ? 'selected' : '' ?>>
                                <?= $ro->ro_years . ' - ' . ($ro->ro_years + 1); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-3">
                    <label class="form-label small text-muted">Grading Period</label>
                    <select id="inputTerm" class="form-select">
                        <option value="">Select Grading Period</option>
                        <option value="1" <?= ($this->session->userdata('term') == 1 ? 'selected' : '') ?>>First</option>
                        <option value="2" <?= ($this->session->userdata('term') == 2 ? 'selected' : '') ?>>Second</option>
                        <option value="3" <?= ($this->session->userdata('term') == 3 ? 'selected' : '') ?>>Third</option>
                        <option value="4" <?= ($this->session->userdata('term') == 4 ? 'selected' : '') ?>>Fourth</option>
                    </select>
                </div>
            </div>


            <!-- ===== REPORT BUILDER BLOCK ===== -->
            <div class="border rounded-4 p-3 mb-4 bg-light-subtle">
                <div class="row g-3">
                    <!-- Report -->
                    <div class="col-lg-4">
                        <label class="form-label">Report Type</label>
                        <select id="selectReport" class="form-select">
                            <option>Select Report</option>
                            <option value="grading_sheet">Grading Sheet</option>

                            <?php if ($this->session->userdata('is_adviser') || $this->session->position_id == 1): ?>
                                <option value="master_sheet">Master Sheet</option>
                                <option value="enrollmentList">Enrollment List</option>
                                <option value="printCC">Class Card</option>
                                <option value="depEdForm1">DepEd SF 1</option>
                                <option value="depEdForm2">DepEd SF 2</option>
                                <option value="depEdForm4">DepEd SF 4</option>
                                <option value="depEdForm5">DepEd SF 5</option>
                                <option value="depEdForm6">DepEd SF 6</option>
                                <option value="depEdForm7">DepEd SF 7</option>
                                <option value="generateCard">Form 138-A</option>

                                <?php if ($this->session->position_id == 1): ?>
                                    <option value="generateForm137">Form 137-A</option>
                                <?php endif; ?>
                            <?php endif; ?>

                            <option value="classRanking">Class Ranking</option>
                        </select>
                    </div>

                    <!-- Grade -->
                    <div class="col-lg-4" id="gl_list">
                        <label class="form-label">Grade Level</label>
                        <select id="inputGrade" class="form-select"
                            onchange="$('#sec_grade_id').val(this.value); selectSection(this.value)">
                            <option>Select Grade</option>
                            <?php foreach ($gradeLevel as $level): ?>
                                <option value="<?= $level->grade_id ?>"><?= $level->level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-lg-4" id="section_list">
                        <label class="form-label">Section</label>
                        <select id="inputSection" class="form-select">
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="col-lg-4 d-none" id="subj_list">
                        <label class="form-label">Subject</label>
                        <select id="inputSubject" class="form-select">
                            <option>Select Subject</option>
                        </select>
                    </div>

                    <!-- Strand -->
                    <div id="strandWrapper" class="col-lg-4 d-none">
                        <label class="form-label">Strand</label>
                        <select id="inputStrand" class="form-select">
                            <option value="0">Select Strand</option>
                            <?php foreach ($strand as $st): ?>
                                <option value="<?= $st->st_id ?>"><?= $st->strand ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Page Selection -->
                    <div id="pageSelection" class="col-lg-4 d-none">
                        <label class="form-label">Class Card Pages <small class="text-muted small" style="color: red;"> [ Section is required ]</small></label>
                        <!-- <select id="frontBack" class="form-select mb-2" onchange="getClassCardCount(this.value)">
                            <option>Select Side</option>
                            <option value="printCCFront">Front</option>
                            <option value="printCCBack">Back</option>
                        </select> -->
                        <select id="pageID" class="form-select">
                        </select>
                    </div>

                    <div id="month" class="col-lg-4 d-none">
                        <label class="form-label">Month</label>
                        <div class="controls" id="AddedSection">
                            <select id="inputMonthReport" class="form-select">
                                <option>Select Month</option>
                                <option value="annual">Annual</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== ACTION BAR ===== -->
            <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">

                <?php if ($this->session->userdata('is_admin')): ?>
                    <button class="btn btn-outline-primary" onclick="getLOFGraph()">
                        <i class="fa fa-bar-chart me-1"></i> Proficiency Graph
                    </button>
                <?php endif; ?>

                <button id="btnGenerate" class="btn btn-success px-4" onclick="generateReport()">
                    <span class="btn-text">
                        <i class="fa fa-file-text me-2"></i> Generate Report
                    </span>
                </button>
            </div>


            <!-- ===== OUTPUT PANEL ===== -->
            <div class="border rounded-4 p-3 bg-white">

                <div id="genRepCard" class="d-none">
                    <div id="studentCard"></div>
                </div>

                <div id="iframeLoader"></div>
                <iframe id="report_iframe" class="w-100 d-none rounded-3" height="520"></iframe>

            </div>

            <input type="hidden" id="sec_grade_id">

        </div>
    </div>

</div>

<?php $this->load->view('levelOfProficiencyGraph'); ?>

<script type="text/javascript">
    $(function() {
        $('#selectReport, #inputGrade, #inputSection, #inputSubject, #inputMonthReport, #inputSY, #inputTerm, #frontBack, #pageID').select2({
            width: '100%'
        });
    });

    $('#selectReport').on('change', function() {
        action($(this).val());
    });

    $('#inputSection').on('change', function() {
        getClassCardCount();
    });

    // ==================== REPORT GENERATOR ====================
    function generateReport() {

        clearErrors();

        let reportEl = $('#selectReport');
        let gradeEl = $('#inputGrade');
        let sectionEl = $('#inputSection');
        let subjectEl = $('#inputSubject');
        let strandEl = $('#inputStrand');
        let termEl = $('#inputTerm');
        let monthEl = $('#inputMonthReport');
        let pageEl = $('#pageID');

        let report = reportEl.val();
        let subject_id = subjectEl.val();
        let section_id = sectionEl.val();
        let grade_id = $('#sec_grade_id').val();
        let strand = (grade_id == 12 || grade_id == 13) ? strandEl.val() : 0;
        let term = termEl.val();
        let school_year = $("#inputSY").val();
        let month = monthEl.val();
        let pageID = pageEl.val();

        // ===== BASE REQUIRED =====
        if (!report || report === 'Select Report') {
            markError(reportEl, 'Please select a report type.');
            return;
        }

        // if (!grade_id) {
        //     markError(gradeEl, 'Grade Level is required.');
        //     return;
        // }

        const needGradeLevel = () => {
            if (!grade_id) {
                markError(gradeEl, 'Grade Level is required');
                return false;
            }
            return true;
        };

        const needSection = () => {
            if (!section_id) {
                markError(sectionEl, 'Section is required.');
                return false;
            }
            return true;
        };

        const needSubject = () => {
            if (!subject_id || subject_id === 'Select Subject') {
                markError(subjectEl, 'Subject is required.');
                return false;
            }
            return true;
        };

        const needTerm = () => {
            if (!term) {
                markError(termEl, 'Grading Period is required.');
                return false;
            }
            return true;
        };

        const needStrand = () => {
            if ((grade_id == 12 || grade_id == 13) && (!strand || strand == 0)) {
                markError(strandEl, 'Strand is required for SHS.');
                return false;
            }
            return true;
        };

        const needMonth = () => {
            if (!month || month === 'Select Month') {
                markError(monthEl, 'Month is required.');
                return false;
            }
            return true;
        };

        const needPage = () => {
            if (!pageID) {
                markError(pageEl, 'Class Card page is required.');
                return false;
            }
            return true;
        };

        // ===== REPORT RULES =====
        switch (report) {
            case 'grading_sheet':
                if (!needSection() || !needSubject() || !needStrand()) return;
                break;

            case 'master_sheet':
                if (!needSection() || !needTerm() || !needStrand()) return;
                break;

            case 'enrollmentList':
                if (!needSection()) return;
                break;

            case 'printCC':
                if (!needSection() || !needTerm() || !needPage() || !needStrand()) return;
                break;

            case 'generateCard':
                if (!needSection() || !needTerm() || !needStrand()) return;
                break;

            case 'depEdForm1':
                if (!needSection()) return;
                break;

            case 'depEdForm2':
                if (!needSection() || !needMonth()) return;
                break;

            case 'depEdForm4':
                if (!needMonth()) return;
                break;

            case 'generateTopTen':
                if (!needSection() || !needSubject() || !needTerm()) return;
                break;

            case 'classRanking':
                if (!needGradeLevel() || !needSection() || !needTerm()) return;
                break;
        }

        // ===== URL BUILD (unchanged logic) =====
        let url = '';

        switch (report) {

            case 'depEdForm2':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${month}/${school_year}/${grade_id}`;
                break;

            case 'depEdForm1':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${school_year}/${grade_id}`;
                break;

            case 'depEdForm4':
                url = `<?= base_url() ?>reports/${report}/${month}/${school_year}`;
                break;

            case 'grading_sheet':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${subject_id}/${school_year}/${strand}/${grade_id}`;
                break;

            case 'depEdForm5':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${school_year}`;
                break;

            case 'depEdForm7':
            case 'depEdForm6':
                url = `<?= base_url() ?>reports/${report}/${school_year}`;
                break;

            case 'master_sheet':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${term}/${school_year}/${strand}/${grade_id}`;
                break;

            case 'enrollmentList':
                url = `<?= base_url() ?>reports/${report}/${section_id}/${school_year}`;
                break;

            case 'printCC':
                let frontBack = 'printCCFront';
                let limit = parseInt(pageID * 2 - 4);
                url = (grade_id != 12 && grade_id != 13) ?
                    `<?= base_url() ?>reports/cc/${frontBack}/${section_id}/${term}/${limit}/${pageID}` :
                    `<?= base_url() ?>reports/cc/printCCSH/${section_id}/${term}/${limit}/${pageID}/${strand}`;
                break;

            case 'generateCard':
                url = (grade_id != 12 && grade_id != 13) ?
                    `<?= base_url() ?>reports/${report}/${section_id}/${school_year}/NULL/${term}` :
                    `<?= base_url() ?>reports/${report}/${section_id}/${school_year}/${strand}/${term}`;
                break;

            case 'generateForm137':
                url = `<?= base_url() ?>reports/${report}/NULL/${school_year}`;
                break;

            case 'generateTopTen':
                url = `<?= base_url() ?>reports/getTopTen/${section_id}/${grade_id}/${term}/${school_year}/${subject_id}`;
                break;

            case 'classRanking':
                url = `<?= base_url() ?>reports/class_ranking/${section_id}/${grade_id}/${term}/${school_year}`;
                break;
        }

        // ===== OUTPUT MODE =====
        const iframeReports = [
            'grading_sheet',
            'master_sheet',
            'enrollmentList',
            'classRanking',
            'generateTopTen',
            'printCC',
            'depEdForm1',
            'depEdForm2',
            'depEdForm4',
            'depEdForm5',
            'depEdForm6',
            'depEdForm7',
        ];

        if (iframeReports.includes(report)) {
            loadReportInIframe(url);
        } else if (report == 'generateCard' || report == 'generateForm137') {
            $.get(url, function(data) {
                $('#report_iframe').addClass('d-none');
                $('#genRepCard').removeClass('d-none').addClass('fade-slide-in');
                $('#studentCard').html(data);
                resetGenerateBtn();
            });
        } else {
            window.open(url, '_blank');
        }
    }

    function loadReportInIframe(url) {
        if (!url) return;
        $('#iframeLoader').html(`<div class="text-center py-4"><div class="report-spinner"></div><div class="text-muted small">Building report… please wait</div></div>`);
        $('#genRepCard').addClass('d-none');
        $('#report_iframe').addClass('d-none');
        $('#report_iframe')
            .attr('src', url)
            .off('load')
            .on('load', function() {
                $('#iframeLoader').empty();
                $('#report_iframe')
                    .removeClass('d-none')
                    .addClass('fade-slide-in');

                resetGenerateBtn();
            });
    }

    function getClassCardCount() {
        var section_id = $('#inputSection').val();

        if (section_id == '') {
            alert('Section is Required');
        } else {
            var url = "<?php echo base_url() . 'reports/getClassCardCount/' ?>" + section_id; // the script where you handle the form input.

            $.ajax({
                type: "GET",
                url: url,
                data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#pageID').removeClass('d-none');
                    $('#pageID').html(data);
                }
            });

        }
        return false;
    }

    // ==================== END REPORT GENERATOR ====================

    // Example: LOF graph function (unchanged)
    function getLOFGraph() {
        var subject_id = $('#inputSubject').val();
        var section_id = $('#inputSection').val();
        var grade_id = $('#inputGrade').val();
        var term = $('#inputTerm').val();
        var school_year = $("#inputSY").val();
        var title = ['', 'First', 'Second', 'Third', 'Fourth'][term] + ' Grading Proficiency Level';

        var url = `<?= base_url() ?>reports/getLevelOfProficiency/${school_year}/${term}/${grade_id}/${section_id}`;

        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function() {
                showLoading('lop_details');
                $('#lop_title').html('Generating PL ... Please Wait Patiently...');
            },
            success: function(data) {
                $('#lop_title').html(title);
                $('#lop_details').html(data);
            }
        });
    }

    // ==================== SECTION & SUBJECT HANDLING ====================
    function selectSection(level_id) {
        var url = "<?= base_url() ?>registrar/getSectionByGL/" + level_id;
        if (level_id == 12 || level_id == 13) $('#strandWrapper').show();
        else $('#strandWrapper').hide();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                level_id: level_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                $('#inputSection').html(data);
                getSubjectOffer(level_id);
            }
        });
    }

    function getSubjectOffer(level) {
        var sy = $("#inputSY").val();
        $.get(`<?= base_url() ?>academic/getSpecificSubjectPerlevel/${level}/${sy}/1`, function(data) {
            $('#inputSubject').html(data);
        });
    }

    function showAnimated(id) {
        const el = $(id);
        el.removeClass('d-none fade-slide-out')
            .addClass('fade-slide-in');
    }

    function hideAnimated(id) {
        const el = $(id);
        el.removeClass('fade-slide-in')
            .addClass('fade-slide-out');

        setTimeout(() => {
            el.addClass('d-none').removeClass('fade-slide-out');
        }, 250);
    }

    function action(value) {

        // pulse highlight on change
        $('#selectReport').addClass('pulse-on-change');
        setTimeout(() => $('#selectReport').removeClass('pulse-on-change'), 400);
        $('#month').addClass('d-none');
        $('#subj_list').addClass('d-none');
        $('#pageSelection').addClass('d-none');
        $('#gl_list').removeClass('d-none');
        $('#section_list').removeClass('d-none');


        switch (value) {

            case 'grading_sheet':
            case 'generateTopTen':
                showAnimated('#subj_list');
                break;
            case 'depEdForm4':
            case 'depEdForm2':
                showAnimated('#month');
                break;
            case 'printCC':
                showAnimated('#pageSelection');
                break;
            case 'generateForm137':
            case 'depEdForm7':
            case 'depEdForm6':
                hideAnimated('#gl_list');
                hideAnimated('#section_list');
                break;
            default:
                hideAnimated('#subj_list');
                hideAnimated('#month');
                hideAnimated('#pageSelection');
                break;
        }
    }

    function resetGenerateBtn() {
        $('#btnGenerate')
            .prop('disabled', false)
            .find('.btn-text')
            .html('<i class="fa fa-file-text me-2"></i> Generate Report');
    }

    function markError(el, message) {
        el.addClass('field-error');

        // focus + open select2 if used
        if (el.hasClass('select2-hidden-accessible')) {
            el.select2('open');
        } else {
            el.focus();
        }

        alert(message);
    }

    function clearErrors() {
        $('.field-error').removeClass('field-error');
    }

    // auto clear when user changes value
    $(document).on('change', 'select', function() {
        $(this).removeClass('field-error');
    });
</script>

<style>
    /* BASIC PAGE STYLING */
    body {
        background-color: #f5f7fb;
    }

    .page-header {
        background: #fff;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
    }

    .filter-card {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
    }

    /* HEADER GRID */
    .header-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        gap: 1.5rem;
    }

    .header-filters {
        display: grid;
        grid-template-columns: 220px 160px;
        gap: 1rem;
        justify-content: end;
    }

    @media(max-width:992px) {
        .header-filters {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width:576px) {
        .header-grid {
            grid-template-columns: 1fr;
        }

        .header-filters {
            grid-template-columns: 1fr;
        }
    }

    /* FILTER GROUPS */
    .filter-group {
        background: #fff;
        padding: .6rem .75rem;
        border-radius: .75rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .04);
    }

    .filter-label {
        font-size: .7rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
    }

    /* BUTTONS & IFRAME */
    .report-actions {
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 -5px 20px rgba(0, 0, 0, .05);
    }

    iframe {
        background: #fff;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
    }

    /* SELECT ENHANCEMENTS */
    select,
    .form-select {
        width: 100%;
        appearance: none;
        background-image: none !important;
        border-radius: 12px;
        border: 1px solid #dee2e6;
        padding: .65rem .9rem;
        font-size: .95rem;
        white-space: nowrap;
        text-overflow: ellipsis;
        transition: all .2s;
    }

    select:focus,
    .form-select:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);
    }

    select:disabled,
    .form-select:disabled {
        background-color: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }

    @media(max-width:576px) {
        .filter-group {
            padding: .75rem
        }

        .filter-label {
            font-size: .65rem
        }
    }

    .card {
        border-radius: 20px;
    }

    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
    }

    .form-select {
        border-radius: 12px;
        padding: .6rem .8rem;
    }

    .bg-light-subtle {
        background: #f8fafc;
    }

    /* ===== ANIMATIONS ===== */
    .fade-slide-in {
        animation: fadeSlideIn .35s ease forwards;
    }

    .fade-slide-out {
        animation: fadeSlideOut .25s ease forwards;
    }

    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeSlideOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(-6px);
        }
    }

    .pulse-on-change {
        animation: pulseGlow .4s ease;
    }

    @keyframes pulseGlow {
        0% {
            box-shadow: 0 0 0 rgba(13, 110, 253, 0);
        }

        50% {
            box-shadow: 0 0 0 6px rgba(13, 110, 253, .15);
        }

        100% {
            box-shadow: 0 0 0 rgba(13, 110, 253, 0);
        }
    }

    /* Loader spinner */
    .report-spinner {
        width: 42px;
        height: 42px;
        border: 4px solid #e9ecef;
        border-top: 4px solid #198754;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .field-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 .15rem rgba(220, 53, 69, .15) !important;
    }
</style>