<?php

function getLetterGrade($value)
{
    if (!is_numeric($value) || $value < 0 || $value > 100) {
        return '';
    }

    if ($value <= 74) {
        return 'B';
    } elseif ($value <= 79) {
        return 'D';
    } elseif ($value <= 84) {
        return 'AP';
    } elseif ($value <= 89) {
        return 'P';
    } else {
        return 'A';
    }
}

function getRating($rate)
{
    switch ($rate) {
        case 1:
            return 'NO';
        case 2:
            return 'RO';
        case 3:
            return 'SO';
        case 4:
            return 'A0';
        default:
            return '';
    }
}
?>

<style>
    th,
    td {
        text-align: center;
        vertical-align: middle;
    }

    .card {
        margin-bottom: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background: linear-gradient(90deg, #007bff, #00c6ff);
        color: #fff;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .card-header img {
        border-radius: 50%;
        border: 2px solid #fff;
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    .student-details {
        margin-left: 1rem;
        font-size: 0.9rem;
        color: #f8f9fa;
    }

    .student-name {
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    .table th {
        background-color: #f1f3f5;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .clickable {
        font-size: 1.2rem;
        transition: transform 0.3s;
    }

    .collapsed i {
        transform: rotate(180deg);
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<script>
    $(document).on('click', '.card-header', function() {
        const $icon = $(this).find('i');
        $(this).next('.card-body').slideToggle();
        $icon.toggleClass('fa-angle-down fa-angle-up');
    });
</script>

<!-- <div class="text-right mb-3 no-print">
    <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
        <i class="fa fa-print"></i> Print All Class Cards
    </button>
</div> -->

<?php
foreach ($students as $student):
?>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="<?php echo base_url('uploads/students/' . $student->avatar); ?>" alt="Student Photo">
                <div class="student-details ml-3">
                    <div class="student-name"><?php echo strtoupper($student->firstname . ' ' . $student->lastname); ?></div>
                    <div><?php echo $student->level . ' - ' . $student->section; ?></div>
                    <div><?php echo $student->st_id; ?></div>
                </div>
            </div>
            <div class="clickable">
                <i class="fa fa-angle-down"></i>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>1Q</th>
                        <th>2Q</th>
                        <th>3Q</th>
                        <th>4Q</th>
                        <th>Final</th>
                        <th>Grade</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mp = 0;
                    $m1 = 0;
                    $m2 = 0;
                    $m3 = 0;
                    $m4 = 0;
                    foreach ($student->subjects as $subject):
                        $info = $subject['name'];
                        if ($info->parent_subject == 11):
                            $m1 += $subject['q1'];
                            $m2 += $subject['q2'];
                            $m3 += $subject['q3'];
                            $m4 += $subject['q4'];
                            $mp += 1;
                        endif;
                    endforeach;
                    $fmg1 = round($m1 / $mp);
                    $fmg2 = round($m2 / $mp);
                    $fmg3 = round($m3 / $mp);
                    $fmg4 = round($m4 / $mp);
                    $finmg = round(($fmg1 + $fmg2 + $fmg3 + $fmg4) / 4);
                    $finmg = ($finmg != 0 ? $finmg : '');
                    $fm = 0;

                    foreach ($student->subjects as $subject):
                        $info = $subject['name'];

                        $fg = round(($subject['q1'] + $subject['q2'] + $subject['q3'] + $subject['q4']) / 4);
                        $fg = ($fg != 0 ? $fg : '');

                        if ($info->parent_subject != 11):
                    ?>
                            <tr>
                                <td class="text-left"><?php echo $info->subject; ?></td>
                                <td><?php echo $subject['q1']; ?></td>
                                <td><?php echo $subject['q2']; ?></td>
                                <td><?php echo $subject['q3']; ?></td>
                                <td><?php echo $subject['q4']; ?></td>
                                <td><?php echo $fg; ?></td>
                                <td><?php echo getLetterGrade($fg); ?></td>
                                <td><?php echo ($fg != 0 ? ($fg >= 75 ? 'Passed' : 'Failed') : ''); ?></td>
                            </tr>
                            <?php
                        else:
                            $fm++;
                            if ($fm == 1):
                            ?>
                                <tr>
                                    <td class="text-left">MAPEH</td>
                                    <td><?php echo ($fmg1 != 0 ? $fmg1 : '') ?></td>
                                    <td><?php echo ($fmg2 != 0 ? $fmg2 : '') ?></td>
                                    <td><?php echo ($fmg3 != 0 ? $fmg3 : '') ?></td>
                                    <td><?php echo ($fmg4 != 0 ? $fmg4 : '') ?></td>
                                    <td><?php echo $finmg ?></td>
                                    <td><?php echo getLetterGrade($finmg); ?></td>
                                    <td><?php echo ($finmg != 0 ? ($finmg >= 75 ? 'Passed' : 'Failed') : ''); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info->subject; ?></td>
                                    <td><?php echo $subject['q1']; ?></td>
                                    <td><?php echo $subject['q2']; ?></td>
                                    <td><?php echo $subject['q3']; ?></td>
                                    <td><?php echo $subject['q4']; ?></td>
                                    <td><?php echo $fg; ?></td>
                                    <td><?php echo getLetterGrade($fg); ?></td>
                                    <td><?php echo ($fg != 0 ? ($fg >= 75 ? 'Passed' : 'Failed') : ''); ?></td>
                                </tr>
                            <?php
                            else:
                            ?>
                                <tr>
                                    <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info->subject; ?></td>
                                    <td><?php echo $subject['q1']; ?></td>
                                    <td><?php echo $subject['q2']; ?></td>
                                    <td><?php echo $subject['q3']; ?></td>
                                    <td><?php echo $subject['q4']; ?></td>
                                    <td><?php echo $fg; ?></td>
                                    <td><?php echo getLetterGrade($fg); ?></td>
                                    <td><?php echo ($fg != 0 ? ($fg >= 75 ? 'Passed' : 'Failed') : ''); ?></td>
                                </tr>
                    <?php
                            endif;
                        endif;
                    endforeach; ?>
                </tbody>
            </table>
            <table class="table table-bordered table-hover table-striped mb-0" style="margin-top: 30px;">
                <thead>
                    <tr>
                        <th colspan="5">Character Traits</th>
                    </tr>
                    <tr>
                        <th>Traits</th>
                        <th>1st Quarter</th>
                        <th>2nd Quarter</th>
                        <th>3rd Quarter</th>
                        <th>4th Quarter</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($student->core_val as $cv):
                    ?>
                        <tr>
                            <td><?php echo $cv['cv'] ?></td>
                            <td><?php echo getRating($cv['bh1']) ?></td>
                            <td><?php echo getRating($cv['bh2']) ?></td>
                            <td><?php echo getRating($cv['bh3']) ?></td>
                            <td><?php echo getRating($cv['bh4']) ?></td>
                        </tr>
                    <?php
                    endforeach
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach; ?>