<?php
$student = $details['student'];
$subject_teacher = Modules::run('academic/getSubjectTeacher', $details['subject_id'], $student->section_id, $details['school_year']);

if ($details['subject_id'] == 6 || $details['subject_id'] == 10):
    $sub_id = $details['subject_id'];
else:
    $sub_id = '0';
endif;

$teachersAssessment = Modules::run(
    'gradingsystem/getAssessmentPerTeacher',
    $subject_teacher->faculty_id,
    $student->section_id,
    $details['subject_id'],
    '',
    $details['term'],
    $details['school_year']
);
?>

<div class="row g-4">
    <!-- Graph Card -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-bold mb-0 text-primary">
                    <i class="fa fa-chart-line me-2"></i>Assessment Performance Trend
                </h5>
                <small class="text-muted">
                    Visual representation of student's assessment progress
                </small>
            </div>
            <div class="card-body">
                <div id="graph" style="height:350px;"></div>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-bold mb-0 text-secondary">
                    <i class="fa fa-table me-2"></i>Assessment Details
                </h5>
                <small class="text-muted">
                    Raw scores per assessment activity
                </small>
            </div>

            <div class="card-body pt-2">
                <div class="table-responsive" style="max-height:300px;">
                    <table id="graph_details" class="table table-hover align-middle mb-0">
                        <thead class="table-light text-center sticky-top">
                            <tr>
                                <th><i class="fa fa-calendar-alt me-1"></i>Date</th>
                                <th class="text-start"><i class="fa fa-book me-1"></i>Title</th>
                                <th><i class="fa fa-star me-1"></i>Raw Score</th>
                                <th><i class="fa fa-list-ol me-1"></i>No. Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($teachersAssessment->result() as $IABS) {
                                $rawScore = Modules::run('gradingsystem/getRawScore', $student->st_id, $IABS->assess_id);
                                $percent = ($rawScore->row()->raw_score / $IABS->no_items) * 100;
                            ?>
                                <tr>
                                    <td class="text-center small text-muted">
                                        <?php echo $IABS->assess_date ?>
                                    </td>
                                    <td class="fw-semibold">
                                        <?php echo $IABS->assess_title ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge 
                                            <?php
                                            if ($percent >= 90) echo 'bg-success';
                                            elseif ($percent >= 85) echo 'bg-primary';
                                            elseif ($percent >= 80) echo 'bg-info text-dark';
                                            elseif ($percent >= 75) echo 'bg-warning text-dark';
                                            else echo 'bg-danger';
                                            ?> px-3 py-2">
                                            <?php echo $rawScore->row()->raw_score ?>
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">
                                        <?php echo $IABS->no_items ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function basic(container) {

        var d1 = [
            [0, 0],
            <?php
            $i = 0;
            foreach ($teachersAssessment->result() as $IABS) {
                $i++;
                $rawScore = Modules::run('gradingsystem/getRawScore', $student->st_id, $IABS->assess_id);
                $res = ($rawScore->row()->raw_score / $IABS->no_items) * 100;
                echo '[' . $i . ',' . $res . ']';
                if ($i < $teachersAssessment->num_rows()):
                    echo ',';
                endif;
            }
            ?>
        ];

        Flotr.draw(container, [{
            data: d1,
            lines: {
                show: true,
                fill: true
            },
            points: {
                show: true
            }
        }], {
            fontSize: 11,
            xaxis: {
                ticks: [
                    <?php
                    $i = 0;
                    foreach ($teachersAssessment->result() as $IABS) {
                        $i++;
                        echo '[' . $i . ',\'' . $IABS->assess_date . '\']';
                        if ($i < $teachersAssessment->num_rows()):
                            echo ',';
                        endif;
                    }
                    ?>
                ],
                labelsAngle: 45,
                title: 'Assessment Taken'
            },
            yaxis: {
                title: 'Percentage',
                max: 100
            },
            grid: {
                minorVerticalLines: true,
                backgroundColor: '#fff'
            },
            HtmlText: false
        });

    })(document.getElementById("graph"));
</script>