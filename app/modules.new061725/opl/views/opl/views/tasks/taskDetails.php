<?php
if ($task->task_author_id == $this->session->username):
    $submittedTask = Modules::run('opl/opl_variables/getSubmittedTask', $task->task_code, $this->session->school_year);
    if (count($submittedTask->result()) > 0):
        $col = 'col-lg-6';
    else:
        $col = 'col-lg-12';
    endif;
else:
    $col = 'col-lg-12';
endif;
if ($this->session->isStudent): 
     $iSubmitted = Modules::run('opl/opl_variables/getSubmittedTask', $task->task_code, $this->session->school_year, $this->session->details->st_id);
    if ($iSubmitted->row()):
        $col = 'col-lg-6';
    else:
        $col = 'col-lg-12';
    endif;
endif;
    $avatar = site_url("images/forms/".$settings->set_logo);
    if($task->avatar != NULL || $task->avatar != ""):
        $avatar = site_url('uploads/' . $task->avatar);
    endif;
?>

<section id="taskDetails" class="<?php echo $col; ?> float-left">
    <div class="card card-widget " id="card_<?php echo $task->task_auto_id ?>">
        <div class="card-header col-12">
            <div class="user-block col-8">
                <img class="img-circle" width="50" src="<?php echo $avatar; ?>" alt="User Image">
                <span class="username"><?php echo $task->task_title . ' - ' . $task->tt_type ?></span>
                <span class="description"><a href="#"><?php echo $task->firstname . ' ' . $task->lastname; ?></a><br /><small><?php echo date('F d, Y g:i a', strtotime($task->task_start_time)) ?></small></span>
            </div>
            <?php if ($task->task_author_id == $this->session->username):
                ?>
                <div class="box-tools float-right col-4">
                    <div class="float-right">
                        
                        <button type="button" class="btn btn-box-tool btn-xs text-primary" task-code="<?php echo $task->task_code; ?>" onclick="window.open('<?php echo base_url('opl/printTask/'.$task->task_code) ?>')">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    <?php if(count($submittedTask->result())==0): ?>
                        <button type="button" class="btn btn-box-tool btn-xs text-success" task-code='<?php echo $task->task_code; ?>' task-title="<?php echo htmlspecialchars($task->task_title); ?>" task-type='<?php echo $task->task_type; ?>' task-details="<?php echo htmlspecialchars($task->task_details); ?>" task-sgls='<?php echo $task->task_subject_id.'-'.$task->task_grade_id.'-'.$task->task_section_id ?>' task-start-date='<?php echo date("Y-m-d", strtotime($task->task_start_time)); ?>' task-start-time="<?php echo date("H:m:s", strtotime($task->task_start_time)); ?>" task-end-date="<?php echo date("Y-m-d", strtotime($task->task_end_time)); ?>" task-end-time="<?php echo date("H:m:s", strtotime($task->task_end_time)); ?>" onclick='showEditModal(this)'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool btn-xs text-danger" task-code='<?php echo $task->task_code; ?>' task-title="<?php echo htmlspecialchars($task->task_title); ?>" task-grade='<?php echo $task->task_grade_id; ?>' task-section='<?php echo $task->task_section_id; ?>' task-subject="<?php echo $task->task_subject_id; ?>" onclick="showDeleteModal(this, 1)">
                            <i class="fas fa-trash"></i>
                        </button>
                    <?php endif; ?>
                    </div>
                        <button type="button" class="btn btn-box-tool btn-xs text-black" task-code='<?php echo $task->task_code; ?>' task-title="<?php echo htmlspecialchars($task->task_title); ?>" task-grade='<?php echo $task->task_grade_id; ?>' task-section='<?php echo $task->task_section_id; ?>' task-subject="<?php echo $task->task_subject_id; ?>" onclick="showDeleteModal(this, 1)">
                            <i class="fas fa-refresh"></i>
                        </button>
                    <br />
                    <span class="float-right text-muted danger" style="font-size: 12px;">
                        Submitted by: <?php echo count($submittedTask->result()) ?> student(s)
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->isStudent):?>
                    <div class="box-tools float-right">
                        <div class="float-right">
                            <button type="button" class="btn btn-box-tool btn-xs text-danger" task-code="<?php echo $task->task_code; ?>" onclick="window.open('<?php echo base_url('opl/printTask/'.$task->task_code.'/'. base64_encode($this->session->details->st_id)) ?>')">
                                <i class="fas fa-file-pdf fa-2x"></i>
                            </button>    
                        </div>
                    </div>
            <?php
                    if(!$iSubmitted->row()):
                        $now = strtotime(date("Y-m-d H:i:s"));
                        $start = strtotime($task->task_start_time);
                        $end = strtotime($task->task_end_time);
                        if($now <= $end && $now >= $start):
                            if(!$task->task_is_online):
                                ?>
                                    <div class="box-tools mt-1 float-right">
                                        <button id="btnAnswer" onclick="$(this).hide(), $('#answerWrapper').show(), $('#taskDetails').removeClass('col-lg-12'), $('#taskDetails').addClass('col-lg-6')" type="button" class="btn btn-primary btn-xs">
                                            Answer this Task
                                        </button>

                                    </div>
                                <?php
                            endif;
                        else:
                            if(!($now >= $start)):
                            ?>
                                <div class="box-tools mt-1 float-right">
                                    <button id="btnAnswer" type="button" class="btn btn-light btn-xs" disabled>
                                        Not Started
                                    </button>

                                </div>
                            <?php
                            elseif(!($now <= $end)):
                                ?>
                                <div class="box-tools mt-1 float-right">
                                    <button id="btnAnswer" type="button" class="btn btn-light btn-xs" disabled>
                                        Time Ended
                                    </button>

                                </div>
                                <?php
                            endif;
                        endif;

                    endif;
                endif; ?>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php 
            if($task->task_attachments!=""):
                $directory = 'uploads/'.$school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$task->task_author_id.DIRECTORY_SEPARATOR.$task->task_subject_id.DIRECTORY_SEPARATOR.'task';

                $scanFiles = scandir($directory);
                $files = array_diff($scanFiles, array('..', '.','.DS_Store'));
                foreach ($files as $file):
                    if($file==$task->task_attachments):
                ?>
            <small><a class="float-right" href="<?php echo base_url('opl/downloads/'. base64_encode($directory.'/'.$file)) ?>"><i class="fas fa-paperclip fa-fw "></i><?php echo $task->task_attachments; ?></a></small>
                    <br />
                <?php
                    endif;
                endforeach;
            endif;
            
            echo $task->task_details;//.'<br />'.$task->task_submission_type;
            
            if($task->task_is_online):
                $quizDetails = Modules::run('opl/qm/getQuizDetails', $task->task_online_link,$this->session->school_year);
                ?>
                    <div id="qWrapper">
                        <ol id="quizItems">
                            <?php $quizItems = explode(',', $quizDetails->qi_qq_ids); 
                                for($q=0; $q <= count($quizItems)-1; $q++):
                                    $qItems = Modules::run('opl/qm/getQuestionItems', $quizItems[$q]);
                                    echo $qItems->question;

                                endfor;
                            ?>
                        </ol>
                    </div>
                    <?php 
                    if($this->session->isStudent): 
                        if(!$iSubmitted->row()): ?>
                            <button onclick="answer(), $(this).prop('disabled', true)" class="btn btn-xs btn-primary float-right">Submit Quiz</button>
                    <?php endif;
                    endif;
                    ?>
                    <input type="hidden" id="q_code" value="<?php echo $task->task_online_link ?>" />
                <?php
            endif;
                    ?>
            <!--<button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Got It!</button>-->
        </div>
