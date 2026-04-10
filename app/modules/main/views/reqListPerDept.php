<div class="list-group list-group-flush small">
    <?php if (!empty($list)): ?>
        <?php foreach ($list as $l): ?>

            <div class="list-group-item d-flex justify-content-between align-items-center py-1">

                <span>
                    <i class="fa fa-file-alt text-primary me-2"></i>
                    <?= $l->eReq_desc ?>
                </span>

                <button class="btn btn-sm btn-link text-danger p-0"
                    onclick="deleteItem('<?= $l->eReq_id ?>','<?= $dept ?>')">
                    <i class="fa fa-trash"></i>
                </button>

            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-muted text-center py-3">
            <i class="fa fa-folder-open me-1"></i>
            No requirements added yet
        </div>

    <?php endif; ?>

</div>