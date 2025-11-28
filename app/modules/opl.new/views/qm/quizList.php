<style>
    .quiz-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 40px;
        border: 1px solid #000;
    }

    h3,
    h4 {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
    }

    .test-section {
        margin-top: 40px;
    }

    .test-section h5 {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 1.1rem;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .description {
        font-style: italic;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .question {
        margin-bottom: 20px;
    }

    .question-number {
        font-weight: bold;
    }

    input[type="text"] {
        border: none;
        border-bottom: 1px dotted #000;
        border-radius: 0;
        outline: none;
        width: 70%;
        display: inline-block;
        background: transparent;
    }

    textarea {
        border: 1px solid #000;
        border-radius: 0;
        width: 100%;
    }

    label {
        margin-left: 20px;
        display: block;
    }

    .signature-line {
        margin-top: 50px;
        border-top: 1px solid #000;
        width: 250px;
        text-align: center;
        font-size: 0.9rem;
        padding-top: 5px;
    }

    @media print {
        .btn {
            display: none;
        }

        body {
            background: #fff;
        }

        .quiz-container {
            border: none;
        }
    }
</style>
<!-- QUIZ LIST PAGE -->
<div class="container mt-4">
    <h4 class="mb-3 d-flex align-items-center">
        <i class="fas fa-list-alt mr-2"></i> Quiz List
    </h4>

    <!-- SEARCH BAR -->
    <div class="input-group mb-3" style="max-width: 400px;">
        <input type="text" id="searchQuiz" class="form-control form-control-sm" placeholder="Search quiz title...">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="thead-light">
            <tr>
                <th style="width: 5%;">#</th>
                <th>Quiz Title</th>
                <th style="width: 20%;">Date Created</th>
                <th style="width: 20%;">Actions</th>
            </tr>
        </thead>
        <tbody id="quizTableBody">
            <?php if ($quizList->num_rows() > 0): ?>
                <?php $q = 1;
                foreach ($quizList->result() as $ql): ?>
                    <tr>
                        <td><?= $q++ ?></td>
                        <td><?= htmlspecialchars($ql->quiz_title) ?></td>
                        <td><?= date('F j, Y @ h:i a', strtotime($ql->created_at)) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-info viewQuiz" data-id="<?= $ql->id ?>" data-details="<?= $ql->quiz_link ?>" data-title="<?= htmlspecialchars($ql->quiz_title) ?>" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning editQuiz" data-id="<?= $ql->id ?>" data-title="<?= htmlspecialchars($ql->quiz_title) ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger deleteQuiz" data-id="<?= $ql->id ?>" data-link="<?= base64_encode($ql->quiz_link) ?>" data-title="<?= htmlspecialchars($ql->quiz_title) ?>" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No quizzes available.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center" id="quizPagination"></ul>
    </nav>
</div>

<!-- ===================== -->
<!-- VIEW QUIZ MODAL -->
<div class="modal fade" id="viewQuizModal" tabindex="-1" role="dialog" aria-labelledby="viewQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">

            <!-- Header -->
            <div class="modal-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title mb-0" id="viewQuizModalLabel">
                    <i class="fas fa-eye mr-2"></i> View Quiz
                </h5>
                <div>
                    <button type="button" id="btnViewAnswerKey" class="btn btn-light btn-sm mr-2">
                        <i class="fas fa-key mr-1"></i> View Answer Key
                    </button>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body bg-light" id="viewQuizDetails">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h4 id="viewQuizTitle" class="text-info mb-2"></h4>
                    <p class="text-muted mb-3" id="viewQuizDescription">
                        Details about this quiz will appear here.
                    </p>

                    <hr>

                    <!-- Quiz Information -->
                    <div class="row text-sm">
                        <div class="col-md-4 mb-2">
                            <strong>Subject:</strong> <span id="viewQuizSubject" class="text-secondary">N/A</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Type:</strong> <span id="viewQuizType" class="text-secondary">N/A</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Number of Questions:</strong> <span id="viewQuizCount" class="text-secondary">0</span>
                        </div>
                    </div>

                    <div class="row text-sm">
                        <div class="col-md-4 mb-2">
                            <strong>Difficulty:</strong> <span id="viewQuizDifficulty" class="text-secondary">N/A</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Created By:</strong> <span id="viewQuizCreator" class="text-secondary">N/A</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Date Created:</strong> <span id="viewQuizDate" class="text-secondary">N/A</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Question List -->
                    <div class="mt-3" id="quizQuestionList">
                        <h5 class="text-dark mb-3">
                            <i class="fas fa-question-circle mr-2 text-info"></i> Questions
                        </h5>
                        <div class="list-group" id="viewQuizQuestions">
                            <!-- Questions will be dynamically inserted here -->
                            <div class="text-center text-muted py-3">No questions loaded yet.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-white border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>


<!-- EDIT MODAL -->
<div class="modal fade" id="editQuizModal" tabindex="-1" role="dialog" aria-labelledby="editQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editQuizModalLabel"><i class="fas fa-edit mr-2"></i>Edit Quiz</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="editQuizForm">
                <div class="modal-body">
                    <input type="hidden" id="editQuizId">
                    <div class="form-group">
                        <label for="editQuizTitle">Quiz Title</label>
                        <input type="text" class="form-control" id="editQuizTitle" required>
                    </div>
                    <small class="text-muted">More fields (e.g. description, category) can be added later.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteQuizModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteQuizModalLabel"><i class="fas fa-trash mr-2"></i>Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="delFile">
                <p>Are you sure you want to delete the quiz "<strong id="deleteQuizTitle"></strong>"?</p>
                <input type="hidden" id="deleteQuizId">
                <input type="hidden" id="quizLink">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteQuiz">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== -->
<!-- JS: Pagination + Search + Modal Handlers -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rowsPerPage = 10;
        const tableBody = document.getElementById('quizTableBody');
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const pagination = document.getElementById('quizPagination');
        const searchInput = document.getElementById('searchQuiz');

        function displayPage(page, filteredRows) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            filteredRows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });
        }

        function setupPagination(filteredRows) {
            pagination.innerHTML = '';
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (totalPages <= 1) {
                pagination.style.display = 'none';
                displayPage(1, filteredRows);
                return;
            }
            pagination.style.display = 'flex';
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('#quizPagination .page-item').forEach(el => el.classList.remove('active'));
                    li.classList.add('active');
                    displayPage(i, filteredRows);
                });
                pagination.appendChild(li);
            }
            pagination.firstChild.classList.add('active');
            displayPage(1, filteredRows);
        }

        // Search functionality
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const filtered = rows.filter(row => {
                const title = row.cells[1].innerText.toLowerCase();
                return title.includes(query);
            });
            rows.forEach(r => r.style.display = 'none');
            setupPagination(filtered);
        });

        // Initialize with all rows
        setupPagination(rows);

        function toRoman(num) {
            const romanNumerals = [
                ["M", 1000],
                ["CM", 900],
                ["D", 500],
                ["CD", 400],
                ["C", 100],
                ["XC", 90],
                ["L", 50],
                ["XL", 40],
                ["X", 10],
                ["IX", 9],
                ["V", 5],
                ["IV", 4],
                ["I", 1]
            ];

            let result = "";
            for (let [roman, value] of romanNumerals) {
                while (num >= value) {
                    result += roman;
                    num -= value;
                }
            }
            return result;
        }

        function questionType(qtype) {
            switch (qtype) {
                case 'identification':
                    return 'Identification';
                case 'multiple_choice':
                    return 'Multiple Choice';
                case 'true_false':
                    return 'True or False';
                case 'fill_in_the_blanks':
                    return 'Fill in the blanks';
                case 'essay':
                    return 'Essay';
                case 'problem_solving':
                    return 'Problem Solving';
            }
        }

        // --- Modal Handlers ---
        $(document).on('click', '.viewQuiz', function() {
            var base = '<?= base_url() ?>';
            const title = $(this).data('title');
            const details = $(this).data('details');
            let quizHtml = '';

            // Save current details URL in modal data for later (for answer key use)
            $('#viewQuizModal').data('details', details);

            // Load quiz normally (questions only)
            loadQuizView(details);

            // Set modal title and show it
            $('#viewQuizTitle').text(title);
            $('#viewQuizModal').modal('show');
        });


        // 🔹 Function to load quiz questions (normal view)
        function loadQuizView(detailsUrl) {
            var base = '<?= base_url() ?>';
            let quizHtml = '';

            fetch(base + detailsUrl)
                .then(response => response.json())
                .then(data => {
                    quizHtml += `
                <div class="quiz-container">
                    <h3><i class="fas fa-clipboard-list mr-2"></i> Quiz Title: ${data.title}</h3>
            `;
                    let i = 0;
                    let j = 0;
                    data.sections.forEach((info) => {
                        i++;
                        quizHtml += `
                <div class="test-section mt-3">
                    <h5>Test ${toRoman(i)}: ${questionType(info.type)}</h5>
                    <p class="description text-muted">${info.description || ''}</p>
                `;
                        info.questions.forEach((qq) => {
                            j++;
                            quizHtml += `
                    <div class="question mb-2">
                        <span class="question-number font-weight-bold">${j}. ${qq.text}</span>
                    `;
                            if (info.type === 'multiple_choice') {
                                quizHtml += `<div class="option pl-3">`;
                                qq.choices.forEach((ch) => {
                                    quizHtml += `<label class="d-block"><input type="radio" disabled> ${ch}</label>`;
                                });
                                quizHtml += `</div>`;
                            } else if (info.type === 'true_false') {
                                quizHtml += `
                        <div class="option pl-3">
                             <label class="mr-3"><input type="radio" disabled> True</label>
                             <label><input type="radio" disabled> False</label>
                        </div>`;
                            } else {
                                quizHtml += `<div class="mt-2"><span class="d-inline-block border-bottom border-dark" style="width: 250px;"></span></div>`;
                            }
                            quizHtml += `</div>`;
                        });
                        quizHtml += `</div>`;
                    });
                    quizHtml += `</div>`;

                    $('#viewQuizDetails').html(quizHtml);
                });
        }


        // 🔹 Function to load quiz + answers
        function loadAnswerKey(detailsUrl) {
            var base = '<?= base_url() ?>';
            let quizHtml = '';

            fetch(base + detailsUrl)
                .then(response => response.json())
                .then(data => {
                    quizHtml += `
                <div class="quiz-container">
                    <h3><i class="fas fa-key mr-2 text-success"></i> Answer Key: ${data.title}</h3>
            `;
                    let i = 0;
                    let j = 0;
                    data.sections.forEach((info) => {
                        i++;
                        quizHtml += `
                <div class="test-section mt-3">
                    <h5>Test ${toRoman(i)}: ${questionType(info.type)}</h5>
                    <p class="description text-muted">${info.description || ''}</p>
                `;
                        info.questions.forEach((qq) => {
                            j++;
                            quizHtml += `
                    <div class="question mb-2">
                        <span class="question-number font-weight-bold">${j}. ${qq.text}</span><br>
                    `;
                            // Show correct answer (you can adjust based on your JSON structure)
                            quizHtml += `
                        <div class="mt-1 text-success">
                            <i class="fas fa-check-circle mr-1"></i><strong>Answer:</strong> ${qq.correct_answer || 'N/A'}
                        </div>
                    `;
                            quizHtml += `</div>`;
                        });
                        quizHtml += `</div>`;
                    });
                    quizHtml += `</div>`;

                    $('#viewQuizDetails').html(quizHtml);
                });
        }


        // 🔹 Toggle button behavior
        $(document).on('click', '#btnViewAnswerKey', function() {
            const details = $('#viewQuizModal').data('details');
            const isAnswerView = $(this).data('answer-view') === true;

            if (!isAnswerView) {
                // Switch to answer key view
                loadAnswerKey(details);
                $(this).html('<i class="fas fa-arrow-left mr-1"></i> Back to Questions');
                $(this).data('answer-view', true);
            } else {
                // Switch back to question view
                loadQuizView(details);
                $(this).html('<i class="fas fa-key mr-1"></i> View Answer Key');
                $(this).data('answer-view', false);
            }
        });

        $(document).on('click', '.editQuiz', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            $('#editQuizId').val(id);
            $('#editQuizTitle').val(title);
            $('#editQuizModal').modal('show');
        });

        $('#editQuizForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editQuizId').val();
            const newTitle = $('#editQuizTitle').val();
            alert('Quiz updated (ID: ' + id + ') — New Title: ' + newTitle);
            $('#editQuizModal').modal('hide');
        });

        $(document).on('click', '.deleteQuiz', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const link = $(this).data('link');
            $('#deleteQuizId').val(id);
            $('#deleteQuizTitle').text(title);
            $('#quizLink').val(link);
            $('#deleteQuizModal').modal('show');
        });

        $('#confirmDeleteQuiz').on('click', function() {
            const id = $('#deleteQuizId').val();
            const link = $('#quizLink').val();
            const title = $('#deleteQuizTitle').text();
            var name = '<?= $this->session->basicInfo->firstname . ' ' . $this->session->basicInfo->lastname ?>';
            var uid = '<?= $this->session->basicInfo->user_id ?>';
            var url = '<?= base_url() . 'opl/qm/removeQuiz/' ?>';

            $.ajax({
                type: 'GET',
                url: url + id + '/' + link + '/' + name + '/' + title + '/' + uid,
                dataType: 'json',
                success: function(data) {
                    $('#delFile').text(data.msg)
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                }
            })
        });
    });
</script>