<!--        <div class="card-footer card-comments">
            
        </div>
        <div class="card-footer">
            <form action="#" method="post">
                <img class="img-fluid img-circle img-sm" width="50" src="<?php echo base_url() . 'uploads/' . $task->avatar; ?>" alt="">
                 .img-push is used to add margin to elements next to floating images 
                <div class="img-push">
                    <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
            </form>
        </div>-->
    </div>
</section>
<?php if($this->session->isStudent): 
        if($iSubmitted->row()):
    ?>
        <div class="card <?php echo $col; ?> card-widget card-blue card-outline" >
            <div class="card-header">
                <h6 class="text-center">Your Answer</h6>
                <small class="text-muted text-xs">Note: Please be reminded to make sure to check your spelling.</small>
            </div>
            <div class="card-body">
                <?php 
                    if($iSubmitted->row()->ts_submission_type==2):
                ?>
                    <span>Submitted File : </span><a href="<?php echo $iSubmitted->row()->ts_details ?>" target="_blank" ><?php echo $iSubmitted->row()->ts_file_name ?></a>
                    <br />
                <?php
                    elseif($iSubmitted->row()->ts_submission_type==3):
                        $ansDetails = explode(',', $iSubmitted->row()->ts_details);
                        echo '<ol>';
                        foreach ($ansDetails as $ans):
                            $ansItems = explode('_', $ans);
                        
                            if(Modules::run('opl/qm/checkAnswer', $ansItems[1], $ansItems[0], $this->session->school_year)):
                                echo '<li> '.$ansItems[1].' <i class="fas fa-check text-success"></i></li>';
                            else:
                                echo '<li> '.$ansItems[1].' <i class="fas fa-times text-danger"></i></li>';
                            endif;
                        endforeach;
                        echo '</ol>';
                    else:
                        echo $iSubmitted->row()->ts_details;
                    endif;
                    ?>
                    <small class="description" style="color: #78838e; font-size: 10px;">Date Submitted : <?php echo date('F d, Y h:i a', strtotime($iSubmitted->row()->ts_date_submitted)) ?></small>
            </div>
            <div class="card-footer card-comments" id="<?php echo $this->session->details->st_id?>_comments">
                <?php 
                    echo Modules::run('opl/opl_variables/getComments', $iSubmitted->row()->ts_code, 4, $this->session->school_year); 
                    ?>
            </div>
            <div class="card-footer">
                    <input type="hidden" id="com_to" value="<?php echo $iSubmitted->row()->ts_code ?>" />
                    <img class="img-fluid img-circle img-sm" width="50" src="<?php echo base_url() . 'uploads/' . $this->session->details->avatar; ?>" alt="">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <div class="input-group">
                            <!--<input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">-->
                            <textarea id="<?php echo $this->session->details->st_id ?>_textarea" style="height: 2em; resize: none;" class="form-control custom-control form-control-sm clearfix" placeholder="Comment..."></textarea>
                            <button onclick="sendComment('4','<?php echo ($this->session->isStudent ? $this->session->details->st_id : $this->session->employee_id) ?>','<?php echo $iSubmitted->row()->ts_code ?>', '<?php echo $this->session->details->st_id ?>','1')" class="input-group-addon btn btn-xs btn-primary float-right">send <i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
        </div>

    <?php
        endif;
    endif; 
    
 if ($task->task_author_id == $this->session->username): 
     ?>
    <section class="col-lg-6 float-left card no-padding">
        <div class="card no-margin">
            <div class="card-header">
                <div class="user-block">
                    <span>Student Response</span>
                </div>
            </div>
            <div class="card-body no-padding">
                <div class=" col-lg-12 no-padding" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <?php
                    foreach ($submittedTask->result() as $sT):
                        $student = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $sT->ts_submitted_by, $this->session->school_year);
                    
                        $rawScore = Modules::run('opl/qm/getRawScore',$task->task_code, $student->st_id, $this->session->school_year );
                        $score = ($rawScore?$rawScore->raw_score:0);
                        ?>
                        <div onclick="$('#scoreWrapper_<?php echo $student->user_id ?>').show()" class="panel card card-primary card-outline no-margin pointer accordion" >
                            <div class="card-header with-border">
                                <h6 class="box-title col-lg-8 float-left" data-toggle="collapse" data-target="#collapse<?php echo $student->user_id ?>" aria-expanded="false" onclick="regStream('<?php echo $student->st_id ?>')">
                                    <?php echo ucwords(strtolower($student->lastname . ', ' . $student->firstname)) ?><br />
                                    <small class="description" style="color: #78838e; font-size: 10px;">Date Submitted : <?php echo date('F d, Y h:i a', strtotime($sT->ts_date_submitted)) ?></small>
                                </h6>
                                <div class="form-group-sm col-lg-3 float-right clearfix">
                                    <?php switch ($sT->marking_type): 
                                          case 0:
                                        ?>
                                        <i class="fa fa-redo fa-xs float-right mt-3 ml-2 text-danger" title="Let student retake the exam" onmouseover="$(this).addClass('fa-spin')" onmouseout="$(this).removeClass('fa-spin')" task-code="<?php echo $task->task_code; ?>" st-id="<?php echo $student->st_id; ?>" student-name="<?php echo $student->firstname." ".$student->lastname; ?>" onclick="readyReset(this)" ></i>
                                        <div class="input-group input-group-md" id="scoreWrapper_<?php echo $student->st_id ?>" style="display: none">
                                            <input type="text" class="form-control" id="score_<?php echo $student->st_id ?>" value="<?php echo $score ?>" style="height: 25px;" placeholder="score" aria-label="score" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-success btn-xs" ans_id="<?php echo $sT->ts_code ?>"  onclick="$('#scoreWrapper_<?php echo $student->st_id ?>').hide(), $('#recordToggle_<?php echo $student->st_id ?>').show(), saveRawScore($(this),'<?php echo $task->task_code ?>','<?php echo $student->st_id ?>')  " type="button" id=""><i class="fas fa-save"></i></button>
                                            </div>
                                            <span> / <?php echo $sT->task_total_score; ?></span>
                                        </div>
                                        <button type="button" onclick="$('#scoreWrapper_<?php echo $student->st_id ?>').show(), $(this).hide()" id="recordToggle_<?php echo $student->st_id ?>" class="btn btn-xs btn-primary mt-2 float-right">Score</button>
                                   <?php 
                                         break;
                                          case 2:
                                               $rubricDetails['score'] = $score;
                                               $rubricDetails['task'] = $task;
                                               $rubricDetails['school_year'] = $this->session->school_year;
                                               $rubricDetails['totalScore'] = $sT->task_total_score;
                                               $rubricDetails['rubricId'] = $sT->marking_link;
                                               $rubricDetails['student'] = $student;
                                               $rubricDetails['isQuestion'] = 0;
                                               $rubricDetails['ans_id'] = $sT->ts_code;
                                               $this->load->view('../rubric/marking', $rubricDetails);
                                          break;    
                                   
                                   endswitch; ?> 
                                    
                                </div>
                            </div>
                            <div id="collapse<?php echo $student->user_id ?>" class="panel-collapse collapse in" style="">
                                <div class="card-body">
                                    <?php 
                                        if($sT->ts_submission_type==2):
                                        ?>
                                    <span>Submitted File : </span><a href="<?php echo base_url('opl/downloads/'. base64_encode($sT->ts_details)) ?>" target="_blank" ><?php echo $sT->ts_file_name ?></a>
                                        <?php
                                            elseif($sT->ts_submission_type==3):
                                                $ansDetails = explode(',', $sT->ts_details);
                                                echo '<ol>';
                                                foreach ($ansDetails as $ans):
                                                    $ansItems = explode('_', $ans);

                                                    if(Modules::run('opl/qm/checkAnswer', $ansItems[1], $ansItems[0], $this->session->school_year)):
                                                        echo '<li> '.$ansItems[1].' <i class="fas fa-check text-success"></i></li>';
                                                    else:
                                                        echo '<li> '.$ansItems[1].' <i class="fas fa-times text-danger"></i></li>';
                                                    endif;
                                                endforeach;
                                                echo '</ol>';
                                            else:
                                                echo $sT->ts_details;
                                            endif;
                                            ?>
                                </div>
                                <div class="card-footer card-comments" id="<?php echo $student->st_id ?>_comments">
                                
                                    <?php 
                                        echo Modules::run('opl/opl_variables/getComments', $sT->ts_code, 4, $this->session->school_year); 
                                        ?>
                                    
                                </div>
                                <div class="card-footer">
                                <input type="hidden" id="com_to" value="<?php echo $sT->ts_code ?>" />
                                        <img class="img-fluid img-circle img-sm" width="50" src="<?php echo base_url() . 'uploads/' . $task->avatar; ?>" alt="">
                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                        <div class="img-push">
                                            <div class="input-group">
                                            <!--<input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">-->
                                                <textarea id="<?php echo $student->st_id ?>_textarea" style="height: 2em; resize: none;" class="form-control custom-control form-control-sm clearfix" placeholder="Comment..."></textarea>
                                                <button onclick="sendComment('4','<?php echo ($this->session->isStudent?$this->session->details->st_id:$this->session->employee_id) ?>','<?php echo $sT->ts_code ?>', '<?php echo $student->st_id ?>','0')" class="btn btn-xs btn-primary float-right col-xs-12">send <i class="fas fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                </div>

                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>
