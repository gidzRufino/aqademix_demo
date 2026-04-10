<style>
    .card {
        border-radius: 14px;
    }

    .list-group-item {
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
    }

    .nav-pills .nav-link {
        border-radius: 10px;
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }

    #otherMenu {
        position: absolute;
        display: none;
        z-index: 10000;
    }
</style>
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="fw-bold mb-0">
                <i class="fa fa-cogs text-primary me-2"></i>
                Department / Course Management
            </h5>
        </div>
    </div>

    <!-- NAV -->
    <ul class="nav nav-pills mb-3 flex-wrap gap-2" id="dcms_tab" role="tablist">
        <?php
        $level_catered = explode(',', $school_settings->level_catered);
        $s = 0;
        foreach ($level_catered as $lc):
            $s++;
            $dept = Modules::run('coursemanagement/getDeptByID', $lc);

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
        endforeach; ?>
    </ul>

    <!-- CONTENT -->
    <div class="tab-content">
        <?php foreach ($department as $dept):
            $active = ($dept->level_dept_id == 1) ? 'show active' : '';

            $title = ($dept->level_dept_id == 5)
                ? 'List of Courses'
                : 'Grade Levels & Sections';
        ?>
            <div class="tab-pane fade <?php echo $active; ?>" id="dept_<?php echo $dept->level_dept_id; ?>">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-3 text-muted"><?php echo $title; ?></h6>

                        <?php if ($dept->level_dept_id != 5): ?>

                            <div class="row g-3">

                                <?php
                                $section = Modules::run('registrar/getGradeLevel', $dept->level_dept_id, '=');
                                foreach ($section as $list):
                                ?>

                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card border-0 shadow-sm h-100">

                                            <!-- GRADE HEADER -->
                                            <div class="card-header bg-light fw-semibold">
                                                <?php echo $list->level; ?>
                                            </div>

                                            <!-- SECTION LIST WITH ADD/EDIT/DELETE -->
                                            <ul class="list-group list-group-flush" id="<?= $list->grade_id ?>_section">
                                                <?php
                                                $section = Modules::run('registrar/getSectionByGradeId', $list->grade_id);
                                                if ($section->num_rows() > 0) {
                                                    foreach ($section->result() as $s):
                                                ?>
                                                        <li class="list-group-item list-group-item-action section-item"
                                                            style="cursor:pointer"
                                                            data-sec-id="<?= $s->s_id ?>"
                                                            data-grade-id="<?= $list->grade_id ?>"
                                                            data-sec-name="<?= $s->section ?>">
                                                            <i class="fa fa-layer-group text-primary me-2"></i><?= $s->section ?>
                                                        </li>
                                                    <?php
                                                    endforeach;
                                                } else {
                                                    ?>
                                                    <li class="list-group-item section-empty"
                                                        style="cursor:pointer; color:#999;"
                                                        data-grade-id="<?= $list->grade_id ?>">
                                                        Right-click here to add a section
                                                    </li>
                                                <?php } ?>
                                            </ul>

                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php else: ?>

                            <!-- COLLEGE SECTION -->
                            <div id="college" class="list-group">
                                <!-- dynamically append courses -->
                            </div>

                        <?php endif; ?>

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- HIDDEN INPUTS -->
<input type="hidden" id="sec_id">
<input type="hidden" id="sec_name">
<input type="hidden" id="grade_id">
<div id="otherMenu" style="position:absolute; display:none; z-index:10000; background:#fff; border:1px solid #ccc; border-radius:6px; min-width:160px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
    <ul style="list-style:none; margin:0; padding:0;">
        <li style="padding:8px; cursor:pointer;" onclick="getAdd('Section')">
            <i class="fa fa-plus-square fa-fw"></i> Add Section
        </li>
        <li style="padding:8px; cursor:pointer;" onclick="getAdd('EditSection')">
            <i class="fa fa-edit fa-fw"></i> Rename Section
        </li>
        <li style="border-top:1px solid #ddd;"></li>
        <li style="padding:8px; cursor:pointer;" onclick="deleteSection()">
            <i class="fa fa-trash fa-fw"></i> Delete Section
        </li>
    </ul>
