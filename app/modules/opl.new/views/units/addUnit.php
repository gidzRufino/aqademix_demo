<section class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
        <div>
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-book me-2"></i> Add a Unit
            </h5>
            <small class="text-muted">This is all about summary</small>
        </div>
    </div>

    <div class="card-body">
        <!-- Unit Title -->
        <div class="mb-3">
            <label for="unitTitle" class="form-label">Unit Title</label>
            <input type="text" class="form-control" id="unitTitle" placeholder="Enter unit title">
        </div>

        <!-- Unit Objectives -->
        <div class="mb-3">
            <label for="unitObjectives" class="form-label">Unit Objectives</label>
            <textarea class="summernote" id="unitObjectives" placeholder="Write the objectives..."></textarea>
        </div>

        <!-- Unit Overview -->
        <div class="mb-3">
            <label for="unitOverview" class="form-label fw-semibold">Unit Overview</label>
            <textarea class="summernote" id="unitOverview" placeholder="Write the overview..."></textarea>
        </div>

        <div class="row">
            <!-- Subject -->
            <div class="mb-3">
                <label for="subjects" class="form-label">Subject</label>
                <div class="custom-select-wrapper">
                    <select id="subjects" class="form-select">
                        <?php foreach ($getSubjects as $sub):
                            $selected = ($subject_id == $sub->subject_id) ? 'selected' : ''; ?>
                            <option <?= $selected ?> value="<?= $sub->subject_id ?>"><?= $sub->subject ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Grade Level -->
            <div class="col-md-6 mb-3">
                <label for="gradeLevel" class="form-label fw-semibold">Grade Level</label>
                <div class="custom-select-wrapper position-relative">
                    <select id="gradeLevel" class="form-select">
                        <?php foreach ($gradeLevel as $gl):
                            $selected = ($grade_level == $gl->grade_id) ? 'selected' : ''; ?>
                            <option <?= $selected ?> value="<?= $gl->grade_id ?>"><?= $gl->level ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- File Attachment -->
        <div class="mb-3">
            <label for="userfile" class="form-label fw-semibold">
                File Attachment <small class="text-danger">[Optional]</small>
            </label>
            <input class="form-control" type="file" name="userfile" id="userfile">
        </div>
    </div>

    <div class="card-footer text-end bg-light rounded-bottom">
        <button class="btn btn-primary px-4" onclick="saveUnitandUpload()">
            <i class="fas fa-save me-2"></i> Save Unit
        </button>
    </div>
</section>

<!-- Hidden fields -->
<input type="hidden" id="grade_level_id" value="<?= $grade_level ?>" />
<input type="hidden" id="section_id" value="<?= $section_id ?>" />
<input type="hidden" id="subject_id" value="<?= $subjectDetails->subject_id ?>" />
<input type="hidden" id="school_year" value="<?= $school_year ?>" />

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        // initialize Summernote
        $('.summernote').summernote({
            height: 200,
            minHeight: 200,
            maxHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // caret toggle code
        const wrappers = document.querySelectorAll(".custom-select-wrapper");

        wrappers.forEach(wrapper => {
            const select = wrapper.querySelector("select");

            select.addEventListener("mousedown", function() {
                wrapper.classList.add("open");
            });

            select.addEventListener("change", function() {
                wrapper.classList.remove("open");
            });
        });

        document.addEventListener("click", function(e) {
            wrappers.forEach(wrapper => {
                if (!wrapper.contains(e.target)) {
                    wrapper.classList.remove("open");
                }
            });
        });
    });

    $(function() {
        // Summernote
        $('.textarea').summernote();

        saveUnitandUpload = function() {
            if ($('#userfile').get(0).files.length === 0) {
                saveUnit();
            } else {
                var base = $('#base').val();
                var school_year = $('#school_year').val();
                var unitObjectives = $('#unitObjectives').val();
                var unitTitle = $('#unitTitle').val();
                var unitOverview = $('#unitOverview').val();
                var fd = new FormData();
                var files = $('#userfile')[0].files[0];

                var url = base + 'opl/saveUnit';

                fd.append("userfile", files);
                fd.append("hasUpload", 1);
                fd.append("school_year", school_year);
                fd.append("unitObjectives", unitObjectives);
                fd.append("unitTitle", unitTitle);
                fd.append("unitOverview", unitOverview);
                fd.append("section_id", $("#section_id").val());
                fd.append("subject_id", $("#subject_id").val());
                fd.append("grade_level_id", $("#grade_level_id").val());
                fd.append("csrf_test_name", $.cookie("csrf_cookie_name"));

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loadingModal').modal('show');
                    },
                    success: function(data) {
                        alert(data.msg);
                        document.location = base + '/opl/unitView/' + school_year + '/List/' + $('#grade_level_id').val() + '/' + $('#section_id').val() + '/' + $('#subject_id').val();
                    },
                    error: function() {
                        alert('An error occured');
                    }
                });
            }
        }

        saveUnit = function() {

            var base = $('#base').val();
            var school_year = $('#school_year').val();
            var unitObjectives = $('#unitObjectives').val();
            var unitTitle = $('#unitTitle').val();
            var unitOverview = $('#unitOverview').val();


            var url = base + 'opl/saveUnit';
            alert($('#grade_level_id').val())

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    hasUpload: 0,
                    school_year: school_year,
                    unitObjectives: unitObjectives,
                    unitTitle: unitTitle,
                    unitOverview: unitOverview,
                    section_id: $('#section_id').val(),
                    subject_id: $('#subject_id').val(),
                    grade_level_id: $('#grade_level_id').val(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                }, // serializes the form's elements.
                dataType: 'json',
                beforeSend: function() {
                    $('#loadingModal').modal('show');
                },
                success: function(data) {
                    alert(data.msg);
                    document.location = base + '/opl/unitView/' + school_year + '/List/' + $('#grade_level_id').val() + '/' + $('#section_id').val() + '/' + $('#subject_id').val();
                }
            });

        }

    });
</script>
<style>
    /* Labels */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.35rem;
        color: #495057;
    }

    /* Rounded inputs and selects */
    .form-control,
    .form-select {
        border-radius: 50px;
        /* pill shape */
        border: 1px solid #ced4da;
        padding: 0.65rem 1.2rem;
        font-size: 0.95rem;
        transition: all 0.2s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        outline: none;
    }

    /* Dropdown caret inside */
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-wrapper .select-icon {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 16px;
        color: #6c757d;
        transition: transform 0.2s ease;
    }

    .custom-select-wrapper.open .select-icon {
        transform: translateY(-50%) rotate(180deg);
    }

    /* File input rounded */
    input[type="file"].form-control {
        border-radius: 50px;
        padding: 0.45rem 1rem;
    }

    /* Summernote refinement */
    .note-editor.note-frame {
        border-radius: 1rem;
        border: 1px solid #ced4da;
    }
</style>