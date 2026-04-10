<style>
    .grade-card {
        transition: all 0.3s ease;
        border-radius: 14px;
        overflow: hidden;
    }

    .grade-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .subject-item {
        color: #6c757d;
        cursor: default;
        /* muted */
    }

    /* Smaller icons */
    .subject-item i {
        font-size: 12px;
    }

    .subject-item:hover {
        background-color: #f8f9fa;
        padding-left: 12px;
    }

    .card-header {
        font-size: 1rem;
        letter-spacing: 0.4px;
    }

    .list-group-item i {
        transition: transform 0.2s ease;
    }

    .subject-item:hover i.fa-chevron-right {
        transform: translateX(4px);
    }

    /* Show delete button only on hover */
    .subject-actions {
        opacity: 0;
        transition: all 0.2s ease;
    }

    .subject-item:hover .subject-actions {
        opacity: 1;
    }

    /* Add button hover */
    .add-subject-btn {
        transition: all 0.2s ease;
    }

    .add-subject-btn:hover {
        transform: scale(1.1);
    }

    /* Delete button subtle */
    .delete-subject-btn {
        border: none;
    }

    .delete-subject-btn:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .sortable-list {
        min-height: 40px;
    }

    .sortable-placeholder {
        height: 32px;
        background: #e9ecef;
        border: 1px dashed #adb5bd;
        border-radius: 6px;
        margin-bottom: 6px;
    }

    .ui-sortable-helper {
        transform: scale(1.02);
    }

    .sortable-list .list-group-item {
        cursor: move;
    }

    /* Item being dragged */
    .ui-sortable-helper {
        background: #ffffff;
        border: 1px solid #dee2e6;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Card */
    .modern-card {
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .modern-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    /* Header Gradient */
    .card-header.bg-gradient {
        background: linear-gradient(135deg, #0d6efd, #4dabf7);
    }

    /* Buttons */
    .btn.rounded-circle {
        width: 32px;
        height: 32px;
        padding: 0;
    }

    .btn.rounded-circle i {
        font-size: 12px;
    }

    /* List Items */
    .subject-item {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .subject-item:hover {
        background: #f8f9fa;
        border-color: #e9ecef;
        transform: translateX(3px);
    }

    /* Drag Handle */
    /* Drag handle */
    .drag-handle {
        cursor: grab;
        padding: 6px 8px;
        position: relative;
        z-index: 10;
        /* 🔥 IMPORTANT */
    }

    .drag-handle:active {
        cursor: grabbing;
    }


    /* Default (muted look) */
    .subject-name {
        color: #6c757d;
        transition: 0.15s ease;
    }

    /* Active (clicked) → ONLY text becomes dark */
    .subject-item.active-item .subject-name {
        color: #212529;
        /* dark */
        font-weight: 600;
    }

    .subject-item.active-item {
        background: #f8f9fa;
        border-left: 3px solid #0d6efd;
    }

    /* Keep icons unchanged */
    .subject-item i {
        color: inherit;
        /* or your existing colors like text-primary */
    }

    /* Actions hidden until hover */
    /* Reduce button size */
    .subject-actions .btn {
        width: 26px;
        height: 26px;
        padding: 0;
    }

    /* Show actions on hover */
    .subject-actions {
        opacity: 0;
        transition: 0.2s;
    }

    .subject-item:hover .subject-actions {
        opacity: 1;
    }

    .sortable-placeholder {
        height: 30px;
        background: #dee2e6;
        border: 1px dashed #adb5bd;
        margin-bottom: 5px;
    }

    .sortable-list * {
        pointer-events: auto !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<div class="container-fluid py-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-semibold mb-0">
            <i class="fa fa-book text-primary me-2"></i>
            Subject Management
        </h4>

        <button id="btnLoadSubjects"
            class="btn btn-outline-primary btn-sm">
            <i class="fa fa-list me-1"></i> List of Subjects
        </button>

    </div>

    <!-- Department Tabs -->
    <div id="subjectManagement_content">
        <div class="text-center py-5 text-muted" id="subjectLoader" style="display:none;">
            <div class="spinner-border text-primary mb-2"></div>
            <div>Loading subjects...</div>
        </div>
        <ul class="nav nav-pills mb-3 flex-wrap" id="dcms_tab" role="tablist">

            <?php
            $level_catered = explode(',', $school_settings->level_catered);
            $s = 0;
            foreach ($level_catered as $lc):
                $s++;
                $dept = Modules::run('subjectmanagement/getDeptByID', $lc);

                if ($dept->num_rows() > 0):
                    if ($dept->row()->level_dept_id != 5):
                        $active = $s == 1 ? 'active' : '';
                        $hide = '';
            ?>
                        <li class="nav-item <?php echo $hide ?>" role="presentation">
                            <button
                                class="nav-link <?php echo $active ?>"
                                data-bs-toggle="tab"
                                data-id="<?= $dept->row()->level_dept_id ?>"
                                data-bs-target="#dept_<?php echo $dept->row()->level_dept_id ?>"
                                type="button">

                                <?php echo $dept->row()->level_department ?>

                            </button>

                        </li>
            <?php
                    endif;
                endif;
            endforeach;
            ?>

        </ul>

        <!-- Tab Content -->
        <div class="tab-content py-3">
            <div class="tab-pane fade" id="dept_1">
                <div class="container-fluid">
                    <div class="row g-4">

                        <?php
                        $dept = Modules::run('subjectmanagement/getDeptByID', 1);

                        if ($dept->row()->level_dept_id != 5):
                            $section = Modules::run('registrar/getGradeLevel', $dept->row()->level_dept_id, '=');

                            foreach ($section as $list):
                                $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $list->grade_id);
                        ?>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="card border-0 shadow-lg h-100 grade-card modern-card">

                                        <!-- Header -->
                                        <div class="card-header bg-gradient text-blue d-flex justify-content-between align-items-center px-3 py-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-layer-group"></i>
                                                <span class="fw-semibold">
                                                    <?php echo $list->level; ?>
                                                </span>
                                            </div>

                                            <!-- Add Button -->
                                            <button
                                                class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm add-subject-btn"
                                                data-grade="<?php echo $list->grade_id; ?>"
                                                title="Add Subject"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addSubject">
                                                <i class="fas fa-plus small"></i>
                                            </button>
                                        </div>

                                        <!-- Body -->
                                        <div class="card-body p-2"
                                            onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>')">

                                            <ul class="list-group list-group-flush sortable-list"
                                                id="<?php echo $list->grade_id ?>_section">

                                                <?php foreach ($subjects as $s):
                                                    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                                ?>
                                                    <li class="list-group-item subject-item d-flex align-items-center justify-content-between px-2 py-1 rounded mb-1"
                                                        id="sub_<?php echo $s->id; ?>"
                                                        data-id="<?= $s->id; ?>">

                                                        <!-- LEFT SIDE -->
                                                        <div class="d-flex align-items-center gap-2">

                                                            <!-- 🔥 DRAG HANDLE (separate block) -->
                                                            <span class="drag-handle">
                                                                <i class="fas fa-grip-vertical text-muted"></i>
                                                            </span>

                                                            <i class="fas fa-book text-primary small"></i>

                                                            <span class="subject-name">
                                                                <?php echo $singleSub->subject ?>
                                                            </span>
                                                        </div>

                                                        <!-- RIGHT ACTION -->
                                                        <div class="subject-actions">
                                                            <button class="btn btn-sm btn-outline-danger delete-subject-btn"
                                                                data-id="<?php echo $s->id; ?>">
                                                                <i class="fas fa-trash small"></i>
                                                            </button>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="dept_2">
                <div class="container-fluid">
                    <div class="row g-4">

                        <?php
                        $dept = Modules::run('subjectmanagement/getDeptByID', 2);

                        if ($dept->row()->level_dept_id != 5):
                            $section = Modules::run('registrar/getGradeLevel', $dept->row()->level_dept_id, '=');

                            foreach ($section as $list):
                                $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $list->grade_id);
                        ?>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="card border-0 shadow-lg h-100 grade-card modern-card">

                                        <!-- Header -->
                                        <div class="card-header bg-gradient text-blue d-flex justify-content-between align-items-center px-3 py-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-layer-group"></i>
                                                <span class="fw-semibold">
                                                    <?php echo $list->level; ?>
                                                </span>
                                            </div>

                                            <!-- Add Button -->
                                            <button
                                                class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm add-subject-btn"
                                                data-grade="<?php echo $list->grade_id; ?>"
                                                title="Add Subject"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addSubject">
                                                <i class="fas fa-plus small"></i>
                                            </button>
                                        </div>

                                        <!-- Body -->
                                        <div class="card-body p-2"
                                            onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>')">

                                            <ul class="list-group list-group-flush sortable-list"
                                                id="<?php echo $list->grade_id ?>_section">

                                                <?php foreach ($subjects as $s):
                                                    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                                ?>
                                                    <li class="list-group-item subject-item d-flex align-items-center justify-content-between px-2 py-1 rounded mb-1"
                                                        id="sub_<?php echo $s->id; ?>"
                                                        data-id="<?= $s->id; ?>">

                                                        <!-- LEFT SIDE -->
                                                        <div class="d-flex align-items-center gap-2">

                                                            <!-- 🔥 DRAG HANDLE (separate block) -->
                                                            <span class="drag-handle">
                                                                <i class="fas fa-grip-vertical text-muted"></i>
                                                            </span>

                                                            <i class="fas fa-book text-primary small"></i>

                                                            <span class="subject-name">
                                                                <?php echo $singleSub->subject ?>
                                                            </span>
                                                        </div>

                                                        <!-- RIGHT ACTION -->
                                                        <div class="subject-actions">
                                                            <button class="btn btn-sm btn-outline-danger delete-subject-btn"
                                                                data-id="<?php echo $s->id; ?>">
                                                                <i class="fas fa-trash small"></i>
                                                            </button>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="dept_3">
                <div class="container-fluid">
                    <div class="row g-4">

                        <?php
                        $dept = Modules::run('subjectmanagement/getDeptByID', 3);

                        if ($dept->row()->level_dept_id != 5):
                            $section = Modules::run('registrar/getGradeLevel', $dept->row()->level_dept_id, '=');

                            foreach ($section as $list):
                                $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $list->grade_id);
                        ?>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="card border-0 shadow-lg h-100 grade-card modern-card">

                                        <!-- Header -->
                                        <div class="card-header bg-gradient text-blue d-flex justify-content-between align-items-center px-3 py-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-layer-group"></i>
                                                <span class="fw-semibold">
                                                    <?php echo $list->level; ?>
                                                </span>
                                            </div>

                                            <!-- Add Button -->
                                            <button
                                                class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm add-subject-btn"
                                                data-grade="<?php echo $list->grade_id; ?>"
                                                title="Add Subject"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addSubject">
                                                <i class="fas fa-plus small"></i>
                                            </button>
                                        </div>

                                        <!-- Body -->
                                        <div class="card-body p-2"
                                            onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>')">

                                            <ul class="list-group list-group-flush sortable-list"
                                                id="<?php echo $list->grade_id ?>_section">

                                                <?php foreach ($subjects as $s):
                                                    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                                                ?>
                                                    <li class="list-group-item subject-item d-flex align-items-center justify-content-between px-2 py-1 rounded mb-1"
                                                        id="sub_<?php echo $s->id; ?>"
                                                        data-id="<?= $s->id; ?>">

                                                        <!-- LEFT SIDE -->
                                                        <div class="d-flex align-items-center gap-2">

                                                            <!-- 🔥 DRAG HANDLE (separate block) -->
                                                            <span class="drag-handle">
                                                                <i class="fas fa-grip-vertical text-muted"></i>
                                                            </span>

                                                            <i class="fas fa-book text-primary small"></i>

                                                            <span class="subject-name">
                                                                <?php echo $singleSub->subject ?>
                                                            </span>
                                                        </div>

                                                        <!-- RIGHT ACTION -->
                                                        <div class="subject-actions">
                                                            <button class="btn btn-sm btn-outline-danger delete-subject-btn"
                                                                data-id="<?php echo $s->id; ?>">
                                                                <i class="fas fa-trash small"></i>
                                                            </button>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="dept_4">
                <div class="container-fluid">
                    <div class="row g-4">

                        <?php
                        $dept = Modules::run('subjectmanagement/getDeptByID', 4);

                        if ($dept->row()->level_dept_id != 5):
                            $section = Modules::run('registrar/getGradeLevel', $dept->row()->level_dept_id, '=');

                            foreach ($section as $list):
                                $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $list->grade_id);
                                $d['list'] = $list;
                                $d['subjects'] = $subjects;
                                $this->load->view('seniorHigh', $d);
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="sub_id" />
<input type="hidden" id="subjects" />
<input type="hidden" id="grade_id" />
<input type="hidden" id="semester" />
<input type="hidden" id="strand_id" />
<div id="otherMenu">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer"><a href="#" onclick="getAdd('Subject')"><i class="fa fa-plus-square fa-fw"></i>Add Subject</a></li>
        <li class="divider"></li>
        <li onclick="removeSubject()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Remove Subject</a></li>
    </ul>
</div>
<div id="SHMenu">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer"><a href="#" onclick="getAdd('SHSubject')"><i class="fa fa-plus-square fa-fw"></i>Add Subject</a></li>
        <li class="divider"></li>
        <li onclick="removeSubject()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Remove Subject</a></li>
    </ul>
</div>
<div id="collegeMenu">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer"><a href="#" onclick="getAdd('CollegeSubject')"><i class="fa fa-plus-square fa-fw"></i>Add Subject</a></li>
        <li class="pointer"><a tabindex="-1"><i class="fa fa-edit fa-fw"></i>Edit Subject</a></li>
        <li class="divider"></li>
        <li onclick="deleteSubject()" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Delete Subject</a></li>
    </ul>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(function() {
        initSortable();
    });

    function initSortable() {

        $(".sortable-list").each(function() {

            if ($(this).hasClass("ui-sortable")) {
                $(this).sortable("destroy");
            }

            $(this).sortable({
                handle: ".drag-handle",
                placeholder: "sortable-placeholder",
                axis: "y",
                tolerance: "pointer",
                cursor: "grabbing",
                update: function() {
                    let order = [];

                    $(this).children("li").each(function(index) {
                        order.push({
                            id: $(this).data("id"),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        url: "<?php echo base_url('subjectmanagement/saveOrder'); ?>",
                        type: "POST",
                        data: {
                            order: order,
                            grade_id: $('#grade_id').val(),
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        dataType: 'json',
                        success: function(res) {
                            showTopAlert(res.message, res.status ? 'success' : 'warning');
                        }
                    });
                }
            });

        });
    }

    $(".sortable-list").length;
    $(".sortable-list").sortable("instance");

    $(document).ready(function() {
        $('#addSubject').on('shown.bs.modal', function() {
            console.log('Modal is shown! ✅');

            $('#addedSubjects').select2({
                placeholder: "Select or type subjects",
                width: '100%',
                tags: true, // allows adding new subjects
                dropdownParent: $('#addSubject') // 🔥 FIX for modal
            });
        });

        const subjects = <?php echo json_encode($subject); ?>;

        subjects.forEach(s => {
            $("#addedSubjects").append(
                new Option(s.subject, s.subject, false, false)
            );
        });

        $("#addedSubjects").trigger("change");


        $("#addedSHSubjects").select2({
            tags: [<?php
                    foreach ($subject as $s) {
                        echo '"' . $s->subject . '",';
                    }
                    ?>]
        });

        $("#inputGrade").select2();
        var activeId = $('#dcms_tab .nav-link.active').data('id');
        // alert(activeId);

        $('#dcms_tab button').on('shown.bs.tab', function(e) {
            initSortable();
        });
    });

    function getAdd(data) {
        $('#add' + data).modal('show');
    }

    function getLevel(level) {
        alert(level)
        if (level == 'k12') {
            $('#k12').show()
            $('#college').hide()
        } else if (level == 'college') {
            $('#k12').hide()
            $('#college').removClass('hide')

        }
    }

    function saveSubjectPerLevel() {
        var grade_level = $('#grade_id').val()
        var subjects = $('#subjects').val()
        var sem = $('#semester').val();

        if (grade_level == 12 || grade_level == 13) {
            var addSubjects = $('#addedSHSubjects').val()
            var strand_id = $('#strand_id').val();
            var url = "<?php echo base_url() . 'subjectmanagement/saveSeniorHighSubjects/' ?>"
        } else {
            addSubjects = $('#addedSubjects').val()
            strand_id = 0;
            url = "<?php echo base_url() . 'main/saveSubjectPerLevel/' ?>"; // the script where you handle the form input.
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + grade_level + "&subjects=" + subjects + '&addSubjects=' + addSubjects + '&sem=' + sem + '&strand_id=' + strand_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (grade_level == 12 || grade_level == 13) {
                    $('#' + grade_level + '_' + strand_id + '_' + sem).html(data)
                } else {
                    $('#' + grade_level + '_section').html(data);
                }

                $('#addSubject').modal('hide')
            }
        });
    }

    function addCollegeSubjects() {
        var allVal = '';
        $("#addCollegeSubject :input").each(function() {
            allVal += '&' + $(this).attr('name') + '=' + $(this).val();
        });

        // alert(allVal)
        var url = "<?php echo base_url() . 'subjectmanagement/addCollegeSubject/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: allVal + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data)
            }
        });
    }

    function addSubject() {
        var grade_level = $('#grade_id').val()
        var subjects = $('#subjects').val()
        var addSubjects = $('#addedSubjects').val()

        var url = "<?php echo base_url() . 'main/saveSubjectSettings/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + grade_level + "&subjects=" + subjects + '&addSubjects=' + addSubjects, // serializes the form's elements.
            success: function(data) {
                $('#' + grade_level + '_section').html(data);
                //location.reload();    
            }
        });
    }

    function saveSubjectSettings() {
        var gradeLevel = '<?php echo $this->uri->segment(3) ?>';
        var subjects = $('#inputSubjects').val();

        var url = "<?php echo base_url() . 'main/saveSubjectSettings/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + gradeLevel + "&subjects=" + subjects, // serializes the form's elements.
            success: function(data) {
                alert('Settings Successfully Saved');
                location.reload();
            }
        });

    }

    function getSubject(gradeLevel) {
        var url = "<?php echo base_url() . 'main/subjectSettings' ?>" // the script where you handle the form input.
        document.location = url + '/' + gradeLevel;
        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + gradeLevel, // serializes the form's elements.
            success: function(data) {
                $('#inputSubjects').val(data);
                document.location = url + '/' + gradeLevel;
            }
        });

        return false;
    }

    function removeSubject() {
        var subjects = $('#subjects').val();
        var grade_level = $('#grade_id').val()
        var subject_id = $('#sub_id').val();
        alert(subjects + ' ' + grade_level + ' ' + subject_id)

        if (grade_level == 12 || grade_level == 13) {
            var sem = $('#semester').val();
            var strand_id = $('#strand_id').val();
            var url = "<?php echo base_url() . 'subjectmanagement/removeSHSubject' ?>"
        } else {
            strand_id = 0;
            sem = 0;
            url = "<?php echo base_url() . 'main/removeSubject' ?>" // the script where you handle the form input.
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + grade_level + "&subject_id=" + subject_id + "&subjects=" + subjects + '&sem=' + sem + '&strand_id=' + strand_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (grade_level == 12 || grade_level == 13) {
                    $('#' + grade_level + '_' + strand_id + '_' + sem + '_' + subject_id + '_sub').addClass('hide');
                } else {
                    $('#' + subject_id + '_sub').addClass('hide');
                }
                alert(data)
            }
        });

        return false;
    }

    function listSubjPerLevel(id) {
        alert(id)
    }

    // Add Subject
    $(document).on('click', '.add-subject-btn', function() {
        let grade = $(this).data('grade');
        $('#grade_id').val(grade);

        console.log('Add subject for grade:', grade);

        // TODO: open modal
    });

    // Delete Subject
    $(document).on('click', '.delete-subject-btn', function(e) {
        e.stopPropagation(); // prevent parent click

        let id = $(this).data('id');
        var url = "<?php echo base_url() . 'main/removeSubject' ?>";
        var grade_level = $('#grade_id').val();

        if (confirm('Are you sure you want to delete this subject?')) {
            console.log('Delete subject:', id);

            $.ajax({
                type: "POST",
                url: url,
                data: "gradeLevel=" + grade_level + "&subject_id=" + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    showTopAlert(data.msg, data.status ? 'success' : 'danger');
                    if (grade_level == 12 || grade_level == 13) {
                        $('#' + grade_level + '_' + strand_id + '_' + sem + '_' + id + '_sub').addClass('hide');
                    } else {
                        $('#sub_' + id).addClass('d-none');
                    }
                }
            });
        }
    });

    $(document).on('click', '.subject-item', function() {
        if (isDragging) return;

        // remove active from others
        $('.subject-item').removeClass('active-item');

        // add active to clicked
        $(this).addClass('active-item');
    });

    document.addEventListener("DOMContentLoaded", function() {

        const activeTab = document.querySelector('#dcms_tab .nav-link.active');

        if (activeTab) {
            const activeTarget = activeTab.getAttribute('data-bs-target');

            // console.log("Active data-bs-target:", activeTarget);

            // Example: remove #
            const cleanTarget = activeTarget.replace('#', '');
            console.log("Clean ID:", cleanTarget);
            $('#' + cleanTarget).addClass('show active');
        }

    });

    $('#btnLoadSubjects').on('click', function() {

        let container = $('#subjectManagement_content');

        // Show loader
        $('#subjectLoader').show();
        container.children().not('#subjectLoader').hide();

        $.ajax({
            url: "<?= base_url() . 'subjectmanagement/listOfSubjects/' ?>",
            type: "GET",
            success: function(response) {

                // Replace content (except loader)
                container.html(response);

            },
            error: function() {
                container.html(`
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-circle me-2"></i>
                Failed to load subjects.
            </div>
        `);
            }
        });
    });
</script>