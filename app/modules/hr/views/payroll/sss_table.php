<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <div class="row align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fa fa-table text-primary me-2"></i>
                SSS Contribution Table
            </h5>
        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover table-striped align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">#</th>
                        <th colspan="2" class="text-center">Range of Compensation</th>
                        <th rowspan="2" class="text-center align-middle">Contribution</th>
                    </tr>
                    <tr>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $t = ($t == '' ? 1 : $t + 1);
                    foreach ($sss as $s): ?>

                        <tr>

                            <td class="text-center fw-semibold">
                                <?php echo $t++; ?>
                            </td>

                            <td class="text-center">
                                <?php echo ($s->ssst_id != 1
                                    ? number_format($s->ssst_from, 2, '.', ',')
                                    : '<span class="badge bg-secondary">BELOW</span>'); ?>
                            </td>

                            <td class="text-center">
                                <?php echo ($s->ssst_id != 67
                                    ? number_format($s->ssst_to, 2, '.', ',')
                                    : '<span class="badge bg-dark">OVER</span>'); ?>
                            </td>

                            <td id="<?php echo $s->esk_payroll_sss_table_code ?>"
                                class="editable text-end fw-semibold text-center">

                                ₱ <?php echo number_format($s->ssst_ee, 2, '.', ',') ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- Footer -->
    <div class="card-footer bg-white">

        <div class="row align-items-center">

            <div class="col-md-6 text-muted small">

                Showing
                <strong><?php echo count($sss); ?></strong>
                of
                <strong><?php echo $total_rows; ?></strong>
                entries

            </div>

            <div class="col-md-6">

                <?php echo $links; ?>

            </div>

        </div>

    </div>

</div>
<script>
    document.getElementById("pageLimit").addEventListener("change", function() {

        var limit = this.value;

        var url = new URL(window.location.href);
        url.searchParams.set("limit", limit);

        window.location.href = url;

    });
</script>