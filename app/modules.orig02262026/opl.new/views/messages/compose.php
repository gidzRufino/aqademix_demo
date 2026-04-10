<div class="card shadow border-0 rounded-4 compose-card">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white fw-bold d-flex align-items-center rounded-top-4">
        <i class="fas fa-envelope me-2"></i> Compose New Message
    </div>

    <!-- Body -->
    <div class="card-body p-4">


        <!-- Recipient (note: special value __all__) -->
        <div class="mb-3">
            <label for="recipient" class="form-label fw-semibold text-secondary">
                <i class="fas fa-user-friends me-2 text-primary"></i> Select Recipient
            </label>
            <div style="border: thin solid #28a745; border-radius: 10px">
                <div style="padding: 10px">
                    <select id="recipient" name="recipient[]" multiple="multiple" class="form-control">
                        <option value="__all__">-- Select All Students --</option>
                        <?php foreach ($students as $s): ?>
                            <option value="<?= base64_encode($s->st_id) ?>">
                                <?= htmlspecialchars($s->firstname . ' ' . $s->lastname, ENT_QUOTES) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Subject -->
        <div class="mb-3">
            <label for="subjMsg" class="form-label fw-semibold text-secondary">
                <i class="fas fa-tag me-2 text-primary"></i> Subject
            </label>
            <input type="text" class="form-control rounded-pill" placeholder="Enter subject" id="subjMsg" />
        </div>

        <!-- Message -->
        <div class="mb-3">
            <label for="composeMsg" class="form-label fw-semibold text-secondary">
                <i class="fas fa-comment-dots me-2 text-primary"></i> Message
            </label>
            <textarea class="form-control textarea" id="composeMsg"></textarea>
        </div>

        <!-- Buttons -->
        <div class="text-end">
            <button class="btn btn-success rounded-pill px-4 shadow-sm" onclick="sendMsg()">
                <i class="fas fa-paper-plane me-2"></i> Send
            </button>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" id="sender"
            value="<?php echo (count($students) > 0 ? base64_encode($this->session->employee_id) : base64_encode($this->session->st_id)) ?>" />
        <input type="hidden" id="isTeacher" value="<?php echo (count($students) > 0 ? 1 : 0) ?>" />

        <!-- Prompt/Error -->
        <span id="promptMsg" class="fw-semibold mt-3 d-block text-center"></span>
        <span id="msgBody"></span>
    </div>
</div>
<div id="loadingOverlay">
    <div class="loader-content">
        <img src="<?php echo base_url() ?>/images/loading.gif" alt="Loading">
        <p class="mt-3 fw-semibold text-white">Sending message...</p>
    </div>
</div>

<!-- Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet" />

