<?php
foreach ($collegeSubjects->result() as $c):
    $subs = Modules::run('college/subjectmanagement/getSubjectsOffered', $c->s_id, $school_year);
    ?>
    <tr id="<?php echo $c->s_id ?>_li">
        <td><?php echo $c->sub_code ?></td>
        <td><?php echo $c->s_desc_title ?></td>
        <td style="text-align: center"><?php echo $c->s_lect_unit ?></td>
        <td style="text-align: center"><?php echo $c->s_lab_unit ?></td>
        <td style="text-align: center"><?php echo $c->pre_req ?></td>
        <td style="text-align: center" class="pointer">
            <button  onclick="getAdd('Section'), selectSubject('<?php echo $c->s_id ?>', '<?php echo $c->sub_code ?>')" class="btn btn-info btn-xs">
    <?php echo ($subs->num_rows() > 0 ? $subs->num_rows() : 0) ?>
            </button>
        </td>
        <td style="text-align: center" class="pointer">
            <div class="btn-group" role="group">
                <button onclick="editSubject('<?php echo $c->s_id ?>', '<?php echo $c->sub_code ?>', &quot;<?php echo $c->s_desc_title ?> &quot;, '<?php echo $c->s_lect_unit ?>', '<?php echo $c->s_lab_unit ?>', '<?php echo $c->pre_req ?>')" title="Edit Subject" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square"></i></button>
                <button onclick="deleteSubject('<?php echo $c->s_id ?>')" title="Delete Subject" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
            </div>
        </td>
    </tr>
<?php
endforeach;
