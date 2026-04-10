<?php
if (!empty($discussionDetails->avatar)) {
    $path = FCPATH . 'uploads/' . $discussionDetails->avatar;
    if (file_exists($path)) {
        $avatar = site_url('uploads/' . $discussionDetails->avatar);
    } else {
        $avatar = site_url('images/avatar/' . ($discussionDetails->sex == 'Female' ? 'female.png' : 'male.png'));
    }
} else {
    $avatar = site_url('images/avatar/' . ($discussionDetails->sex == 'Female' ? 'female.png' : 'male.png'));
}
?>

<section id="discussDetails" class="col-lg-6 col-12 float-left mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img class="img-circle mr-2" width="50" src="<?php echo $avatar; ?>" alt="User Image">
                <div>
                    <h6 class="mb-0 font-weight-bold"><?php echo $discussionDetails->dis_title ?></h6>
                    <small class="text-muted">
                        <a href="#" class="text-primary"><?php echo $discussionDetails->firstname . ' ' . $discussionDetails->lastname; ?></a> •
                        <?php echo date('F d, Y g:i a', strtotime($discussionDetails->dis_start_date)) ?>
                    </small>
                </div>
            </div>

            <div class="action-icons">
                <?php if ($this->session->username == $discussionDetails->dis_author_id || $this->session->isOplAdmin): ?>
                    <i class="fa fa-edit text-success mx-2" title="Edit"
                        style="cursor:pointer;"
                        discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>"
                        discussion-title="<?php echo $discussionDetails->dis_title; ?>"
                        discussion-link="<?php echo $discussionDetails->dis_unit_id; ?>"
                        discussion-date="<?php echo date('Y-m-d', strtotime($discussionDetails->dis_start_date)); ?>"
                        discussion-time="<?php echo date('H:i', strtotime($discussionDetails->dis_start_date)); ?>"
                        onclick="showEditDiscussion(this)">
                    </i>

                    <i class="fa fa-file-pdf text-primary mx-2" title="Export to PDF" style="cursor:pointer;"
                        onclick="window.open('<?php echo base_url('opl/printDiscussion/' . $discussionDetails->dis_sys_code) ?>')">
                    </i>

                    <i class="fa fa-trash text-danger mx-2" title="Delete" style="cursor:pointer;"
                        discussion-id="<?php echo $discussionDetails->dis_sys_code; ?>"
                        discussion-title="<?php echo htmlspecialchars($discussionDetails->dis_title); ?>"
                        onclick="readyDelete(this)">
                    </i>
                <?php else: ?>
                    <i class="fa fa-file-pdf text-primary" title="Export to PDF" style="cursor:pointer;"
                        onclick="window.open('<?php echo base_url('opl/printDiscussion/' . $discussionDetails->dis_sys_code . '/' . base64_encode($this->session->details->st_id)) ?>')">
                    </i>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <p class="text-justify"><?php echo $discussionDetails->dis_details ?></p>
        </div>

        <?php if (!empty($discussionDetails->dis_attachments)): ?>
            <div class="card-footer bg-white">
                <label class="font-weight-bold">📎 Attachments:</label>
                <p>
                    <a href="<?php echo site_url('uploads/' . $school_year . '/faculty/' . $discussionDetails->dis_author_id . '/' . $discussionDetails->dis_subject_id . '/discussion/' . $discussionDetails->dis_attachments); ?>" class="text-primary">
                        <?php echo $discussionDetails->dis_attachments; ?>
                    </a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="commentDetails" class="col-lg-6 col-12 float-left mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light font-weight-bold">
            💬 Discussion Comments & Questions
        </div>

        <div class="card-body">
            <input type="hidden" id="com_to" value="<?php echo $discussionDetails->dis_sys_code ?>" />
            <?php
            $assets = $this->eskwela->getSet();
            $avatar = site_url("/uploads/") . $this->session->user_id . ".png";
            $avloc = FCPATH . "uploads/" . $this->session->user_id . ".png";
            if (!file_exists($avloc)) {
                $avatar = site_url("images/forms/") . $assets->set_logo;
            }
            ?>

            <div class="d-flex align-items-start mb-3">
                <img class="img-circle mr-2" width="40" src="<?php echo $avatar; ?>" alt="User Avatar">
                <div class="flex-grow-1">
                    <textarea id="commentArea" rows="2" class="form-control form-control-sm mb-2" placeholder="Type here to post a comment or question..."></textarea>
                    <button onclick="sendComment('3', '<?php echo ($this->session->isStudent ? $this->session->details->st_id : $this->session->employee_id) ?>', '<?php echo $discussionDetails->dis_sys_code ?>','<?php echo ($this->session->isStudent ? 1 : 0) ?>')" class="btn btn-sm btn-primary float-right">
                        <i class="fa fa-paper-plane"></i> Send
                    </button>
                </div>
            </div>
        </div>

        <div id="discussComments" class="card-footer bg-white overflow-auto" style="max-height: 400px;">
            <?php echo Modules::run('opl/opl_variables/getDiscussComments', $discussionDetails->dis_sys_code, 3, $this->session->school_year); ?>
        </div>
    </div>
</section>

<?php echo $this->load->view('editDiscussion'); ?>
<style>
    /* Chat bubble container */
    .comment-bubble {
        display: flex;
        margin-bottom: 12px;
    }

    /* Left side (others) */
    .comment-left {
        justify-content: flex-start;
    }

    .comment-left .bubble {
        background: #f1f1f1;
        color: #333;
        border-radius: 15px 15px 15px 0;
        padding: 10px 15px;
        max-width: 70%;
        font-size: 0.9rem;
    }

    /* Right side (current user) */
    .comment-right {
        justify-content: flex-end;
    }

    .comment-right .bubble {
        background: #007bff;
        color: #fff;
        border-radius: 15px 15px 0 15px;
        padding: 10px 15px;
        max-width: 70%;
        font-size: 0.9rem;
        text-align: right;
    }

    /* Avatar */
    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 8px;
    }

    /* Metadata */
    .comment-meta {
        display: block;
        font-size: 0.75rem;
        color: #888;
        margin-top: 3px;
    }
</style>
<script type="text/javascript">
    $(function() {
        hasComment = true;

        // $('.textarea').summernote()

        fetchComment = function(st_id) {
            var base = $('#base').val();
            var commentCount = $('#commentCount').val();
            var url = base + 'opl/fetchDiscussComments';
            var com_to = $('#com_to').val();
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    comCount: commentCount,
                    com_to: com_to,
                    com_from: st_id,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                dataType: 'json',
                success: function(data) {
                    $('#commentCount').val(data.comCount);
                    if (data.hasNewComment) {
                        for (var i = 0; i < data.comments.length; i++) {
                            if ($('#individualComment_' + data.comments[i].com_sys_code).length == 0) {

                                $('#mainComment').prepend(data.commentDetails.com[i]);

                                //alert($('#individualComment_'+data.comments[i].com_id)
                            }
                            //alert($('#individualComment_'+data.comments[i].com_id).find());
                        }

                        for (var r = 0; r < data.replyDetails.sys_code.length; r++) {
                            if ($('#individualReply_' + data.replyDetails.sys_code[r]).length == 0) {
                                //console.log(data.replyDetails.sys_code[r]);
                                $('#replyTo_' + data.replyDetails.replyTo[r]).append(data.replyDetails.com[r]);
                            }
                        }
                    }
                }
            });

            return false;
        };

        sendComment = function(com_type, st_id, post_id, isStudent) {

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
                success: function(data) {
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