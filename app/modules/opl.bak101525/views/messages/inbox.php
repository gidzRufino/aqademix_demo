<div class="card card-primary card-outline">
    <div class="card-header">
        Inbox
    </div>
    <div class="card-body">
        <div id="links" class="pull-left">
            <?php echo $links ?>
        </div>

        <div id="inboxTable" class="row table-responsive" style="margin:0 1%;">
            <table class="table table-hover table-stripped">
                <tbody>
                    <?php
                    foreach ($messages as $m):
                        $time = strtotime($m->date_sent);
                        $sender = Modules::run('opl/messages/getSender', base64_encode($m->sender));
                        ?>

                    <tr class="pointer" onclick="readMsge('<?php echo base64_encode($m->msg_recpt_id); ?>','<?php echo $m->is_reply; ?>','<?php echo base64_encode($m->replied_msg_id) ?>')">
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="check<?php echo $m->msg_recpt_id ?>" />
                                    <label for="check<?php echo $m->msg_recpt_id ?>"></label>
                                </div>
                            </td>
                            <td style="font-weight: <?php echo ($m->is_read ? '' : 'bold') ?>"><?php echo ucwords(strtolower($sender->firstname . ' ' . $sender->lastname)) ?></td>
                            <td style="font-weight: <?php echo ($m->is_read ? '' : 'bold') ?>"><?php echo ($m->is_reply ? 'Re: ' : '') . $m->subject_msg ?></td>
                            <td style="font-weight: <?php echo ($m->is_read ? '' : 'bold') ?>"><?php echo humanTiming($time) . ' ago'; ?></td>
                            <td></td>
                        </tr>

                        <?php
                    endforeach;

                    function humanTiming($time) {

                        $time = time() - $time; // to get the time since that moment
                        $time = ($time < 1) ? 1 : $time;
                        $tokens = array(
                            31536000 => 'year',
                            2592000 => 'month',
                            604800 => 'week',
                            86400 => 'day',
                            3600 => 'hour',
                            60 => 'minute',
                            1 => 'second'
                        );

                        foreach ($tokens as $unit => $text) {
                            if ($time < $unit)
                                continue;
                            $numberOfUnits = floor($time / $unit);
                            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type='text/javascript'>
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

</script>