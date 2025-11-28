<h3 style="text-align: center; margin-top: 10px">Attendance Present</h3><br>
<table class="table table-stripped">
    <tr>
        <th>Name</th>
        <?php
        for ($i = 6; $i <= 16; $i++):
            if ($i > 12):
                $m = $i - 12;
            else:
                $m = $i;
            endif;
            ?>
            <th><?php echo date('F', strtotime(date('Y-' . $m . '-01'))); ?></th>
        <?php endfor; ?>
        <th style="text-align: center">Action</th>
    </tr>
    <?php
    $cnt = 0;
    foreach ($students->result() as $s):
        $cnt++;
        if ($s->st_id != "" && $s->lastname != ""):
            ?>
            <tr id="<?php echo $cnt; ?>" stdnt="<?php echo $s->st_id ?>" sprid ="<?php echo $s->spr_id ?>">
                <td><?php echo strtoupper($s->firstname) . ' ' . strtoupper($s->lastname); ?></td>
                <td><?php echo $s->June ?></td>
                <td><?php echo $s->July ?></td>
                <td><?php echo $s->August ?></td>
                <td><?php echo $s->September ?></td>
                <td><?php echo $s->October ?></td>
                <td><?php echo $s->November ?></td>
                <td><?php echo $s->December ?></td>
                <td><?php echo $s->January ?></td>
                <td><?php echo $s->February ?></td>
                <td><?php echo $s->March ?></td>
                <td><?php echo $s->April ?></td>
                <td style="text-align: center">
                    <i class="fa fa-pencil-square-o" style="cursor: pointer" id="<?php echo $s->spr_id ?>" data-toggle="modal" data-target="#editNumDays"
                       onclick="
                                       $('#eJun').val('<?php echo $s->June ?>'),
                                       $('#eJul').val('<?php echo $s->July ?>'),
                                               $('#eAug').val('<?php echo $s->August ?>'),
                                               $('#eSept').val('<?php echo $s->September ?>'),
                                               $('#eOct').val('<?php echo $s->October ?>'),
                                               $('#eNov').val('<?php echo $s->November ?>'),
                                               $('#eDec').val('<?php echo $s->December ?>'),
                                               $('#eJan').val('<?php echo $s->January ?>'),
                                               $('#eFeb').val('<?php echo $s->February ?>'),
                                               $('#eMar').val('<?php echo $s->March ?>'),
                                               $('#eApr').val('<?php echo $s->April ?>'),
                                               $('#sprid').val(this.id),
                                               $('#stName').text('<?php echo $s->firstname . ' ' . $s->lastname?>');
                       ">
                    </i>
                </td>
            </tr>
            <?php
        endif;
    endforeach;
    ?>
</table>
<div id="editNumDays" class="modal fade">
    <?php
    $attributes = array('id' => 'updateSPR');
    echo form_open(base_url() . 'attendance/attendance_reports/updateSPR', $attributes);
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Update Days Present</h3><br/>
                <h4 id="stName"></h4>
            </div>
            <div class="modal-body">
                <label class="form-label">June:</label>
                <input type="text" class="form-group" id="eJul" name="eJune" /><br/>
                <label class="form-label">July:</label>
                <input type="text" class="form-group" id="eJul" name="eJul" /><br/>
                <label class="form-label">August:</label>
                <input type="text" class="form-group" id="eAug" name="eAug" /><br/>
                <label class="form-label">September:</label>
                <input type="text" class="form-group" id="eSept" name="eSept" /><br/>
                <label class="form-label">October:</label>
                <input type="text" class="form-group" id="eOct" name="eOct" /><br/>
                <label class="form-label">November:</label>
                <input type="text" class="form-group" id="eNov" name="eNov" /><br/>
                <label class="form-label">December:</label>
                <input type="text" class="form-group" id="eDec" name="eDec" /><br/>
                <label class="form-label">January:</label>
                <input type="text" class="form-group" id="eJan" name="eJan" /><br/>
                <label class="form-label">February:</label>
                <input type="text" class="form-group" id="eFeb" name="eFeb" /><br/>
                <label class="form-label">March:</label>
                <input type="text" class="form-group" id="eMar" name="eMar" /><br/>
                <label class="form-label">April:</label>
                <input type="text" class="form-group" id="eApr" name="eApr" />
            </div>
            <div class="modal-footer">
                <input type="hidden" id="sprid" name="sprid" />
                <input type="hidden" id="tbleName" name="tbleName" value="gs_spr_attendance" />
                <button type="button" class="btn btn-success" data-dismiss="modal" id="updateDays" onclick="updateNumDays()">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <?php form_close(); ?>
</div>
<input type="hidden" id="totalStudents" value="<?php echo $students->num_rows() ?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<input type="hidden" id="date_m" value="<?php echo (date('n') < 7 ? date('n') + 12 : date('n')) ?>" />
<script type="text/javascript">
    $(document).ready(function () {
        var month = $('#inputMonth').val();

        //getNext(1,month, month)

    });

    var records = 0;

    function getNext(id, month, m)
    {
        var stid = $('#' + id).attr('stdnt');
        var sprid = $('#' + id).attr('sprid');
        var school_year = $('#school_year').val();

        if (id <= $('#totalStudents').val()) {

            id = id + 1;

            if (m > 12)
            {
                var year = parseInt(school_year) + 1;
            } else {
                year = school_year;
            }

            getIndividualMonthlyAttedance(stid, month, year, school_year, id, m, sprid);

        }
    }


    function getIndividualMonthlyAttedance(st_id, month, year, school_year, id, m, sprid)
    {
        if (month > 12) {
            month = month - 12;
        }
        records = records + 1;
        var url = '<?php echo base_url('attendance/attendance_reports/getIndividualMonthlyAttedance/') ?>' + st_id + '/' + month + '/' + year + '/' + school_year + '/' + sprid;
        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching ' + records + ' records...');
                $('#td_' + st_id + '_' + month).html('<i class="fa fa-spinner fa-spin "></i>')
            },
            success: function (data)
            {

                $('#td_' + st_id + '_' + month).text(data);

                if (m <= parseInt($('#date_m').val()))
                {

                    if (id > $('#totalStudents').val())
                    {
                        month = parseInt(month) + 1;
                        getNext(1, month, month);
                    } else {
                        getNext(id, month, m);
                    }
                } else {
                    $('#message').html('Successfully Fetched');
                }

            }
        });

        return false;
    }

    function updateNumDays() {
        var url = '<?php echo base_url() . 'attendance/attendance_reports/updateSPR' ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data: $('#updateSPR').serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function () {
                alert('Successfully Updated');
                location.reload();
            },
            error: function () {
                alert('an error occured');
            }
        });
    }
</script>