<?php
$settings = Modules::run('main/getSet');
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $details['details']);

switch ($details['term']) {
    case 1:
        $grading = 'first';
        break;
    case 2:
        $grading = 'second';
        break;
    case 3:
        $grading = 'third';
        break;
    case 4:
        $grading = 'fourth';
        break;
}

$subjects = [];
$finalAssessment = 0;

foreach ($subject_ids as $s):
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $assessment = Modules::run(
        'gradingsystem/getPartialAssessment',
        base64_decode($details['st_id']),
        $details['section_id'],
        $s->sub_id,
        $details['year']
    );
    $gradeVal = $assessment->$grading;
    $finalAssessment += $gradeVal;

    $subjects[] = [
        'name'  => $singleSub->subject,
        'grade' => $gradeVal
    ];
endforeach;

if ($finalAssessment > 0):
    $avg = round($finalAssessment / count($subjects), 2);
?>

    <div class="card border-0 shadow-sm rounded-4">
        <!-- Header -->
        <div class="card-header bg-white border-0 pb-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0 text-primary">
                        <i class="bi bi-journal-text me-2"></i>Academic Performance
                    </h5>
                    <small class="text-muted">
                        <?php echo ucfirst($grading); ?> Grading Period
                    </small>
                </div>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6 rounded-pill">
                    Avg: <?php echo $avg; ?>
                </span>
            </div>
        </div>

        <div class="card-body pt-3">

            <!-- Summary Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light h-100">
                        <div class="text-muted small">Total Subjects</div>
                        <div class="fs-3 fw-bold text-dark">
                            <?php echo count($subjects); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light h-100">
                        <div class="text-muted small">Average Grade</div>
                        <div class="fs-3 fw-bold text-success">
                            <?php echo $avg; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light h-100">
                        <div class="text-muted small">Overall Status</div>
                        <div class="fs-5 fw-semibold <?php echo ($avg >= 75) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($avg >= 75) ? 'Passing' : 'Needs Improvement'; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Elegant Responsive Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border rounded-4 overflow-hidden">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-start ps-3">Subject</th>
                            <th style="width:120px;">Grade</th>
                            <th style="width:200px;">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $sub): ?>
                            <tr>
                                <td class="fw-semibold text-dark ps-3">
                                    <?php echo $sub['name']; ?>
                                </td>
                                <td class="text-center fw-bold">
                                    <span class="badge 
                                    <?php
                                    if ($sub['grade'] >= 90) echo 'bg-success';
                                    elseif ($sub['grade'] >= 85) echo 'bg-primary';
                                    elseif ($sub['grade'] >= 80) echo 'bg-info text-dark';
                                    elseif ($sub['grade'] >= 75) echo 'bg-warning text-dark';
                                    else echo 'bg-danger';
                                    ?> px-3 py-2 rounded-pill">
                                        <?php echo $sub['grade']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar 
                                        <?php
                                        if ($sub['grade'] >= 90) echo 'bg-success';
                                        elseif ($sub['grade'] >= 85) echo 'bg-primary';
                                        elseif ($sub['grade'] >= 80) echo 'bg-info';
                                        elseif ($sub['grade'] >= 75) echo 'bg-warning';
                                        else echo 'bg-danger';
                                        ?>"
                                            role="progressbar"
                                            style="width: <?php echo $sub['grade']; ?>%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="bi bi-folder-x text-warning" style="font-size: 3rem;"></i>
            </div>
            <h4 class="fw-bold mb-1">No Record Found</h4>
            <p class="text-muted mb-0">Grades for this grading period are not yet available.</p>
        </div>
    </div>
<?php endif; ?>