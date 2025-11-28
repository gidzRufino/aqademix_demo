<!--<div class="col-lg-12 clearboth" style="background: #ccc;">-->
<?php
$pYear = date('Y');
$presentSY = $this->session->school_year;
?>
<div class="col-lg-8 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <?php if ($this->eskwela->getSet()->level_catered == 4): ?>
            <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url('college') ?>'">
            <?php else: ?>   
                <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url() ?>'">
                <?php endif; ?>
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>

            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>

            <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
            <?php if ($school_year != NULL): ?>
                <h5 class="text-right" style="color:black;">S.Y. <?php echo $school_year . ' - ' . ($school_year + 1) ?><?php echo ($semester == 1 ? ' - First Semester' : ($semester == 2 ? ' - Second Semester' : ($semester == 3 ? ' - Summer' : ''))) ?></h5>
            <?php endif;
            ?>
        </div>
        <div class="col-md-12"><br>
            <?php if ($school_year != NULL && $semester != NULL): ?>
                <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('college/enrollment/monitor') ?>'">Enrollment Monitor Menu</button>
                <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('college/') ?>'">Dashboard</button>
            <?php else: ?>
                <button class="btn btn-info btn-md pull-right" onclick="document.location = '<?php echo base_url('college/') ?>'">Dashboard</button>
            <?php endif; ?>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px;">  
            <?php if ($school_year != NULL && $semester != NULL): ?>

                <div class="col-lg-12 col-xs-12" style="margin-bottom:10px;">
                    <span>Student's Legend :</span>
                    <br />
                    &nbsp;<button onclick="getEnrollmentDetails('0', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Students for Payment')" class="btn btn-default btn-xs"><i class="fa fa-money fa-fw"></i> Enrollment Application Approval - <?php echo $forEnApp; ?></button>
                    &nbsp;<button onclick="getEnrollmentDetails('3', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Students for Payment')" class="btn btn-warning btn-xs"><i class="fa fa-money fa-fw"></i> For Payment - <?php echo $forPay; ?></button>
                    &nbsp;<button onclick="getEnrollmentDetails('4', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Students for Payment Evaluation')" class="btn btn-danger btn-xs"><i class="fa fa-cc fa-fw"></i> For Payment Evaluation - <?php echo $forPEval; ?></button>
                    &nbsp;<button onclick="getEnrollmentDetails('5', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Students for Payment Confirmation')" class="btn btn-success btn-xs"><i class="fa fa-cc fa-fw"></i> For Payment Confirmation - <?php echo $forPConf; ?></button>
                    &nbsp;<button onclick="getEnrollmentDetails('6', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Students for Evaluation')" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i> For Evaluation - <?php echo $forEval; ?></span></button>
                    &nbsp;<button onclick="getEnrollmentDetails('1', '<?php echo $semester ?>', '<?php echo $school_year ?>', 'Officially Enrolled Students')" class="btn btn-primary btn-sm"><i class="fa fa-user fa-fw"></i> Officially Enrolled - <?php echo $forOffEn; ?></button>
                </div><br />
                <div class="clearfix row">
                    <div class="col-lg-8 col-xs-12">
                        <div class="col-lg-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Enrollment Details
                                </div>
                                <div class="panel-body" id="studentDetails" style='min-height: 50vh;'>
                                    <?php
                                    if ($st_id != NULL):
                                        echo $student;
                                    endif;
                                    ?>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-xs-12">    
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Total Students Enrolled Online <strong><span class="pull-right"><?php echo $forPay + $forPEval + $forPConf + $forEval + $forOffEn + $forEnApp; ?></span></strong>
                            </div>
                            <div class="panel-body no-padding">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search..." onkeyup="searchEnrolledStudent(this.value)" />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-outline-secondary" onclick="searchEnrolledStudent($(this).parent().prev().val())"><i class="fa fa-search fa-xs"></i></button>
                                    </div>
                                </div>
                                <div>
                                    <div class="list-group" id="enrolledList" style="overflow-y: scroll; max-height: 750px;">
                                        <?php echo $totalEnrStuds; ?>
                                    </div>
                                    <div class="list-group" id="temporaryEnrolledList" style="overflow-y: scroll; max-height: 750px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  <!--end of modal-body --> 
            <?php else:
                ?><br><br><br>
                <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px;">
                    <div class="col-md-5">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Basic Ed Enrollment Monitor
                            </div>
                            <div class="panel-body">
                                <button class="btn btn-success btn-xl" onclick="document.location = '<?php echo base_url('college/enrollment/monitor/0/' . ($presentSY < $pYear ? ($presentSY + 1) : $pYear) . '/3') ?>'">
                                    Enrollment for New School Year
                                </button>
                                <button class="btn btn-primary btn-xl" onclick="document.location = '<?php echo base_url('college/enrollment/monitor/3/' . ($presentSY < $pYear ? $presentSY : ($presentSY - 1)) . '/3') ?>'">
                                    Enrollment for Summer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                College Enrollment Monitor
                            </div>
                            <div class="panel-body">
                                <button class="btn btn-danger btn-xl" onclick="document.location = '<?php echo base_url('college/enrollment/monitor/1/' . ($presentSY < $pYear ? ($presentSY + 1) : $pYear) . '/5') ?>'">
                                    Enrollment for 1st Sem
                                </button>
                                <button class="btn btn-info btn-xl" onclick="document.location = '<?php echo base_url('college/enrollment/monitor/2/' . $presentSY . '/5') ?>'">
                                    Enrollment for 2nd Sem
                                </button>
                                <button class="btn btn-warning btn-xl" onclick="document.location = '<?php echo base_url('college/enrollment/monitor/3/' . ($presentSY < $pYear ? $presentSY : ($presentSY - 1)) . '/5') ?>'">
                                    Enrollment for Summer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>   
