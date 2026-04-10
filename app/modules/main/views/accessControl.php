<!-- Ultra Modern Access Control Page -->
<div class="container-fluid px-3 px-md-4 py-3">

    <!-- HEADER CARD -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">

                <!-- Title -->
                <div>
                    <h3 class="fw-bold mb-1 text-gradient">
                        <i class="fa fa-shield-alt me-2"></i> Access Control
                    </h3>
                    <p class="text-muted mb-0 small">
                        Manage user permissions and system access levels
                    </p>
                </div>

                <!-- Select -->
                <div class="w-100 w-lg-auto">
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0">
                            <i class="fa fa-user-cog text-primary"></i>
                        </span>
                        <select id="inputTeacher" class="form-select">
                            <option selected disabled>Select Position</option>
                            <?php foreach ($position as $position): ?>
                                <option value="<?= $position->position_id ?>"><?= $position->position ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ALERT (FLOATING STYLE) -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="alert-info" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa fa-check-circle me-2"></i>
                    Access Control Successfully Saved!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- RESULT SECTION -->

    <div id="accessResult"></div>
    <!-- <input type="hidden" id="menuAccess" value=""> -->

</div>
<style>
    /* Gradient Text */
    .text-gradient {
        background: linear-gradient(45deg, #0d6efd, #4dabf7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Card Modern Style */
    #accessResult .card {
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* Card Hover Glow */
    #accessResult .card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    /* Subtle Accent Bar */
    #accessResult .card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #20c997);
    }

    /* Status Borders */
    .card.border-success::before {
        background: linear-gradient(90deg, #198754, #20c997);
    }

    .card.border-danger::before {
        background: linear-gradient(90deg, #dc3545, #ff6b6b);
    }

    /* Buttons */
    .btn.select-roles {
        border-radius: 10px;
        padding: 6px 16px;
        transition: all 0.25s ease;
    }

    .btn.select-roles:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    }

    /* Input focus */
    .form-select:focus {
        box-shadow: none;
    }

    /* Mobile spacing fix */
    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>

<script>
    $(document).ready(function() {

        // ✅ Load saved position (ONLY this uses localStorage)
        let savedPosition = localStorage.getItem('selectedPosition');

        if (savedPosition) {

            // 🔥 ensure value exists in dropdown
            if ($('#inputTeacher option[value="' + savedPosition + '"]').length) {

                $('#inputTeacher').val(savedPosition);

                // slight delay ensures DOM + AJAX stability
                setTimeout(function() {
                    getAccessList(savedPosition);
                }, 100);

            }
        }

        // Load position access
        $(document).on('change', '#inputTeacher', function() {
            let positionId = $(this).val();
            if (!positionId) return;

            localStorage.setItem('selectedPosition', positionId.toString());
            getAccessList(positionId);
        });

        function getAccessList(pid) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'main/getPositionAccess/' ?>" + pid,
                data: {
                    position_id: pid,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                beforeSend: function() {
                    $('#accessResult').html('<p class="text-center py-5">Loading...</p>');
                },
                success: function(data) {
                    $('#accessResult').html(data);

                    // Re-initialize permission toggles (active state, click, change)
                    initializePermissionToggles();

                }
            });
        }

        // Initialize toggles for newly loaded access cards
        function initializePermissionToggles() {

            let ids = [];

            $('.permission-toggle').each(function() {
                let checkbox = $(this);
                let id = checkbox.data('id').toString();

                if (checkbox.is(':checked')) {
                    ids.push(id);
                    checkbox.closest('.permission-card').addClass('active');
                } else {
                    checkbox.closest('.permission-card').removeClass('active');
                }
            });

            $('#menuAccess').val(ids.join(','));
            $('#assignedCount').text(ids.length + " Enabled");

            // 🔥 FIXED CARD CLICK (NO DOUBLE TOGGLE)
            $('#accessResult')
                .off('click', '.permission-card')
                .on('click', '.permission-card', function(e) {

                    if ($(e.target).closest('.form-check-input').length) return;

                    let checkbox = $(this).find('.permission-toggle');
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                });

            // ✅ CHECKBOX CHANGE
            $('#accessResult')
                .off('change', '.permission-toggle')
                .on('change', '.permission-toggle', function() {

                    let checkbox = $(this);
                    let id = checkbox.data('id').toString();
                    let accessName = $('#' + id + "_name").text();

                    // 🔥 ALWAYS rebuild from actual checked inputs
                    let accessArr = [];

                    $('.permission-toggle:checked').each(function() {
                        accessArr.push($(this).data('id').toString());
                    });

                    // Update UI
                    $('#menuAccess').val(accessArr.join(','));
                    $('#assignedCount').text(accessArr.length + " Enabled");

                    // Update card state
                    if (checkbox.is(':checked')) {
                        checkbox.closest('.permission-card').addClass('active');
                    } else {
                        checkbox.closest('.permission-card').removeClass('active');
                    }

                    // Save to DB (ONLY the clicked ID)
                    let url = checkbox.is(':checked') ?
                        "<?php echo base_url() . 'main/saveAccess/' ?>" :
                        "<?php echo base_url() . 'main/unlinkAccess/' ?>";

                    $.post(url, {
                        column: 'menu_access',
                        id: id,
                        position_id: $('#inputTeacher').val(),
                        accessValue: accessArr.join(','),
                        accessName: accessName,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    });

                });
        }

        // Initialize toggles and hidden input
        function initializeMenuAccess() {
            let ids = [];
            $('.permission-toggle:checked').each(function() {
                ids.push($(this).data('id'));
                $(this).closest('.permission-card').addClass('active');
            });
            $('#menuAccess').val(ids.join(','));
        }

        // Card click toggles checkbox
        $('#accessResult').on('click', '.permission-card', function(e) {
            if (!$(e.target).is('input')) {
                let checkbox = $(this).find('.permission-toggle');
                checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
            }
        });

        // Checkbox change
        $('#accessResult').on('change', '.permission-toggle', function() {
            let checkbox = $(this);
            let id = checkbox.data('id');
            let accessArr = $('#menuAccess').val() ? $('#menuAccess').val().split(',') : [];
            let accessName = $('#' + id + "_name").text();

            if (checkbox.is(':checked')) {
                if (!accessArr.includes(id.toString())) accessArr.push(id);
                checkbox.closest('.permission-card').addClass('active');

                $.post("<?php echo base_url() . 'main/saveAccess/' ?>", {
                    column: 'menu_access',
                    id: id,
                    position_id: $('#inputTeacher').val(),
                    accessValue: $('#menuAccess').val(),
                    accessName: accessName,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                });

            } else {
                accessArr = accessArr.filter(val => val != id);
                checkbox.closest('.permission-card').removeClass('active');

                $.post("<?php echo base_url() . 'main/unlinkAccess/' ?>", {
                    column: 'menu_access',
                    id: accessArr.join(','),
                    position_id: $('#inputTeacher').val(),
                    accessValue: $('#menuAccess').val(),
                    accessName: accessName,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                });
            }

            // Update hidden input and counter
            $('#menuAccess').val(accessArr.join(','));
            $('#assignedCount').text(accessArr.length + " Enabled");
        });

    });
</script>