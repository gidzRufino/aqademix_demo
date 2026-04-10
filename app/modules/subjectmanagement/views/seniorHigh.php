<div class="col-12 col-lg-6">
    <div class="card shadow-sm border-0 shs-card h-100">

        <!-- Header -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">
                <i class="fas fa-layer-group me-2"></i>
                <?php echo $list->level; ?>
            </span>
            <i class="fas fa-graduation-cap"></i>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <!-- FIRST SEM -->
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light fw-semibold text-center">
                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                            First Semester
                        </div>

                        <div class="card-body p-2">
                            <?php
                            $strand = Modules::run('subjectmanagement/getSHOfferedStrand');
                            foreach ($strand as $st):
                                $subjects = Modules::run('subjectmanagement/getAllSHSubjects', $list->grade_id, 1, $st->st_id);
                            ?>

                                <div class="card mb-3 strand-card">
                                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center py-2">
                                        <span>
                                            <i class="fas fa-stream me-2"></i>
                                            <?php echo $st->strand; ?>
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <?php echo count($subjects); ?>
                                        </span>
                                    </div>

                                    <div class="card-body p-2">
                                        <ul class="list-group list-group-flush">

                                            <?php foreach ($subjects as $sub): ?>
                                                <li class="list-group-item subject-item d-flex justify-content-between align-items-center"
                                                    data-grade="<?php echo $list->grade_id; ?>"
                                                    data-strand="<?php echo $st->st_id; ?>"
                                                    data-sem="1"
                                                    data-id="<?php echo $sub->sh_sub_id; ?>">

                                                    <span>
                                                        <i class="fas fa-book text-primary me-2"></i>
                                                        <?php echo $sub->subject ?>
                                                    </span>

                                                    <i class="fas fa-chevron-right text-muted small"></i>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- SECOND SEM -->
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light fw-semibold text-center">
                            <i class="fas fa-calendar-check text-success me-1"></i>
                            Second Semester
                        </div>

                        <div class="card-body p-2">
                            <?php
                            foreach ($strand as $st):
                                $subjects = Modules::run('subjectmanagement/getAllSHSubjects', $list->grade_id, 2, $st->st_id);
                            ?>

                                <div class="card mb-3 strand-card">
                                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center py-2">
                                        <span>
                                            <i class="fas fa-stream me-2"></i>
                                            <?php echo $st->strand; ?>
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <?php echo count($subjects); ?>
                                        </span>
                                    </div>

                                    <div class="card-body p-2">
                                        <ul class="list-group list-group-flush">

                                            <?php foreach ($subjects as $sub): ?>
                                                <li class="list-group-item subject-item d-flex justify-content-between align-items-center"
                                                    data-grade="<?php echo $list->grade_id; ?>"
                                                    data-strand="<?php echo $st->st_id; ?>"
                                                    data-sem="2"
                                                    data-id="<?php echo $sub->sh_sub_id; ?>">

                                                    <span>
                                                        <i class="fas fa-book text-success me-2"></i>
                                                        <?php echo $sub->subject ?>
                                                    </span>

                                                    <i class="fas fa-chevron-right text-muted small"></i>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .shs-card {
        border-radius: 14px;
    }

    .strand-card {
        border: none;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .strand-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .subject-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-size: 0.92rem;
    }

    .subject-item:hover {
        background: #f8f9fa;
        padding-left: 12px;
    }

    .subject-item.active {
        background: #e7f1ff;
        border-left: 4px solid #0d6efd;
        font-weight: 500;
    }

    .subject-item .fa-chevron-right {
        transition: transform 0.2s ease;
    }

    .subject-item:hover .fa-chevron-right {
        transform: translateX(5px);
    }
</style>

<script>
    $(document).on('click', '.subject-item', function() {
        // remove previous active
        $('.subject-item').removeClass('active');

        // highlight selected
        $(this).addClass('active');

        // get values
        let grade = $(this).data('grade');
        let strand = $(this).data('strand');
        let sem = $(this).data('sem');
        let sub = $(this).data('id');

        // assign to hidden inputs
        $('#grade_id').val(grade);
        $('#strand_id').val(strand);
        $('#semester').val(sem);
        $('#sub_id').val(sub);

        console.log({
            grade,
            strand,
            sem,
            sub
        });
    });
</script>