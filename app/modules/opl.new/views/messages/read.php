<?php
// Helper to get avatar
function getAvatarUrl($avatar, $sex)
{
    $default = ($sex === 'Female') ? 'female.png' : 'male.png';
    if (!empty($avatar) && file_exists(FCPATH . 'uploads/' . $avatar)) {
        return site_url('uploads/' . $avatar);
    }
    return site_url('images/avatar/' . $default);
}

// print_r($msg);
// Get recipients
$recipients = Modules::run('opl/messages/getRecipients', $msg->opl_msg_id);
$s = [];
$name = [];
foreach ($recipients as $r):
    $s[] = base64_encode($r->st_id);
    $name[] = $r->firstname . ' ' . $r->lastname;
endforeach;
$r_id = implode(',', $s);
?>

<div class="card shadow-sm border-0 rounded-3">
    <!-- Header -->
    <div class="card-header bg-primary text-white fw-bold d-flex align-items-center rounded-top-3">
        <i class="fas fa-envelope me-2"></i> Read Message
    </div>

    <!-- Body -->
    <div class="card-body bg-body text-body">

        <!-- Message Info -->
        <div class="mb-3">
            <h5 class="fw-bold mb-1">📌 Subject: <?php echo $msg->subject_msg; ?></h5>
            <p class="mb-1">
                <strong>From:</strong>
                <img src="<?php echo getAvatarUrl($msg->avatar, $msg->sex); ?>"
                    class="rounded-circle me-2 shadow-sm"
                    style="width:30px; height:30px; object-fit:cover;">
                <?php echo ucfirst(strtolower($msg->firstname . ' ' . $msg->lastname)); ?>
                <span class="text-muted float-end small">
                    <?php echo date('M d, Y h:i:s a', strtotime($msg->date_sent)) ?>
                </span>
            </p>
            <p>
                <strong>To:</strong>
                <?php foreach ($name as $n): ?>
                    <span class="badge bg-secondary me-1 mb-1"><?php echo $n; ?></span>
                <?php endforeach; ?>
            </p>
        </div>

        <!-- Action Toolbar -->
        <div class="d-flex justify-content-between align-items-center mb-3 border-top pt-2 pb-2 border-bottom">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="far fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm" title="Reply" id="msgReply">
                    <i class="fas fa-reply"></i>
                </button>
                <button type="button" class="btn btn-outline-info btn-sm" title="Forward">
                    <i class="fas fa-share"></i>
                </button>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" title="Print">
                <i class="fas fa-print"></i>
            </button>
        </div>

        <!-- Highlighted Main Message -->
        <div class="p-4 rounded mb-4 bg-light shadow-sm border-start border-4 border-primary position-relative">
            <span class="badge bg-primary text-white position-absolute" style="top:-10px; left:-10px; font-size:0.8rem;">
                📌 Main Message
            </span>
            <?php echo html_entity_decode($msg->content) ?>
        </div>

        <!-- Replies -->
        <style>
            /* Bubble tails and spacing */
            .reply-bubble {
                position: relative;
                padding: 10px 15px;
                margin-top: 5px;
                margin-bottom: 2px;
            }

            .reply-bubble.left {
                background-color: #e9ecef;
                /* light gray for left bubbles */
                color: #212529;
                border: 1px solid #dee2e6;
            }

            .reply-bubble.right {
                background-color: #0d6efd;
                /* primary blue */
                color: #fff;
            }

            .reply-bubble.left::before {
                content: "";
                position: absolute;
                top: 12px;
                left: -8px;
                /* tail points to avatar */
                width: 0;
                height: 0;
                border-top: 8px solid transparent;
                border-bottom: 8px solid transparent;
                border-right: 8px solid #e9ecef;
                /* matches left bubble background */
            }

            .reply-bubble.right::before {
                content: "";
                position: absolute;
                top: 12px;
                right: -8px;
                /* tail points to avatar */
                width: 0;
                height: 0;
                border-top: 8px solid transparent;
                border-bottom: 8px solid transparent;
                border-left: 8px solid #0d6efd;
                /* matches right bubble bg */
            }

            .reply-row {
                display: flex;
                align-items: flex-start;
                margin-bottom: 10px;
            }

            .reply-left {
                flex-direction: row;
            }

            .reply-right {
                flex-direction: row-reverse;
            }

            /* Extra spacing between avatar and bubble */
            .reply-left .bubble-container {
                margin-left: 12px;
            }

            .reply-right .bubble-container {
                margin-right: 12px;
            }
        </style>

        <?php
        $msgReply = Modules::run('opl/messages/getMsgReply', $msg->opl_msg_id);
        foreach ($msgReply as $mr):
            $sender = Modules::run('opl/messages/getSender', base64_encode($mr->sender));
            $isMe = (base64_decode($mid) == $mr->msg_recpt_id);
        ?>
            <div class="reply-row <?php echo $isMe ? 'reply-right' : 'reply-left'; ?>">
                <img src="<?php echo getAvatarUrl($sender->avatar, $sender->sex); ?>"
                    class="rounded-circle shadow-sm"
                    style="width:50px; height:50px; object-fit:cover;">

                <div class="d-flex flex-column bubble-container" style="max-width: 75%;">
                    <div class="reply-bubble <?php echo $isMe ? 'right rounded-3 shadow-sm' : 'left rounded-3 shadow-sm'; ?>">
                        <?php echo html_entity_decode($mr->content); ?>
                    </div>
                    <small class="text-muted mt-1 <?php echo $isMe ? 'text-end' : ''; ?>">
                        <?php echo ucwords(strtolower($sender->firstname . ' ' . $sender->lastname)); ?> •
                        <?php echo date('M d, Y h:i:s a', strtotime($mr->date_sent)) ?>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Reply Section -->
        <div class="card shadow-sm border-0 rounded-3 mb-3 d-none" id="replyMsg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-reply"></i> Reply to <?php echo ucfirst(strtolower($msg->firstname . ' ' . $msg->lastname)); ?></h6>
                <button type="button" class="btn-close btn-close-white" id="closeReply"></button>
            </div>
            <div class="card-body bg-body">
                <textarea class="form-control" id="contentReply" rows="5" placeholder="Write your reply..."></textarea>
            </div>
            <div class="card-footer text-end bg-body-secondary">
                <button class="btn btn-primary btn-sm" onclick="sendReply()">Send</button>
                <input type="hidden" id="recipient_id" value="<?php echo base64_encode($msg->sender) ?>" />
                <input type="hidden" id="sender_id" value="<?php echo base64_encode($this->session->st_id != '' ? $this->session->st_id : $this->session->employee_id) ?>" />
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this message? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteMessage()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet" />
<script>
    function sendReply() {
        var sender = $('#sender_id').val();
        var recipient_id = $('#recipient_id').val();
        var msg_id = '<?php echo $msg->opl_msg_id ?>';
        var content = $('#contentReply').val();
        var subjMsg = '<?php echo $msg->subject_msg ?>';
        var subj_id = '<?php echo $subj_id ?>';
        var url = '<?php echo base_url() . 'opl/messages/replyMsg' ?>';
        // var recipient = recipient_id + ',' + '<?php // echo $r_id 
                                                    ?>';

        $.ajax({
            type: 'POST',
            data: {
                sender: sender,
                recipient: recipient_id,
                // recipient: recipient,
                msg_id: msg_id,
                content: content,
                subjMsg: subjMsg,
                subj_id: subj_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            url: url,
            success: function(data) {
                alert(data);
                location.reload();
            }
        });
    }

    function deleteMessage() {
        alert('Delete functionality goes here...');
        $('#deleteModal').modal('hide');
    }

    // Toggle reply box
    $('#msgReply').on('click', function() {
        $('#replyMsg').removeClass('d-none');
        $(this).addClass('d-none');
    });
    $('#closeReply').on('click', function() {
        $('#replyMsg').addClass('d-none');
        $('#msgReply').removeClass('d-none');
    });

    $('.textarea').summernote({
        height: 180,
        placeholder: "Hey! What's up?"
    });
</script>