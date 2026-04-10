<?php foreach ($subjects as $s): ?>
    <tr id="tr_<?php echo $s->subject_id ?>">

        <td><?php echo $s->subject_id; ?></td>

        <td id="td_<?php echo $s->subject_id; ?>" class="fw-semibold">
            <?php echo $s->subject ?>
        </td>

        <td>
            <span class="badge bg-light text-dark border">
                <?php echo $s->short_code ?>
            </span>
        </td>

        <td class="text-center">
            <input type="checkbox"
                onclick="makeCore('<?php echo $s->subject_id; ?>')"
                <?php if ($s->is_core) echo "checked"; ?>>
        </td>

        <td class="text-end">
            <button onclick="showModal('<?php echo addslashes($s->subject) ?>','<?php echo $s->subject_id ?>','<?php echo addslashes($s->short_code) ?>')"
                class="btn btn-sm btn-outline-primary">
                <i class="fa fa-pen"></i>
            </button>

            <button onclick="deleteModal('<?php echo $s->subject ?>','<?php echo $s->subject_id ?>','0')"
                class="btn btn-sm btn-outline-danger">
                <i class="fa fa-trash"></i>
            </button>
        </td>

    </tr>
<?php endforeach; ?>