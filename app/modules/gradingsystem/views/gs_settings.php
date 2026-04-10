<style>
    .card {
        border-radius: 14px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .badge {
        font-weight: 500;
        border-radius: 8px;
    }

    .card {
        border-radius: 16px;
    }

    .btn-group .btn {
        border-radius: 8px !important;
    }

    .btn-rounded {
        border-radius: 50px;
    }

    .editable-weight {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .editable-weight:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }

    #subjectSearch {
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    #subjectSearch:focus {
        box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.25);
        border-color: #dc3545;
    }

    #clearSearch:hover {
        color: #dc3545;
    }

    .input-group .btn {
        border-left: 0;
    }

    .input-group-sm .form-control,
    .input-group-sm .btn {
        height: 38px;
    }

    .input-group .form-control {
        border-right: 0;
    }

    .input-group .btn {
        border-left: 0;
    }

    .input-group .form-control:focus {
        box-shadow: none;
        border-color: #dc3545;
    }

    .input-group .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-group .form-control,
    .search-group .btn {
        height: 38px !important;
        padding: 0.25rem 0.5rem;
    }

    .search-group .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-group .form-control {
        border-right: 0;
    }

    .search-group .btn {
        border-left: 0;
    }

    .pointer {
        cursor: pointer;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    /* Optional: rotate icon when collapsed/expanded */
    .card-header[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }

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

<div class="row g-4">

    <!-- ROW 1: Raw Score + Component Weights (Single Card) -->
    <div class="col-12">
        <div class="card shadow-sm border-0">

            <!-- Card Header -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center pointer"
                data-bs-toggle="collapse" data-bs-target="#collapseRawAndComponents" aria-expanded="true">
                <div>
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-layer-group me-2 text-success"></i>
                        Raw Score & Component Weights
                    </h5>
                    <small class="text-muted">Manage grading distribution and raw score transmutation</small>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>

            <!-- Card Body -->
            <div id="collapseRawAndComponents" class="collapse show">
                <div class="card-body pt-3">

                    <!-- Section 1: Raw Score Transmutation -->
                    <div class="mb-4">
                        <h6 class="fw-semibold text-success mb-2">
                            <i class="fas fa-calculator me-2"></i> Raw Score Transmutation
                        </h6>
                        <p class="mb-2 text-muted small">
                            Raw scores are transmuted using the formula:
                        </p>
                        <div class="bg-light rounded p-3 border small">
                            <strong>Percentage Score (PS)</strong> =
                            ((Learner's Total RS / Highest Possible Score) × 100%)
                        </div>
                    </div>

                    <!-- Section 2: Component Weights -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <!-- Search Input -->
                            <div class="position-relative" style="max-width:300px;">
                                <input type="text"
                                    id="subjectSearch"
                                    class="form-control form-control-sm ps-5 pe-5"
                                    placeholder="Search subject...">
                                <i class="fas fa-search position-absolute"
                                    style="top: 50%; left: 12px; transform: translateY(-50%); color:#999; font-size: 13px;">
                                </i>
                                <i class="fas fa-times position-absolute d-none"
                                    id="clearSearch"
                                    style="top: 50%; right: 12px; transform: translateY(-50%); cursor:pointer; color:#999; font-size: 13px;">
                                </i>
                            </div>

                            <button class="btn btn-sm btn-light border" id="btnReset">Reset</button>
                        </div>
                        <div class="d-flex justify-content-end mt-2" id="paginationWrapper">
                            <?= $links ?>
                        </div>

                        <!-- Component Table -->
                        <div class="table-responsive" id="subjectTableContainer">
                            <table class="table align-middle mb-0" id="subjectsTable">
                                <thead class="border-bottom">
                                    <tr class="text-muted small text-uppercase">
                                        <th>Subject</th>
                                        <?php foreach ($components as $c): ?>
                                            <th class="text-center"><?php echo $c->component ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ss = 0;
                                    foreach ($subjects as $sub):
                                        if ($sub->subject != ""): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold text-dark"><?php echo $sub->subject; ?></div>
                                                    <small class="text-muted">Code: <?php echo $sub->short_code; ?></small>
                                                </td>

                                                <?php foreach ($components as $cp): ?>
                                                    <td class="text-center"
                                                        data-subject="<?php echo $sub->subject_id ?>"
                                                        data-component="<?php echo $cp->id ?>">
                                                        <?php
                                                        $cmp = Modules::run('gradingsystem/new_gs/componentPerSubject', $sub->subject_id, $cp->id);
                                                        $value = ($cmp && $cmp->weight != 0) ? ($cmp->weight * 100) : '';
                                                        ?>
                                                        <span class="editable-weight badge bg-light text-dark border px-3 py-2"
                                                            data-value="<?php echo $value; ?>">
                                                            <?php echo ($value === '' ? '-' : $value . '%'); ?>
                                                        </span>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                    <?php endif;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Learner's Observed Values -->
    <div class="col-12">
        <div class="card shadow-sm border-0">

            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center pointer"
                data-bs-toggle="collapse" data-bs-target="#collapseObserved" aria-expanded="true">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-user-check me-2"></i> Learner's Observed Values
                </h6>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>

            <!-- Body -->
            <div id="collapseObserved" class="collapse show">
                <div class="card-body">
                    <div class="small text-muted mb-3">
                        Configure learner behavior and observed value settings.
                    </div>
                    <div class="p-2">
                        <?php echo Modules::run('gradingsystem/behSettings') ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?php $this->load->view('addAssessment'); ?>
<?php $this->load->view('addDO8_subjects'); ?>
<?php $this->load->view('behavior_settings_modal'); ?>
<input type="hidden" id="prevSelected" value="" />

<script type="text/javascript">
    $(function() {
        $('#addCriteriaBtn').clickover({
            placement: 'top',
            html: true
        });

        $('#inputSubjectID').select2();
    })

    function showEditAssessWeight(subject, school_year, sub_title, code) {
        $('#editDOSubjects').modal('show');
        $('#code').val(code);
        $('#subject_id').val(subject);
        $('#school_year').val(school_year);
        $('#sub_title').html(sub_title);
    }

    function editSubjectWeight() {
        var code = $('#code').val();
        var subject_id = $('#subject_id').val();
        var assessment = $('#editAssessment').val()
        var weight = $('#editWeight').val()
        var proceed = 1;

        if (assessment == 0) {
            errorMsg('Please Select Assessment', 'red', 3000);
            proceed = 0;
        } else if (weight == '') {
            errorMsg('Please Enter weight in decimal form', 'red', 3000);
            proceed = 0;
        }

        if (proceed == 1) {
            var url = '<?php echo base_url() . 'gradingsystem/new_gs/editSubjectWeight' ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'subject_id=' + subject_id + '&assessment=' + assessment + '&weight=' + weight + '&code=' + code + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    errorMsg(data.msg, 'green', 3000);
                    setTimeout(function() {
                        $('#editDOSubjects').modal('hide');
                        if (data.status) {
                            $('#' + data.tid).text(data.weight);
                        }
                    }, 2000);
                }
            })
        }

    }

    function addSubjectWeight() {
        var subject_id = $('#inputSubjectID').val()
        var assessment = $('#inputAssessment').val()
        var weight = $('#inputWeight').val()
        var proceed = 1;

        if (subject_id == 0) {
            errorMsg('Please Select Subject', 'red', 3000);
            proceed = 0;
        } else if (assessment == 0) {
            errorMsg('Please Select Assessment', 'red', 3000);
            proceed = 0;
        } else if (weight == '') {
            errorMsg('Please Enter weight in decimal form', 'red', 3000);
            proceed = 0;
        }

        if (proceed == 1) {
            var url = '<?php echo base_url() . 'gradingsystem/new_gs/addSubjectWeight' ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'subject_id=' + subject_id + '&assessment=' + assessment + '&weight=' + weight + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    errorMsg(data.msg, data.color, 5000);
                    setTimeout(location.reload.bind(location), 6000);
                }
            });
        }
    }

    function errorMsg(msg, color, tDelay) {
        $('.promptMsg').show().delay(tDelay).queue(function(n) {
            $(this).hide();
            n();
        });
        $('.promptMsg').css('color', color);
        $('.promptMsg').text('Alert: ' + msg);
    }

    function selectGS(value) {
        switch (value) {
            case '1':
                $('#kpup_body').removeClass('hide');
                $('#DO_8').addClass('hide')
                break;
            case '2':

                $('#kpup_body').addClass('hide');
                $('#DO_8').removeClass('hide')
                break;
        }

        var url = "<?php echo base_url() . 'gradingsystem/saveGS/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'gs_used=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {

            }
        });
    }

    function getAssessment(value) {

        var url = "<?php echo base_url() . 'gradingsystem/new_gs/selectAssessment/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {

            }
        });
    }

    function saveTransmutation() {

        if ($('#bybase').is(':checked')) {
            var byBase = 1
            var base = $('#base').val()
            var formula = ""
        }
        if ($('#byform').is(':checked')) {
            byBase = 0
            base = ""
            formula = $('#formula').val()
        }

        var url = "<?php echo base_url() . 'gradingsystem/saveTransmutation/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'byBase=' + byBase + '&base=' + base + '&formula=' + formula + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data.msg)
                location.reload()
            }
        });
    }

    function saveCriteria() {
        var subject_id = $('#getSubject').val()

    }

    function addCriteria() {

        var subject_id = $('#getSubject').val()
        var subject_name = $('#getSubject :selected').text()
        var k = $('#' + subject_id + '_kpupsContainer_1').val()

        if ($('#' + subject_id + '_kpupsContainer_1').length > 0) {
            var proc = $('#' + subject_id + '_kpupsContainer_2').val()
            var u = $('#' + subject_id + '_kpupsContainer_3').val()
            var prod = $('#' + subject_id + '_kpupsContainer_4').val()



            if (k == "") {
                k = 15
            }
            if (proc == "") {
                proc = 25
            }
            if (u == "") {
                u = 30
            }
            if (prod == "") {
                prod = 30
            }

            var kpups = parseInt(k) + parseInt(proc) + parseInt(u) + parseInt(prod);
            //alert(kpups)
            if (kpups >= 100) {
                alert('Sorry, You Can\'t add a Criteria')
                location.reload()
            } else {
                $('#addCriteriaBtn').clickover({
                    auto_close: 1000
                });
                var name = $('#addedCriteria').val();
                var i = $('#p_kpupsContainer_' + subject_id).find('input').length + 1;
                var kpupsContainer = $('#p_kpupsContainer_' + subject_id);
                $('<input type="text" id="' + subject_id + '_kpupsContainer_' + i + '" size="8" name="' + name + '" value="" placeholder="' + name.charAt(0) + ' %" /><i class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,' + i + ')"></i>').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', i);
                i++;
            }
        } else {
            $('<label>' + subject_name + ' :</label><br /><p id="p_kpupsContainer_' + subject_id + '">\n\
                \n\
                </p>').appendTo($('#kpupsContainer'))

            var kpupsContainer = $('#p_kpupsContainer_' + subject_id);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_1" size="8" name="Knowledge" value="15" placeholder="K %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_2" size="8" name="Process" value="25" placeholder="P %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_3" size="8" name="Understanding" value="30" placeholder="U %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_4" size="8" name="Product" value="30" placeholder="P %" />').appendTo(kpupsContainer);
            $('#addCriteriaBtn').attr('count', 4);
        }



    }

    function addSubjectComponent() {

        var subject_id = $('#getSubject').val()
        var subject_name = $('#getSubject :selected').text()
        var k = $('#' + subject_id + '_kpupsContainer_1').val()

        if ($('#' + subject_id + '_kpupsContainer_1').length > 0) {
            var proc = $('#' + subject_id + '_kpupsContainer_2').val()
            var u = $('#' + subject_id + '_kpupsContainer_3').val()
            var prod = $('#' + subject_id + '_kpupsContainer_4').val()



            if (k == "") {
                k = 15
            }
            if (proc == "") {
                proc = 25
            }
            if (u == "") {
                u = 30
            }
            if (prod == "") {
                prod = 30
            }

            var kpups = parseInt(k) + parseInt(proc) + parseInt(u) + parseInt(prod);
            //alert(kpups)
            if (kpups >= 100) {
                alert('Sorry, You Can\'t add a Criteria')
                location.reload()
            } else {
                $('#addCriteriaBtn').clickover({
                    auto_close: 1000
                });
                var name = $('#addedCriteria').val();
                var i = $('#p_kpupsContainer_' + subject_id).find('input').length + 1;
                var kpupsContainer = $('#p_kpupsContainer_' + subject_id);
                $('<input type="text" id="' + subject_id + '_kpupsContainer_' + i + '" size="8" name="' + name + '" value="" placeholder="' + name.charAt(0) + ' %" /><i class="pointer fa fa-trash" title="kpupsContainer" onclick="removed(this,' + i + ')"></i>').appendTo(kpupsContainer);
                $('#addCriteriaBtn').attr('count', i);
                i++;
            }
        } else {
            $('<label>' + subject_name + ' :</label><br /><p id="p_kpupsContainer_' + subject_id + '">\n\
                \n\
                </p>').appendTo($('#kpupsContainer'))

            var kpupsContainer = $('#p_kpupsContainer_' + subject_id);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_1" size="8" name="Knowledge" value="15" placeholder="K %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_2" size="8" name="Process" value="25" placeholder="P %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_3" size="8" name="Understanding" value="30" placeholder="U %" />').appendTo(kpupsContainer);
            $('<input style="margin-right:10px;" class="text-center" type="text" id="' + subject_id + '_kpupsContainer_4" size="8" name="Product" value="30" placeholder="P %" />').appendTo(kpupsContainer);
            $('#addCriteriaBtn').attr('count', 4);
        }



    }

    function removed(e, i, id) {
        var name = $('#kpupsContainer_' + i).attr('name')
        if (i > 0) {

            $(e).parents('p').remove();
            i--;
            $('#addCriteriaBtn').attr('count', i);
        }
        var url = "<?php echo base_url() . 'gradingsystem/deleteKPUPS/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'custom=' + i + '&name=' + name + '&id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (data.status) {
                    alert(data.msg)
                    location.reload()
                } else {
                    console.log(data.msg)
                }
            }
        });
    }


    function addComponent() {
        var comp = $('#component').val();
        if (comp !== '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'gradingsystem/addComponent' ?>",
                data: "component=" + comp + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#inputAssessment').append('<option value="' + data.id + '"> ' + $('#component').val() + '</option>');
                        alert('Successfully Added')
                    } else {
                        alert('Sorry Component already exist');
                    }

                    $('#addComponent').modal('hide');
                }

            });
        } else {
            alert('Name of Component should not be empty');
        }

    }

    function deleteSubject(subject_id, tr) {
        if (confirm("Are you sure you want to delete this subject?")) {
            $.ajax({
                url: "<?= base_url() . 'gradingsystem/deleteSubject' ?>", // update this
                type: "POST",
                data: {
                    subject_id: subject_id,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                dataType: 'json',
                success: function(res) {
                    showTopAlert(res.msg, res.status ? 'success' : 'danger');
                    alert(tr)
                    $('#tr_' + (tr - 1)).addClass('d-none');
                },
                error: function() {
                    showTopAlert('An Error Occured', 'danger');
                }
            });
        }
    }

    $(document).on('click', '.editable-weight', function() {
        let span = $(this);
        let currentValue = span.data('value');

        // Prevent multiple inputs
        if (span.closest('td').find('input').length) return;

        let input = $(`
        <input type="number"
               class="form-control form-control-sm text-center"
               style="width:80px; display:inline-block;"
        />
    `).val(currentValue);

        // Replace span with input
        span.replaceWith(input);

        // 🔥 IMPORTANT: focus AFTER render
        setTimeout(() => {
            input.focus();
            input.select(); // optional: auto-highlight value
        }, 0);

        // ENTER = save
        input.on('keydown', function(e) {
            if (e.key === 'Enter') {
                let newValue = $(this).val();
                let td = $(this).closest('td');

                let subject_id = td.data('subject');
                let component_id = td.data('component');

                saveWeight(td, subject_id, component_id, newValue);
            }

            // ESC = cancel
            if (e.key === 'Escape') {
                cancelEdit($(this), currentValue);
            }
        });

        // Blur = cancel
        input.on('blur', function() {
            cancelEdit($(this), currentValue);
        });
    });

    function saveWeight(td, subject_id, component_id, value) {
        let percent = value;

        // Convert to decimal (e.g. 50 → 0.5)
        let weight = percent / 100;

        $.ajax({
            url: "<?= base_url() . 'gradingsystem/new_gs/editSubjectWeight' ?>", // update this
            type: "POST",
            data: {
                subject_id: subject_id,
                assessment: component_id,
                weight: weight,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            success: function(res) {
                showTopAlert(res.msg, res.status ? 'success' : 'danger')
                let display = percent ? percent + '%' : '-';

                td.html(`
                <span class="editable-weight badge bg-light text-dark border px-3 py-2"
                      data-value="${percent}">
                    ${display}
                </span>
            `);
            },
            error: function() {
                showTopAlert("Failed to save.", 'warning');
            }
        });
    }

    function cancelEdit(input, oldValue) {
        let display = oldValue ? oldValue + '%' : '-';

        input.replaceWith(`
        <span class="editable-weight badge bg-light text-dark border px-3 py-2"
              data-value="${oldValue}">
            ${display}
        </span>
    `);
    }

    function filterSubjects() {
        let keyword = $('#subjectSearch').val().toLowerCase();

        $('tbody tr').each(function() {
            let subject = $(this).find('td:first').text().toLowerCase();

            if (subject.indexOf(keyword) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Button click
    $('#btnSearch').on('click', function() {
        filterSubjects();
    });

    // Enter key trigger
    $('#subjectSearch').on('keyup', function() {
        let keyword = $(this).val();
        loadSubjects(1, keyword); // page 1
    });

    function loadSubjects(page, keyword = '') {
        $.get("<?= base_url('gradingsystem/gs_settings') ?>", {
            page: page,
            search: keyword
        }, function(data) {
            let html = $(data).find('#subjectTableContainer').html();
            let pagination = $(data).find('#paginationWrapper').html();

            $('#subjectTableContainer').html(html);
            $('#paginationWrapper').html(pagination);
        });
    }

    // Reset button
    $('#btnReset').on('click', function() {
        $('#subjectSearch').val('');
        $('tbody tr').show();
    });

    // Toggle collapse icon
    document.querySelectorAll('.collapse').forEach(function(collapseEl) {
        collapseEl.addEventListener('show.bs.collapse', function() {
            collapseEl.previousElementSibling.querySelector('.toggle-icon').style.transform = 'rotate(180deg)';
        });
        collapseEl.addEventListener('hide.bs.collapse', function() {
            collapseEl.previousElementSibling.querySelector('.toggle-icon').style.transform = 'rotate(0deg)';
        });
    });

    // Search + Clear button
    function filterSubjects() {
        let keyword = $('#subjectSearch').val().toLowerCase();
        $('tbody tr').each(function() {
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(keyword));
        });
    }

    $('#subjectSearch').on('keyup', function() {
        filterSubjects();
        $('#clearSearch').toggle($(this).val().length > 0);
    });

    $('#clearSearch').on('click', function() {
        $('#subjectSearch').val('').focus();
        $(this).addClass('d-none');
        filterSubjects();
    });

    $('#btnReset').on('click', function() {
        $('#subjectSearch').val('');
        $('#clearSearch').addClass('d-none');
        filterSubjects();
    });

    // 🔥 AJAX PAGINATION (LIKE YOUR OTHER MODULE)
    let isLoading = false;

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        if (isLoading) return; // 🔥 prevent spam clicking

        let url = $(this).attr('href');
        if (!url) return;

        isLoading = true;

        $('#subjectTableContainer').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-danger"></div>
            <div class="mt-2 small text-muted">Loading...</div>
        </div>
    `);

        $.get(url)
            .done(function(data) {

                let html = $(data).find('#subjectTableContainer').html();
                let pagination = $(data).find('#paginationWrapper').html();

                if (html) {
                    $('#subjectTableContainer').html(html);
                }

                if (pagination) {
                    $('#paginationWrapper').html(pagination);
                }
            })
            .fail(function() {
                $('#subjectTableContainer').html(`
                <div class="text-danger text-center py-4">
                    Failed to load data
                </div>
            `);
            })
            .always(function() {
                isLoading = false; // 🔥 release lock
            });
    });
</script>