<div class="container-fluid py-3">

    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h4 class="fw-bold mb-2">
                    <i class="fa fa-cogs me-2 text-primary"></i>
                    School Settings
                </h4>

                <a href="<?php echo base_url() ?>main/backup"
                    class="btn btn-warning shadow-sm">
                    <i class="fa fa-database me-2"></i>
                    Backup School Data
                </a>

            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="card shadow-lg border-0">

        <!-- Tabs -->
        <div class="card-header bg-white border-bottom">

            <ul class="nav nav-tabs card-header-tabs" id="settings_tab" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#generalSettings"
                        type="button">
                        <i class="fa fa-cog me-2"></i>General
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#subjectSettings"
                        type="button">
                        <i class="fa fa-book me-2"></i>Subjects
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#GSSettings"
                        type="button">
                        <i class="fa fa-calculator me-2"></i>Grading System
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#timeSettings"
                        type="button">
                        <i class="fa fa-clock me-2"></i>Time Settings
                    </button>
                </li>

            </ul>

        </div>

        <!-- Content -->
        <div class="card-body">

            <div class="tab-content">

                <div class="tab-pane fade show active"
                    id="generalSettings">

                    <?php $this->load->view('schoolSettings') ?>

                </div>

                <div class="tab-pane fade"
                    id="GSSettings">

                    <?php echo Modules::run('gradingsystem/gs_settings')
                    ?>

                </div>

                <div class="tab-pane fade"
                    id="subjectSettings">

                    <?php echo Modules::run('subjectmanagement')
                    ?>

                </div>

                <div class="tab-pane fade"
                    id="timeSettings">

                    <?php $this->load->view('timeSettings')
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript">
    $(function() {
        $(document).on('click', '.editableTable span[id]', function() {
            var OriginalContent = $(this).text().trim();
            var ID = $(this).attr('id');

            $(this).addClass("cellEditing");
            $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();

                    var dataString = "column=" + ID + "&value=" + newContent + '&csrf_test_name=' + $.cookie('csrf_cookie_name')
                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'main/inLineEdit' ?>",
                        dataType: 'json',
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            // inline edit success
                        }
                    });

                }
            });

            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });

        // Load tab from URL hash
        let hash = window.location.hash;
        if (hash) {
            let triggerEl = document.querySelector('[data-bs-target="' + hash + '"]');
            if (triggerEl) {
                new bootstrap.Tab(triggerEl).show();
            }
        }

        // Update URL when tab changes
        document.querySelectorAll('#settings_tab button[data-bs-toggle="tab"]').forEach(function(tabBtn) {
            tabBtn.addEventListener('shown.bs.tab', function(event) {
                let id = event.target.getAttribute('data-bs-target');
                history.replaceState(null, null, id);
            });
        });

        $(".setNumDays").dblclick(function() {
            $(this).text('');
            var OriginalContent = $(this).text();
            var month = $(this).attr('id');
            var dept = $(this).attr('dept');

            $(this).addClass("cellEditing");
            $(this).html("<input type='text' style='height:30px; text-align:center; width:30px;' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    var sy = '<?php echo $this->session->school_year ?>';

                    var url = '<?php echo base_url() . 'reports/saveSchoolDays/' ?>';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        beforeSend: function() {

                            $('#confirmMsg').html('<i class="fa fa-spinner fa-spin">');
                        },
                        data: {
                            dept: dept,
                            numOfSchoolDays: newContent,
                            month: month,
                            year: sy,
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        //dataType: 'json',
                        success: function(result) {
                            $('#' + month).text(result.days);
                        },
                        error: function(result) {
                            //alert('error checking');
                        }
                    });

                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");

                }
            });

            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });
    });

    function showStats() {
        var url = "<?php echo base_url() . 'main/showStats/' ?>"; // the script where you handle the form input.

        document.location = url
    }

    function changeGSSetting(value, column) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'gradingsystem/editSettings' ?>",
            data: 'column=' + column + '&value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                console.log(data);
            }
        });
    }

    function changeAttendanceSetting(value) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'main/inLineEdit' ?>",
            data: 'column=att_check&value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            cache: false,
            success: function(data) {

            }
        });
    }

    function changeLevelSetting(value) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'main/inLineEdit' ?>",
            data: 'column=level_catered&value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            cache: false,
            success: function(data) {

            }
        });
    }
</script>