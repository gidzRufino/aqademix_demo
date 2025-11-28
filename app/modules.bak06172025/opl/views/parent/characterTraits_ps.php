<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="5">
                Character Traits
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $coreVal = Modules::run('reports/getCoreValues');
        foreach ($coreVal as $cv):
            $bhRate = Modules::run('reports/getBhGroup', 2, $cv->core_id, 1);
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
                <tr><td colspan="5"></td></tr>
        <tr>
            <th colspan="5">
                Language, Literacy and Communication
            </th>
        </tr>
        <?php
        $preSchoolSubj = Modules::run('customize/getPreSchoolSubj');
        foreach ($preSchoolSubj as $s):
            ?>
            <tr>
                <td style="text-align: left; font-weight: bold">
                    <?php echo $s->subj_name ?>
                </td>
                <td style="font-weight: bold">Q1</td>
                <td style="font-weight: bold">Q2</td>
                <td style="font-weight: bold">Q3</td>
                <td style="font-weight: bold">Q4</td>
            </tr>
            <?php
            $subj_details = Modules::run('customize/getSubjDetails', $s->id);

            foreach ($subj_details as $sd):
                $first = Modules::run('customize/getLLCrate', $st_id, $sd->id, 1, $sy);
                $second = Modules::run('customize/getLLCrate', $st_id, $sd->id, 2, $sy);
                $third = Modules::run('customize/getLLCrate', $st_id, $sd->id, 3, $sy);
                $fourth = Modules::run('customize/getLLCrate', $st_id, $sd->id, 4, $sy);
                ?>
                <tr>
                    <td style="text-align: left"><?php echo $sd->details ?></td>
                    <td><?php echo $first->rate ?></td>
                    <td><?php echo $second->rate ?></td>
                    <td><?php echo $third->rate ?></td>
                    <td><?php echo $fourth->rate ?></td>
                </tr>
                <?php
            endforeach;
        endforeach;
        ?>
    </tbody>
</table>