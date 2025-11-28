<?php echo Modules::run('academic/viewCollegeTeacherInfo', $id, $school_year); ?>
<div class='col-lg-12 no-padding'>
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h5 class="text-center no-margin col-lg-7">Subjects Assigned</h5>
        </div>
        <div class="panel-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Section Code</th>
                        <th>Descriptive Title</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php
                $totalUnits = 0;
                $u = 0;
                //print_r($subjects);
                foreach ($subjects as $s):
                    $totalUnits += $s->s_lect_unit;
                    $u++;
                    ?>
                    <tr id="tr_<?php echo $s->sched_gcode ?>">
                        <td><?php echo $s->sub_code; ?></td>
                        <td><?php echo $s->section; ?></td>
                        <td><?php echo $s->s_desc_title; ?></td>
                        <?php
                        switch ($s->is_gs_lock):
                            case 1:
                                $value = 0;
                                $text = 'LOCKED';
                                $fa = 'fa fa-lock';
                                $color = 'red';
                                break;
                            case 0:
                                $value = 1;
                                $text = 'OPEN';
                                $fa = 'fa fa-unlock-alt';
                                $color = 'green';
                                break;
                        endswitch;
                        ?>
                    <input type="hidden" id="lockVal-<?php echo $u ?>" value="<?php echo ($s->is_gs_lock ? 0 : 1) ?>">
                    <td class="text-center pointer" id="td-<?php echo $u ?>" onclick="subjUnlock($('#lockVal-<?php echo $u ?>').val(), '<?php echo $s->s_id ?>', '<?php echo $s->sec_id ?>', '<?php echo base64_encode($s->section) ?>', '<?php echo $school_year ?>', '<?php echo $u ?>')">
                        <i class="<?php echo $fa ?>" aria-hidden='true' style="color: <?php echo $color ?>">&nbsp;<?php echo $text ?></i>
                    </td>
                    </tr>
                    <?php
                endforeach;
                if ($totalUnits > 0):
                    ?>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('regModal') ?>

<script type="text/javascript">


    function removeSubject(id, school_year)
    {
        var teacher = $('#teacher_id').val();
        r = confirm('Are you sure you want to remove subject Assigned?');
        if (r == true) {
            var url = "<?php echo base_url() . 'college/deleteFacultyAssignment/' ?>" + id + '/' + school_year;
            $.ajax({
                type: "GET",
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
                dataType: 'json',
                success: function (data)
                {
                    if (data.status) {
                        $('#subjectsAssignedTable').html(data.data);
                        alert('Successfully Removed');
                        $('#tr_' + id).remove();

                    }
                    $('#notify_me').show();
                    $('#notify_me').fadeOut(5000);
                }
            });

            return false;
        }

    }

</script>