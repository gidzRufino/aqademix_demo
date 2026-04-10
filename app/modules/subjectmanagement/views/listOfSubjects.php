<style>
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 2px;
        color: #495057;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: #f1f3f5;
        color: #dc3545;
    }

    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }
</style>
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">

            <!-- LEFT -->
            <div>
                <h5 class="fw-semibold mb-0">
                    <i class="fa fa-book text-primary me-2"></i>
                    List of Subjects
                </h5>
                <small class="text-muted">Manage all subjects</small>
            </div>

            <!-- RIGHT -->
            <div class="d-flex flex-wrap align-items-center gap-2">

                <!-- LINK -->
                <!-- <a href="#" id="loadSubjects"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-list me-1"></i> View Full List
                </a> -->

                <!-- SEARCH -->
                <div class="input-group input-group-sm" style="width:250px;">
                    <span class="input-group-text bg-white">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="Search subject...">
                </div>

                <!-- ADD -->
                <button onclick="$('#addNewSubject').modal('show')"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i> Add
                </button>

            </div>

        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card border-0 shadow-sm">

        <!-- 🔥 PAGINATION MOVED HERE -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

            <small class="text-muted">
                Showing subjects list
            </small>

            <div>
                <?php echo $links; ?>
            </div>

        </div>

        <!-- TABLE -->
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase">
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Code</th>
                            <th class="text-center">Core</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="subjectsWrapper">
                        <?php foreach ($subjects as $s): ?>
                            <tr id="tr_<?php echo $s->subject_id ?>">

                                <td><?php echo $s->subject_id; ?></td>

                                <td id="td_<?php echo $s->subject_id; ?>" class="fw-semibold">
                                    <?php echo $s->subject ?>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo $s->short_code ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        onclick="makeCore('<?php echo $s->subject_id; ?>')"
                                        <?php if ($s->is_core) echo "checked"; ?>>
                                </td>

                                <td class="text-end">
                                    <button onclick="showModal('<?php echo addslashes($s->subject) ?>','<?php echo $s->subject_id ?>','<?php echo addslashes($s->short_code) ?>')"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pen"></i>
                                    </button>

                                    <button onclick="deleteModal('<?php echo $s->subject ?>','<?php echo $s->subject_id ?>','0')"
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
    function search(subject) {

        var url = "<?php echo base_url() . 'subjectmanagement/searchSubject/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "subject=" + subject + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#subjectsWrapper').html(data);
                $('#links').hide();
            }
        });
    }

    function makeCore(sub_id) {

        var url = "<?php echo base_url() . 'subjectmanagement/makeCore/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "sub_id=" + sub_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert('Successfully Updated')
            }
        });
    }

    function deleteModal(subject, sub_id, isUse) {
        if (isUse == 1) {
            alert('Cannot delete the Subject. Subject is in use');
        } else {
            $('#deleteSubject').modal('show');
            setTimeout(function() {
                $('#subject').val(subject);
                $('#sub_id').val(sub_id);
            }, 100);
        }
    }

    function showModal(subject, sub_id, short_code) {
        $('#editSubject').modal('show');
        setTimeout(function() {
            $('#subject').val(subject);
            $('#sub_id').val(sub_id);
            $('#subjectCode').val(short_code);
        }, 100);
    }

    function deleteSubject() {
        var sub_id = $('#sub_id').val()
        var subjects = $('#subject').val()

        var url = "<?php echo base_url() . 'subjectmanagement/deleteSubject/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "sub_id=" + sub_id + "&subject=" + subjects + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#tr_' + sub_id).hide();
                $('#deleteSubject').modal('hide');
                alert('Successfully Deleted')
            }
        });
    }


    function addSubject() {
        var subject = $('#inputAddSubject').val();
        var sCode = $('#AddSubjectCode').val();

        var url = "<?php echo base_url() . 'subjectmanagement/addSubject/' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "subject=" + subject + "&subjectCode=" + sCode + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'warning');
                $('#addNewSubject').modal('hide');
            }
        });
    }

    function editSubject() {
        var sub_id = $('#sub_id').val()
        var subjects = $('#subject').val()
        var sCode = $('#subjectCode').val();

        var url = "<?php echo base_url() . 'subjectmanagement/editSubject/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "sub_id=" + sub_id + "&subject=" + subjects + "&subCode=" + sCode + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#td_' + sub_id).html(subjects)
                $('#editSubject').modal('hide');
                alert('Successfully Updated')
            }
        });
    }

    // 🔥 AJAX PAGINATION
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $('#subjectManagement_content').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
            <div class="mt-2">Loading...</div>
        </div>
    `);

        $.get(url, function(data) {
            $('#subjectManagement_content').html(data);
        });
    });


    // 🔥 AJAX SEARCH (LIVE)
    $('#searchInput').on('keyup', function() {

        let keyword = $(this).val();

        $.ajax({
            url: "<?= base_url('subjectmanagement/searchSubject') ?>",
            type: "POST",
            data: {
                subject: keyword,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                $('#subjectsWrapper').html(data);
            }
        });

    });


    // 🔥 CORE TOGGLE
    function makeCore(sub_id) {
        $.post("<?= base_url('subjectmanagement/makeCore') ?>", {
            sub_id: sub_id,
            csrf_test_name: $.cookie('csrf_cookie_name')
        });
    }


    // 🔥 DELETE
    function deleteSubject() {
        let sub_id = $('#sub_id').val();

        $.post("<?= base_url('subjectmanagement/deleteSubject') ?>", {
            sub_id: sub_id,
            csrf_test_name: $.cookie('csrf_cookie_name')
        }, function() {
            $('#tr_' + sub_id).remove();
            $('#deleteSubject').modal('hide');
        });
    }


    // 🔥 ADD
    // function addSubject() {
    //     $.post("<?= base_url('subjectmanagement/addSubject') ?>", {
    //         subject: $('#inputAddSubject').val(),
    //         subjectCode: $('#AddSubjectCode').val(),
    //         csrf_test_name: $.cookie('csrf_cookie_name')
    //     }, function() {
    //         location.reload(); // optional
    //     });
    // }


    // 🔥 EDIT
    function editSubject() {
        $.post("<?= base_url('subjectmanagement/editSubject') ?>", {
            sub_id: $('#sub_id').val(),
            subject: $('#subject').val(),
            subCode: $('#subjectCode').val(),
            csrf_test_name: $.cookie('csrf_cookie_name')
        }, function() {
            $('#editSubject').modal('hide');
            location.reload();
        });
    }

    $('#loadSubjects').click(function(e) {
        e.preventDefault();
        $('#subjectManagement_content').load("<?= base_url('subjectmanagement/listOfSubjectsAjax') ?>");
    });
</script>