</div>
<?php
$data['ro_year'] = Modules::run('registrar/getROYear');
$data['collegeSubjects'] = Modules::run('subjectmanagement/getCollegeSubjects');
$this->load->view('modalForms', $data);
?>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#dcms_tab button'))
        triggerTabList.forEach(function(triggerEl) {
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                const tabTrigger = new bootstrap.Tab(triggerEl)
                tabTrigger.show()
            })
        })
    });

    $(document).ready(function() {
        $('#dcms_tab a').click(function(e) {
            e.preventDefault()
            $(this).tab('show')
        })
    })

    $(document).ready(function() {
        // Right-click context menu
        $(document).on('contextmenu', '.section-item', function(e) {
            e.preventDefault();

            // Save selected section
            $('#sec_id').val($(this).data('sec-id'));
            $('#sec_name').val($(this).data('sec-name'));
            $('#grade_id').val($(this).data('grade-id'));

            const menu = $('#otherMenu');
            const menuWidth = menu.outerWidth();
            const menuHeight = menu.outerHeight();
            const winWidth = $(window).width();
            const winHeight = $(window).height();
            let left = e.pageX;
            let top = e.pageY;

            // Adjust if menu overflows right or bottom
            if (left + menuWidth > winWidth) left = winWidth - menuWidth - 10;
            if (top + menuHeight > winHeight) top = winHeight - menuHeight - 10;

            menu.css({
                display: 'block',
                top: top + 'px',
                left: left + 'px'
            });
        });

        // Hide menu when clicking anywhere else
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#otherMenu').length) {
                $('#otherMenu').hide();
            }
        });

        // Update hidden inputs on left-click
        $(document).on('click', '.section-item', function() {
            $('#sec_id').val($(this).data('sec-id'));
            $('#sec_name').val($(this).data('sec-name'));
            $('#grade_id').val($(this).data('grade-id'));
        });

        // Right-click menu for section items
        $(document).on('contextmenu', '.section-item, .section-empty', function(e) {
            e.preventDefault();

            // Set hidden inputs
            $('#grade_id').val($(this).data('grade-id'));
            $('#sec_id').val($(this).data('sec-id') || '');
            $('#sec_name').val($(this).data('sec-name') || '');

            // Find the card container
            let card = $(this).closest('.card');
            let cardOffset = card.offset();

            const menu = $('#otherMenu');
            const menuWidth = menu.outerWidth();
            const menuHeight = menu.outerHeight();
            const winWidth = $(window).width();
            const winHeight = $(window).height();

            // Position menu **above the card, left-aligned**
            let left = cardOffset.left;
            let top = cardOffset.top - menuHeight - 5; // 5px gap above

            // Adjust if menu goes offscreen
            if (left + menuWidth > winWidth) left = winWidth - menuWidth - 5;
            if (top < 0) top = cardOffset.top + card.outerHeight() + 5; // place below if not enough space above

            menu.css({
                display: 'block',
                top: top + 'px',
                left: left + 'px'
            });
        });

        // Hide menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#otherMenu').length) {
                $('#otherMenu').hide();
            }
        });

        // Hide menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#otherMenu').length) {
                $('#otherMenu').hide();
            }
        });

        // Hide menu on click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#otherMenu').length) {
                $('#otherMenu').hide();
            }
        });
    });

    function getAdd(data) {
        $('#eSec').attr('value', $('#sec_name').val());
        $('#add' + data).modal('show');
    }

    function loadSubject(course) {
        $('#courseTitle').html(course);
        var url = '<?php echo base_url() . 'coursemanagement/loadSubject/' ?>' + $('#course_id').val()
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: '', // serializes the form's elements.
            success: function(data) {
                $('#11_Sem').html(data.fyfs);
                $('#12_Sem').html(data.fyss);
                $('#21_Sem').html(data.syfs);
                $('#22_Sem').html(data.syss);
            }
        });

        return false;
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

    function addSection() {
        var section = $('#txtAddSection').val();
        var grade_id = $('#grade_id').val();
        if (!section) return alert('Please enter section name');

        $.ajax({
            url: '<?php echo base_url("coursemanagement/addSection") ?>/' + section + '/' + grade_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'danger');
                if (data.status) {
                    $('#' + grade_id + '_section').append(
                        `<li class="list-group-item list-group-item-action section-item"
                        data-sec-id="${data.id}" data-grade-id="${grade_id}" data-sec-name="${section}">
                        <i class="fa fa-layer-group text-primary me-2"></i>${section}
                    </li>`
                    );
                    $('#txtAddSection').val('');
                    $('#addSection').modal('hide');
                }
            }
        });
    }

    function editSection() {
        var secID = $('#sec_id').val();
        var sec = $('#eSec').val();
        if (!sec) return alert('Section name cannot be empty');

        $.ajax({
            url: '<?php echo base_url("coursemanagement/editSection") ?>/' + sec + '/' + secID,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                // Update the li text dynamically
                if (res.status) {
                    $('li[data-sec-id="' + secID + '"]').data('sec-name', sec).html(
                        '<i class="fa fa-layer-group text-primary me-2"></i>' + sec
                    );
                }
                showTopAlert(data.msg, data.status ? 'success' : 'danger');
                $('#addEditSection').modal('hide');
            },
            error: function() {
                alert('Error updating section');
            }
        });
    }

    function addCourse() {
        var course = $('#inputCourse').val()
        var short_code = $('#inputShortCode').val()
        var url = '<?php echo base_url() . 'coursemanagement/addCourse/' ?>' + course + '/' + short_code;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: '', // serializes the form's elements.
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'danger');
                if (data.status) {
                    $('#college').append('<li>' + course + '</li>');
                }
            }
        });

        return false;
    }

    function deleteSection() {
        var section_id = $('#sec_id').val();
        var section = $('#sec_name').val();
        if (!section_id) return;

        if (confirm("Do you really want to delete '" + section + "'?")) {
            $.ajax({
                url: '<?php echo base_url("coursemanagement/deleteSection") ?>/' + section_id,
                type: 'GET',
                dataType: 'json',
                success: function(r) {
                    if (r.status) {
                        $('li[data-sec-id="' + section_id + '"]').remove();
                        showTopAlert(r.msg, 'success');
                    } else {
                        showTopAlert(r.msg, 'danger');
                    }
                },
                error: function() {
                    showTopAlert('Error deleting section', 'danger');
                }
            });
        }
    }
</script>
<?php $this->load->view('coursemanagement_modal'); ?>