<script type="text/javascript">
    $(function() {
        // Summernote
        $('.textarea').summernote({
            height: 180,
            placeholder: "Hey! What's up?"
        });

        // Select2 Recipients
        $('#recipient').select2({
            placeholder: "Search and select recipients",
            allowClear: true,
            width: '100%',
            closeOnSelect: false
        });

        // Helper: get array of all student values (excluding __all__)
        function getAllStudentValues() {
            return $('#recipient option').map(function() {
                const v = $(this).val();
                return (v && v !== '__all__') ? v : null;
            }).get();
        }

        // Refresh dropdown result rows: hide the rows whose underlying option values are currently selected.
        function refreshDropdownVisibility() {
            // only act on currently-open dropdown results
            const $results = $('.select2-container--open .select2-results__option');
            if (!$results.length) return;

            // show everything first
            $results.show();

            // currently selected values (array of strings)
            const selected = $('#recipient').val() || [];

            // Hide any result row whose text matches a selected value (skip the "Select All" row)
            $results.each(function() {
                const $r = $(this);
                const text = $r.text().trim();

                // keep the "Select All" result visible
                if (text.indexOf('Select All') !== -1) {
                    $r.show();
                    return;
                }

                // find the matching option in the original select by text
                const $match = $("#recipient option").filter(function() {
                    return $(this).text().trim() === text;
                }).first();

                if ($match.length && selected.indexOf($match.val()) !== -1) {
                    $r.hide(); // hide from dropdown
                }
            });
        }

        // If user selects the "Select All" pseudo-option, select every student
        $('#recipient').on('select2:select', function(e) {
            if (e.params && e.params.data && e.params.data.id === '__all__') {
                const all = getAllStudentValues();
                $('#recipient').val(all).trigger('change');
                // close dropdown to reduce confusion
                $('#recipient').select2('close');
            }
        });

        // When dropdown opens, hide already-selected items
        $('#recipient').on('select2:open', function() {
            // slight delay to allow Select2 to render results before we hide rows
            setTimeout(refreshDropdownVisibility, 10);
        });

        // Whenever selection changes (select or unselect via tags), refresh visibility
        $('#recipient').on('change', function() {
            // if dropdown is open, refresh the visible rows
            if ($('.select2-container--open').length) {
                setTimeout(refreshDropdownVisibility, 10);
            }
        });
    });

    // Send Function
    function sendMsg() {
        const sender = $('#sender').val();
        const recipient = $('#recipient').val();
        const subjMsg = $('#subjMsg').val().trim();
        const content = $('#composeMsg').val().trim();
        const url = '<?php echo base_url('opl/messages/sendMsg') ?>';
        const subj_id = '<?php echo $subject_id ?>';
        const isTeacher = $('#isTeacher').val();
        const grade_id = '<?php echo $grade_level ?>';
        const section_id = '<?php echo $section_id ?>';

        if (!recipient || recipient.length === 0) {
            return showError('Recipient should not be empty', 'danger');
        }
        if (!subjMsg) {
            return showError('Subject should not be empty', 'danger');
        }

        const $sendBtn = $('.btn.btn-success'); // your Send button

        $.ajax({
            url: url,
            type: "POST",
            data: {
                subjMsg,
                content,
                recipient: JSON.stringify(recipient),
                sender,
                subj_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            traditional: true,
            beforeSend: function() {
                $sendBtn.prop('disabled', true).text('Sending...');
                $("#loadingOverlay").css("display", "flex").hide().fadeIn(200);
            },
            success: function(response) {
                alert(response);
                const base = '<?php echo base_url() ?>';
                if (isTeacher != 1) {
                    location.href = `${base}opl/student/classBulletin/${subj_id}/<?php echo $this->session->school_year ?>`;
                } else {
                    location.href = `${base}opl/messages/employee_inbox/${sender}/${subj_id}/${grade_id}/${section_id}`;
                }
            },
            error: function() {
                $("#loadingOverlay").fadeOut(200);
                $sendBtn.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Send');
                showError('Failed to send message. Please try again.', 'danger');
            }
        });
    }

    function showError(msg, type) {
        $('#promptMsg')
            .removeClass()
            .addClass('alert alert-' + type + ' py-2 rounded-pill shadow-sm')
            .html('⚠️ ' + msg)
            .fadeIn()
            .delay(3000)
            .fadeOut();
    }
</script>

<style>
    /* Card styling */
    .compose-card {
        transition: 0.3s ease-in-out;
    }

    .compose-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #0d6efd, #3b82f6);
    }

    /* Recipient select box */
    .select2-container--default .select2-selection--multiple {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        align-items: center !important;
        min-height: 46px;
        padding: 8px;
        border: 1px solid #ced4da !important;
        border-radius: 0.75rem !important;
        background-color: #fff !important;
        scrollbar-width: thin;
        scrollbar-color: #bbb transparent;
    }

    .select2-container--default .select2-selection--multiple::-webkit-scrollbar {
        height: 6px;
    }

    .select2-container--default .select2-selection--multiple::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 10px;
    }

    /* Chips style */
    .select2-selection__choice {
        display: inline-flex !important;
        align-items: center;
        margin: 2px 4px 2px 0 !important;
        background-color: #198754 !important;
        color: #fff !important;
        border-radius: 20px !important;
        padding: 4px 12px !important;
        font-size: 13px !important;
        white-space: nowrap !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .select2-selection__choice__remove {
        color: #fff !important;
        margin-right: 6px !important;
        font-weight: bold;
        cursor: pointer;
    }

    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 2000;
        display: none;
        /* hidden by default */
        align-items: center;
        justify-content: center;
    }

    #loadingOverlay .loader-content {
        text-align: center;
    }

    #loadingOverlay img {
        width: 125px;
        display: block;
        margin: 0 auto;
    }
</style>