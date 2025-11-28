<?php

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

if($isReply):
    $commentId = 'individualReply_'.$comment->com_sys_code;
else:    
    $commentId = 'individualComment_'.$comment->com_sys_code;
    
endif;
?>

<div id="<?php echo $commentId ?>">
    <img width="50" class="img-circle img-sm" src="<?php echo $avatar; ?>" alt="User Image">

    <div class="comment-text">
        <small class="rounded">
            <span class="username">
                <?php echo ucwords(strtolower($profile->firstname.' '.$profile->lastname)) ?>
                <span class="text-muted float-right timeago" datetime="<?php echo $com_timestamp ?>"></span>
            </span><!-- /.username -->
            <?php echo $comment->com_details; ?>
        </small>
    </div>
    <?php if(!$isReply): ?>
    <button type="button" class="btn btn-xs btn-transparent float-right text-primary" onclick="readyReply('<?php echo $comment->com_id ?>')">Reply</button><br />
    </div>
    <div class="card-comment col-11 float-right reply-box">
        <div id="replyTo_<?php echo $comment->com_sys_code ?>" >
            <?php
                $replies = Modules::run('opl/opl_variables/getReplies', $comment->com_sys_code, $this->session->school_year);
                if(count($replies) != 0):
                    foreach($replies AS $reply):
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
        <input type="text" id="reply_<?php echo $comment->com_id ?>" class="form-control form-control-sm reply-input" com-to="<?php echo $comment->com_to; ?>" code="<?php echo $comment->com_sys_code; ?>" placeholder="Press enter to send reply" onkeypress="if(event.which == 13) sendReply(this)" />
    <?php endif; ?>
    </div>

<script>
    $(document).ready(function(){
        timeago.render(document.querySelectorAll(".timeago"));
    });
</script>