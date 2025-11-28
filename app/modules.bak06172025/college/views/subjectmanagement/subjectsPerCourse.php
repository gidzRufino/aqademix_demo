<?php  foreach($collegeSubjects as $c): ?>
<tr id="<?php echo $c->s_id ?>_li">
    <td><?php echo $c->sub_code ?></td>
    <td><?php echo $c->s_desc_title ?></td>
    <td style="text-align: center"><?php echo $c->s_lect_unit ?></td>
    <td style="text-align: center"><?php echo $c->s_lab_unit ?></td>
    <td style="text-align: center"><?php echo $c->pre_req ?></td>
</tr>
<?php endforeach; ?>
