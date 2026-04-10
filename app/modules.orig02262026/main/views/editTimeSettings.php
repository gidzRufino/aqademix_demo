<div id='addressInfo'>
    <div class='panel panel-info' style='margin:0;'>
        <div class='panel-heading '>
            Edit <?php echo $section ?> Time Settings
        </div>
        <input type='text' id='editOption' value='<?php echo $optionToEdit ?>' hidden='' />
        <div class='panel-body'>
            <div class='form-group'>
                <label class='control-label'>Time In [ AM ]</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='time' value='<?php echo $timeInAM ?>' placeholder='<?php echo $timeInAM ?>' id='inAM' />
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>Time Out [ AM ]</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='time' value='<?php echo $timeOutAM ?>' placeholder='<?php echo $timeOutAM ?>' id='outAM' />
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>Time In [ PM ]</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='time' value='<?php echo $timeInPM ?>' placeholder='<?php echo $timeInPM ?>' id='inPM' />
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>Time Out [ PM ]</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='time' value='<?php echo $timeOutPM ?>' placeholder='<?php echo $timeOutPM ?>' id='outPM' />
                </div>

            </div>
        </div>

        <div class='panel-footer clearfix'>
            <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='clickover' onclick='editTimeSettings(<?php echo $sectionID ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
        </div>
    </div>
</div>
<script type='text/javascript'>
    function editTimeSettings(id) {
        var option = $('#editOption').val();
        var inAM = $('#inAM').val();
        var outAM = $('#outAM').val();
        var inPM = $('#inPM').val();
        var outPM = $('#outPM').val();
        var url = '<?php echo base_url() . 'main/editTimeSettings/' ?>' + inAM + '/' + outAM + '/' + inPM + '/' + outPM + '/' + id + '/' + option;
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            data: 'id=' + id,
            success: function(data) {
                if (data.status) {
                    $('#' + id + '_ami').text(inAM);
                    $('#' + id + '_amo').text(outAM);
                    $('#' + id + '_pmi').text(inPM);
                    $('#' + id + '_pmo').text(outPM);
                } else {
                    alert(data.msg);
                }
            },
            error: function(data) {
                alert('error');
            }
        });
    }
</script>