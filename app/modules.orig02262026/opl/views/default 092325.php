<!-- Quick Post Card -->
<div class="card shadow-sm border-0 rounded-lg mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-paper-plane mr-2"></i>Quick Post</h6>
    </div>
    <div class="card-body">
        <div class="form-group">
            <textarea id="postDetails" class="summernote"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="form-group mb-0">
                <select class="form-control form-control-sm" id="postTarget" onchange="setStudentExceptions($(this).val())">
                    <option value="0">All</option>
                    <?php if ($this->session->isOplAdmin == 1): ?>
                        <option value="1">Teachers</option>
                    <?php endif; ?>
                    <option value="2">Parents</option>
                    <?php if ($this->session->isOplAdmin == 1): ?>
                        <option value="3">Grades or Courses</option>
                    <?php endif; ?>
                    <option value="4">Sections and Classes</option>
                </select>
                <input type="hidden" id="postTargetID" />
            </div>
            <button type="button" class="btn btn-primary btn-sm px-4" onclick="submitQuickPost()">
                <i class="fas fa-paper-plane mr-1"></i>Post
            </button>
        </div>
    </div>
</div>

<!-- Subject Cards -->
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Teacher Dashboard</h5>
        </div>
        <div class="card-body">
            <div class="subject-card-wrapper">
                <?php foreach ($subjectDetails as $s): ?>
                    <div class="subject-card" onclick="openPanel('<?= $s->subject ?>')">
                        <div class="subject-name">
                            <?= $s->subject . ' - ' . $s->level . ' [ ' . $s->section . ' ]' ?>
                        </div>
                        <div class="badge-group d-flex justify-content-between mt-3">
                            <div class="badge-wrapper text-center">
                                <span class="badge-label d-block">Task</span>
                                <span class="badge">2</span>
                            </div>
                            <div class="badge-wrapper text-center">
                                <span class="badge-label d-block">Discussion</span>
                                <span class="badge">5</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Slide-in Panel -->
<div class="panel-overlay" id="panelOverlay"></div>
<div class="slide-panel" id="slidePanel">
    <button class="close" id="closePanel">&times;</button>
    <div class="slide-panel-header">
        <h5 id="panelTitle" class="mb-0"></h5>
    </div>
    <div class="slide-panel-body" id="panelContent"></div>
</div>

<!-- Example Modals -->
<div class="modal fade" id="selectInclusion" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-lg shadow">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title">Select Inclusion</h6>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Modal body content -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-sm btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Outer Teacher Dashboard card */
    .container-fluid .card {
        margin: 0 auto;
        max-width: 100%;
        /* narrower container */
        border-radius: 0.75rem;
    }

    .container-fluid .card-body {
        padding: 1rem 1.25rem;
    }

    /* Subject Cards */
    .subject-card-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }

    .subject-card {
        flex: 1 1 calc(50% - 1rem);
        /* two per row */
        min-width: 260px;
        max-width: 400px;
        border-radius: 0.85rem;
        padding: 1rem 1.25rem;
        color: #fff;
        background: linear-gradient(135deg, #667eea, #764ba2);
        /* fallback */
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: pointer;
    }

    .subject-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.3);
    }

    .subject-name {
        font-size: 1rem;
        font-weight: 600;
    }

    .badge {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.25);
        font-weight: bold;
    }

    .badge-label {
        font-size: 0.7rem;
        opacity: 0.85;
    }

    /* Slide Panel */
    .panel-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }

    .slide-panel {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100%;
        background: #fff;
        box-shadow: -2px 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 12px 0 0 12px;
        z-index: 1050;
        transition: right 0.3s ease;
    }

    .slide-panel.active {
        right: 0;
    }

    .slide-panel-header {
        background: #007bff;
        color: #fff;
        padding: 1rem;
        border-radius: 12px 0 0 0;
    }

    .slide-panel-body {
        padding: 1rem;
    }

    .slide-panel .close {
        position: absolute;
        top: 12px;
        left: 12px;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        color: #fff;
    }

    /* Modal */
    .modal-content {
        border-radius: 1rem;
    }
</style>

<script>
    function openPanel(title) {
        document.getElementById('panelTitle').innerText = title;
        document.getElementById('panelOverlay').style.display = 'block';
        document.getElementById('slidePanel').classList.add('active');
    }
    document.getElementById('closePanel').addEventListener('click', closePanel);
    document.getElementById('panelOverlay').addEventListener('click', closePanel);

    function closePanel() {
        document.getElementById('panelOverlay').style.display = 'none';
        document.getElementById('slidePanel').classList.remove('active');
    }

    $(document).ready(function() {
        $('#postDetails').summernote({
            height: 120,
            placeholder: 'Write something...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const gradients = [
            "linear-gradient(135deg, #007bff, #0056b3)", // blue
            "linear-gradient(135deg, #dc3545, #a71d2a)", // red
            "linear-gradient(135deg, #28a745, #1e7e34)", // green
            "linear-gradient(135deg, #6f42c1, #4e2889)", // purple
            "linear-gradient(135deg, #fd7e14, #cc5800)", // orange
            "linear-gradient(135deg, #20c997, #138f75)" // teal
        ];

        document.querySelectorAll(".subject-card").forEach(card => {
            const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];
            card.style.background = randomGradient;
        });
    });
</script>