<?php
$today = date('Y-m-d');
switch ($sem):
    case 1:
        $is_posted = $deadline->is_first_posted;
        $dd = date('Y-m-d', strtotime($deadline->finFirst));
        $date = date('Y-m-d', strtotime($deadline->finFirst . ' + 1 day'));
        $semester = 'First';
        break;
    case 2:
        $is_posted = $deadline->is_second_posted;
        $dd = date('Y-m-d', strtotime($deadline->finSecond));
        $date = date('Y-m-d', strtotime($deadline->finSecond . ' + 1 day'));
        $semester = 'Second';
        break;
    case 3:
        $is_posted = $deadline->is_summer_posted;
        $dd = date('Y-m-d', strtotime($deadline->finSummer));
        $date = date('Y-m-d', strtotime($deadline->finSummer . ' + 1 day'));
        $semester = 'Summer';
        break;
    default :
        $is_posted = $deadline->is_first_posted;
        $dd = date('Y-m-d', strtotime($deadline->finSummer));
        $date = date('Y-m-d', strtotime($deadline->finFirst . ' + 1 day'));
        $semester = 'First';
        break;
endswitch;
?>
<?php if ($is_posted): ?>
    <div class="alert alert-danger pull-right">Attention: Deadline for submission of Grades will be <?php echo ($today == $dd ? 'TODAY' : 'on ' . date('F d, Y', strtotime($dd))) ?>!!!<br>    
        <h5>Remaining Time : <p id="demo"></p></h5>
    </div><br>
<?php endif;
?>
<div class="col-lg-12">
    <div class="col-lg-12">
        <h4 class="text-center">COLLEGE GRADE SHEET
        </h4>
        <button href="#printGrade" onclick="$('#printGrade').modal('show')"  class="btn btn-default btn-xs pull-right" title="Print Grade Sheet" ><i class="fa fa-print fa-2x"></i></button>
    </div>
    <div class="col-lg-10">
        <div class="col-lg-6">
            <dl class="dl-horizontal">
                <dt>
                    Instructor : 
                </dt>
                <dd>
                    <?php
                    $faculty = Modules::run('hr/getEmployeeName', $faculty_id);
                    echo $faculty->firstname . ' ' . $faculty->lastname;
                    ?>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Schedule : 
                </dt>
                <dd>
                    <?php
                    $scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id, $sem, $school_year);
                    $sched = json_decode($scheds);
                    echo ($sched->count > 0 ? ' [ ' . $sched->day . ' ] ' . $sched->time : 'TBA');
                    ?>
                </dd>
            </dl>
        </div>
        <div class="col-lg-6 pull-right">
            <dl class="dl-horizontal">
                <dt>
                    School Year : 
                </dt>
                <dd>
                    <?php
                    $next = $students->row()->school_year + 1;
                    echo $students->row()->school_year . ' - ' . $next;
                    ?>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Semester : 
                </dt>
                <dd>
                    <?php
                    echo $semester;
                    ?>
                </dd>
            </dl>

        </div>

    </div>
    <div class='col-lg-10'>
        <div class="col-lg-10">
            <dl class="dl-horizontal">
                <dt>
                    Subject : 
                </dt>
                <dd>
                    <?php
                    $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
                    echo $subject->sub_code . ' - ' . $subject->s_desc_title;
                    ?>
                </dd>
            </dl>
        </div>
    </div>

</div>
<div class="col-lg-12">
    <div class="alert alert-info">
        <h4><i class="fa fa-info-circle text-center"> Hello Again! To start with Double Click the first row in the Mid Term Column and Enter the desired grade for the student and then press enter to save.
                <br /> Use this Numerical Legend : <br /> Failed - 5.0 <br /> INC - 6.0 <br /> Dropped - 8.0
            </i></h4>
    </div>
    <hr />
</div>

