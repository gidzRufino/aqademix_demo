<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<div id="accessControls" class="container-fluid mt-4">

    <div class="card border-0 shadow-sm rounded-4">

        <!-- Header -->
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <div class="fw-semibold">
                <i class="fa-solid fa-shield-halved text-primary me-2"></i>
                Menu Access Control
            </div>

            <span class="badge bg-primary-subtle text-primary" id="assignedCount">
                <?= !empty($positionAccess->menu_access) ? count(explode(",", $positionAccess->menu_access)) : 0 ?> Enabled
            </span>
        </div>

        <!-- Body -->
        <div class="card-body custom-scroll">

            <div class="row g-3">

                <?php
                $assigned = explode(',', $positionAccess->menu_access ?? '');
                foreach ($menuAccess as $mnA):
                    $isChecked = in_array($mnA->menu_id, $assigned);
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="permission-card d-flex justify-content-between align-items-center p-3 mb-3 shadow-sm rounded-4"
                            style="background: rgba(255,255,255,0.9); backdrop-filter: blur(6px); transition: all 0.3s ease;">

                            <!-- Label -->
                            <div class="d-flex align-items-center">
                                <i class="fa fa-folder me-2 text-muted"></i>
                                <span id="<?= $mnA->menu_id ?>_name"><?= $mnA->menu_name ?></span>
                            </div>

                            <!-- Toggle Switch -->
                            <div class="form-check form-switch m-0">
                                <input type="checkbox"
                                    class="form-check-input permission-toggle"
                                    data-id="<?= $mnA->menu_id ?>"
                                    <?= $isChecked ? 'checked' : '' ?>>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </div>

    <input type="hidden" value="<?= $positionAccess->menu_access ?>" id="menuAccess">

</div>

<style>
    /* Scroll */
    .custom-scroll {
        max-height: 500px;
        overflow-y: auto;
    }

    /* Permission Card */
    .permission-card {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 14px 16px;
        transition: all 0.25s ease;
        border: 1px solid transparent;
    }

    /* Hover */
    .permission-card:hover {
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.08);
    }

    /* Active (checked) */
    .permission-card.active {
        border: 1px solid rgba(13, 110, 253, 0.2);
        background: rgba(13, 110, 253, 0.05);
    }

    /* Switch */
    .form-check-input {
        width: 42px;
        height: 22px;
        cursor: pointer;
    }

    /* Smooth toggle */
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Badge */
    .bg-primary-subtle {
        background: rgba(13, 110, 253, 0.1);
    }
</style>