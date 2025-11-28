<?php

function getRating($behaviorRating)
{
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
        default:
            $star = '';
            break;
    }
    return $star;
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="6">
                Character Traits
            </th>
        </tr>
        <tr>
            <th>Core Values</th>
            <th>Details</th>
            <th>1st</th>
            <th>2nd</th>
            <th>3rd</th>
            <th>4th</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $td = 1;
        $bg = 0;
        $coreVal = Modules::run('reports/getCoreValues');
        $bhrate = Modules::run('reports/getBhGroup', 2, NULL, NULL);
        foreach ($bhrate as $b):
            $rate1 = Modules::run('gradingsystem/getBHRating', $st_id, 1, $sy, $b->bh_id);
            $rate2 = Modules::run('gradingsystem/getBHRating', $st_id, 2, $sy, $b->bh_id);
            $rate3 = Modules::run('gradingsystem/getBHRating', $st_id, 3, $sy, $b->bh_id);
            $rate4 = Modules::run('gradingsystem/getBHRating', $st_id, 4, $sy, $b->bh_id);
            switch ($b->bh_group):
                case 1:
                    $core = 'MAKA DIYOS';
                    $rs = 1;
                    break;
                case 2:
                    $core = 'MAKA TAO';
                    $rs = 1;
                    break;
                case 3:
                    $core = 'MAKA KALIKASAN';
                    $rs = 1;
                    break;
                case 4:
                    $core = 'MAKA BANSA';
                    $rs = 2;
                    break;
            endswitch;

            if ($rs == 2):
                if ($td == 1):
        ?>
                    <tr>
                        <td rowspan="2" style="vertical-align: middle; text-align:left"><?php echo $core ?></td>
                        <td style="vertical-align: middle; text-align:left"><?php echo $b->bh_name ?></td>
                        <td>
                            <?php echo $rate1->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate2->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate3->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate4->row()->rate ?>
                        </td>
                    </tr>
                <?php
                    $td--;
                else:
                ?>
                    <tr>
                        <td style="vertical-align: middle; text-align:left"><?php echo $b->bh_name ?></td>
                        <td>
                            <?php echo $rate1->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate2->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate3->row()->rate ?>
                        </td>
                        <td>
                            <?php echo $rate4->row()->rate ?>
                        </td>
                    </tr>
                <?php
                endif;
                $bg++;
                if ($bg == 2):
                    $td = 1;
                    $bg = 0;
                endif;
            else:
                ?>
                <tr>
                    <td style="vertical-align: middle; text-align:left"><?php echo $core ?></td>
                    <td style="vertical-align: middle; text-align:left"><?php echo $b->bh_name ?></td>
                    <td>
                        <?php echo $rate1->row()->rate ?>
                    </td>
                    <td>
                        <?php echo $rate2->row()->rate ?>
                    </td>
                    <td>
                        <?php echo $rate3->row()->rate ?>
                    </td>
                    <td>
                        <?php echo $rate4->row()->rate ?>
                    </td>
                </tr>
        <?php
            endif;
        endforeach;
        ?>
    </tbody>
</table>