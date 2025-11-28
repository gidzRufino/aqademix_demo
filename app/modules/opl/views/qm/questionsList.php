<!-- ====== STYLES ====== -->
<style>
	body {
		background: #f5f7fa;
		font-family: "Poppins", sans-serif;
	}

	.container {
		max-width: 1100px;
	}

	.card {
		border: none;
		border-radius: 1rem;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
		transition: transform 0.2s ease;
	}

	.card:hover {
		transform: translateY(-2px);
	}

	.card-header {
		font-weight: 600;
		padding: 0.85rem 1.25rem;
		border: none;
	}

	.card-header.bg-primary {
		background: linear-gradient(135deg, #007bff, #0056d8);
	}

	.card-header.bg-secondary {
		background: linear-gradient(135deg, #6c757d, #495057);
	}

	.preview-card {
		background: #fff;
		border: 2px dashed #e0e0e0;
		border-radius: 0.75rem;
		padding: 20px;
		min-height: 230px;
		transition: all 0.3s ease;
	}

	.preview-card:hover {
		border-color: #007bff;
		box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
	}

	.choice-item {
		padding: 10px 12px;
		background: #f8f9fa;
		border: 1px solid #dee2e6;
		border-radius: 0.5rem;
		margin-bottom: 6px;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.choice-item:hover {
		background: #e9f2ff;
		border-color: #b6d4fe;
	}

	.badge-correct {
		background-color: #28a745;
		color: white;
		font-size: 0.75rem;
		padding: 4px 8px;
		border-radius: 0.25rem;
		font-weight: 500;
	}

	.btn-success {
		padding: 10px 18px;
		border-radius: 0.5rem;
		font-weight: 500;
	}

	.btn-secondary {
		border-radius: 0.5rem;
		font-weight: 500;
	}

	label {
		font-weight: 500;
	}

	.form-control {
		border-radius: 0.5rem;
		box-shadow: none !important;
		transition: border-color 0.2s ease;
	}

	.form-control:focus {
		border-color: #007bff;
	}

	table {
		border-radius: 0.5rem;
		overflow: hidden;
	}

	thead {
		background: linear-gradient(135deg, #007bff, #0056d8);
		color: white;
	}

	.table td,
	.table th {
		vertical-align: middle !important;
	}

	tr:hover {
		background-color: #f8f9fa;
	}

	.fade-out {
		opacity: 0;
		transition: opacity 0.4s ease;
	}

	.btn-sm i {
		font-size: 14px;
		line-height: 1;
	}

	.btn-sm {
		width: 32px;
		height: 32px;
		padding: 0;
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}
</style>

<!-- ====== HTML STRUCTURE ====== -->
<div class="container mt-5 mb-5">

	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success shadow-sm"><?= $this->session->flashdata('success') ?></div>
	<?php endif; ?>

	<div class="row">
		<!-- LEFT FORM -->
		<div class="col-md-6 mb-4">
			<div class="card">
				<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
					<span><i class="fas fa-plus-circle mr-2"></i> Add Question</span>
				</div>

				<div class="card-body">
					<form id="questionForm" method="post" action="<?php echo site_url('question_bank/save'); ?>">
						<div class="form-group">
							<label><i class="fas fa-layer-group text-primary mr-1"></i>Question Type</label>
							<select class="form-control" id="question_type" name="question_type" required>
								<option value="">-- Select Type --</option>
								<option value="multiple_choice">Multiple Choice</option>
								<option value="identification">Identification</option>
								<option value="fill_in_the_blanks">Fill in the Blanks</option>
								<option value="true_false">True or False</option>
								<option value="essay">Essay</option>
								<option value="problem_solving">Problem Solving</option>
							</select>
						</div>

						<div class="form-group">
							<label><i class="fas fa-pen text-primary mr-1"></i>Question Text</label>
							<textarea class="form-control" name="question_text" id="question_text" rows="3" required placeholder="Enter your question here..."></textarea>
						</div>

						<div id="answer_section"></div>

						<div class="text-right mt-4">
							<button type="submit" class="btn btn-success">
								<i class="fas fa-save"></i> Save Question
							</button>
						</div>
						<input type="hidden" id="grade_id" name="grade_id" value="<?= $grade_level ?>">
						<input type="hidden" id="subject_id" name="subject_id" value="<?= $subject_id ?>">
						<input type="hidden" id="section_id" name="section_id" value="<?= $section_id ?>">

					</form>
				</div>
			</div>
		</div>

		<!-- RIGHT PREVIEW -->
		<div class="col-md-6 mb-4">
			<div class="card">
				<div class="card-header bg-secondary text-white">
					<i class="fas fa-eye mr-2"></i> Preview
				</div>
				<div class="card-body">
					<div class="preview-card" id="previewArea">
						<p class="text-muted text-center my-4">
							<i class="fas fa-info-circle mr-2"></i> Your question preview will appear here.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- QUESTION LIST -->
	<div class="card">
		<div class="card-header bg-primary text-white">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<div class="d-flex align-items-center">
					<i class="fas fa-list mr-2"></i>
					<span class="font-weight-bold">Question List</span>
				</div>

				<div class="d-flex align-items-center">
					<label class="mr-2 mb-0"><i class="fas fa-filter text-light"></i> Type:</label>
					<select id="filterType" class="form-control mr-3" style="width:180px;">
						<option value="">All</option>
						<option value="multiple_choice">Multiple Choice</option>
						<option value="identification">Identification</option>
						<option value="fill_in_the_blanks">Fill in the Blanks</option>
						<option value="true_false">True or False</option>
						<option value="essay">Essay</option>
						<option value="problem_solving">Problem Solving</option>
					</select>

					<div class="input-group" style="width: 250px;">
						<input type="text" id="searchInput" class="form-control" placeholder="Search question...">
						<div class="input-group-append">
							<button class="btn btn-light" id="searchBtn"><i class="fas fa-search text-primary"></i></button>
						</div>
					</div>
				</div>
			</div>

			<nav>
				<ul id="pagination" class="pagination mb-0"></ul>
			</nav>
		</div>

		<div class="card-body">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">#</th>
						<th>Question</th>
						<th width="15%">Type</th>
						<th width="20%" class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody id="questionList">
					<tr>
						<td colspan="4" class="text-center text-muted">No questions yet.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- ====== MODAL FOR QUESTION DETAILS ====== -->
<div class="modal fade" id="viewQuestionModal" tabindex="-1" aria-labelledby="viewQuestionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title" id="viewQuestionModalLabel"><i class="fas fa-search mr-2"></i> Question Details</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modalContent">
					<p class="text-center text-muted">Loading...</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<i class="fas fa-times"></i> Close
				</button>
			</div>
		</div>
	</div>
</div>

<!-- ====== MODAL FOR UPDATE QUESTION ====== -->
<div class="modal fade" id="updateQuestionModal" tabindex="-1" aria-labelledby="updateQuestionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-success text-white">
				<h5 class="modal-title" id="updateQuestionModalLabel">
					<i class="fas fa-edit mr-2"></i> Update Question
				</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="updateQuestionForm" method="post">
				<div class="modal-body">
					<input type="hidden" name="question_id" id="update_question_id">

					<div class="form-group">
						<label><i class="fas fa-layer-group text-success mr-1"></i>Question Type</label>
						<select class="form-control" id="update_question_type" name="question_type" required>
							<option value="">-- Select Type --</option>
							<option value="multiple_choice">Multiple Choice</option>
							<option value="identification">Identification</option>
							<option value="fill_in_the_blanks">Fill in the Blanks</option>
							<option value="true_false">True or False</option>
							<option value="essay">Essay</option>
							<option value="problem_solving">Problem Solving</option>
						</select>
					</div>

					<div class="form-group">
						<label><i class="fas fa-pen text-success mr-1"></i>Question Text</label>
						<textarea class="form-control" id="update_question_text" name="question_text" rows="3" required></textarea>
					</div>

					<div id="update_answer_section"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<i class="fas fa-times"></i> Cancel
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fas fa-save"></i> Save Changes
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ====== SCRIPTS ====== -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
	const typeSelect = document.getElementById('question_type');
	const textInput = document.getElementById('question_text');
	const section = document.getElementById('answer_section');
	const preview = document.getElementById('previewArea');
	const clearBtn = document.getElementById('clearFormBtn');
	const questionList = document.getElementById('questionList');

	const grade_id = '<?= $grade_level ?>'
	const subject_id = '<?= $subject_id ?>'
	$(document).ready(function() {
		listQuestions();
	})

	let questionCounter = 0;

	typeSelect.addEventListener('change', renderFields);
	textInput.addEventListener('input', updatePreview);

	function renderFields() {
		const type = typeSelect.value;
		section.innerHTML = '';

		if (type === 'multiple_choice') {
			let html = '<label><i class="fas fa-list-ol text-primary mr-1"></i>Choices</label>';
			for (let i = 1; i <= 4; i++) {
				html += `
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input type="checkbox" name="correct_choices[]" value="${i}" onchange="updatePreview()">
							</div>
						</div>
						<input type="text" class="form-control" name="choice_${i}" placeholder="Choice ${i}" oninput="updatePreview()">
					</div>`;
			}
			html += '<small class="form-text text-muted">Check the correct answer(s).</small>';
			section.innerHTML = html;
		} else if (type === 'identification') {
			section.innerHTML = `
				<div class="form-group">
					<label><i class="fas fa-key text-primary mr-1"></i>Correct Answer</label>
					<input type="text" class="form-control" name="correct_answer" oninput="updatePreview()" required placeholder="Enter correct answer">
				</div>`;
		} else if (type === 'fill_in_the_blanks') {
			section.innerHTML = `
				<div class="form-group">
					<label><i class="fas fa-underline text-primary mr-1"></i>Correct Word(s)</label>
					<input type="text" class="form-control" name="correct_answer" oninput="updatePreview()" required placeholder="Enter missing word(s)">
					<small class="form-text text-muted">Use “____” in your question text to mark the blank.</small>
				</div>`;
		} else if (type == 'true_false') {
			section.innerHTML = `
				<div class="form-group">
					<label><i class="fas fa-underline text-primary mr-1"></i>Correct Answer</label>
					<select class="form-control" name="correct_answer" oninput="updatePreview()" required>
						<option>Select Option</option>
						<option value="true">True</option>
						<option value="false">False</option>
					</select>
				</div>`;
		}
		updatePreview();
	}

	function updatePreview() {
		const type = typeSelect.value;
		const qtext = textInput.value.trim();
		if (!type || !qtext) {
			preview.innerHTML = `
				<p class="text-muted text-center my-4">
					<i class="fas fa-info-circle mr-2"></i> Your question preview will appear here.
				</p>`;
			return;
		}

		let html = `<h5 class="font-weight-bold">${qtext}</h5><hr>`;

		if (type === 'multiple_choice') {
			const choices = document.querySelectorAll('[name^="choice_"]');
			if (choices.length) {
				choices.forEach((c, i) => {
					if (c.value.trim()) {
						const checked = document.querySelector(`[value="${i + 1}"]`).checked;
						html += `
							<div class="choice-item">
								<div>${String.fromCharCode(65 + i)}. ${c.value.trim()}</div>
								${checked ? '<span class="badge-correct"><i class="fas fa-check"></i> Correct</span>' : ''}
							</div>`;
					}
				});
			}
		} else if (type === 'identification') {
			const ans = document.querySelector('[name="correct_answer"]');
			html += `<p><strong>Answer:</strong> ${ans ? ans.value.trim() : ''}</p>`;
		} else if (type === 'fill_in_the_blanks') {
			const ans = document.querySelector('[name="correct_answer"]');
			html += `<p>${qtext.replace('____', '<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>')}</p>`;
			html += `<p><strong>Correct Word:</strong> ${ans ? ans.value.trim() : ''}</p>`;
		} else if (type === 'true_false') {
			const ans = document.querySelector('[name="correct_answer"]');
			html += `<p><strong>Answer:</strong> ${ans ? ans.value.trim() : ''}</p>`;
		}
		preview.innerHTML = html;
	}

	// CSRF tokens
	const csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
	const csrfHash = "<?= $this->security->get_csrf_hash(); ?>";

	$('#questionForm').on('submit', function(e) {
		e.preventDefault();

		// Create FormData object
		const formData = new FormData(this);

		// Ensure unchecked checkboxes are included as false (if needed)
		$(this).find('input[type=checkbox]').each(function() {
			if (!formData.has(this.name)) {
				formData.append(this.name, '0'); // or 'false'
			}
		});

		// If you have multiple-choice options, gather them explicitly
		// Example: inputs named "choices[]" or "correct_answers[]"
		$(this).find('input[name^="choices"], input[name^="correct_answers"]').each(function() {
			formData.append(this.name, $(this).val());
		});

		// Add CSRF token
		formData.append(csrfName, csrfHash);

		// Optional: Debug – view all form values in console
		console.group("Form Data Submitted");
		for (let [key, value] of formData.entries()) {
			// console.log(key, ":", value);
		}
		console.groupEnd();

		// Submit via AJAX
		$.ajax({
			url: "<?= base_url('opl/qm/save') ?>",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function(response) {
				if (response.csrfName && response.csrfHash) {
					window.csrfName = response.csrfName;
					window.csrfHash = response.csrfHash;
				}

				if (response.success) {
					alert(response.message || 'Saved successfully!');
				} else {
					alert(response.message || 'Save failed. Please check your input.');
				}
				location.reload();
				listQuestions();
				clearForm();
			},
			error: function(xhr) {
				console.error('AJAX Error:', xhr.status, xhr.statusText, xhr.responseText);
				alert('Request failed: ' + xhr.status + ' ' + xhr.statusText);
			}
		});
	});

	// function listQuestions() {
	// 	var url = '<?= base_url('opl/qm/listQuestions/') ?>' + grade_id + '/' + subject_id

	// 	$.ajax({
	// 		type: 'GET',
	// 		url: url,
	// 		success: function(data) {
	// 			$('#questionList').html(data)
	// 		}
	// 	})
	// }

	function listQuestions(page = 1) {
		const limit = 5;
		const type = $('#filterType').val();
		const search = $('#searchInput').val().trim(); // <-- added search value

		$.ajax({
			url: "<?= base_url('opl/qm/listQuestionsAjax') ?>",
			type: "GET",
			data: {
				page: page,
				limit: limit,
				type: type,
				search: search, // <-- send search query
				grade_id: grade_id,
				subject_id: subject_id
			},
			dataType: "json",
			success: function(response) {
				const data = response.questions;
				const total = response.total;
				const currentPage = response.page;
				const totalPages = Math.ceil(total / limit);

				let html = '';
				if (data.length > 0) {
					data.forEach((q, i) => {
						html += `
            <tr>
              <td>${(page - 1) * limit + (i + 1)}</td>
              <td>${q.question_text}</td>
              <td>${q.question_type.replaceAll('_', ' ')}</td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <button class="btn btn-info btn-sm rounded-circle mr-2" title="View" onclick='viewQuestionDetails(${JSON.stringify(q)})'>
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-success btn-sm rounded-circle mr-2" title="Edit" onclick='editQuestion(${JSON.stringify(q)})'>
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-danger btn-sm rounded-circle" title="Delete" onclick='deleteQuestion(${q.id})'>
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>`;
					});
				} else {
					html = `<tr><td colspan="4" class="text-center text-muted">No questions found.</td></tr>`;
				}
				$('#questionList').html(html);

				// === Pagination ===
				let pagHtml = '';
				if (totalPages > 1) {
					for (let i = 1; i <= totalPages; i++) {
						pagHtml += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
              <a class="page-link" href="#" onclick="listQuestions(${i})">${i}</a>
            </li>`;
					}
				}
				$('#pagination').html(pagHtml);
			},
			error: function(xhr) {
				console.error('AJAX Error:', xhr.status, xhr.statusText);
			}
		});
	}

	// Reload when filter or search changes
	$('#filterType').on('change', function() {
		listQuestions(1);
	});

	// Search when pressing Enter or clicking button
	$('#searchBtn').on('click', function() {
		listQuestions(1);
	});

	$('#searchInput').on('keypress', function(e) {
		if (e.which === 13) listQuestions(1);
	});


	function viewQuestionDetails(data) {
		$('#viewQuestionModal').modal('show');

		let qData = $('#modalContent');
		const mc = [];
		if (data.question_type == 'multiple_choice') {
			const ch = JSON.parse(data.choices);
			if (ch.length > 0) {
				ch.forEach((c) => {

				})
			}
		}

		qData.html(`
		<h5 class="font-weight-bold">${data.question_text}</h5>
		<p><strong>Type:</strong> ${data.question_type}</p><hr>
		`)

		if (data.question_type === 'multiple_choice') {
			const ch = JSON.parse(data.choices);
			if (ch.length > 0) {
				ch.forEach((c, i) => {
					if (c.is_correct) {
						qData.append(`
						<div class="choice-item">
							<div>${String.fromCharCode(65 + i)}. ${c.ans}</div>
							<span class="badge-correct"><i class="fas fa-check"></i> Correct</span>
						</div>
						`)
					} else {
						qData.append(`
						<div class="choice-item">
							<div>${String.fromCharCode(65 + i)}. ${c.ans}</div>
						</div>
						`)
					}
				})
			}
		} else if (data.question_type === 'identification') {
			qData.append(`
			<p><strong>Answer:</strong> ${data.correct_answer ? data.correct_answer.trim() : ''}</p>
			`)
		} else if (data.question_type === 'fill_in_the_blanks') {
			qData.append(`
			<p><strong>Correct Word:</strong> ${data.correct_answer ? data.correct_answer.trim() : ''}</p>
			`)
		}
	}

	function clearForm() {
		document.getElementById('questionForm').reset();
		section.innerHTML = '';
		updatePreview();
	}

	// Open the update modal with question data
	function editQuestion(data) {
		$('#updateQuestionModal').modal('show');

		$('#update_question_id').val(data.id);
		$('#update_question_type').val(data.question_type);
		$('#update_question_text').val(data.question_text);

		renderUpdateFields(data);
	}

	// Dynamically render the correct fields
	function renderUpdateFields(data) {
		const type = data.question_type;
		let html = '';

		if (type === 'multiple_choice') {
			const ch = JSON.parse(data.choices);
			html += '<label><i class="fas fa-list-ol text-success mr-1"></i>Choices</label>';
			ch.forEach((c, i) => {
				html += `
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" name="correct_choices[]" value="${i}" ${c.is_correct ? 'checked' : ''}>
					</div>
				</div>
				<input type="text" class="form-control" name="choice_${i}" value="${c.ans}">
			</div>`;
			});
			html += `<small class="form-text text-muted">Check the correct answer(s).</small>`;
		} else if (type === 'identification') {
			html = `
		<div class="form-group">
			<label><i class="fas fa-key text-success mr-1"></i>Correct Answer</label>
			<input type="text" class="form-control" name="correct_answer" value="${data.correct_answer}">
		</div>`;
		} else if (type === 'fill_in_the_blanks') {
			html = `
		<div class="form-group">
			<label><i class="fas fa-underline text-success mr-1"></i>Correct Word(s)</label>
			<input type="text" class="form-control" name="correct_answer" value="${data.correct_answer}">
		</div>`;
		} else if (type === 'true_false') {
			html = `
			<div class="form-group">
				<label><i class="fas fa-underline text-success mr-1"></i>Correct Answer</label>
				<select class="form-control" name="correct_answer">
					<option value="true" ${data.correct_answer === 'true' ? 'selected' : ''}>True</option>
					<option value="false" ${data.correct_answer === 'false' ? 'selected' : ''}>False</option>
				</select>
			</div>
			`;
		}

		$('#update_answer_section').html(html);
	}

	// Submit update form
	$('#updateQuestionForm').on('submit', function(e) {
		e.preventDefault();

		const formData = new FormData(this);
		formData.append(csrfName, csrfHash);

		$.ajax({
			url: "<?= base_url('opl/qm/update') ?>",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function(response) {
				if (response.success) {
					alert('Question updated successfully!');
					$('#updateQuestionModal').modal('hide');
					listQuestions();
				} else {
					alert(response.message || 'Update failed.');
				}
				location.reload();
			},
			error: function(xhr) {
				console.error('AJAX Error:', xhr.status, xhr.statusText);
				alert('Update failed: ' + xhr.statusText);
			}
		});
	});

	// Delete Question
	function deleteQuestion(id) {
		if (!confirm("Are you sure you want to delete this question?")) return;

		$.ajax({
			url: "<?= base_url('opl/qm/delete') ?>/" + id,
			type: "POST",
			data: {
				[csrfName]: csrfHash // CSRF protection
			},
			dataType: "json",
			success: function(response) {
				if (response.success) {
					alert('Question deleted successfully!');
					listQuestions(); // refresh table
				} else {
					alert(response.message || 'Failed to delete question.');
				}

				// Update CSRF token if provided
				if (response.csrfName && response.csrfHash) {
					window.csrfName = response.csrfName;
					window.csrfHash = response.csrfHash;
				}
			},
			error: function(xhr) {
				console.error("AJAX Error:", xhr.status, xhr.statusText);
				alert("Request failed: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
</script>