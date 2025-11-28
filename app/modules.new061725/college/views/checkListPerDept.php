<?php
$checkList = Modules::run('main/displayCheckListPerDept', $level);
foreach ($checkList as $c):
    $ifCheck = Modules::run('registrar/getCheckList', base64_encode($stid), $c->eReq_id);
    ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="box_<?php echo $c->eReq_id ?>" value="<?php echo $c->eReq_id ?>" onclick="checkItem('<?php echo $c->eReq_id ?>', '<?php echo base64_encode($stid) ?>')" <?php echo ($ifCheck == 1 ? 'checked' : '') ?>>
        <label class="custom-control-label" for="<?php echo $c->eReq_id ?>"><?php echo $c->eReq_desc ?></label>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    function checkItem(id, stid) {
        if ($('#box_' + id).is(':checked')) {
            var opt = 1;
        } else {
            var opt = 0;
        }

        var url = '<?php echo base_url() . 'registrar/checkItem/' ?>' + id + '/' + stid + '/' + opt;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {

            }
        });
    }
</script>