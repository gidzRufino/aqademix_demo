<section>
    <div class="card card-outline card-primary shadow-sm">
        <?php if (count($discussionDetails) != 0): ?>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-comments"></i> Discussions</h5>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" id="discussionSearch" class="form-control" placeholder="Search lesson...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row" id="discussionList">
                    <?php foreach ($discussionDetails as $discussion): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3 discussion-item">
                            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all rounded-lg">
                                <div class="card-body d-flex align-items-start">
                                    <i class="fa fa-arrow-circle-right text-primary fa-lg mr-2 mt-1"></i>
                                    <div>
                                        <a href="<?php echo base_url('opl/student/discussionDetails/' . $discussion->dis_sys_code . '/' . $this->session->details->school_year . '/' . $gradeLevel . '/' . $subject_id) ?>"
                                            class="font-weight-bold text-dark stretched-link discussion-title">
                                            <?php echo ucwords(strtolower($discussion->dis_title)) ?>
                                        </a>
                                        <p class="text-muted small mb-0">Click to view lesson details</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="card-body text-center p-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Lessons Available</h4>
                <p class="text-muted small">Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-3px);
        transition: all 0.3s ease-in-out;
    }
</style>

<script>
    document.getElementById("discussionSearch").addEventListener("keyup", function() {
        var filter = this.value.toLowerCase();
        var items = document.querySelectorAll("#discussionList .discussion-item");

        items.forEach(function(item) {
            var title = item.querySelector(".discussion-title").textContent.toLowerCase();
            item.style.display = title.includes(filter) ? "" : "none";
        });
    });
</script>