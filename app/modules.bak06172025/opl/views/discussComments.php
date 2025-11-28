<style>
    .fa {
        font-size: 0.60em;
        cursor: pointer;
    }
</style>
<div class="card-comments" >
        <!-- User image -->
        <div id="mainComment" >
            <?php 
                $com = 0;
                foreach ($comments as $comment): 
                    $com++;
                    if($comment->com_isStudent==1):
                        $profile = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $comment->com_from, $this->session->school_year);
                    else:
                        $profile = Modules::run('opl/opl_variables/getBasicEmployee', $comment->com_from, $this->session->school_year);
                    endif;
                    $assets = $this->eskwela->getSet();
                    $avatar = site_url("/uploads/").$profile->avatar;
                    $avloc = FCPATH."uploads/".($profile->avatar ? $profile->avatar : "none.png");
                    if(file_exists($avloc) == FALSE):
                        $avatar = site_url("images/forms/").$assets->set_logo;
                    endif;
            ?>    
                <div id="individualComment_<?php echo $comment->com_sys_code ?>" class="card-comment float-left col-12">
                    <img id="<?php $comment->com_id ?>" width="50" class="img-circle img-sm" src="<?php echo $avatar; ?>" alt="User Image">
                    <i class="text-gray fa fa-trash fa-xs float-right" title="Delete Comment" com-id="<?php echo $comment->com_sys_code; ?>" onclick="commentDelete(this)"></i>

                    <div class="comment-text">
                        <small class="rounded">
                            <span class="username">
                                <?php echo ucwords(strtolower($profile->firstname.' '.$profile->lastname)) ?>
                                <span class="text-muted float-right timeago" datetime="<?php echo $comment->com_timestamp ?>"></span>
                            </span><!-- /.username -->
                            <?php echo $comment->com_details; ?>
                        </small>
                    </div>
                    
                    <?php if(!$this->session->isParent): ?>
                    <button type="button" class="btn btn-xs btn-transparent float-right text-primary" onclick="readyReply('<?php echo $comment->com_id ?>')">Reply</button><br />
                    <?php endif; ?>
                </div>
                <div class="card-comment col-11 float-right reply-box">
                    <div id="replyTo_<?php echo $comment->com_sys_code ?>" >
                        <?php
                            $replies = Modules::run('opl/opl_variables/getReplies', $comment->com_sys_code, $this->session->school_year);
                            if(count($replies) != 0):
                                foreach($replies AS $reply):
                                    $com++;
                                    if($reply->com_isStudent==1):
                                        $rprofile = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $reply->com_from, $this->session->school_year);
                                    else:
                                        $rprofile = Modules::run('opl/opl_variables/getBasicEmployee', $reply->com_from, $this->session->school_year);
                                    endif;
                                    $assets = $this->eskwela->getSet();
                                    $avatar = site_url("/uploads/").$rprofile->avatar;
                                    $avloc = FCPATH."uploads/".($rprofile->avatar ? $rprofile->avatar : "none.png");
                                    if(file_exists($avloc) == FALSE):
                                        $avatar = site_url("images/forms/").$assets->set_logo;
                                    endif;
                        ?>
                                    <div class="mb-3" id="individualReply_<?php echo $reply->com_sys_code ?>">
                                        <img class="img-circle img-sm" src="<?php echo $avatar; ?>" alt="User Image">
                                        <i class="text-gray fa fa-trash fa-xs float-right" title="Delete Reply" reply-id="<?php echo $reply->com_sys_code; ?>" onclick="replyDelete(this)"></i>
                                        <div class="comment-text">
                                            <small>
                                            <span class="username">
                                                <?php echo ucwords(strtolower($rprofile->firstname.' '.$rprofile->lastname)) ?>
                                                <span class="text-muted float-right timeago" datetime="<?php echo $reply->com_timestamp ?>"></span>
                                            </span> 
                                                <?php echo $reply->com_details; ?>
                                            </small>
                                        </div>
                                    </div>
                                
                        <?php
                                endforeach;
                            endif;
                        ?>
                        </div>    
                    <?php if(!$this->session->isParent): ?>
                    <input type="text" id="reply_<?php echo $comment->com_id ?>" class="form-control form-control-sm reply-input" com-to="<?php echo $comment->com_to; ?>" code="<?php echo $comment->com_sys_code; ?>" placeholder="Press enter to send reply" onkeypress="if(event.which == 13) sendReply(this)" />
                    <?php endif; ?>
                </div>
            <?php
            endforeach;
            ?>
        </div>
        
            <input type="hidden" id="commentCount" value="<?php echo $com; ?>" />
    </div>
  <div class="modal rounded" id="deleteComment">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Comment</h5>
            </div>
            <div class="modal-body">
                <p id='highlightText'>Are you sure you want to delete this comment?</p>
                <small>Note: This cannot be undone</small>
                <button type="button" class="btn btn-success btn-sm float-right" id="deleteCommentButton" onclick="deleteComment(this)">Proceed</button>
                <button type="button" class="btn btn-light btn-sm float-right mr-2" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
  <div class="modal rounded" id="deleteReply">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Reply</h5>
            </div>
            <div class="modal-body">
                <p id='highlightText'>Are you sure you want to delete this reply?</p>
                <small>Note: This cannot be undone</small>
                <button type="button" class="btn btn-success btn-sm float-right" id="deleteReplyBtn" onclick="deleteComment(this)">Proceed</button>
                <button type="button" class="btn btn-light btn-sm float-right mr-2" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        timeago.render(document.querySelectorAll(".timeago"));
        $(".reply-input").hide();
    });
    
    function deleteComment(btn){
        var comid = $(btn).attr('com-id'),
                modal = $("#deleteComment");
        
        $.ajax(
                {
                    url: "<?php echo site_url("opl/opl_variables/deleteComment"); ?>",
                    type: "POST",
                    data:{
                        commentid: comid,
                        csrf_test_name: $.cookie("csrf_cookie_name")
                    },
                    beforeSend: function(){
                        $('#loadingModal').modal('show');
                    },
                    success: function(data){
                        alert(data);
                        location.reload();
                    }
                });
    }
    
    function replyDelete(btn){
        var replyid = $(btn).attr('reply-id'),
                modal = $("#deleteReply");
        modal.find("#deleteReplyBtn").attr('com-id', replyid);
        modal.modal("show");
    }
    
    function commentDelete(btn){
        var comid = $(btn).attr('com-id'),
                modal = $("#deleteComment");
        modal.find("#deleteCommentButton").attr('com-id', comid);
        modal.modal("show");
    }

    function readyReply(btn)
    {
         var input = $('#reply_'+btn);
        input.show();
        input.focus();
    }

    function sendReply(btn)
    {
        var btn = $(btn),
            code = btn.attr('code'),
            value = btn.val(),
            base = $("#base").val(),
            to = btn.attr('com-to'),
            url = base+"opl/opl_variables/sendReply";
            if(value!=""){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        code: code,
                        reply: value,
                        to: to,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function(data){
                        if(data !== null){
                            timeago.render(document.querySelectorAll(".timeago"));
                            btn.prev().html(data);
                            btn.val('');
                        }
                        var com = parseInt($('#commentCount').val());
                        com += 1;
                        $('#commentCount').val(com);
                        
                    }
                });
                
            }else{
                alert('Sorry comment box is empty');
            }
    }
</script>