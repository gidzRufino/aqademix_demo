<div class="col-md-12" id="listReq">
    <?php foreach ($list as $s): ?>
        <ul>
            <li>
                <span class="pull-left" id="span_eReqDesc"><?php echo $s->eReq_desc; ?></span>
                <span class="pull-right">
                    <i id="editReq" class="fa fa-edit" style="cursor: pointer; color: green" data-toggle="modal" data-target="#editEnReq" onclick="$('#editReqDesc').val('<?php echo $s->eReq_desc; ?>', $('#eReqID').val('<?php echo $s->eReq_list_id ?>'))"></i>&nbsp;|&nbsp;
                    <i id="deleteReq" class="fa fa-trash" style="cursor: pointer; color: red" onclick="deleteReq('<?php echo $s->eReq_list_id ?>', 2)"></i>
                </span>
            </li>
        </ul>
    <?php endforeach; ?>
</div>



<script type="text/javascript">
    $(function () {
        function checkUpdateList() {
            var url = '<?php echo base_url() . 'main/getAllEnrollmentReq' ?>';
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $('#listReq').html(data);
                }
            });
        }

        //setInterval(checkUpdateList, 1000);
    });
</script>