<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:0"><a href="<?php echo base_url(); ?>"><i class="fa fa-home fa-fw"></i></a> | School Settings
            <a href="<?php echo base_url() ?>main/backup" class="btn btn-small btn-warning pull-right">Backup School Data</a>

        </h3>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div style="position:absolute; top:30%; left:50%;" class="alert alert-error hide" id="notify" data-dismiss="alert-message">
            <h4></h4>
        </div>
        <div class="tabbable tabs-right">
            <ul class="nav nav-tabs" id="settings_tab" role="tablist">
                <li class="active"><a href="#generalSettings">General</a></li>
                <li><a href="#subjectSettings">Subjects</a></li>
                <li><a href="#GSSettings">Grading System</a></li>
                <li><a href="#timeSettings">Time Settings</a></li>
            </ul>
            <div class="tab-content col-lg-12">
                <div class="tab-pane active" style="padding-top: 15px;" id="generalSettings">
                    <?php $this->load->view('schoolSettings') ?>
                </div>
                <div class="tab-pane" style="padding-top: 15px;" id="GSSettings">
                    <?php echo Modules::run('gradingsystem/gs_settings') ?>
                </div>
                <div class="tab-pane" style="padding-top: 15px;" id="subjectSettings">
                    <?php echo Modules::run('subjectmanagement') ?>
                </div>
                <div class="tab-pane" style="padding-top: 15px;" id="timeSettings">
                    <?php $this->load->view('timeSettings') ?>
                </div>
            </div>
        </div>
    </div>
</div>





</div>
<script type="text/javascript">
    $(function() {
        $(".editableTable td h5 span").dblclick(function() {
            var OriginalContent = $(this).text();
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

                            //                  $('#success').html(data.msg);
                            //                  $('#alert-info').fadeOut(5000);
                            //                  $('#'+ID+'_result').html(data.equivalent)
                        }
                    });

                }
            });

            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });
        $('#settings_tab a').click(function(e) {
            e.preventDefault()
            $(this).tab('show')
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