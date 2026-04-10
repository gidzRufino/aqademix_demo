<div class="col-xl-6 col-lg-6 col-12">
    <div class="card modern-card h-100">

        <!-- Card Body -->
        <div class="card-body p-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-start mb-4">

                <!-- Stats -->
                <div>
                    <h6 class="text-muted fw-semibold mb-1">
                        Employees Attendance
                    </h6>

                    <div class="d-flex align-items-end gap-2">
                        <div class="fs-2 fw-bold text-info">
                            <span
                                class="count-up"
                                data-count="<?php echo min(
                                    $numberOfPresents->num_rows(),
                                    $numberOfStudents->num_rows()
                                ); ?>"
                            >0</span>
                        </div>

                        <div class="text-muted mb-1">
                            / <?php echo $numberOfStudents->num_rows() ?>
                        </div>
                    </div>

                    <small class="text-muted">
                        Employees Present
                    </small>
                </div>

                <!-- Icon Pill -->
                <div class="date-pill text-center">
                    <i class="fa fa-user-check text-info fs-5"></i>
                </div>

            </div>

            <!-- Progress -->
            <?php
                $percentage = $numberOfStudents->num_rows() > 0
                    ? ($numberOfPresents->num_rows() / $numberOfStudents->num_rows()) * 100
                    : 0;
            ?>

            <div class="progress progress-modern">
                <div
                    class="progress-bar bg-info"
                    style="width: <?php echo min(100, $percentage); ?>%">
                </div>
            </div>

        </div>

        <!-- Footer -->
        <a href="<?php echo base_url().'hr/getDailyAttendance' ?>"
           class="card-footer modern-footer text-decoration-none">
            <span>View Employee Attendance</span>
            <i class="fa fa-arrow-right text-info"></i>
        </a>

    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".count-up").forEach(el => {
        const target = parseInt(el.dataset.count, 10);
        let count = 0;
        const step = Math.max(1, target / 30);

        const animate = () => {
            count += step;
            if (count >= target) {
                el.textContent = target;
            } else {
                el.textContent = Math.floor(count);
                requestAnimationFrame(animate);
            }
        };

        animate();
    });
});
</script>


<style>
.employees-card {
    border-radius: 0.75rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.employees-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}


.employees-card a.card-footer:hover {
    background: #ffffff; /* subtle hover highlight */
    cursor: pointer;
}


</style>