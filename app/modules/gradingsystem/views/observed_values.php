<?php
$isSub = 0;
foreach ($coreValues as $cv):
    $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
    if ($bStatements->num_rows() > 0):
        $isSub++;
    endif;
endforeach;
?>
<tr>
    <?php if ($isSub > 0): ?>
        <th style="width: 40%">Observed Values</th>
        <th >Behavioral Statements</th>
    <?php else: ?>
        <th>Observed Values</th>
    <?php endif; ?>
</tr>
<?php 
    foreach ($coreValues as $cv):
        $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id); ?>
        <tr>
            <td style="vertical-align: middle; text-align: left;" data-toggle="context" data-target="#editValues" onmouseover="$('#core_id').val('<?php echo $cv->core_id ?>'), $('#bStatement').text('<?php echo $cv->core_values ?>', $('#inputCore').val('<?php echo $cv->core_values ?>'))">
                <?php echo $cv->core_values; ?>
            </td>
            <?php if ($isSub > 0): ?>
                <td>
                    <ul>
                    <?php foreach ($bStatements->result() as $bs): ?>
                        <li data-toggle="context" data-target="#editBS" onmouseover="$('#bh_id').val('<?php echo $bs->bh_id ?>'), $('#addEditBS').text('Edit Behavioral Statement'), $('#inputBS').val('<?php echo $bs->bh_name; ?>')">
                            <?php echo $bs->bh_name; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </td>
            <?php endif; ?>
        </tr>                    
    <?php endforeach; ?>