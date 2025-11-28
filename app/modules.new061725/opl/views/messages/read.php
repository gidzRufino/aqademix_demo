<?php
$recipients = Modules::run('opl/messages/getRecipients', $msg->opl_msg_id);
foreach ($recipients as $r):
    $s[] = base64_encode($r->st_id);
    $name[] = $r->firstname . ' ' . $r->lastname . ' ';
endforeach;

$r_id = implode(',', $s);
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        Read Message
    </div>
    <div class="card-body">
        <div class="mailbox-read-info">
            <h5>Subject: <?php echo $msg->subject_msg; ?></h5>
            <h6>From: <?php echo ucfirst(strtolower($msg->firstname . ' ' . $msg->lastname)); ?>
                <span class="mailbox-read-time float-right"><?php echo date('M d, Y H:i:s a', strtotime($msg->date_sent)) ?></span>
            </h6>
            <h6>
                <span class="pull-left">To:&nbsp;</span>
                <?php foreach ($name as $n): ?>
                    <ul class="nav nav-pills pull-left" role='tablist'>
                        <li class=""><span class="badge badge-secondary"><?php echo $n; ?></span>&nbsp;</li>
                    </ul>
                <?php endforeach; ?>
                <br/>
            </h6>
        </div>
        <div class="mailbox-controls with-border text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="far fa-trash-alt"></i></button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                    <i class="fas fa-reply"></i></button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fas fa-share"></i></button>
            </div>
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                <i class="fas fa-print"></i></button>
        </div>
        <div class="mailbox-read-message">
            <?php echo html_entity_decode($msg->content) ?>
        </div>
        <div class="card-footer">
            <?php
            $msgReply = Modules::run('opl/messages/getMsgReply', $msg->opl_msg_id);
            foreach ($msgReply as $mr):
                $sender = Modules::run('opl/messages/getSender', base64_encode($mr->sender));
                ?>
                <div class="card card-blue card-outline" id="">
                    <div class="card card-header">
                        <h6 style="font-weight: <?php echo (base64_decode($mid) == $mr->msg_recpt_id ? 'bold' : '') ?>">From: <?php echo ucwords(strtolower($sender->firstname . ' ' . $sender->lastname)); ?>
                            <span class="mailbox-read-time float-right"><?php echo date('M d, Y H:i:s a', strtotime($mr->date_sent)) ?></span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mailbox-read-message">
                            <?php echo html_entity_decode($mr->content); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>           

            <div class="float-right">
                <button type="button" class="btn btn-default" id="msgReply" onclick="$('#replyMsg').show(), $(this).hide(), $('#deleteMsg').hide()"><i class="fas fa-reply"></i> Reply</button>
            </div>
            <button type="button" class="btn btn-default" id="deleteMsg"><i class="fas fa-trash-alt"></i> Delete</button>
            <div class="card card-blue card-outline" id="replyMsg" style="display: none">
                <div class="card-header">
                    <h6><i class="fas fa-reply"></i> <?php echo ucfirst(strtolower($msg->firstname . ' ' . $msg->lastname)); ?>
                        <span class="float-right pointer" onclick="$('#replyMsg').hide(), $('#msgReply').show(), $('#deleteMsg').show()"><i class="fas fa-times"></i></span>
                    </h6>
                </div>
                <div class="card-body">
                    <textarea class="textarea" id="contentReply" placeholder="Hey! What's Up!"
                              style="font-size: 14px; line-height: 50px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-sm float-right" onclick="sendReply()">Send</button><br/>
                    <input type="hidden" id="recipient_id" value="<?php echo base64_encode($msg->sender) ?>" />
                    <input type="hidden" id="sender_id" value="<?php echo base64_encode($this->session->st_id != '' ? $this->session->st_id : $this->session->employee_id) ?>" />
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    function sendReply() {
        var sender = $('#sender_id').val();
        var recipient_id = $('#recipient_id').val();
        var msg_id = '<?php echo $msg->opl_msg_id ?>';
        var content = $('#contentReply').val();
        var subjMsg = '<?php echo $msg->subject_msg ?>';
        var subj_id = '<?php echo $subj_id ?>';
        var url = '<?php echo base_url() . 'opl/messages/replyMsg' ?>';
        var recipient = recipient_id + ',' + '<?php echo $r_id ?>';
        
//        alert(recipient + ' ' + sender);

        $.ajax({
            type: 'POST',
            data: 'sender=' + sender + '&recipient=' + recipient + '&msg_id=' + msg_id + '&content=' + content + '&subjMsg=' + subjMsg + '&subj_id=' + subj_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function (data) {
                alert(data);
                location.reload();
            }
        });

    }

    function errorMsg(msg, color, tDelay) {
        $('#promptMsg').show().delay(tDelay).queue(function (n) {
            $(this).hide();
            n();
        });
        $('#promptMsg').css('color', color);
        $('#promptMsg').text('Alert: ' + msg);
    }

    function updateTime(value) {
        alert(value);
    }

    $(function () {
        $('.textarea').summernote({
//            placeholder: "Hey! What's Up! Anything Interesting?"
        });

    });


    $(document).ready(function () {
        $("#recipient_id").select2({maximumSelectionSize: 1});
    });
</script>