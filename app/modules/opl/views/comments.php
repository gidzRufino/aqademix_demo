<?php 
foreach ($comments as $comment): 
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
    <div class="card-comment">
        <!-- User image -->
        <img width="50" class="img-circle img-sm" src="<?php echo $avatar; ?>" alt="User Image">

        <div class="comment-text">
            <small class="rounded">
                <span class="username">
                    <?php echo ucwords(strtolower($profile->firstname.' '.$profile->lastname)) ?>
                    <span class="text-muted float-right"><?php 
                        $now = new DateTime();
                        $stamp = new DateTime($comment->com_timestamp);
                        $parted = $now->diff($stamp);
                        if($parted->format("%d") <= 1):
                            if($parted->format("%h") <= 0):
                                if($parted->format("%i") < 0):
                                    echo $parted->format("%ss");
                                else:
                                    echo $parted->format("%im");
                                endif;
                            else:
                                echo $parted->format("%hh");
                            endif;
                        else:
                            if($parted->format("%d") == 1):
                                echo $parted->format("%dd");
                            else:
                                echo $stamp->format("F d, Y h:i a");
                            endif;
                        endif;
                    ?></span>
                </span><!-- /.username -->
                <?php echo htmlspecialchars($comment->com_details); ?>
            </small>
        </div>
        <button type="button" class="btn btn-xs btn-transparent float-right text-primary" onclick="readyReply(this)">Reply</button>
        <div class="card-comment col-11 float-right reply-box">
            <div id="comments" >
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
                            <div class="mb-3">
                                <img class="img-circle img-sm" src="<?php echo $avatar; ?>" alt="User Image">
                                <div class="comment-text">
                                    <small>
                                    <span class="username">
                                        <?php echo ucwords(strtolower($rprofile->firstname.' '.$rprofile->lastname)) ?>
                                        <span class="text-muted float-right timeago" datetime="<?php echo $reply->com_timestamp ?>"></span>
                                    </span><!-- /.username -->
                                        <?php echo $reply->com_details; ?>
                                    </small>
                                </div>
                            </div>
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
            <input type="text" class="form-control form-control-sm reply-input" com-to="<?php echo $comment->com_to; ?>" code="<?php echo $comment->com_sys_code; ?>" placeholder="Press enter to send reply" onkeypress="if(event.which == 13) sendReply(this)" />
        </div>
        <!-- /.comment-text -->
    </div>
  
<?php
endforeach;
?>
<script>
    $(document).ready(function(){
        timeago.render(document.querySelectorAll(".timeago"));
        $(".reply-input").hide();
    });

    function readyReply(btn)
    {
        $(".reply-input").hide();
        var input = $(btn).next().find(".reply-input");
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
                    btn.prev().html(data);
                    btn.val('');
                }
            }
        });
    }
</script>