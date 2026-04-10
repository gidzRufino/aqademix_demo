<?php
$loadedSubject = Modules::run('registrar/getOvrLoadSub', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
if ($this->session->details->status == 4):
    $msg = "Your application for enrollment undergoes an evaluation from the finance department because of past dues, but this will be quick so visit us often;";
elseif ($this->session->details->status == 3):
    $msg = "You can now proceed to the final steps of the enrollment proceedure please click <a class='btn btn-xs btn-info' onclick='getFinDetails()' href='#'>Next</a> to proceed";
endif;

$admissionRemarks = Modules::run('college/enrollment/getAdmissionRemarks', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
?>
<style>
    /* Enhanced UI Styles */
    .elegant-modal {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        border: none;
        overflow: hidden;
    }

    .elegant-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        border-radius: 0;
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .elegant-header .logo-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .elegant-header .logo-container img {
        width: 60px;
        height: 60px;
        background: white;
        padding: 8px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .elegant-header .logo-container img:hover {
        transform: scale(1.05);
    }

    .elegant-header .school-info h1 {
        font-size: 22px;
        font-weight: 600;
        color: white;
        margin: 0 0 5px 0;
        letter-spacing: 0.5px;
    }

    .elegant-header .school-info h6 {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-weight: 400;
    }

    .elegant-header .welcome-section {
        text-align: right;
    }

    .elegant-header .welcome-section h4 {
        font-size: 18px;
        font-weight: 500;
        color: white;
        margin: 0 0 5px 0;
    }

    .elegant-header .welcome-section h5 {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-weight: 400;
    }

    .elegant-body {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 0;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }

    .elegant-btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .elegant-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .elegant-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .elegant-btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
    }

    .elegant-table-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
    }

    .elegant-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .elegant-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .elegant-table thead th:first-child {
        border-top-left-radius: 8px;
    }

    .elegant-table thead th:last-child {
        border-top-right-radius: 8px;
    }

    .elegant-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e2e8f0;
    }

    .elegant-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }

    .elegant-table tbody tr:last-child {
        border-bottom: none;
    }

    .elegant-table tbody td {
        padding: 15px;
        color: #2d3748;
        font-size: 14px;
    }

    .elegant-table tbody td:first-child {
        font-weight: 500;
        color: #1a202c;
    }

    .elegant-alert {
        border-radius: 12px;
        padding: 20px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .elegant-alert-info {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        color: #0c4a6e;
        border-left: 4px solid #0ea5e9;
    }

    .elegant-alert-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #78350f;
        border-left: 4px solid #f59e0b;
    }

    .elegant-alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .elegant-footer {
        background: white;
        border-top: 1px solid #e2e8f0;
        padding: 25px 30px;
        border-radius: 0;
    }

    .elegant-btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .elegant-btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
    }

    .elegant-btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .elegant-btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
    }

    .elegant-btn-sm {
        padding: 8px 16px;
        font-size: 12px;
        border-radius: 6px;
    }

    .action-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: #f1f5f9;
        border-radius: 6px;
        font-size: 12px;
        color: #475569;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .elegant-header {
            padding: 20px 15px;
        }

        .elegant-header .welcome-section {
            text-align: left;
            margin-top: 15px;
        }

        .elegant-body {
            padding: 20px 15px;
        }

        .elegant-table-container {
            padding: 15px;
        }
    }

    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .search-modal-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 0;
    }

    .schedule-modal-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 0;
    }

    .search-modal-header h4,
    .schedule-modal-header h4 {
        color: white;
        font-weight: 600;
        margin: 0;
    }

    .search-input-elegant {
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    .search-input-elegant:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
</style>

<div id="studentDashboard" class="modal fade col-lg-6 col-xs-12 elegant-modal" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix elegant-header">
        <div class="col-lg-6 col-xs-12 logo-container">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" alt="School Logo" />
            <div class="school-info">
                <h1><?php echo $settings->set_school_name ?></h1>
                <h6><?php echo $settings->set_school_address ?></h6>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12 welcome-section">
            <h4>Welcome <?php echo $this->session->name . '!'; ?></h4>
            <h5><i class="fa fa-graduation-cap"></i> <?php echo $this->session->details->level; ?></h5>
        </div>
    </div>
    <div class="elegant-body" style="overflow-y: auto; max-height: 70vh;">
        <div class="modal-body clearfix">
            <div style="width: 100%" class="col-lg-12 no-padding">
                <div class="form-group pull-left">
                    <h4 class="section-title">Subjects To Take</h4>
                </div>
                <div class="form-group pull-right">
                    <button onclick="$('#searchSubject').modal('show')" title="search more subjects" class="btn elegant-btn elegant-btn-primary elegant-btn-sm pull-right">
                        <i class="fa fa-search-plus"></i> Search Subject
                    </button>
                </div>
            </div>
            <div style="width: 100%;" class="pull-left col-lg-12" id="schedDetails">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-xs-12 elegant-table-container">
                    <table id="tableSched" class="elegant-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th style="width: 20%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="subjectLoadBody">
                            <?php if ($this->session->details->status != 0):
                                if (empty($loadedSubject)): ?>
                                    <tr>
                                        <td colspan="2" class="empty-state">
                                            <i class="fa fa-book"></i>
                                            <p>No subjects loaded yet. Click "Search Subject" to add subjects.</p>
                                        </td>
                                    </tr>
                                    <?php else:
                                    foreach ($loadedSubject as $ls):
                                    ?>
                                        <tr id="tr_<?php echo $ls->subject_id ?>" class="trSched" subject_id="<?php echo $ls->subject_id ?>">
                                            <td><i class="fa fa-book text-primary"></i> <?php echo strtoupper($ls->subject) ?></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                if ($admissionRemarks): ?>
                                    <tr>
                                        <td colspan="2" class="elegant-alert elegant-alert-warning" style="margin: 10px 0;">
                                            <strong><i class="fa fa-exclamation-triangle"></i> Admission Remarks</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="elegant-alert elegant-alert-info">
                                            <i class="fa fa-info-circle"></i> <?php echo $admissionRemarks->remarks ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="empty-state">
                                        <i class="fa fa-book"></i>
                                        <p>No subjects available. Please contact your advisor.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!--end of modal-body -->
        <div class="modal-footer clearfix elegant-footer" style="display: none;" id="confirmGrp">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <button onclick="submitEnrollmentData()" class="btn elegant-btn elegant-btn-success btn-block" style="margin-bottom: 10px;">
                    <i class="fa fa-check-circle"></i> CONFIRM ENROLLMENT
                </button>
                <button class="btn elegant-btn elegant-btn-danger btn-block">
                    <i class="fa fa-times-circle"></i> CANCEL
                </button>
            </div>
        </div>
        <div class="modal-footer clearfix elegant-footer" style="display:<?php echo ($this->session->details->status == 0 ? 'none' : '') ?>;" id="confirmMsgWrapper">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="elegant-alert elegant-alert-info">
                    <p id="confirmMsg" class="text-center" style="margin-bottom: 15px; line-height: 1.6;">
                        <?php echo $msg ?>
                    </p>
                    <div class="text-center">
                        <button onclick="document.location='<?php echo base_url('entrance') ?>'" class="btn elegant-btn elegant-btn-danger elegant-btn-sm">
                            <i class="fa fa-times"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="base" value="<?php echo base_url(); ?>" />
<input type="hidden" id="studentID" value="<?php echo base64_encode($this->session->details->st_id) ?>" />
<input type="hidden" id="year_level" value="<?php echo $this->session->details->grade_level_id ?>" />
<input type="hidden" id="previous_school_year" value="<?php echo $this->session->details->school_year ?>" />
<input type="hidden" id="previous_semester" value="<?php echo Modules::run('main/getSemester') ?>" />
<input type="hidden" id="user_id" value="<?php echo $this->session->details->user_id ?>" />

<div id="scheduleModal" class="modal fade col-lg-4 col-xs-12 elegant-modal" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix schedule-modal-header">
        <h4 class="pull-left"><i class="fa fa-calendar"></i> Please Select Schedule</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn elegant-btn elegant-btn-danger elegant-btn-sm" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
            <i class="fa fa-times"></i>
        </button>
    </div>

    <div class="elegant-body" style="max-height: 60vh; overflow-y: auto;">
        <div id="schedBody" class="modal-body clearfix">
        </div>
    </div>
</div>

<div id="searchSubject" class="modal fade col-lg-4 col-xs-12 elegant-modal" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix search-modal-header">
        <h4 class="pull-left"><i class="fa fa-search"></i> Search Subject</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn elegant-btn elegant-btn-danger elegant-btn-sm" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
            <i class="fa fa-times"></i>
        </button>
        <input class="form-control search-input-elegant" onkeypress="if (event.keyCode == 13) {
                    searchSubjectOffered(this.value)
                }" name="studentNumber" type="text" id="studentNumber" placeholder="Search Subject Code and press enter" />
    </div>

    <div class="elegant-body" style="max-height: 60vh; overflow-y: auto;">
        <div id="searchBody" class="modal-body clearfix">
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#inputSem').select2();
        $('#studentDashboard').modal('show');

        $('.modal').on("hidden.bs.modal", function(e) { //fire on closing modal box
            if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
                $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
            }
        });
        //hasTimeConflict('08:30','10:30','07:30','11:30');    
    });

    $(function() {

        var totalUnits = 0;

        fetchSearchSubject = function(subject_id, subject) {
            var exist = 0;
            $('#tableSched tr.trSched').each(function() {
                //alert($(this).attr('id'))
                if ($(this).attr('subject_id') === subject_id) {
                    exist++;
                    alert('Sorry this subject already exist');
                }
            });


            if (exist == 0) {
                $('#subjectLoadBody').append(
                    '<tr id="tr_' + subject_id + '" class="trSched" subject_id="' + subject_id + '"  >' +
                    '<td><i class="fa fa-book text-primary"></i> ' + subject + '</td>' +
                    '<td class="text-center"> \n\
                            <button onclick="removeSubject(\'' + subject_id + '\')" title="remove from the list" class="btn elegant-btn elegant-btn-danger elegant-btn-sm"><i class="fa fa-trash"></i></button>\n\
                        </td>' +
                    '</tr>'
                );
            }

            $('#searchSubject').modal('hide');
            $('#confirmGrp').show();

        };


        removeSubject = function(sub_id) {
            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);
            $('#tr_' + sub_id).remove();
        };

        submitEnrollmentData = function() {
            var base = $('#base').val();
            var semester = $('#previous_semester').val();
            var year_level = $('#year_level').val();
            var school_year = $('#previous_school_year').val();
            var st_id = $('#studentID').val();
            var user_id = $('#user_id').val();

            var url = base + 'college/enrollment/saveBasicRO/'; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    year_level: year_level,
                    school_year: school_year,
                    semester: semester,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function() {
                    $('#btnConfirm').hide();
                    $('#schedBody').html('System is processing...Thank you for waiting patiently');
                },
                success: function(data) {
                    if (semester == 3) {
                        loadEnrollmentData(data.st_id, data.user_id);
                        console.log(data)
                    }
                }
            });

            return false;

        };

        loadEnrollmentData = function(st_id, user_id) {
            var enrollmentDetails = [];
            $('#tableSched tr.trSched').each(function() {
                var id = {
                    'sub_id': $(this).attr('subject_id'),
                    'level_id': $('#year_level').val(),
                    'st_id': st_id,
                    'is_overload': 3,
                    'sem': 3
                };
                enrollmentDetails.push(id);
            });

            var enrollmentData = JSON.stringify(enrollmentDetails);
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/saveBasicLoad';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    enData: enrollmentData,
                    semester: $('#previous_semester').val(),
                    school_year: school_year,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function() {
                    $('#confirmGrp').hide();
                    $('#confirmMsgWrapper').show();
                    $('#confirmMsg').html('Please Wait while system is submitting your request...');

                },
                success: function(data) {
                    $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    $('.action').remove();

                    //alert(data);
                }
            });

            return false;

        }


        getSchedule = function(sem) {
            if (sem != 0) {
                var st_id = $('#studentID').val();
                var course_id = $('#course_id').val();
                var year_level = $('#year_level').val();
                var school_year = $('#previous_school_year').val();
                var base = $('#base').val();

                var url = base + 'college/enrollment/getSubjectLoad/' + st_id + '/' + course_id + '/' + year_level + '/' + sem + '/' + school_year; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name'),

                    }, // serializes the form's elements.
                    // dataType:'json',
                    beforeSend: function() {
                        $('#schedDetails').html('System is processing...Thank you for waiting patiently')
                    },
                    success: function(data) {
                        $('#schedDetails').html(data);
                        if (totalUnits != 0) {
                            $('#confirmGrp').show();
                        }
                    }
                });

                return false;
            }

        }



        searchSubjectOffered = function(value) {
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base + 'college/enrollment/searchBasicEdSubject/' + value + '/' + school_year; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name'),
                }, // serializes the form's elements.
                // dataType:'json',
                beforeSend: function() {
                    $('#searchBody').html('System is processing...Thank you for waiting patiently')
                },
                success: function(data) {
                    $('#searchBody').html(data);

                }
            });

            return false;

        };



    });

    function hasTimeConflict(timeFrom, timeTo, dbFrom, dbTo) {
        var cf = timestamp(timeFrom);
        var ct = timestamp(timeTo);
        var tf = timestamp(dbFrom);
        var tt = timestamp(dbTo);

        if (cf >= tf && cf < tt) {
            //alert('conflict 1');
            return true;
        } else if (ct < tt && ct > tt) {
            //alert('conflict 2');
            return true;

        } else if (cf == tf) {
            //alert('conflict 3');
            return true;
        } else {
            //alert('time is available');
            return false;
        }

    }

    function getFinDetails() {
        var base = $('#base').val();
        var url = base + 'student/accounts'; // the script where you handle the form input.
        document.location = url;
    }

    function modalControl(open, close) {
        $('#' + open).modal('show');
        $('#' + close).modal('hide');
    }

    function loadSchedule(s_id) {
        var semester = $('#inputSem').val();
        var school_year = $('#previous_school_year').val();
        var base = $('#base').val();
        var url = base + 'college/enrollment/loadSchedule/' + s_id + '/' + semester + '/' + school_year; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),

            }, // serializes the form's elements.
            // dataType:'json',
            beforeSend: function() {
                $('#schedBody').html('System is processing...Thank you for waiting patiently')
            },
            success: function(data) {
                $('#scheduleModal').modal('show');
                $('#schedBody').html(data);
            }
        });

        return false;

    }
</script>