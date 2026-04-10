<!-- QUIZ MANAGEMENT PAGE -->
<div>
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h4 class="mb-0">
                <i class="fas fa-clipboard-list mr-2"></i> Quiz Management
            </h4>
        </div>

        <div class="card-body">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" id="quizTab" role="tablist">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="create-tab"
                        data-toggle="tab"
                        href="#createQuiz"
                        role="tab"
                        aria-controls="createQuiz"
                        aria-selected="true">
                        <i class="fas fa-plus-circle mr-1"></i> Create Quiz
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="list-tab"
                        data-toggle="tab"
                        href="#quizList"
                        role="tab"
                        aria-controls="quizList"
                        aria-selected="false">
                        <i class="fas fa-list mr-1"></i> Quiz List
                    </a>
                </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content mt-3" id="quizTabContent">
                <!-- CREATE QUIZ TAB -->
                <div
                    class="tab-pane fade show active"
                    id="createQuiz"
                    role="tabpanel"
                    aria-labelledby="create-tab">
                    <!-- QUIZ CREATION PAGE -->
                    <button class="btn btn-light btn-sm fw-bold" id="clearForm">
                        <i class="fas fa-broom me-1"></i> Clear Form
                    </button>

                    <div class="card-body bg-light px-4 py-4">
                        <form id="quizForm">
                            <!-- Quiz Title and Total Items -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label for="quizTitle" class="form-label fw-semibold">Quiz Title</label>
                                    <input type="text" name="title" id="quizTitle" class="form-control form-control-lg shadow-sm" placeholder="Enter quiz title..." required>
                                </div>
                                <div class="col-md-4">
                                    <label for="totalItems" class="form-label fw-semibold">Total Items</label>
                                    <input type="number" name="total_items" id="totalItems" class="form-control form-control-lg shadow-sm" placeholder="0" min="1" required>
                                </div>
                            </div>

                            <!-- Add Question Type -->
                            <div class="row align-items-end mt-4 mb-4 g-3 p-3 bg-light rounded-4 shadow-sm border border-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary mb-2">
                                        <i class="fas fa-question-circle me-1 text-primary"></i> Select Question Type
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-list-ul"></i>
                                        </span>
                                        <select id="questionType" class="form-select border-0 shadow-sm">
                                            <option value="">-- Choose a type --</option>
                                            <option value="identification">Identification</option>
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="true_false">True or False</option>
                                            <option value="fill_in_the_blanks">Fill in the Blanks</option>
                                            <option value="essay">Essay</option>
                                            <option value="problem_solving">Problem Solving</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <button type="button" class="btn btn-gradient-primary w-100 shadow-sm d-flex align-items-center justify-content-center" id="addSection">
                                        <i class="fas fa-plus-circle me-2"></i> Add Section
                                    </button>
                                </div>
                            </div>

                            <!-- Sections -->
                            <div id="sections"></div>
                        </form>

                    </div>

                    <!-- Footer Buttons -->
                    <div class="card-footer bg-white text-end p-3 border-top">
                        <button type="button" id="exportQuizBtn" class="btn btn-success me-2 shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Quiz
                        </button>
                        <button type="button" id="previewQuizBtn" class="btn btn-outline-dark shadow-sm">
                            <i class="fas fa-eye me-1"></i> Preview
                        </button>
                    </div>
                </div>

                <!-- QUIZ PREVIEW -->
                <div id="quizPreviewContainer" class="mt-4" style="display:none;">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-file-alt me-2"></i> Quiz Preview</h5>
                            <button class="btn btn-outline-secondary btn-sm" id="hidePreview"><i class="fas fa-times"></i> Close</button>
                        </div>
                        <div class="card-body bg-white p-4" id="quizPreview"></div>
                    </div>
                </div>

                <!-- 🔹 MODAL: Insert from Question Bank -->
                <div class="modal fade" id="questionBankModal" tabindex="-1" role="dialog" aria-labelledby="questionBankModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="questionBankModalLabel">Select Questions from Bank</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <!-- 🔹 Search and Filter -->
                                Question Type: <strong id="qType"></strong>
                                <hr>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <input type="text" id="searchKeyword" class="form-control" placeholder="Search question...">
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <select id="filterQuestionType" class="form-select">
                            <option value="">All Types</option>
                            <option value="Multiple Choice">Multiple Choice</option>
                            <option value="Identification">Identification</option>
                            <option value="True or False">True or False</option>
                            <option value="Essay">Essay</option>
                            <option value="Fill in the Blanks">Fill in the Blanks</option>
                        </select> -->
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <button id="searchBtn" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>

                                <!-- 🔹 Question List -->
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%"></th>
                                            <th>Question</th>
                                            <th width="20%">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody id="questionBankList">
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- 🔹 Pagination -->
                                <nav>
                                    <ul id="pagination" class="pagination justify-content-center mb-0"></ul>
                                </nav>
                            </div>

                            <div class="modal-footer">
                                <button id="insertSelectedQuestions" class="btn btn-success">
                                    <i class="fas fa-plus-circle me-1"></i> Add Selected
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Preview Modal -->
                <div class="modal fade" id="quizPreviewModal" tabindex="-1" aria-labelledby="quizPreviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content quiz-preview-paper">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold" id="quizPreviewModalLabel">Quiz Preview</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="quizPreviewBody">
                                <!-- Quiz preview content goes here -->
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="printQuizBtn" class="btn btn-outline-dark">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QUIZ LIST TAB -->
                <div
                    class="tab-pane fade"
                    id="quizList"
                    role="tabpanel"
                    aria-labelledby="list-tab">
                    <div class="table-responsive">
                        <?php
                        echo Modules::run('opl/qm/quizList', $grade_level, $subject_id, $this->session->employee_id);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
    let sectionCount = 0;

    $('#addSection').click(function() {
        const type = $('#questionType').val();
        if (!type) return;

        // ✅ Check for duplicate section type
        let duplicate = false;
        $('.section-block').each(function() {
            const existingType = $(this).find('input[name*="[type]"]').val();
            if (existingType === type) {
                duplicate = true;
                return false; // break loop
            }
        });

        if (duplicate) {
            // ✅ Create a visible floating alert (no Bootstrap JS needed)
            let $alert = $('#duplicateAlert');
            if ($alert.length === 0) {
                $alert = $(`
        <div id="duplicateAlert"
             class="alert alert-warning shadow position-fixed"
             style="top: 20px; right: 20px; z-index: 2000; min-width: 250px;">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <span id="alertText"></span>
        </div>
      `).appendTo('body');
            }

            let kyutee = '';
            switch (type) {
                case 'identification':
                    kyutee = 'Identification';
                    break;
                case 'multiple_choice':
                    kyutee = 'Multiple Choice';
                    break;
                case 'true_false':
                    kyutee = 'True or False';
                    break;
                case 'fill_in_the_blanks':
                    kyutee = 'Fill in the blanks';
                    break;
                case 'essay':
                    kyutee = 'Essay';
                    break;
                case 'problem_solving':
                    kyutee = 'Problem Solving';
                    break;
            }

            $('#alertText').text(`${kyutee} Question Type already exists!`);
            $alert.fadeIn(200);

            setTimeout(() => $alert.fadeOut(400), 2500);
            return;
        }

        // ✅ Continue if unique
        sectionCount++;
        const sectionHtml = `
    <div class="card mt-4 p-4 border-0 shadow-sm section-block position-relative" 
         data-section-id="${sectionCount}" 
         style="border-radius: 1rem; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold text-primary mb-0">
          <i class="fas fa-layer-group me-2"></i> ${type}
        </h5>
        <button type="button" class="btn btn-light text-danger border-0 shadow-sm px-3 py-1 remove-section">
          <i class="fas fa-trash-alt me-1"></i> Remove
        </button>
      </div>

      <input type="hidden" name="sections[${sectionCount}][type]" value="${type}">
      <div class="mb-3">
        <label class="form-label fw-semibold text-secondary">
          <i class="fas fa-align-left me-1 text-info"></i> Section Description
        </label>
        <textarea name="sections[${sectionCount}][description]" class="form-control shadow-sm border-1" rows="2" placeholder="Describe this section..."></textarea>
      </div>

      <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-3 border border-1">
        <h6 class="text-secondary fw-semibold mb-0">
          <i class="fas fa-question-circle me-1 text-primary"></i> Questions
        </h6>
        <button type="button" class="btn btn-outline-info btn-sm fetch-bank d-flex align-items-center gap-1" 
          data-section="${sectionCount}" 
          data-type="${type}">
          <i class="fas fa-database"></i> &nbsp;From Question Bank
        </button>
      </div>

      <div class="questions mt-3 border-start border-3 border-primary ps-3"></div>
    </div>
  `;

        $('#sections').append(sectionHtml);

        // ✅ Scroll to bottom when new section added
        const sectionsDiv = document.getElementById('sections');
        sectionsDiv.scrollTo({
            top: sectionsDiv.scrollHeight,
            behavior: 'smooth'
        });
    });

    $(document).on('click', '.remove-section', function() {
        $(this).closest('.section-block').remove();
    });

    // 🔹 Add manual question
    $(document).on('click', '.add-question', function() {
        const section = $(this).data('section');
        const type = $(this).data('type');
        const qIndex = Date.now();

        const questionHtml = `
    <div class="question-block mt-3 p-3 border rounded shadow-sm bg-light">
      <label class="fw-semibold text-secondary mb-2">Question:</label>
      <input type="text" class="form-control mb-2" 
        name="sections[${section}][questions][${qIndex}][text]" 
        placeholder="Enter question here">

      <div class="text-end">
        <button type="button" class="btn btn-danger btn-sm remove-question">
          <i class="fas fa-times me-1"></i> Remove
        </button>
      </div>
    </div>
  `;

        // ✅ Add the question inside the correct section
        $(`.section-block[data-section-id="${section}"] .questions`).append(questionHtml);

        // ✅ Scroll to bottom of the main sections container
        const sectionsDiv = document.getElementById('sections');
        sectionsDiv.scrollTop = sectionsDiv.scrollHeight;
    });

    $(document).on('click', '.remove-question', function() {
        $(this).closest('.question-block').remove();
    });

    // 🔹 Add choice dynamically
    $(document).on('click', '.add-choice', function() {
        const section = $(this).data('section');
        const qIndex = $(this).data('qindex');
        const choiceHtml = `
    <div class="input-group mb-2">
      <input type="text" class="form-control" name="sections[${section}][questions][${qIndex}][choices][]" placeholder="Choice text">
      <div class="input-group-append"><span class="input-group-text">Correct? <input type="checkbox" name="sections[${section}][questions][${qIndex}][correct][]"></span></div>
    </div>`;
        $(this).siblings('.choices').append(choiceHtml);
    });

    let selectedSection = null;

    // Function to set which section we're inserting into
    function selectSection(sectionId) {
        selectedSection = sectionId;
    }

    // 🔹 Open Question Bank Modal
    $(document).on('click', '.fetch-bank', function() {
        selectedSection = $(this).data('section');
        const typeValue = $(this).data('type');
        switch (typeValue) {
            case 'identification':
                $('#qType').text('Identification');
                break;
            case 'multiple_choice':
                $('#qType').text('Multiple Choice');
                break;
            case 'true_false':
                $('#qType').text('True or False');
                break;
            case 'fill_in_the_blanks':
                $('#qType').text('Fill in the blanks');
                break;
            case 'essay':
                $('#qType').text('Essay');
                break;
            case 'problem_solving':
                $('#qType').text('Problem Solving');
                break;
        }

        // Load questions for this section/type
        loadQuestionBank(typeValue, 1, '');

        // Open the modal properly
        $('#questionBankModal').modal('show');
    });

    // 🔹 Load question bank list
    let qbCurrentPage = 1;
    let qbLimit = 5; // number of questions per page
    let qbCurrentType = '';
    let qbKeyword = '';
    let qbLastRequest = null;

    // small helper: escape HTML to avoid accidental markup injection
    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/[&<>"']/g, function(m) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[m];
        });
    }

    // 🔹 When modal opens
    $('#questionsBankModal').on('show.bs.modal', function(e) {
        const button = $(e.relatedTarget);
        selectedSection = button.data('section-id');
        loadQuestionBank('', 1, '');
    });

    // Debounce helper
    function debounce(fn, delay) {
        let t;
        return function() {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, arguments), delay);
        };
    }

    // 🔹 Load question bank list with pagination and search
    function loadQuestionBank(type = qbCurrentType, page = 1, keyword = qbKeyword) {
        qbCurrentPage = page;
        qbCurrentType = type;
        qbKeyword = keyword;

        $('#questionBankList').html(`
        <tr><td colspan="3" class="text-center text-muted py-3">
            <i class="fas fa-spinner fa-spin"></i> Loading questions...
        </td></tr>
    `);

        // Exclude already added question IDs in this section
        const existingIds = [];
        $(`.section-block[data-section-id="${selectedSection}"] input[name*="questions_from_bank"]`).each(function() {
            const v = $(this).val();
            if (v) existingIds.push(String(v));
        });

        const dataToSend = {
            page: page,
            limit: qbLimit,
            type: type,
            keyword: keyword, // primary
            q: keyword, // alternate param names
            search: keyword,
            grade_id: '<?= $grade_level ?>',
            subject_id: '<?= $subject_id ?>'
        };

        if (qbLastRequest && qbLastRequest.readyState !== 4) {
            qbLastRequest.abort();
        }

        qbLastRequest = $.ajax({
            url: "<?= base_url('opl/qm/listQuestionsAjax') ?>",
            method: "GET",
            data: dataToSend,
            dataType: "json",
            success: function(res) {
                const questions = res.questions || res.data || [];
                const total = res.total || res.count || questions.length;

                const available = questions.filter(q => !existingIds.includes(String(q.id)));
                let rows = '';

                if (available.length > 0) {
                    available.forEach(q => {
                        const safeJson = encodeURIComponent(JSON.stringify(q));
                        rows += `
                        <tr>
                            <td><input type="checkbox" class="select-question" data-question="${safeJson}"></td>
                            <td>${escapeHtml(q.question_text)}</td>
                            <td>${escapeHtml(q.question_type)}</td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="3" class="text-center text-muted">No questions found.</td></tr>`;
                }

                $('#questionBankList').html(rows);
                renderPagination(total, qbCurrentPage, qbLimit);
            },
            error: function(xhr, status) {
                if (status !== 'abort') {
                    $('#questionBankList').html('<tr><td colspan="3" class="text-center text-danger">Error loading questions.</td></tr>');
                }
            }
        });
    }

    // Render pagination UI
    function renderPagination(total, currentPage, limit) {
        const totalPages = Math.ceil(total / limit);
        const $pagination = $('#pagination');
        $pagination.empty();

        if (totalPages <= 1) return;

        const addPage = (label, page, disabled = false, active = false) => {
            const cls = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            const link = `<a class="page-link" href="#" data-page="${page}">${label}</a>`;
            $pagination.append(`<li class="${cls}">${link}</li>`);
        };

        addPage('Prev', currentPage - 1, currentPage === 1);

        const start = Math.max(1, currentPage - 2);
        const end = Math.min(totalPages, currentPage + 2);

        if (start > 1) addPage('1', 1);
        if (start > 2) $pagination.append(`<li class="page-item disabled"><span class="page-link">…</span></li>`);

        for (let i = start; i <= end; i++) {
            addPage(i, i, false, i === currentPage);
        }

        if (end < totalPages - 1) $pagination.append(`<li class="page-item disabled"><span class="page-link">…</span></li>`);
        if (end < totalPages) addPage(totalPages, totalPages);

        addPage('Next', currentPage + 1, currentPage === totalPages);
    }

    // Pagination click (delegated)
    $(document).on('click', '#pagination .page-link', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (!page || page === qbCurrentPage) return;
        loadQuestionBank(qbCurrentType, page, qbKeyword);
    });

    // Search button
    $('#searchBtn').on('click', function() {
        const keyword = $('#searchKeyword').val().trim();
        const type = $('#filterQuestionType').val();
        loadQuestionBank(type, 1, keyword);
    });

    // Optional: live search with debounce (typing)
    $('#searchKeyword').off('input').on('input', debounce(function() {
        const kw = $(this).val().trim();
        // Only trigger if length >= 2, or empty to reset; adjust as desired
        if (kw.length >= 2 || kw.length === 0) {
            loadQuestionBank(qbCurrentType, 1, kw);
        }
    }, 450));

    // 🔹 Filter button
    $('#filterQuestions').click(function() {
        const type = $('#filterType').val();
        const keyword = $('#searchKeyword').val();
        loadQuestionBank(type, 1, keyword);
    });

    // Click handler for inserting selected questions
    $('#insertSelectedQuestions').click(function() {
        if (!selectedSection) {
            showToast("No section selected.", 'warning');
            return;
        }

        // Target section reliably by data attribute
        const sectionEl = $(`.section-block[data-section-id="${selectedSection}"] .questions`);
        if (sectionEl.length === 0) {
            showToast("Section not found. Please check the section ID or markup.", 'warning');
            return;
        }

        // Get all selected questions from modal
        const selected = [];
        $('.select-question:checked').each(function() {
            const qData = JSON.parse(decodeURIComponent($(this).attr('data-question')));
            selected.push(qData);
        });

        if (selected.length === 0) {
            showToast("Please select at least one question.", 'danger');
            return;
        }

        // Collect existing question IDs to prevent duplicates
        const existingIds = [];
        sectionEl.find('input[name^="sections"]').each(function() {
            const val = $(this).val();
            if (val && !isNaN(val)) {
                existingIds.push(parseInt(val));
            }
        });

        let addedCount = 0;
        let skippedCount = 0;

        selected.forEach(q => {
            if (existingIds.includes(parseInt(q.id))) {
                skippedCount++;
                return; // Skip duplicates
            }

            const qIndex = Date.now() + Math.floor(Math.random() * 1000);

            // Question container
            let html = `
            <div class="form-group mt-2 question-block border p-3 rounded d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <input type="hidden" name="sections[${selectedSection}][questions_from_bank][]" value="${q.id}">
                    <p class="mb-2"><strong>${q.question_text}</strong></p>`;


            // Multiple Choice type — list choices with disabled checkboxes
            if (q.question_type === 'multiple_choice' && q.choices) {
                const choices = JSON.parse(q.choices)
                html += `<ul class="list-unstyled ml-3">`;
                choices.forEach(choice => {
                    html += `
                    <li class="mb-1">
                        <label class="d-flex align-items-center">
                            <input type="checkbox" disabled class="mr-2">
                            <span>${choice['ans']}</span>
                        </label>
                    </li>`;
                });
                html += `<div class="ml-3 cAnswer"><em>Answer:</em><p> ${q.correct_answer || ''}</p></div>`;
                html += `</ul>`;
            }

            // Identification / True or False type
            else if (q.question_type === 'identification' || q.question_type === 'true_false' || q.question_type === 'fill_in_the_blanks') {
                html += `<div class="ml-3 cAnswer"><em>Answer:</em><p> ${q.correct_answer || ''}</p></div>`;
            }

            // Remove button
            html += `</div>
                <button type="button" class="btn btn-sm btn-danger remove-question ms-2">Remove</button>
            </div>`;

            sectionEl.append(html);
            addedCount++;
        });

        // Close modal after adding
        $('#questionBankModal').modal('hide');

        // Feedback message
        if (addedCount > 0 || skippedCount > 0) {
            let msg = `${addedCount} question(s) added.`;
            if (skippedCount > 0) msg += ` ${skippedCount} duplicate(s) skipped.`;
            showToast(msg, 'success');
        }
    });

    // Submit form to CI
    $('#quizForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('quiz/save'); ?>",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                let data = JSON.parse(res);
                showToast("Quiz saved! ID: " + data.quiz_id, 'success');
            }
        });
    });

    // Clear form
    $('#clearForm').click(function() {
        $('#quizTitle').val('');
        $('#sections').html('');
    });

    // Download JSON
    $('#downloadJson').click(function() {
        let formData = $('#quizForm').serializeArray();
        let json = JSON.stringify(formData, null, 2);
        let blob = new Blob([json], {
            type: "application/json"
        });
        let url = URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.href = url;
        a.download = ($('#quizTitle').val() || 'quiz') + '.json';
        a.click();
    });

    // Upload JSON
    $('#uploadJson').change(function(e) {
        let file = e.target.files[0];
        if (!file) return;
        let reader = new FileReader();
        reader.onload = function(evt) {
            let jsonData = JSON.parse(evt.target.result);
            showToast("Quiz JSON Loaded: " + jsonData.length + " items", 'success');
            // TODO: Populate form dynamically from JSON
        };
        reader.readAsText(file);
    });

    // Export to PDF
    $('#exportPdf').click(function() {
        const element = document.getElementById('quizForm');
        html2pdf().from(element).save('quiz.pdf');
    });

    // Fancy Toast with Icons
    function showToast(message, type = 'info', reload = false) {
        const icons = {
            info: '<i class="toast-icon fas fa-info-circle"></i>',
            success: '<i class="toast-icon fas fa-check-circle"></i>',
            warning: '<i class="toast-icon fas fa-exclamation-triangle"></i>',
            danger: '<i class="toast-icon fas fa-times-circle"></i>'
        };

        const bgClass = {
            info: 'bg-info text-white',
            success: 'bg-success text-white',
            warning: 'bg-warning text-dark',
            danger: 'bg-danger text-white'
        } [type] || 'bg-secondary text-white';

        const toastId = 'toast-' + Date.now();
        // note: keep 'fade' class for smooth CSS transition with Bootstrap
        const toastHtml = `
            <div id="${toastId}" class="toast ${bgClass}" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2800">
                <div class="toast-body">
                    ${icons[type] || ''}<span>${message}</span>
                    <button type="button" class="close ml-auto text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>`;

        $('#toastContainer').prepend(toastHtml);
        const $toast = $('#' + toastId);

        const delay = $('#toastContainer .toast').length * 100;
        setTimeout(() => {
            $toast.toast('show');
        }, delay);

        // cleanup and optional reload
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
            if (reload) location.reload();
        });
    }


    // ====== Export Quiz JSON ======
    $('#exportQuizBtn').on('click', function() {
        const $sections = $('.section-block');

        // ✅ Fix: reference correct variable
        if ($sections.length === 0) {
            alert('No sections found. Please add at least one quiz section before exporting.');
            return;
        }

        let hasQuestions = false;
        const quizData = {
            title: $('#quizTitle').val() || '',
            totalItem: $('#totalItems').val() || '',
            sections: []
        };

        $sections.each(function() {
            const $sec = $(this);
            const sectionId = $sec.data('section-id') || null;
            const sectionType = $sec.find(`input[name="sections[${sectionId}][type]"]`).val() || '';
            const description = $sec.find(`textarea[name="sections[${sectionId}][description]"]`).val() || '';

            const sectionObj = {
                id: sectionId,
                type: sectionType,
                description,
                questions: []
            };

            $sec.find('.question-block').each(function() {
                hasQuestions = true;
                const $q = $(this);
                const $bankInput = $q.find('input[type="hidden"][name*="questions_from_bank"]');
                const bankId = $bankInput.length ? $bankInput.val() : null;

                // --- Get Question Text ---
                let questionText = '';
                if (bankId) {
                    questionText = $q.find('p strong').text().trim() || $q.find('p').text().trim();
                } else {
                    const $title = $q.find('input[name*="[title]"]').first();
                    questionText = $title.val() || $q.find('textarea').first().val() || '';
                }

                // --- Collect Choices ---
                const choices = [];

                // For questions from bank (HTML list)
                $q.find('ul li span').each(function() {
                    const t = $(this).text().trim();
                    if (t) choices.push(t);
                });

                // For manually added questions
                if (choices.length === 0) {
                    $q.find('input[name*="[choices]"]').each(function() {
                        const v = $(this).val()?.trim();
                        if (v) choices.push(v);
                    });
                }

                // --- Collect Correct Answers ---
                let ans = [];

                // Case 1: manual answer field
                const $answerField = $q.find('textarea[name*="[answer]"], input[name*="[answer]"]');
                if ($answerField.length) {
                    const val = $answerField.val()?.trim();
                    if (val) ans.push(val);
                }

                // Case 2: multiple choice with checkboxes
                $q.find('.choices .input-group').each(function() {
                    const choiceText = $(this).find('input[type="text"]').val()?.trim();
                    const isChecked = $(this).find('input[type="checkbox"]').is(':checked');
                    if (choiceText) {
                        // Avoid duplicates
                        if (!choices.includes(choiceText)) choices.push(choiceText);
                        if (isChecked) ans.push(choiceText);
                    }
                });

                // Case 3: question from bank (inside .cAnswer p)
                if (ans.length === 0) {
                    const $bankAnswer = $q.find('.cAnswer p');
                    if ($bankAnswer.length) {
                        try {
                            const parsed = JSON.parse($bankAnswer.text().trim());
                            ans = Array.isArray(parsed) ? parsed : [parsed];
                        } catch {
                            ans = [$bankAnswer.text().trim()];
                        }
                    }
                }

                const qType = bankId ? 'from_bank' : sectionType;
                sectionObj.questions.push({
                    id: bankId,
                    text: questionText,
                    type: qType,
                    choices: choices,
                    correct_answer: ans
                });
            });

            quizData.sections.push(sectionObj);
        });

        if (!hasQuestions) {
            alert('No questions found. Please add at least one question before exporting.');
            return;
        }

        console.log(quizData)

        // --- Save JSON via AJAX ---
        $.ajax({
            type: 'POST',
            url: '<?= base_url('opl/qm/save_quiz_json') ?>',
            data: {
                quizData: JSON.stringify(quizData),
                user_id: '<?= $this->session->employee_id ?>',
                grade_id: '<?= $grade_level ?>',
                subject_id: '<?= $subject_id ?>',
                section_id: '<?= $section_id ?>',
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    showToast(data.message, 'success', true);
                } else {
                    showToast(data.message || 'Error saving quiz.', 'danger');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showToast('Error saving quiz. Please try again.', 'danger');
            }
        });
    });
