<?php

function getRating($behaviorRating) {
    $rate = $behaviorRating->row()->rate;
    switch ($rate) {
        case 1:
            $star = 'NO';
            break;
        case 2:
            $star = 'RO';
            break;
        case 3:
            $star = 'SO';
            break;
        case 4:
            $star = 'A0';
            break;
        default :
            $star = '';
            break;
    }
    return $star;
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="5">
                Character Traits
            </th>
        </tr>
        <?php if ($dept_code == 11): ?>
            <tr>
                <th colspan="5">
                    Language, Literacy and Communication
                </th>
            </tr>
        <?php endif; ?>
    </thead>
    <tbody>
        <?php
        $coreVal = Modules::run('reports/getCoreValues');
        foreach ($coreVal as $cv):
            $bhRate = Modules::run('reports/getBhGroup', 2, $cv->core_id, 12);
            ?>
            <tr>
                <td style="text-align: center; font-weight: bold">
                    <?php echo $cv->core_values ?>
                </td>
                <td style="font-weight: bold">Q1</td>
                <td style="font-weight: bold">Q2</td>
                <td style="font-weight: bold">Q3</td>
                <td style="font-weight: bold">Q4</td>
            </tr>
            <?php
            foreach ($bhRate as $bh):
                $bhRate1 = Modules::run('gradingsystem/getBHRating', $st_id, 1, $sy, $bh->bh_id);
                $bhRate2 = Modules::run('gradingsystem/getBHRating', $st_id, 2, $sy, $bh->bh_id);
                $bhRate3 = Modules::run('gradingsystem/getBHRating', $st_id, 3, $sy, $bh->bh_id);
                $bhRate4 = Modules::run('gradingsystem/getBHRating', $st_id, 4, $sy, $bh->bh_id);
                ?>
                <tr>
                    <td style="text-align: left">
                        <?php echo $bh->bh_name ?>
                    </td>
                    <td><?php echo getRating($bhRate1) ?></td>
                    <td><?php echo getRating($bhRate2) ?></td>
                    <td><?php echo getRating($bhRate3) ?></td>
                    <td><?php echo getRating($bhRate4) ?></td>
                </tr>
                <?php
            endforeach;
        endforeach;
        ?>
    </tbody>
</table>