<div class="col-lg-12">
    <table class='table table-hover table-bordered'>
        <tr>
            <th style='vertical-align: middle;' rowspan="2">#</th>
            <th style='vertical-align: middle;' rowspan="2">LAST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">FIRST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">COURSE</th>
            <?php foreach ($term->result() as $t): ?>
                <th class="text-center"><?php echo $t->gst_term; ?></th>
            <?php endforeach; ?>
            <th colspan="2" class="text-center"></th>    
        </tr>
        <tr>
            <?php foreach ($term->result() as $t): ?>

                <th class="text-center">Grade</th>   
            <?php endforeach; ?>
<!--<th class="text-center">Final Grade</th>-->
        </tr>
        <?php
        $i = 0;
        foreach ($students->result() as $s):
            if ($s->st_id != ""):
                $i++;
                $adm_id = Modules::run('college/getAdmissionID', $s->user_id, $sem);
                ?>
                <tr>
                    <th><?php echo $i ?></th>
                    <th><?php echo strtoupper($s->lastname); ?></th>
                    <th><?php echo ucwords(strtolower($s->firstname)); ?></th>
                    <th><?php echo $s->short_code . ' - ' . $s->year_level; ?></th>

                    <?php
                    foreach ($term->result() as $t):

                        $grade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, $t->gst_id);
                        $is_lock = Modules::run('college/gradingsystem/isGSlock', $adm_id->admission_id, $subject_id, $school_year);
                        ?>
                        <td class="text-center text-strong"
                            id="<?php echo $i . '_' . $t->gst_id ?>"
                            gst="<?php echo $t->gst_id ?>"
                            st_id="<?php echo $s->st_id ?>"
                            lock_id="<?php echo $is_lock->is_lock ?>"
                            ondblclick="editTable(this.id)"
                            row="<?php echo $i ?>"
                            term="<?php echo $t->gst_id ?>"
                            course_id ="<?php echo $s->c_id ?>"
                            year_level ="<?php echo $s->year_level ?>"
                            ><?php echo $grade->gsa_grade ?></td>


                        <?php
                        $fg = $grade->gsa_grade;
                    endforeach;


                    $finalGrade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, 4);
                    ?>
                                                                                        <!--<td class="text-center text-strong" id="<?php echo $s->st_id . '_F' ?>"><?php echo $fg; ?></td>-->
                    <td style="text-align: center"  onmouseover="$('#grade_id').val('<?php echo $fg ?>'), $('#st_id').val('<?php echo $s->st_id ?>'), $('#term_id').val('<?php echo $i ?>'), $('#year_level').val('<?php echo $s->year_level ?>'), $('#course_id').val('<?php echo $s->c_id ?>')">
                        <?php echo ($finalGrade->gsa_is_final == 0 ? $finalGrade->is_approved == 1 ? '<button id="btn_' . $i . '" class="btn btn-info btn-xs" onclick="postGrade(), $(this).removeClass(\'btn-info\'), $(this).addClass(\'btn-success\')" >POST</button>' : '<button class="btn btn-info btn-xs disabled">POST</button>' : '<button class="btn btn-success btn-xs">POSTED</button>'); ?>
                    </td>
                </tr>
                <?php
            endif;
            unset($fg);
        endforeach;
        ?>
    </table>
</div>


<div id="printGrade"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Please Select Term
            </h4>
        </div>
        <div class="panel-body" id="editTransBody">
            <button onclick="printGrade(2)" class="btn btn-primary btn-xs pull-left col-lg-6 col-sm-12">Mid Term</button>
            <button onclick="printGrade(4)" class="btn btn-primary btn-xs pull-left col-lg-6 col-sm-12">Final Term</button>
        </div>
    </div>
</div>

<script type="text/javascript">

    function printGrade(term)
    {
        var url = '<?php echo base_url('college/gradingsystem/printGradeSheet/') . base64_encode($faculty_id) . '/' . $section_id . '/' . $subject_id . '/' . $sem . '/' ?>' + term + '/' + '<?php echo $school_year ?>';

        window.open(url, '_blank');
    }

//-------------------------- Deadline CountDown ------------------------------------------ //
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $date ?> 00:00:00").getTime();

// Update the count down every 1 second
    var x = setInterval(function () {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = days + " Days " + hours + " Hours "
                + minutes + " minutes " + seconds + " seconds ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);

//---------------------------- End of CountDown Script --------------------------------- //
</script>


