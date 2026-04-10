<?php foreach($subjects as $s): ?>
    <tr id='tr_<?php echo $s->subject_id ?>'>
        <td><?php echo $s->subject_id; ?></td>
        <td id="td_<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></td>
        <td><?php echo $s->short_code ?></td>
        <td>
            <button onclick="showModal('<?php echo addslashes($s->subject) ?>','<?php echo $s->subject_id ?>','<?php echo addslashes($s->short_code) ?>')" class="btn btn-xs btn-warning pull-right"><i class="fa fa-edit fa-fw"></i></button>
            <button onclick="deleteModal('<?php echo $s->subject ?>','<?php echo $s->subject_id ?>')" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash fa-fw"></i></button>

        </td>
        <td style="text-align: center"><input onclick="makeCore('<?php echo $s->subject_id; ?>')" type="checkbox" <?php if($s->is_core) echo "checked='checked'" ?> /></td>
    </tr>
<?php endforeach;   