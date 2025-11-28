<style>
	.questionsList td li {
		list-style: none;
	}
</style>
<div class="card">
	<div class="card-body">
		<nav class="navbar navbar-expand-md">
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
				<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="questionTab" data-toggle="pill" href="#questions" role="tab" aria-controls="question" aria-selected="true">Questions List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="quizzesTab" data-toggle="pill" href="#quizzes" role="tab" aria-controls="quizzes" aria-selected="false">List of Quizzes</a>
					</li>
				</ul>
			</div>
			<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<input type="text" class="form-control" placeholder="Type any key an press enter" onkeyup="if(event.which == 13) new qbClass().searchQB(this, 0);"></li>
					</li>
				</ul>
			</div>
		</nav>
		<div class="tab-content" id="qtTabContent">
			<div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="	questions">
				<div class="qPaginationRow"></div>
				<table class="table table-responsive-sm table-stripe" id="questionRows">
				</table>
				<div class="qPaginationRow"></div>
			</div>
			<div class="tab-pane fade" id="quizzes" role="tabpanel" aria-labelledby="quizzes">
				<div class="paginationRow"></div>
				<table class="table table-responsive-sm table-stripe" id="quizRows">
				</table>
				<div class="paginationRow"></div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<script type="text/javascript">
	$(document).ready(function() {
		qb = new qbClass();
		deleteQuiz = function(sys_code) {
			var base = $('#base').val();
			var url = base + 'opl/qm/deleteQuiz';

			var con = confirm('Are you sure you want to delete this Assessment, please note that you cannot undo the process');
			if (con === true) {
				$.ajax({
					type: "POST",
					url: url,
					data: {
						school_year: $('#school_year').val(),
						quizCode: sys_code,
						csrf_test_name: $.cookie('csrf_cookie_name')
					}, // serializes the form's elements.
					//dataType: 'json',
					beforeSend: function() {
						$('#loadingModal').modal('show');
					},
					success: function(data) {
						alert(data);
						location.reload();
					}
				});
			}
		};

		deleteQuestion = function(sys_code) {
			var base = $('#base').val();
			var url = base + 'opl/qm/deleteQuestion';

			var con = confirm('Are you sure you want to delete this question, please note that you cannot undo the process');
			if (con === true) {
				$.ajax({
					type: "POST",
					url: url,
					data: {
						school_year: $('#school_year').val(),
						sys_code: sys_code,
						csrf_test_name: $.cookie('csrf_cookie_name')
					}, // serializes the form's elements.
					//dataType: 'json',
					beforeSend: function() {
						$('#loadingModal').modal('show');
					},
					success: function(data) {
						alert(data);
						location.reload();
					}
				});
			}
		};


		$(".paginationRow").on("click", "span", function(e) {
			e.preventDefault();
			var pageno = $(this).find('a').attr('data-ci-pagination-page');
			qb.loadQuizes(pageno);
		});

		$(".qPaginationRow").on("click", "span", function(e) {
			e.preventDefault();
			var pageno = $(this).find('a').attr('data-ci-pagination-page');
			qb.loadQuestions(pageno);
		});

		qb.loadQuestions(0);

		qb.loadQuizes(0);
	});

	class qbClass {

		searchQB = function(inp, page = 0) {
			var inp = $(inp),
				search = inp.val();
			if ($("#questions").hasClass("active")) {
				if (search !== '') {
					$.ajax({
						url: "<?php echo site_url('opl/qm/searchQuestion/'); ?>" + btoa(search) + "<?php echo '/' . $teacher_id . '/' . $this->session->school_year . '/'; ?>" + page,
						type: 'GET',
						dataType: 'JSON',
						beforeSend: function() {
							inp.prop("disabled", true);
							inp.val("Searching...")
						},
						success: function(data) {
							$("#questionRows").html(data.questions);
							$(".qPaginationRow").html(data.paginate);
							inp.val(search);
							inp.prop("disabled", false);
						}
					});
				} else {
					this.loadQuestions(0);
				}
			} else if ($("#quizzes").hasClass("active")) {
				if (search !== "") {
					$.ajax({
						url: "<?php echo site_url('opl/qm/searchQuizzes/'); ?>" + btoa(search) + "<?php echo '/' . $teacher_id . '/' . $this->session->school_year . '/'; ?>" + page,
						type: 'GET',
						dataType: 'JSON',
						beforeSend: function() {
							inp.prop("disabled", true);
							inp.val("Searching...")
						},
						success: function(data) {
							$('#quizRows').html(data.quiz);
							$(".paginationRow").html(data.paginate);
							inp.val(search);
							inp.prop("disabled", false);
						}
					});
				} else {
					this.loadQuizes(0);
				}
			}
		}

		loadQuizes = function(page = 0) {
			$.ajax({
				url: "<?php echo site_url('opl/qm/getAllQuizzes/' . $teacher_id . '/' . $this->session->school_year . '/'); ?>" + page,
				type: 'GET',
				dataType: 'JSON',
				success: function(data) {
					$('#quizRows').html(data.quiz);
					$(".paginationRow").html(data.paginate);
				}
			});
		}

		loadQuestions = function(page = 0) {
			$.ajax({
				url: "<?php echo site_url('opl/qm/getAllQuestions/' . $teacher_id . '/' . $this->session->school_year . '/'); ?>" + page,
				type: 'GET',
				dataType: 'JSON',
                                beforeSend: function () {
                                   $('#questionRows').html('<img style="display:block; margin:0 auto; width:125px;"  src="">');
                                },
				success: function(data) {
					$("#questionRows").html(data.questions);
					$(".qPaginationRow").html(data.paginate);
				}
			})
		}
	}
</script>