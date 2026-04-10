<div class="card border-0 shadow-sm mb-3">

    <div class="card-body py-3">

        <div class="row align-items-center g-3">

            <!-- Avatar -->
            <div class="col-auto">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                    style="width:50px;height:50px;font-size:20px;">
                    <?php echo strtoupper(substr($basicInfo->firstname, 0, 1)); ?>
                </div>
            </div>

            <!-- Teacher Info -->
            <div class="col">

                <div class="fw-semibold fs-5" id="name">
                    <?php echo $basicInfo->firstname . ' ' . $basicInfo->lastname ?>
                </div>

                <div class="text-muted small mt-1">
                    <span class="badge bg-light text-dark border me-2">
                        <?php echo $basicInfo->position ?>
                    </span>

                    Employee ID:
                    <strong><?php echo $basicInfo->employee_id ?></strong>
                </div>

                <input type="hidden"
                    id="em_id"
                    value="<?php echo $basicInfo->employee_id ?>" />

            </div>

            <!-- Advisory -->
            <div class="col-lg-5">

                <div class="bg-light border rounded p-2">

                    <div class="small fw-semibold text-muted mb-2">
                        Advisory Class
                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <?php
                        if (!empty($getAdvisory->row())) {

                            for ($a = 0; $a < $getAdvisory->num_rows(); $a++) {
                        ?>

                                <span class="badge bg-primary-subtle text-primary border">

                                    <?php echo $getAdvisory->row($a)->level . ' [ ' . $getAdvisory->row($a)->section . ' ]'; ?>

                                    <a onclick="removeAdvisory('<?php echo $getAdvisory->row($a)->adv_id ?>','<?php echo $basicInfo->employee_id ?>')"
                                        href="#"
                                        class="text-danger ms-1"
                                        title="Remove Advisory">

                                        <i class="fa fa-times"></i>

                                    </a>

                                </span>

                        <?php
                            }
                        } else {

                            echo '<span class="badge bg-secondary">No Advisory Assigned</span>';
                        }
                        ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>