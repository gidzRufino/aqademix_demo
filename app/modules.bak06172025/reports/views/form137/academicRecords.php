   
<button style="margin-top:15px;" id="genCardEnabled" onclick="printForm('<?php echo base64_encode($student->uid) ?>')" class="btn btn-small btn-success pull-right"><i class="fa fa-book fa-fw"></i> Generate Form  </button>

<table class="table table-striped table-bordered">
    <tr>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-4" rowspan="2">Subject</th>
        <th class="col-lg-4 text-center" colspan="4">Grading Periods</th>
        <th style="vertical-align: middle; text-align: center;" class="col-lg-2" rowspan="2">Final Rating</th>
    </tr>
    <tr>
        <th class="col-lg-1 text-center">1</th>
        <th class="col-lg-1 text-center">2</th>
        <th class="col-lg-1 text-center">3</th>
        <th class="col-lg-1 text-center">4</th>


    </tr>

    <?php
    // print_r($acadRecords);
    $count = 0;
    foreach ($acadRecords->result() as $ar):
        $count++;
        if ($ar->fourth != 0):
            $division = 4;
        else:
            if ($ar->third != 0):
                $division = 3;
            else:
                if ($ar->second != 0):
                    $division = 2;
                else:
                    $division = 1;
                endif;
            endif;
        endif;

        $ave = round(($ar->first + $ar->second + $ar->third + $ar->fourth) / $division, 2);
        if ($ave > 74):
            $AT = 'passed';
        else:
            $AT = 'failed';
        endif;
        if ($ar->subject == 'Citizen Army Training'):
            if ($ave > 0):
                $AT = 'passed';
            else:
                $AT = 'failed';
            endif;
            ?>
            <tr>
                <td class="col-lg-1 text-center"><?php echo $ar->subject ?></td>
                <td class="col-lg-1 text-center"><?php
                    if ($ar->first > 0): echo 'taken';
                    endif;
                    ?></td>
                <td class="col-lg-1 text-center"><?php
                    if ($ar->second > 0): echo 'taken';
                    endif;
                    ?></td>
                <td class="col-lg-1 text-center"><?php
                    if ($ar->third > 0): echo 'taken';
                    endif;
                    ?></td>
                <td class="col-lg-1 text-center"><?php
                    if ($ar->fourth > 0): echo 'taken';
                    endif;
                    ?></td>

                <th class="col-lg-1  text-center"><?php echo $ave ?></th>
                <th class="col-lg-1  text-center"><?php echo $AT ?></th>
            </tr>
            <?php
        else:
            ?>
            <tr>
                <?php if ($ar->parent_subject == 11): ?>
                    <td class="col-lg-1">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ar->subject ?></td>
                    <td class="col-lg-1"><?php echo $ar->first ?></td>
                    <td class="col-lg-1"><?php echo $ar->second ?></td>
                    <td class="col-lg-1"><?php echo $ar->third ?></td>
                    <td class="col-lg-1"><?php echo $ar->fourth ?></td>
                    <?php $mapehAve = ($ar->first + $ar->second + $ar->third + $ar->fourth) / 4 ?>
                    <th class="col-lg-1"><?php echo $mapehAve ?></th>
                <?php else: ?>
                    <td class="col-lg-1"><?php echo $ar->subject ?></td>
                    <td class="col-lg-1"><?php echo $ar->first ?></td>
                    <td class="col-lg-1"><?php echo $ar->second ?></td>
                    <td class="col-lg-1"><?php echo $ar->third ?></td>
                    <td class="col-lg-1"><?php echo $ar->fourth ?></td>
                    <th class="col-lg-1"><?php echo $ar->avg ?></th>
                <?php endif; ?>
            </tr>
        <?php
        endif;

    endforeach;
    ?>


</table>
<input type="hidden" id="getSPR" value="<?php echo $acadRecords->row()->spr_id; ?>" />
<input type="hidden" id="spr_status" value="<?php echo $acadRecords->row()->go_to_next_level; ?>" />