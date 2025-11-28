
<div class='panel panel-info' style='margin:0;'>
    <div class='panel-heading '>
        <?php echo ($action == 1?'Edit ' . $dept:'Delete ' . $dept) ?> Position
    </div>
    <input type='text' id='editOption' hidden=''/>
    <div class='panel-body'>
        <select id='positionList' onclick='newPosition($(&quot;option:selected&quot;).attr(&quot;data-id&quot;),this.value)'>
            <option>Select Position</option>
            <?php foreach ($position as $posDesc): ?>
                <option data-id='<?php echo $posDesc->position_id; ?>' value='<?php echo $posDesc->position; ?>'><?php echo $posDesc->position; ?></option>
            <?php endforeach; ?>
        </select><br/><br/>
        <input type='text' id='newPosition' name='newPosition' disabled='' />
        <input type='text' id='posID' hidden='' value=''/>
    </div>

    <div class='panel-footer clearfix'>
        <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
        <a href='#' data-dismiss='clickover' onclick='updatePosition(this.id)' id='<?php echo $action ?>' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'><?php echo($action==1?'Update':'Delete') ?></a>
    </div>         
</div>

<script type='text/javascript'>
    function newPosition(id,value) {
        $('#newPosition').attr('disabled', false);
        $('#newPosition').val(value);
        $('#posID').val(id);
    }

    function updatePosition(action) {
        var pid = $('#posID').val();
        var pDesc = $('#newPosition').val();
        var url = '<?php echo base_url() . 'hr/editDeptPosition/' ?>' + pid + '/' + pDesc + '/' + action;

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + pid,
            success: function (data) {
                alert(data);
                location.reload();
            },
            error: function (data) {
                alert('error');
            }
        });
    }
</script>
