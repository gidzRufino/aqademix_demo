
<div class="modal fade" id="insertReq" tabindex="-1">
<?php $reqList = Modules::run('main/listRequirements'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title">
                    Insert Requirements for
                    <span id="dept_desc"></span>
                </h6>

                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="dept_id">

                <label class="form-label">Select Requirement</label>

                <select id="reqSelect" class="form-select">
                    <option value="0">Select Requirement</option>
                    <?php foreach ($reqList as $r): ?>
                        <option value="<?= $r->eReq_list_id ?>">
                            <?= $r->eReq_desc ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div id="alertMsg" class="mt-3"></div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="addSelected">
                    <i class="fa fa-save me-1"></i> Save
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editTimeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Edit Time Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="editTimeContent">
                <div class="text-center py-4">
                    <div class="spinner-border"></div>
                </div>
            </div>

        </div>
    </div>
</div>