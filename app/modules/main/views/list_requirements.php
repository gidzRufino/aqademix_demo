<style>
    /* Compact requirement row */
    .req-item {
        padding: 6px 12px;
        min-height: 38px;
        transition: .2s ease;
    }

    .req-item:hover {
        background: #f8f9fb;
    }

    /* Text spacing */
    .req-text {
        font-size: 14px;
        line-height: 1.3;
    }

    /* Input while editing */
    .req-edit-input {
        max-width: 400px;
        padding: 3px 8px;
        font-size: 14px;
        height: 30px;
    }

    /* Buttons */
    .req-actions button {
        padding: 3px 8px;
        font-size: 13px;
        transition: .2s;
    }

    .req-actions button:hover {
        transform: scale(1.05);
    }
</style>
<div class="col-12">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h6 class="mb-0 fw-semibold">
                <i class="fa fa-file-alt text-primary me-2"></i>
                Enrollment Requirements
            </h6>

            <button class="btn btn-sm btn-primary" onclick="showAddRequirement()">
                <i class="fa fa-plus"></i> Add Requirement
            </button>

        </div>

        <div class="card-body p-0">

            <!-- Add Requirement -->
            <div id="addRequirementBox" class="p-3 border-bottom d-none">

                <div class="input-group">

                    <input type="text"
                        id="newRequirement"
                        class="form-control"
                        placeholder="Enter requirement">

                    <button class="btn btn-success" onclick="saveRequirement()">
                        <i class="fa fa-check"></i>
                    </button>

                    <button class="btn btn-light border" onclick="hideAddRequirement()">
                        <i class="fa fa-times"></i>
                    </button>

                </div>

            </div>

            <!-- Requirement List -->
            <ul class="list-group list-group-flush">

                <?php if (!empty($list)): ?>

                    <?php foreach ($list as $s): ?>

                        <li class="list-group-item req-item d-flex align-items-center justify-content-between"
                            data-id="<?= $s->eReq_list_id ?>">

                            <div class="flex-grow-1">

                                <div class="req-text">
                                    <?= $s->eReq_desc ?>
                                </div>

                                <input type="text"
                                    class="form-control req-edit-input d-none"
                                    value="<?= $s->eReq_desc ?>">

                            </div>

                            <div class="req-actions ms-3">

                                <button class="btn btn-sm btn-light border edit-btn">
                                    <i class="fa fa-edit text-success"></i>
                                </button>

                                <button class="btn btn-sm btn-light border save-btn d-none">
                                    <i class="fa fa-check text-primary"></i>
                                </button>

                                <button class="btn btn-sm btn-light border"
                                    onclick="deleteReq('<?= $s->eReq_list_id ?>',2)">
                                    <i class="fa fa-trash text-danger"></i>
                                </button>

                            </div>

                        </li>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="text-center py-5 text-muted">

                        <i class="fa fa-folder-open fa-2x mb-2 opacity-50"></i>
                        <div>No requirements added</div>

                    </div>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</div>

<script type="text/javascript">
    $(function() {
        function checkUpdateList() {
            var url = '<?php echo base_url() . 'main/getAllEnrollmentReq' ?>';
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $('#listReq').html(data);
                }
            });
        }

        //setInterval(checkUpdateList, 1000);
    });

    function showAddRequirement() {

        $('#addRequirementBox').removeClass('d-none');
        $('#newRequirement').focus();

    }

    function hideAddRequirement() {

        $('#addRequirementBox').addClass('d-none');
        $('#newRequirement').val('');

    }

    function saveRequirement() {

        let desc = $('#newRequirement').val();

        if (desc == '') {
            alert("Please enter requirement.");
            return;
        }

        $.post("<?= site_url('main/addRequirement') ?>", {

            desc: desc,
            csrf_test_name: $.cookie('csrf_cookie_name')

        }, function() {

            location.reload();

        });

    }

    $(document).on('click', '.edit-btn', function() {

        let row = $(this).closest('.req-item');

        row.find('.req-text').addClass('d-none');
        row.find('.req-edit-input').removeClass('d-none').focus();

        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn').removeClass('d-none');

    });


    $(document).on('click', '.save-btn', function() {

        let row = $(this).closest('.req-item');

        let id = row.data('id');
        let desc = row.find('.req-edit-input').val();

        if (desc == '') {
            alert("Requirement cannot be empty");
            return;
        }

        $.ajax({

            url: "<?= site_url('main/editReqList') ?>",
            type: "POST",

            data: {
                id: id,
                value: desc,
                opt: 1,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },

            success: function() {

                row.find('.req-text').text(desc).removeClass('d-none');
                row.find('.req-edit-input').addClass('d-none');

                row.find('.edit-btn').removeClass('d-none');
                row.find('.save-btn').addClass('d-none');

            }

        });

    });
</script>