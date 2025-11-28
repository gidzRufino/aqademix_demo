<?php
    $loadedSubject = Modules::run('registrar/getOvrLoadSub', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
    if($this->session->details->status==4):
        $msg = "Your application for enrollment undergoes an evaluation from the finance department because of past dues, but this will be quick so visit us often;";
    elseif($this->session->details->status==3):
        $msg = "You can now proceed to the final steps of the enrollment proceedure please click <a class='btn btn-xs btn-info' onclick='getFinDetails()' href='#'>Next</a> to proceed";
    endif;
    
        $admissionRemarks= Modules::run('college/enrollment/getAdmissionRemarks', $this->session->details->st_id, $this->session->details->semester, $this->session->details->school_year);
?>
<div id="studentDashboard" class="modal fade col-lg-6 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <div class="col-lg-1 col-xs-2 no-padding">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
        </div>
        <div class="col-lg-5 col-xs-10">
            <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
            <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
        </div>

        <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
        <h5 class="text-right" style="color:black;"><?php echo $this->session->details->level; ?></h5>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">  
        <div class="modal-body clearfix">
            <div style="width: 100%" class="col-lg-12 no-padding">
                <div class="form-group pull-left">
                    <h4 class="text-left no-margin col-lg-12 col-xs-12 no-padding">Subjects To Take</h4>
                </div>
                <div class="form-group pull-right">
                    <button onclick="$('#searchSubject').modal('show')" title="search more subjects" style="margin-left:5px;" class="btn btn-sm btn-info pull-right">Search Subject <i class="fa fa-search-plus"></i></button>
                    
                </div>
            </div>
            <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-xs-12 no-padding">
                    <table id="tableSched" class="table table-stripped table-responsive">
                        <tr>
                            <th>Subject</th>
                            <th style="width: 20%" class="text-center">Action</th>
                        </tr>
                        <tbody id="subjectLoadBody">
                            <?php if($this->session->details->status!=0): 
                                    foreach($loadedSubject as $ls):
                                    ?>
                                    <tr id="tr_<?php echo $ls->subject_id ?>" class="trSched" subject_id="' + subject_id + '"  >
                                        <td><?php echo strtoupper($ls->subject) ?></td>
                                        <td></td>
                                    </tr>
                                    <?php if($admissionRemarks): ?>
                                    <tr>
                                        <td colspan="2" class="danger text-center">Admission Remarks</td>

                                    </tr>
                                    <tr>
                                        <td colspan="2" class="info text-center"><i class="fa fa-info fa-fw" ></i>&nbsp;&nbsp;<?php echo $admissionRemarks->remarks ?></td>

                                    </tr>
                                    <?php endif; ?>  
                            <?php 
                                    endforeach;
                                endif; ?>
                        </tbody>
                       
                    </table>
                </div>
            </div>
        </div> <!--end of modal-body --> 
        <div class="modal-footer clearfix" style="display: none;" id="confirmGrp">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <button onclick="submitEnrollmentData()" style="margin: 0 auto" class="btn btn-small btn-success btn-block">CONFIRM</button><br />
                <button style="margin: 0 auto" class="btn btn-small btn-danger btn-block">CANCEL</button>
            </div>
        </div>
        <div class="modal-footer clearfix" style="display:<?php echo ($this->session->details->status==0?'none':'') ?>;" id="confirmMsgWrapper">
            <div class="col-lg-3 col-md-1 col-xs-1"></div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="alert alert-info">
                    <p id="confirmMsg" class="text-center">
                        <?php echo $msg ?>
                    </p>
                    <button onclick="document.location='<?php  echo base_url('entrance') ?>'" class="btn btn-danger btn-xs">Close</button>
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

<div id="scheduleModal" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-info" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Please Select Schedule</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; overflow: scroll">  
        <div id="schedBody" class="modal-body clearfix">
        </div>    
    </div>    
</div>

<div id="searchSubject" class="modal fade col-lg-4 col-xs-12" style="margin:15px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-warning" style="border-radius:15px 15px 0 0; ">
        <h4 class="pull-left">Search Subject</h4>
        <button type="button" data-dismiss="modal" class="pull-right btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
        <input class="form-control" onkeypress="if (event.keyCode == 13) {
                    searchSubjectOffered(this.value)
                }"  name="studentNumber" type="text" id="studentNumber" placeholder="Search Subject Code and press enter" />
    </div>

    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;  box-shadow:3px 3px 5px 6px #ccc; ">  
        <div id="searchBody" class="modal-body clearfix">
        </div>    
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function () {
        
        $('#inputSem').select2();
        $('#studentDashboard').modal('show');

        $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
            if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
                $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
            }
        });
        //hasTimeConflict('08:30','10:30','07:30','11:30');    
    });

    $(function () {

        var totalUnits = 0;

        fetchSearchSubject = function (subject_id, subject)
        {
            var exist = 0;
            $('#tableSched tr.trSched').each(function () {
                //alert($(this).attr('id'))
                if ($(this).attr('subject_id') === subject_id)
                {
                    exist++;
                    alert('Sorry this subject already exist');
                }
            });


            if (exist == 0) {
                $('#subjectLoadBody').append(
                        '<tr id="tr_' + subject_id + '" class="trSched" subject_id="' + subject_id + '"  >' +
                        '<td>' + subject + '</td>' +
                        '<td class="text-center"> \n\
                            <button onclick="removeSubject(\'' + subject_id + '\')" title="remove from the list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>\n\
                        </td>' +
                        +'</tr>'
                        );
            }

            $('#searchSubject').modal('hide');
            $('#confirmGrp').show();

        };


        removeSubject = function (sub_id)
        {
            totalUnits -= $('#units_' + sub_id).html();
            $('#totalUnits').html(totalUnits);
            $('#tr_' + sub_id).remove();
        };

        submitEnrollmentData = function ()
        {
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
                    semester : semester,
                    st_id: st_id,
                    user_id: user_id,
                    csrf_test_name: $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function () {
                    $('#btnConfirm').hide();
                    $('#schedBody').html('System is processing...Thank you for waiting patiently');
                },
                success: function (data)
                {
                    if(semester==3)
                    {
                        loadEnrollmentData(data.st_id, data.user_id);
                        console.log(data)
                    }
                }
            });

            return false;

        };

        loadEnrollmentData = function (st_id, user_id)
        {
            var enrollmentDetails = [];
            $('#tableSched tr.trSched').each(function () {
                var id = {
                    'sub_id'            : $(this).attr('subject_id'),
                    'level_id'          : $('#year_level').val(),
                    'st_id'             : st_id,
                    'is_overload'       : 3,
                    'sem'               : 3
                };
                enrollmentDetails.push(id);
            });
            
            var enrollmentData = JSON.stringify(enrollmentDetails);
            var school_year = $('#previous_school_year').val();
            var base = $('#base').val();
            var url = base+'college/enrollment/saveBasicLoad';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    enData          : enrollmentData,
                    semester        : $('#previous_semester').val(),
                    school_year     : school_year,
                    st_id           : st_id,
                    user_id         : user_id,
                    csrf_test_name  : $.cookie('csrf_cookie_name'),

                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function () {
                    $('#confirmGrp').hide();
                    $('#confirmMsgWrapper').show();
                    $('#confirmMsg').html('Please Wait while system is submitting your request...');
                    
                },
                success: function (data)
                {
                    $('#confirmMsg').html('You have Successfully Submitted your application for enrollment, We will notify you in the next 24 to 48 hours once your subjects are approved. Thank you for using this online system.');
                    $('.action').remove();
                    
                    //alert(data);
                }
            });

            return false;
           
        }


        getSchedule = function (sem)
        {
            if (sem != 0) {
                var st_id = $('#studentID').val();
                var course_id = $('#course_id').val();
                var year_level = $('#year_level').val();
                var school_year = $('#previous_school_year').val();
                var base = $('#base').val();
                
                var url = base+'college/enrollment/getSubjectLoad/' + st_id + '/' + course_id + '/' + year_level + '/' + sem + '/' + school_year; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name'),

                    }, // serializes the form's elements.
                    // dataType:'json',
                    beforeSend: function () {
                        $('#schedDetails').html('System is processing...Thank you for waiting patiently')
                    },
                    success: function (data)
                    {
                        $('#schedDetails').html(data);
                        if (totalUnits != 0) {
                            $('#confirmGrp').show();
                        }
                    }
                });

                return false;
            }

        }



        searchSubjectOffered = function (value)
        {
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
                beforeSend: function () {
                    $('#searchBody').html('System is processing...Thank you for waiting patiently')
                },
                success: function (data)
                {
                    $('#searchBody').html(data);

                }
            });

            return false;

        };



    });

    function hasTimeConflict(timeFrom, timeTo, dbFrom, dbTo)
    {
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

    function getFinDetails()
    {
        var base = $('#base').val();
        var url = base+ 'student/accounts'; // the script where you handle the form input.
        document.location = url;
    }

    function modalControl(open, close)
    {
        $('#' + open).modal('show');
        $('#' + close).modal('hide');
    }

    function loadSchedule(s_id)
    {
        var semester = $('#inputSem').val();
        var school_year = $('#previous_school_year').val();
        var base = $('#base').val();
        var url = base+ 'college/enrollment/loadSchedule/' + s_id + '/' + semester + '/'+school_year; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name'),

            }, // serializes the form's elements.
            // dataType:'json',
            beforeSend: function () {
                $('#schedBody').html('System is processing...Thank you for waiting patiently')
            },
            success: function (data)
            {
                $('#scheduleModal').modal('show');
                $('#schedBody').html(data);
            }
        });

        return false;

    }
</script>