<?php endif; ?>
<?php 
if (!$this->session->isStudent && !$this->session->isOplAdmin && !$this->session->isParent): 
    echo $this->load->view('tasks/editTask');
endif;
?>
<section class="col-lg-6 float-right" id="answerWrapper" style="display: none;">
<?php $this->load->view('../students/createResponse', $task); ?>

</section>

<div class="modal modal-warning" id='resetResponse' tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h1><i class="fa fa-question-circle text-warning"></i></h1>
				<h5>Are you sure you want to reset <span id="student-name"></span>'s answer?</h4>
				<small>Note: This cannot be undone</small>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" id="resetBtn" onclick="resetResponse(this)">Reset</button>
				<button type="button" class="btn btn-secondary" onclick="$(this).parent().find('#resetBtn').removeAttr('task-code');" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="task_id" value="<?php echo $task->task_auto_id ?>" />
<input type="hidden" id="task_code" value="<?php echo $task->task_code ?>" />
<input type="hidden" id="subject_id" value="<?php echo $task->task_subject_id ?>" />
<input type="hidden" id="task_type" value="<?php echo $task->task_type ?>" />
<input type="hidden" id="school_year" value="<?php echo $this->session->school_year ?>" />
<input type="hidden" id="st_id" value="<?php echo ($this->session->isStudent?$this->session->details->st_id:'') ?>" />
<input type="hidden" id="teacher_id" value="<?php echo $task->task_author_id ?>" />
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });
        hasComment = true;
    });
    
    function resetResponse(btn){
        var btn = $(btn),
                stid = btn.attr('st-id'),
                task = btn.attr('task-code');
        $.ajax(
                {
                    url: "<?php echo site_url('opl/resetStudentAnswers'); ?>",
                    type: "POST",
                    data:{
                        stid: stid,
                        code: task,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    beforeSend: function(){
                        btn.html("<i class='fa fa-spinner fa-spin fa-xs'></i>");
                        btn.prop('disabled', true);
                    },
                    success: function(data){
                        location.reload();
                    }
                })
    }
    
    function readyReset(redo){
        var modal = $("#resetResponse"),
                btn = $(redo);
        modal.find("#student-name").html(btn.attr('student-name'));
        modal.find("#resetBtn").attr('task-code', btn.attr('task-code'));
        modal.find("#resetBtn").attr('st-id', btn.attr('st-id'));
        modal.modal();
    }

    $(function () {
        // Summernote
        $('.textarea').summernote();

        $("#btnAnswer").click(function () {
            $('html,body').animate({
                scrollTop: $("#answerWrapper").offset().top},
                    'slow');
        });
        
        regStream = function(st_id){
            $('#st_id').val(st_id);
        };
        
        saveRawScore = function(that,task_code, st_id){
            var base = $('#base').val();
            var url = base + 'opl/qm/saveRawScore';
            
            $.ajax({
                type    : 'POST',
                url     : url,
                data    : {
                    st_id           : st_id,
                    score           : $('#score_'+st_id).val(),
                    task_code       : task_code,
                    ans_id          : that.attr('ans_id'),
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    alert(data);
                    location.reload();
                }
            });
        };
        
        answer = function(){
            var ans = [];
            $('.answerOption').each(function(){
                
                if($(this).attr('qt')=='1')
                {
                    ans.push($(this).attr('name')+'_'+$(this).val());
                }else{
                    if($(this).is(':checked'))
                    {
                        ans.push($(this).attr('name')+'_'+$(this).val());

                    }
                }
            });
            
            //alert(ans);
            var base = $('#base').val();
            var url = base + 'opl/student/submitAnswer';
            
            $.ajax({
                type    : 'POST',
                url     : url,
                data    : {
                    teacher         : $('#teacher_id').val(),
                    answers         : ans.toString(),
                    task_code       : $('#task_code').val(),
                    q_code          : $('#q_code').val(),
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    alert(data);
                    location.reload();
                }
            });
        };
        
        fetchComment = function(st_id){
            var base = $('#base').val();
            var url = base + 'opl/fetchComments';
            var com_to = $('#com_to').val();
            $.ajax({
                type    : 'POST',
                url     : url,
                data    : {
                    com_to          : com_to,
                    com_from        : st_id,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#'+st_id+'_comments').html(data);
                }
            });
            
            return false;
        };
        
        sendComment = function(com_type, st_id, post_id, id, isStudent) {
            
            var base = $('#base').val();
            var url = base + 'opl/sendComment';
            
            $.ajax({
                type    : 'POST',
                url     : url,
                data    : {
                    com_type        : com_type,
                    com_details     :$('#'+id+'_textarea').val(),
                    com_from        : st_id,
                    com_to          : post_id,
                    is_student      : isStudent,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#'+id+'_comments').html(data);
                    $('#'+id+'_textarea').val('')
                }
            });
            
            return false;
            
        };

    });

    //uploading script
    $('#fileSubmit').click(function (e) {
	var file = document.getElementById("userfile").files[0];
        //readUploadFile(fileUpload);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('submission_type', $('#submissionType').val());
        formdata.append('teacher', $('#teacher_id').val());
        formdata.append('task_type', $('#task_type').val());
        formdata.append('task_code', $('#task_code').val());
        formdata.append('subject_id', $('#subject_id').val());
        formdata.append('st_id', $('#st_id').val());
        formdata.append('school_year', $('#school_year').val());
        formdata.append('task_id', $('#task_id').val());
        
         var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo base_url() . 'opl/student/uploadResponse/' ?>");
        ajax.send(formdata);
   

    });
     
    function progressHandler(event) {

        $('#progressBarWrapper').show();
       
    }
    function completeHandler(event) {
       // _("status").innerHTML = event.target.responseText;
        $("#progressBarWrapper").hide();
        alert(event.target.responseText);
        location.reload();
    }
    
    function errorHandler(event) {
        alert(event.target.responseText);
    }
    function abortHandler(event) {
        alert(event.target.responseText);
    }

    function readUploadFile(data)
    {

        var currentData = document.getElementById('uploadValue');

        if (currentData.value == "") {
            // alert(currentData.value)   
            currentData.value = data
        } else {
            currentData.value = currentData.value + ',' + data
        }
    }

</script>    

<script src="<?php echo base_url('opl_assets/js/ajaxfileupload.js'); ?>"></script>

