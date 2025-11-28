<input type="hidden" id="act_id" value="<?php echo $act_id; ?>" />
<input type="hidden" id="dept_id" value="<?php echo $dept_id; ?>" />
<div class="row">
    <div class="col-md-6" style="border: 1px solid #ccc">
        <div class="col-md-12 row">
            <div class="text-center">
                <a style="cursor: pointer" onclick="$('#focusonme').focus(); $('#focusonme').select()"><img class="img-fluid" id="profilePic" src="<?php echo site_url('images/icons/who.jpg'); ?>" style="height: 400px; width: 325px;"></a>
            </div>
            <div class="col-md-12" id="personalAtt">
                <h4>Name: -</h4>
                <h4>Grade: -</h4>
                <h4>Section: -</h4>
            </div>
            <div class="col-md-12">
                <h4 class="text-muted pull-right" id="curTime">--:-- --</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <th></th>
            <th class="text-center">
                In
            </th>
            <th class="text-center">
                Out
            </th>
            </thead>
            <tbody id="attlist_bod">
                <?php
                foreach ($att_list AS $at):
                    $prof = Modules::run('college/activity/getProfile', $at->st_id);
                    ?>
                    <tr>
                        <td>
                            <?php echo mb_strtoupper($prof->firstname . " " . $prof->lastname, 'UTF-8'); ?>
                        </td>
                        <td class="text-center">
                            <?php echo Date('h:i a', strtotime($at->act_in)); ?>
                        </td>
                        <td class="text-center">
                            <?php echo ($at->act_out != '') ? Date('h:i a', strtotime($at->act_out)) : "-"; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <div id="showAlert">
            <div class="alert alert-warning fade in" id="messageAlert" role="alert" style="display: none">
                <strong>Warning!</strong> <span id="alertContent"></span>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        reFocus();
        $("#overrideDept").val(<?php echo $dept_id; ?>);
        $("#overrideAct").val(<?php echo $act_id; ?>);
    })
</script>
