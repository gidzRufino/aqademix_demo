<?php 

$cnt = count($postDetails);
foreach ($postDetails as $pd):
    $submittedTask = Modules::run('opl/opl_variables/getSubmittedTask', $pd->task_code, $this->session->school_year);
    if ($cnt > 1):
        $col = 'col-lg-6';
    else:
        $col = 'col-lg-12';
    endif;
    ?>
    <section id="gvDetails" class="<?php echo $col ?> float-left">
        <div class="card card-widget " id="card_<?php echo $pd->task_auto_id ?>">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $pd->avatar; ?>" alt="User Image">
                    <span class="username"><?php echo $pd->task_title . ' - ' . $pd->tt_type ?></span>
                    <span class="description"><a href="#"><?php echo $pd->firstname . ' ' . $pd->lastname; ?></a> <small><?php echo date('F d, Y g:i a', strtotime($pd->task_start_time)) ?></small></span>
                </div>
                <?php if ($pd->task_author_id == $this->session->username): ?>
                    <div class="box-tools float-right">
                        <div class="float-right">
                            <button type="button" class="btn btn-box-tool btn-xs text-primary" task-code="<?php echo $pd->task_code; ?>" onclick="window.open('<?php echo base_url('opl/printTask/'.$pd->task_code) ?>')">
                                <i class="fas fa-file-pdf"></i>
                            </button>    
                    <?php if(count($submittedTask->result())==0): ?>
                            <button type="button" class="btn btn-box-tool btn-xs text-success" task-code='<?php echo $pd->task_code; ?>' task-title="<?php echo htmlspecialchars($pd->task_title); ?>" task-type='<?php echo $pd->task_type; ?>' task-details="<?php echo htmlspecialchars($pd->task_details); ?>" task-sgls='<?php echo $pd->task_subject_id.'-'.$pd->task_grade_id.'-'.$pd->task_section_id ?>' task-start-date='<?php echo date("Y-m-d", strtotime($pd->task_start_time)); ?>' task-start-time="<?php echo date("H:m:s", strtotime($pd->task_start_time)); ?>" task-end-date="<?php echo date("Y-m-d", strtotime($pd->task_end_time)); ?>" task-end-time="<?php echo date("H:m:s", strtotime($pd->task_end_time)); ?>" onclick='showEditModal(this)'>
                                <i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-box-tool btn-xs text-danger" task-code='<?php echo $pd->task_code; ?>' task-title='<?php echo $pd->task_title; ?>' onclick="showDeleteModal(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                    <?php endif; ?>  
                            
                        </div>
                        <br />
                        <span class="float-right text-muted danger pointer" 
                              style="font-size: 12px;"
                              data-container="body" data-toggle="popover" data-placement="right" 
                              data-content="
                              <?php
                                  $data['submittedTask'] = $submittedTask->result();
                                  $data['totalStudents'] = count($submittedTask->result());
                                  $this->load->view('submittedTask', $data);
                              ?>
                              "
                              >
                            Submitted by: <?php echo count($submittedTask->result()) ?> student(s)
                        </span>
                    </div>
                <?php    
                endif; ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php 
                
                if($pd->task_attachments!=""):
//                    $directory = UPLOADPATH . $this->session->school_year . DIRECTORY_SEPARATOR . 'faculty' . DIRECTORY_SEPARATOR . $pd->task_author_id . DIRECTORY_SEPARATOR . $pd->task_subject_id . DIRECTORY_SEPARATOR . 'task';
                    $directory = 'uploads/'.$this->session->school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$pd->task_author_id.DIRECTORY_SEPARATOR.$pd->task_subject_id.DIRECTORY_SEPARATOR.'task';

                    $scanFiles = scandir($directory);
                    $files = array_diff($scanFiles, array('..', '.','.DS_Store'));
                    foreach ($files as $file):
                        if($file==$pd->task_attachments):
                    ?>
                <small><a class="float-right" href="<?php echo base_url('opl/downloads/'. base64_encode($directory.'/'.$file)) ?>"><i class="fas fa-paperclip fa-fw "></i><?php echo $pd->task_attachments; ?></a></small>
                        <br />
                    <?php
                        endif;
                    endforeach;
                endif;
                echo $pd->task_details;
                    if($pd->task_is_online):
                        $quizDetails = Modules::run('opl/qm/getQuizDetails', $pd->task_online_link,$this->session->school_year);
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
                    endif;
                ?>
                <!--<button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Got It!</button>-->
            </div>

        </div>
    </section>   
    <input class="dateTime" task_id="<?php echo $pd->task_auto_id ?>"  type="hidden" id="dateTime_<?php echo $pd->task_auto_id ?>" value="<?php echo date('M d, Y G:i:s', strtotime($pd->task_end_time)) ?>" />
<?php endforeach; ?>
