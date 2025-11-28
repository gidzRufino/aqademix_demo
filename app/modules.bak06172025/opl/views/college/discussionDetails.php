<section id="discussDetails" class="col-lg-6 col-xs-12 float-left">
    <div class="card card-blue card-outline">
        <div class="card-header">
            <div class="user-block">
                <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $discussionDetails->avatar; ?>" alt="User Image">
                <span class="username"><?php echo $discussionDetails->dis_title ?></span>
                <span class="description"><a href="#"><?php echo $discussionDetails->firstname . ' ' . $discussionDetails->lastname; ?></a> <small><?php echo date('F d, Y g:i a', strtotime($discussionDetails->dis_start_date)) ?></small></span>
            </div>
            <?php if($this->session->username==$discussionDetails->dis_author_id): ?>
                <i class="fa fa-trash fa-xs float-right text-danger" style="cursor:pointer;" discussion-section="<?php echo $discussionDetails->dis_section_id; ?>" discussion-subject="<?php echo $discussionDetails->dis_subject_id; ?>" discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>" discussion-title="<?php echo htmlspecialchars($discussionDetails->dis_title); ?>" onclick="readyDelete(this)"></i>
                <i class="fa fa-file-pdf fa-1x float-right mr-2 text-primary" style="cursor:pointer;" discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>" onclick="window.open('<?php echo base_url('opl/printDiscussion/'.$discussionDetails->dis_sys_code) ?>')"></i>
                <i class="fa fa-edit fa-xs float-right mr-2 text-success" style="cursor:pointer;" discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>" discussion-title="<?php echo $discussionDetails->dis_title; ?>" discussion-link="<?php echo $discussionDetails->dis_unit_id; ?>" discussion-date="<?php echo date('Y-m-d', strtotime($discussionDetails->dis_start_date)); ?>" discussion-time="<?php echo date('H:i', strtotime($discussionDetails->dis_start_date)); ?>" onclick="showEditDiscussion(this)"></i>
            <?php 
            else: ?>
                <i class="fa fa-file-pdf fa-1x float-right mr-2 text-primary" style="cursor:pointer;" discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>" onclick="window.open('<?php echo base_url('opl/printDiscussion/'.$discussionDetails->dis_sys_code.'/'. base64_encode($this->session->details->st_id)) ?>')"></i>
            <?php
            endif; ?>
        </div>
        <div class="card-body">
            <?php echo $discussionDetails->dis_details ?>
        </div>
        <div class="card-footer">
            <label>Attachments:</label>
            <?php   
                if($discussionDetails->dis_attachments != NULL || $discussionDetails->dis_attachments != ""):
                ?>
            <p><a href="<?php echo site_url('UPLOADPATH'.$school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$this->session->username.DIRECTORY_SEPARATOR.$discussionDetails->dis_subject_id.DIRECTORY_SEPARATOR.'discussion'.DIRECTORY_SEPARATOR.$discussionDetails->dis_attachments); ?>"><?php echo $discussionDetails->dis_attachments; ?></a></p>
            <?php
                endif;
            ?>
        </div>
    </div>

</section>
<section id="commentDetails" class="col-lg-6 col-xs-12 float-left">
    <div class="card card-indigo card-outline">
        <div class="card-header">
            Discussion Comments and Questions
        </div>
        <div class="card-body">
            <input type="hidden" id="com_to" value="<?php echo $discussionDetails->dis_sys_code ?>" />
            <?php
                $assets = $this->eskwela->getSet();
                $avatar = site_url("/uploads/").$this->session->user_id.".png";
                $avloc = FCPATH."uploads/".$this->session->user_id.".png";
                if(file_exists($avloc) == FALSE):
                    $avatar = site_url("images/forms/").$assets->set_logo;
                endif;
            ?>
            <img class="img-fluid img-circle img-sm" width="50" src="<?php echo $avatar; ?>" alt="">
            <!-- .img-push is used to add margin to elements next to floating images -->
            <div class="img-push">
                <!--<input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">-->
                <textarea id="commentArea" class="form-control form-control-sm clearfix mb-1" placeholder="Type here to Post a Comment or a Question"></textarea>
                <button onclick="sendComment('3', '<?php echo ($this->session->isStudent ? $this->session->details->st_id : $this->session->employee_id) ?>', '<?php echo $discussionDetails->dis_sys_code ?>','<?php echo ($this->session->isStudent ? 1 : 0) ?>')" class="btn btn-xs btn-primary float-right col-xs-12">send</button>
            </div>
        </div>

        <div id="discussComments" class="card-footer card-comments overflow-auto">
            <?php 
                echo Modules::run('opl/opl_variables/getDiscussComments', $discussionDetails->dis_sys_code, 3, $this->session->school_year); 
            ?>
        </div>
    </div>

</section>

<?php echo $this->load->view('college/editDiscussion'); ?>

<script type="text/javascript">

    $(function () {
        hasComment = true;
        
       // $('.textarea').summernote()
        
        fetchComment = function(st_id){
            var base = $('#base').val();
            var commentCount = $('#commentCount').val();
            var url = base + 'opl/fetchDiscussComments';
            var com_to = $('#com_to').val();
            $.ajax({
                type    : 'POST',
                url     : url,
                data    : {
                    comCount        : commentCount,
                    com_to          : com_to,
                    com_from        : st_id,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                dataType:'json',
                success: function (data)
                {
                    $('#commentCount').val(data.comCount);
                    if(data.hasNewComment)
                    {
                        for(var i=0; i < data.comments.length; i++)
                        {
                            if ($('#individualComment_'+data.comments[i].com_sys_code).length == 0 ) {
                               
                                $('#mainComment').prepend(data.commentDetails.com[i]);
                                
                                //alert($('#individualComment_'+data.comments[i].com_id)
                            }
                            //alert($('#individualComment_'+data.comments[i].com_id).find());
                        }
                        
                        for(var r=0; r < data.replyDetails.sys_code.length; r++)
                        {
                            if ($('#individualReply_'+data.replyDetails.sys_code[r]).length == 0 ){
                                //console.log(data.replyDetails.sys_code[r]);
                                $('#replyTo_'+data.replyDetails.replyTo[r]).append(data.replyDetails.com[r]);
                            }
                        }
                    }
                }
            });
            
            return false;
        };
        
        sendComment = function (com_type, st_id, post_id, isStudent) {

            var base = $('#base').val();
            var url = base + 'opl/sendDiscussComment';

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    com_type: com_type,
                    com_details: $('#commentArea').val(),
                    com_from: st_id,
                    com_to: post_id,
                    is_student: isStudent,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#discussComments').html(data);
                    $('#commentArea').val('');
                    
                    var com = parseInt($('#commentCount').val());
                    com += 1;
                    $('#commentCount').val(com);
                    
                }
            });

            return false;

        };
    });
</script>