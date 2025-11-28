<table class="table table-stripped">
    <tr>
        <th class="text-center">Code</th>
        <th class="text-center">Subject</th>
        <th class="text-center">Lecture Units</th>
        <th class="text-center">Lab Units</th>
        <th></th>
    </tr>
    <?php
        foreach ($subjects as $sub):
    ?>
    <tr>
        <td class="text-center"><?php echo $sub->sub_code ?></td>
        <td class="text-center"><?php echo $sub->s_desc_title ?></td>
        <td class="text-center"><?php echo $sub->s_lect_unit ?></td>
        <td class="text-center"><?php echo $sub->s_lab_unit ?></td>
    </tr>
    <?php
        endforeach;
    ?>
</table>