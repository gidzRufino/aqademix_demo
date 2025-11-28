<?php
$settings = $this->eskwela->getSet();

$db_name = 'csscore_eskwela_' . strtolower($settings->short_name) . '_' . $school_year;
?>
<div class="col-md-12">
    <table class="table table-bordered">
        <tr>
            <th style="text-align: center" colspan="7">Grade <?php echo ($grade_id - 1) ?>
                <div id="rCheck<?php echo $grade_id ?>" class="h-25 d-inline-block pull-right" style="height: 10px" hidden=""><img style="width: 15px; height: 15px" src="<?php // echo base_url() . 'images/icons/loading.gif' ?>" /> Please wait...</div>
                <a class="btn btn-xs btn-primary pull-right" id="btn<?php echo $grade_id ?>" onclick="fetchRec('<?php echo $grade_id ?>', '<?php echo $school_year ?>', '#rCheck<?php echo $grade_id ?>', '#msgRec<?php echo $grade_id ?>', '#' + this.id, '#addRec<?php echo $grade_id ?>', $(this).hide(), $('#sySelected').val('<?php echo $school_year ?>'), $('#dbExist').val('<?php echo $dbExist ?>'))">Fetch Record <i class="fa fa-database fa-sm pointer"></i></a>
            </th>
        </tr>
        <tr>
            <td>
                <h5 style="color: red; text-align: center" id="msgRec<?php echo $grade_id ?>">No Records Found!!!</h5>
                <br>
                <div class="col-lg-12" hidden="" id="addRec<?php echo $grade_id ?>">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <button onclick="$('#createnew').modal('show'), $('#levelSelected').val('<?php echo $grade_id ?>')" class="btn btn-sm btn-success btn-block">Create New Record</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
