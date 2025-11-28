<div class="card card-primary card-outline">
    <div class="card-header">
        Compose New Message
    </div>
    <div class="card-body">
        <div class="form-group">
            <?php if (count($students) > 0): ?>
                <select placeholder="To:" class="populate select2-offscreen " style="width:100%;" multiple="" id="recipient" name="recipient">
                    <?php foreach ($students as $s): ?>
                        <option value="<?php echo base64_encode($s->st_id) ?>" onclick="$('#recipient').val(this.value)"><?php echo $s->lastname . ' ' . $s->firstname ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text" class="form-control" placeholder="<?php ?>" id="receipent" value="<?php echo 'To: ' . $teacher->firstname . ' ' . $teacher->lastname ?>" readonly=""/>
                <input type="hidden" id="recipient" value="<?php echo base64_encode($teacher->employee_id) ?>" /><br/>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Subject:" id="subjMsg"  />
        </div>
        <div class="form-group">
            <textarea class="textarea" id="composeMsg" placeholder="Hey! What's Up!"
                      style="font-size: 14px; line-height: 50px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>
        <button class="btn btn-primary btn-sm pull-right" onclick="sendMsg()">Send</button><br/>
        <input type="hidden" id="sender" value="<?php echo (count($students) > 0 ? base64_encode($this->session->employee_id) : base64_encode($this->session->st_id)) ?>"/>
        <input type="hidden" id="isTeacher" value="<?php echo (count($students) > 0 ? 1 : 0) ?>"/>
        <span id="promptMsg"></span>
    </div>
</div>

<script type='text/javascript'>

    $(function () {
        $('.textarea').summernote({
//            placeholder: "Hey! What's Up! Anything Interesting?"
        });

    });

    $(document).ready(function () {
        $("#receipent").select2({maximumSelectionSize: 1});
    });

    function sendMsg() {
        var sender = $('#sender').val();
        var recipient = $('#recipient').val();
        var subjMsg = $('#subjMsg').val();
        var content = $('#composeMsg').val();
        var url = '<?php echo base_url() . 'opl/messages/sendMsg' ?>';
        var subj_id = '<?php echo $subj_id ?>';
        var isTeacher = $('#isTeacher').val();
        var grade_id = '<?php echo $grade_id ?>';
        var section_id = '<?php echo $section_id ?>';
//        alert(sender + ' ' + recipient);
        var proceed = 1;

        if (recipient == '' && subjMsg != '') {
            errorMsg('Recipient should not be empty', 'red', 3000);
            proceed = 0;
        } else if (recipient != '' && subjMsg == '') {
            errorMsg('Subject Message should not be empty', 'red', 3000);
            proceed = 0;
        } else if (recipient == '' && subjMsg == '') {
            errorMsg('Recipient and Subject Message should not be empty', 'red', 3000);
            proceed = 0;
        }

        if (proceed == 1) {

            $.ajax({
                type: 'POST',
                url: url,
                data: 'subjMsg=' + subjMsg + '&content=' + content + '&recipient=' + recipient + '&sender=' + sender + '&subj_id=' + subj_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function (data) {
                    alert(data);
                    if (isTeacher != 1) {
                        document.location = '<?php echo base_url() . 'opl/student/classBulletin/' ?>' + subj_id + '/' + '<?php echo $this->session->school_year ?>';
                    } else {
                        document.location = '<?php echo base_url() . 'opl/messages/employee_inbox/'?>' + sender + '/' + subj_id + '/' + grade_id + '/' + section_id;
                    }
                }
            });
        }
    }

    function errorMsg(msg, color, tDelay) {
        $('#promptMsg').show().delay(tDelay).queue(function (n) {
            $(this).hide();
            n();
        });
        $('#promptMsg').css('color', color);
        $('#promptMsg').text('Alert: ' + msg);
    }
</script>