</div>

<div id="enrollDetails" class="modal fade col-lg-4 col-xs-12" style="margin:30px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h4 id="entitle" class="no-margin col-lg-6"></h4>
            <input type="search" placeholder="Search Student" id="studentSearch" onkeyup="searchStudent(this.value)" />
            <button class="pull-right btn btn-xs btn-danger" data-dismiss="modal">x</button>
        </div>
        <div style="height:60vh; overflow-y: scroll; cursor: pointer;" class="panel-body" id="enrollBody">

        </div>
    </div>
</div>    

<input type="hidden" value="<?php echo base_url() ?>" id="base" />
<script type="text/javascript">

    function searchEnrolledStudent(value) {
        if (value.length != 0) {
            console.info(value);
            var students = $("#enrolledList a").filter(function () {
                return $(this).attr('stud-name').toLowerCase().indexOf(value.toLowerCase()) > -1;
            }),
                    html = '';
            $.each(students, function (idx, val) {
                html += $(val).prop('outerHTML');
            });
            $("#enrolledList").hide();
            $("#temporaryEnrolledList").html(html);
            $("#temporaryEnrolledList").show();
        } else {
            $("#temporaryEnrolledList").hide();
            $("#enrolledList").show();
        }
    }

    function searchStudent(value) {
        if (value.length != 0) {
            var students = $("#mainBody tr").filter(function () {
                return $(this).attr('student').toLowerCase().indexOf(value.toLowerCase()) > -1;
            }),
                    html = '';
            $.each(students, function (idx, val) {
                html += $(val).prop('outerHTML');
            });
            $("#mainBody").hide();
            $("#searchBody").html(html);
            $("#searchBody").show();
        } else {
            $("#searchBody").hide();
            $("#mainBody").show();
        }
    }

    $(document).ready(function () {
        //$('#enrollDetails').modal('show');
    });

    function getEnrollmentDetails(status, semester, school_year, title)
    {
        var dept = '<?php echo $department ?>';
        var base = $('#base').val();
        var url = base + 'college/enrollment/listOfStudentsEnrolled/' + semester + '/' + school_year + '/' + status + '/' + dept;
//        alert(url);

        $.ajax({
            type: 'GET',
            url: url,
            complete: function (data)
            {
                $('#entitle').html(title);
                $('#enrollBody').html(data.responseText);
                $('#enrollDetails').modal('show');
            }
        });

    }

</script>