<table class="table table-stripped">
    <tr>
        <th class="text-center">Code</th>
        <th class="text-center">Subject</th>
        <th class="text-center">Lecture Units</th>
        <th class="text-center">Lab Units</th>
        <th class="text-center"></th>
        <th></th>
    </tr>
    <?php
        $totalUnitsLec = 0;
        $totalUnitsLab = 0;
        if(!empty($subjects))
        
        foreach ($subjects as $sub):
    ?>
    <tr id="tr_<?php echo $sub->spc_id?>">
        <td class="text-center"><?php echo $sub->sub_code ?></td>
        <td class="text-center"><?php echo $sub->s_desc_title ?></td>
        <td class="text-center"><?php echo $sub->s_lect_unit ?></td>
        <td class="text-center"><?php echo $sub->s_lab_unit ?></td>
        <td class="text-center"><button onclick="removeSubjectFromCourse('<?php echo $sub->spc_id ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
    </tr>
    <?php
        $totalUnitsLec += $sub->s_lect_unit;
        $totalUnitsLab += $sub->s_lab_unit;
        endforeach;
    ?>
    <tr>
        <td colspan="2"></td>
        <td class="text-center" style="font-weight: bold;"><?php echo (!empty($subjects)?$totalUnitsLec:"") ?></td>
        <td class="text-center" style="font-weight: bold;"><?php echo (!empty($subjects)?$totalUnitsLab:"") ?></td>
    </tr>
</table>