</script>
<!-- Toast Container -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div id="toastContainer" class="toast-container position-fixed" style="top:1rem; right:1rem; z-index:2000;"></div>
</div>

<style>
    .card {
        border-radius: 1rem;
    }

    .card-header h4 {
        letter-spacing: 0.5px;
    }

    .form-label {
        color: #444;
    }

    .form-select,
    .form-control {
        border-radius: 0.5rem;
    }

    .btn {
        border-radius: 0.5rem;
    }

    .section-block {
        background: #fff;
        border: 2px dashed #ccc;
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        transition: all 0.2s ease;
    }

    .section-block:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-block h6 {
        font-weight: bold;
        color: #0d6efd;
    }

    .question-block {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .toast {
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.35s ease;
        border-radius: .5rem;
        min-width: 260px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-bottom: .5rem;
    }

    .toast.showing,
    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast .toast-body {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: 0.9rem;
    }

    .toast-icon {
        font-size: 1.3rem;
        line-height: 1;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .quiz-preview-paper {
        background-color: #fff;
        color: #000;
        font-family: 'Times New Roman', serif;
        line-height: 1.6;
        padding: 2rem;
        border-radius: 0.5rem;
    }

    .quiz-preview-paper h3,
    .quiz-preview-paper h5 {
        font-family: Georgia, serif;
    }

    .quiz-preview-paper ol {
        padding-left: 1.2rem;
    }

    .quiz-preview-paper li {
        margin-bottom: 1rem;
    }

    .btn-outline-dark:hover {
        background-color: #212529;
        color: #fff;
    }

    .btn-gradient-primary {
        background: linear-gradient(90deg, #007bff, #00b4d8);
        border: none;
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(90deg, #0056b3, #0096c7);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
    }

    .remove-section:hover {
        background-color: #ffe5e5 !important;
        color: #dc3545 !important;
        transform: scale(1.05);
        transition: 0.2s ease-in-out;
    }

    .section-block {
        transition: all 0.3s ease;
    }

    .section-block:hover {
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .questions {
        transition: all 0.3s ease;
    }

    .questions .question-item {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        border-left: 3px solid #007bff;
    }

    #sections {
        max-height: 60vh;
        overflow-y: auto;
        padding-right: 5px;
        scroll-behavior: smooth;
    }

    #sections::-webkit-scrollbar {
        width: 8px;
    }

    #sections::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    #sections::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.4);
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">