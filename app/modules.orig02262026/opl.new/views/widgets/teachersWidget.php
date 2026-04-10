<?php
function timeAgo($datetime)
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return $diff . " seconds ago";
    } elseif ($diff < 3600) {
        return floor($diff / 60) . " minutes ago";
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . " hours ago";
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . " days ago";
    } elseif ($diff < 2419200) {
        return floor($diff / 604800) . " weeks ago";
    } else {
        return date("M d, Y", $timestamp); // fallback to normal date
    }
}
?>
<style>
    .task-dashboard {
        display: grid;
        grid-template-columns: 2fr 1fr;
        /* left big, right small */
        gap: 20px;
        padding: 20px;
        background: #f4f6fa;
        font-family: "Segoe UI", sans-serif;
    }

    /* Right column stack */
    .right-column {
        display: grid;
        grid-template-rows: auto auto;
        gap: 20px;
    }

    /* Announcements scrollable */
    /* .discussion-card .card-body {
        max-height: 500px;
        /* you can adjust */
    overflow-y: auto;
    padding: 16px;
    }

    */

    /* Custom scrollbar for announcements */
    .discussion-card .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .discussion-card .card-body::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .discussion-card .card-body::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border-radius: 10px;
    }

    .discussion-card .card-body::-webkit-scrollbar-thumb:hover {
        background: #888;
    }

    /* Ensure cards are full width in grid */
    .discussion-card,
    .task-summary-card,
    .message-card {
        width: 100% !important;
    }

    /* Responsive breakpoints */
    @media(max-width: 1200px) {
        .task-dashboard {
            grid-template-columns: 1.5fr 1fr;
        }
    }

    @media(max-width: 992px) {
        .task-dashboard {
            grid-template-columns: 1fr;
            /* single column on medium screens */
        }

        .right-column {
            grid-template-rows: unset;
        }
    }

    @media(max-width: 576px) {
        .task-dashboard {
            padding: 10px;
            gap: 15px;
        }

        .discussion-card .card-body {
            max-height: 350px;
            /* smaller scroll area for mobile */
        }
    }

    .task-summary-card,
    .message-card {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        width: 340px;
        overflow: hidden;
        position: relative;
        padding-top: 20px;
    }


    .discussion-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 500px;
    }

    .discussion-card .card-header {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: #fff;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .discussion-card .card-header h4 {
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .discussion-card .card-header .badge {
        background: #f1c40f;
        color: #000;
        font-size: 0.8rem;
        padding: 4px 8px;
        border-radius: 12px;
    }

    .discussion-card .card-body {
        padding: 15px;
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    #postHolder.post-scroll {
        flex: 1;
        overflow-y: auto;
        padding-right: 5px;
    }

    #postHolder.post-scroll::-webkit-scrollbar {
        width: 6px;
    }

    #postHolder.post-scroll::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    #postHolder.post-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .post-item {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    .post-item:last-child {
        border-bottom: none;
    }

    .post-item h5 {
        margin: 0 0 5px;
        font-size: 1rem;
        color: #2c3e50;
    }

    .post-item p {
        margin: 0 0 6px;
        font-size: 0.9rem;
        color: #555;
    }

    .post-item small {
        color: #888;
        font-size: 0.8rem;
    }

    .task-summary-card:hover,
    .message-card:hover,
    .discussion-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.15);
        font-weight: 600;
        font-size: 1.2rem;
        text-align: center;
    }

    .card-header h4 {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .badge {
        background: #ff4d4f;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Task Stats */
    .task-stats {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-top: 15px;
        gap: 12px;
    }

    .stat {
        flex: 1;
        text-align: center;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px;
        transition: background 0.3s;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat:hover {
        background: #e9f7ef;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1d976c;
        /* ✅ Dark green for visibility */
        display: block;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #555;
    }

    /* Button */
    .view-task-btn {
        margin-top: 18px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        background: #1d976c;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .view-task-btn:hover {
        background: #148f62;
    }

    .task-summary-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        padding-top: 10px;
    }

    .task-summary-card .card-header {
        background: linear-gradient(135deg, #1d976c, #2ecc71);
        color: #fff;
        padding: 15px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
    }

    .task-summary-card .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Circular Progress */
    .circular-progress {
        position: relative;
        width: 150px;
        height: 150px;
        margin-bottom: 20px;
    }

    .circular-progress svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .circular-progress circle {
        fill: none;
        stroke-width: 14;
        stroke-linecap: round;
    }

    .circular-progress .bg {
        stroke: #eee;
    }

    .circular-progress .progress {
        stroke: #2ecc71;
        stroke-dasharray: 440;
        /* 2 * Math.PI * 70 */
        stroke-dashoffset: 440;
        transition: stroke-dashoffset 0.6s ease, stroke 0.3s ease;
    }

    .circular-progress .percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.6rem;
        font-weight: bold;
        color: #333;
    }

    /* Messages Card */
    .message-card .card-body {
        align-items: stretch;
        max-height: auto;
        overflow-y: auto;
    }

    .message-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Discussion Card */
    /* .discussion-card .card-body {
        align-items: stretch;
        max-height: auto;
        overflow-y: auto;
    } */

    .discussion-item {
        background: rgba(255, 255, 255, 0.15);
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .discussion-question {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .discussion-answer {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    /* Responsive */
    @media(max-width: 650px) {

        .task-summary-card,
        .message-card,
        .discussion-card {
            width: 100%;
        }

        .circular-progress {
            width: 130px;
            height: 130px;
        }
    }

    /* Task Modal */
    .task-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .progress {
        border-radius: 12px;
        overflow: hidden;
    }

    .progress-bar {
        font-weight: bold;
        font-size: 13px;
    }

    /*--- Messages ---*/
    .message-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        font-family: "Segoe UI", sans-serif;
        width: 100%;
        max-width: 420px;
    }

    .message-card .card-header {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
        padding: 15px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .message-card .card-header h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .message-card .badge {
        background: #e74c3c;
        color: #fff;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        min-width: 28px;
        text-align: center;
    }

    .message-card .card-body {
        padding: 15px;
        overflow-y: auto;
        max-height: 320px;
        /* ✅ scrollable */
    }

    /* ✅ Custom scrollbar */
    .message-card .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .message-card .card-body::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .message-card .card-body::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border-radius: 10px;
    }

    .message-card .card-body::-webkit-scrollbar-thumb:hover {
        background: #888;
    }

    .message-item {
        padding: 10px 12px;
        border-radius: 8px;
        background: #f8f9ff;
        margin-bottom: 10px;
        transition: all 0.2s ease-in-out;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .message-item:hover {
        background: #e8eaf6;
        transform: translateX(3px);
    }

    .message-info {
        flex: 1;
        margin-right: 12px;
    }

    .message-sender {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 3px;
    }

    .message-preview {
        font-size: 0.9rem;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .message-time {
        font-size: 0.8rem;
        color: #888;
        margin-top: 2px;
    }

    .message-content {
        flex-grow: 1;
    }

    .message-item h6 {
        margin: 0 0 4px 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }

    .message-item span {
        font-weight: 400;
        color: #555;
    }

    .message-item small {
        font-size: 0.75rem;
        color: #888;
    }

    .read-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        background: #3498db;
        color: #fff;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    .read-btn:hover {
        background: #217dbb;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        color: #777;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #3498db;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 1rem;
        margin: 0;
    }
</style>
<?php // print_r($messages)
?>
<div class="task-dashboard">
    <!-- Left Column: Announcements -->
    <div class="discussion-card">
        <div class="card-header">
            <h4>📢 Announcements <span class="badge">3</span></h4>
        </div>
        <div class="card-body">
            <div id="postHolder" class="post-scroll">
            </div>
        </div>
    </div>

    <!-- Right Column: Task + Messages -->
    <div class="right-column">
        <!-- Tasks Summary -->
        <div class="task-summary-card"
            data-total="<?= $totalTask ?>"
            data-completed="<?= $completed ?>"
            data-total_student="<?= $totalStudents ?>"
            data-total_submitted="<?= $totalSubmit ?>">
            <div class="card-header">
                📋 Tasks Summary
            </div>
            <div class="card-body">
                <div class="circular-progress">
                    <svg>
                        <circle class="bg" cx="75" cy="75" r="70"></circle>
                        <circle class="progress" cx="75" cy="75" r="70"></circle>
                    </svg>
                    <div class="percentage">0%</div>
                </div>

                <div class="task-stats">
                    <div class="stat">
                        <div class="stat-number total">0</div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number completed">0</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number pending">0</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>

                <button class="view-task-btn" onclick="$('#perTask').modal('show')">
                    View Task Details
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div class="message-card" data-count="<?= $msgCount ?>">
            <div class="card-header">
                <span>💬 Messages</span>
                <span class="badge">0</span>
            </div>
            <div class="card-body">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $m): ?>
                        <div class="message-item">
                            <div class="message-info">
                                <div class="message-sender"><?= $m['sender'] ?></div>
                                <div class="message-preview"><?= $m['preview'] ?></div>
                                <div class="message-time"><?= timeAgo($m['date_sent']) ?></div>
                            </div>
                            <button class="read-btn">Read</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-envelope-open-text"></i>
                        <p>No new messages</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="perTask" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="chartModalLabel">
                    📊 Progress Per Task
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">
                <?php if (!empty($perTask) && is_array($perTask)): ?>
                    <?php foreach ($perTask as $task):
                        $completed = $task['total_submitted'] ?? 0;
                        $total = $task['total_students'] ?? 0;
                        $percent = ($total > 0) ? round(($completed / $total) * 100) : 0;
                    ?>
                        <div class="card border-0 shadow-sm rounded mb-3">
                            <div class="card-body p-3">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <!-- Left: Subject, Title + View Details -->
                                    <div class="d-flex align-items-center text-left flex-wrap">
                                        <div class="mr-2">
                                            <h6 class="font-weight-bold mb-1 text-dark">
                                                <?= $task['subject'] . ' - ' . $task['level'] . ' [ ' . $task['section'] . ' ]' ?>
                                            </h6>
                                            <small class="text-primary font-weight-bold"><?= $task['task_title'] ?></small>
                                        </div>
                                        <button class="btn btn-sm btn-link text-primary font-weight-bold ml-2 p-0" onclick="window.location.href = '<?= base_url() . 'opl/viewTaskDetails/' . $task['task_code'] . '/' . $task['grade_id'] . '/' . $task['section_id'] . '/' . $task['subj_id'] . '/' . $this->session->school_year ?>'">
                                            <i class="fas fa-eye text-primary"></i> View Details
                                        </button>
                                    </div>

                                    <!-- Right: Badge -->
                                    <span class="badge 
        <?php if ($percent < 50): ?>badge-danger
        <?php elseif ($percent < 80): ?>badge-warning
        <?php else: ?>badge-success<?php endif; ?> 
        px-3 py-2">
                                        <?= $completed ?>/<?= $total ?>
                                    </span>
                                </div>

                                <div class="progress mb-3" style="height: 20px; width: 100%">
                                    <div class="progress-bar 
                                        <?php if ($percent < 50): ?>bg-danger
                                        <?php elseif ($percent < 80): ?>bg-warning
                                        <?php else: ?>bg-success<?php endif; ?>"
                                        role="progressbar"
                                        style="width: <?= $percent ?>%;"
                                        aria-valuenow="<?= $percent ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= $percent ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No task completion data available.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const card = document.querySelector('.task-summary-card');
    const total = parseInt(card.dataset.total);
    const completed = parseInt(card.dataset.completed);
    const pending = total - completed;
    const total_student = parseInt(card.dataset.total_student);
    const total_submitted = parseInt(card.dataset.total_submitted);

    const percentage = (total_student === 0 ? 0 : Math.round((total_submitted / total_student) * 100));

    card.querySelector('.total').textContent = total;
    card.querySelector('.completed').textContent = completed;
    card.querySelector('.pending').textContent = pending;

    const progressCircle = card.querySelector('.progress');
    const percentageText = card.querySelector('.percentage');
    const radius = 70;
    const circumference = 2 * Math.PI * radius;

    progressCircle.style.strokeDasharray = circumference;
    let offset = circumference - (percentage / 100) * circumference;
    progressCircle.style.strokeDashoffset = offset;

    // Color logic
    if (percentage < 40) {
        progressCircle.style.stroke = '#e74c3c'; // red
    } else if (percentage < 70) {
        progressCircle.style.stroke = '#f39c12'; // yellow
    } else {
        progressCircle.style.stroke = '#2ecc71'; // green
    }

    // Animate percentage
    let current = 0;
    const step = Math.ceil(percentage / 60);
    const interval = setInterval(() => {
        if (current >= percentage) {
            percentageText.textContent = percentage + '%';
            clearInterval(interval);
        } else {
            current += step;
            percentageText.textContent = current + '%';
        }
    }, 15);

    /* Animate badge count-up */
    const msgCard = document.querySelector('.message-card');
    const badge = msgCard.querySelector('.badge');
    const targetCount = parseInt(msgCard.dataset.count);
    let currentCount = 0;
    const step2 = Math.max(1, Math.ceil(targetCount / 50));
    const interval2 = setInterval(() => {
        currentCount += step2;
        if (currentCount >= targetCount) {
            currentCount = targetCount;
            clearInterval(interval2);
        }
        badge.textContent = currentCount;
    }, 20);
</script>