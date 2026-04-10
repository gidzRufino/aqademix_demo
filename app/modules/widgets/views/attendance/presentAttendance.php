<?php
$present = $numberOfPresents->num_rows();
$total   = $numberOfStudents->num_rows();
$ratio   = ($total > 0) ? ($present / $total) : 0;

$cardColor = 'primary';
if ($ratio >= 0.9) {
    $cardColor = 'success';
} elseif ($ratio < 0.75) {
    $cardColor = 'warning';
}
?>

<div class="col-lg-6 col-12">
    <div class="card h-100 border-0 shadow-sm attendance-card modern-card">

        <!-- Body -->
        <div class="card-body p-4">

            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-start mb-3">

                <!-- Title -->
                <div>
                    <h6 class="fw-semibold mb-1 text-muted">
                        Attendance Today
                    </h6>

                    <div class="fs-2 fw-bold text-<?php echo $cardColor ?>">
                        <span
                            class="count-up"
                            data-count="<?php
                                echo (
                                    $numberOfPresents->num_rows() > $numberOfStudents->num_rows()
                                        ? $numberOfStudents->num_rows()
                                        : $numberOfPresents->num_rows()
                                );
                            ?>"
                        >0</span>
                        <span class="fs-6 text-muted">
                            / <?php echo $numberOfStudents->num_rows() ?>
                        </span>
                    </div>

                    <small class="text-muted">
                        Students Present
                    </small>
                </div>

                <!-- Date Pill -->
                <div class="text-center px-3 py-2 rounded-3 bg-light">
                    <i class="fa fa-calendar text-<?php echo $cardColor ?> mb-1"></i>
                    <div class="small fw-semibold">
                        <?php echo date('M') ?>
                    </div>
                    <div class="fs-5 fw-bold">
                        <?php echo date('d') ?>
                    </div>
                </div>

            </div>

            <!-- Progress Bar -->
            <?php
                $percentage = $numberOfStudents->num_rows() > 0
                    ? ($numberOfPresents->num_rows() / $numberOfStudents->num_rows()) * 100
                    : 0;
            ?>
            <div class="progress rounded-pill" style="height:6px;">
                <div
                    class="progress-bar bg-<?php echo $cardColor ?>"
                    role="progressbar"
                    style="width: <?php echo min(100, $percentage); ?>%;">
                </div>
            </div>

        </div>

        <!-- Footer Action -->
        <a href="<?php echo base_url().'attendance/dailyPerSubject' ?>" class="card-footer bg-white border-0 d-flex justify-content-between align-items-center text-decoration-none">
            <span class="fw-semibold text-<?php echo $cardColor ?>">
                View Attendance Details
            </span>
            <i class="fa fa-arrow-right text-<?php echo $cardColor ?>"></i>
        </a>

    </div>
</div>



<style>
.card {
    border-radius: 0.75rem;
}

.card-footer:hover {
    background: rgba(0,0,0,0.03);
}

.attendance-card {
    border-radius: 0.75rem;
}

.attendance-card .card-footer {
    background: #fff;
    transition: background 0.2s ease;
}

.attendance-card .card-footer:hover {
    background: rgba(0,0,0,0.04);
}

.attendance-card i {
    opacity: 0.9;
}

.modern-card {
    border-radius: 16px;
    transition: all 0.25s ease;
}

.modern-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.modern-card .card-footer {
    cursor: pointer;
}


</style>