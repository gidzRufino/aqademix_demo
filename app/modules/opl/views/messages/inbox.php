<?php
// ---------- Helper: humanTiming (PHP) ----------
if (!function_exists('humanTiming')) {
    function humanTiming($time)
    {
        $time = is_numeric($time) ? intval($time) : strtotime($time);
        $diff = time() - $time;
        if ($diff < 1) return 'just now';

        $secsIn = [
            31536000 => 'year',
            2592000  => 'month',
            604800   => 'week',
            86400    => 'day',
            3600     => 'hour',
            60       => 'minute',
            1        => 'second'
        ];

        // days special-case for "Yesterday"
        if ($diff >= 86400 && $diff < 86400 * 7) {
            $days = floor($diff / 86400);
            if ($days === 1) return 'Yesterday';
            return $days . ' days ago';
        }

        foreach ($secsIn as $secs => $name) {
            if ($diff >= $secs) {
                $num = floor($diff / $secs);
                if ($name === 'second' && $num < 10) return 'just now';
                return $num . ' ' . $name . ($num > 1 ? 's' : '') . ' ago';
            }
        }
    }
}
// print_r($messages);
?>

<!-- ---------- Inbox Component (Full) ---------- -->
<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <!-- Header -->
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 fw-semibold text-dark me-3">
                <i class="fas fa-inbox me-2 text-primary" aria-hidden="true"></i> Inbox
            </h5>
            <div id="links" class="text-muted small"><?php echo $links ?? ''; ?></div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Filter dropdown (optional) -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="filterMenu">
                    <li><a class="dropdown-item" href="#" onclick="filterInbox('all');return false;">📂 All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterInbox('unread');return false;">✉️ Unread</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterInbox('starred');return false;">⭐ Starred</a></li>
                </ul>
            </div>

            <!-- Search -->
            <div class="input-group input-group-sm" style="min-width:220px;">
                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="inboxSearch" class="form-control border-0 shadow-none" placeholder="Search messages (sender or subject)...">
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body p-0">
        <div id="inboxTable" class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="select-col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkAll" aria-label="Select all messages">
                            </div>
                        </th>
                        <th style="width:28%;">Sender</th>
                        <th>Subject</th>
                        <th style="width:18%;">Time</th>
                        <th style="width:110px;"></th> <!-- reserved space for actions -->
                    </tr>
                </thead>

                <tbody id="inboxRows">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $m):
                            // Compute timestamp (seconds)
                            echo $m->created_at;
                            $lt = Modules::run('opl/messages/getLatestTime', $m->opl_msg_id); // Fetch the latest time of msge sent
                            // $time = is_numeric($m->date_sent ?? $m->created_at ?? null)
                            //     ? intval($m->date_sent ?? $m->created_at)
                            //     : strtotime($m->date_sent ?? $m->created_at ?? 'now');
                            $time = is_numeric($lt->dtime ?? $m->created_at ?? null)
                                ? intval($lt->dtime ?? $m->created_at)
                                : strtotime($lt->dtime ?? $m->created_at ?? 'now');

                            // Get sender (safe fallback)
                            $sender = @Modules::run('opl/messages/getSender', base64_encode($m->sender)) ?: (object)['firstname' => '', 'lastname' => ''];

                            $isreply = ($m->replied_msg_id ?? 0) == 0 ? 0 : 1;
                            $isUnread = (isset($m->unread) && isset($m->total_msg)) ? ($m->unread != $m->total_msg) : false;
                            // Encoded ids (safe for attributes)
                            $encoded_thread = base64_encode($m->replied_msg_id ?? ($m->opl_msg_id ?? 0));
                            $encoded_msgid = base64_encode($m->opl_msg_id ?? 0);

                            // Data attributes
                            $data_subject = htmlspecialchars(strtolower($m->subject_msg ?? $m->subject ?? ''));
                            $data_sender = htmlspecialchars(strtolower(trim(($sender->firstname ?? '') . ' ' . ($sender->lastname ?? ''))));
                        ?>
                            <tr class="inbox-row pointer<?= $isUnread ? 'fw-semibold table-row-unread unread' : '' ?>" style="font-weight: <?= $isUnread ? 'bold' : '' ?>"
                                data-subject="<?= $data_subject ?>"
                                data-sender="<?= $data_sender ?>"
                                onclick="readMsge('<?= $encoded_thread ?>','<?= $isreply ?>','<?= $encoded_thread ?>','<?= $this->session->employee_id ?? '' ?>')">
                                <!-- Checkbox -->
                                <td class="select-col">
                                    <div class="form-check">
                                        <input type="checkbox" id="check<?= htmlspecialchars($m->opl_msg_id ?? '') ?>" class="form-check-input row-check" aria-label="Select message" />
                                    </div>
                                </td>

                                <!-- Sender -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2"
                                            style="width:34px;height:34px;font-size:0.85rem;">
                                            <?= htmlspecialchars(strtoupper(substr($sender->firstname ?? '', 0, 1))) ?>
                                        </div>
                                        <div class="text-truncate" style="max-width:220px;">
                                            &nbsp;<?= htmlspecialchars(ucwords(trim(($sender->firstname ?? '') . ' ' . ($sender->lastname ?? '')))) ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Subject -->
                                <td class="text-truncate" style="max-width:420px;">
                                    <?= ($m->is_reply ?? false) ? '<span class="badge bg-light text-secondary border me-1">Re</span>' : '' ?>
                                    <?= htmlspecialchars($m->subject_msg ?? $m->subject ?? '') ?>
                                </td>

                                <!-- Time (JS will fill this from data-time) -->
                                <td>
                                    <small class="text-muted time-ago" data-time="<?= $time ?>"></small>
                                </td>

                                <!-- Actions (float on hover) -->
                                <td class="actions-col">
                                    <div class="row-actions" role="group" aria-label="Row actions">
                                        <button class="btn btn-sm btn-outline-primary me-1" title="View"
                                            onclick="event.stopPropagation(); readMsge('<?= $encoded_thread ?>','<?= $isreply ?>','<?= $encoded_thread ?>','<?= $this->session->employee_id ?? '' ?>')"
                                            aria-label="View message">
                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Delete"
                                            onclick="event.stopPropagation(); deleteMessage('<?= $encoded_msgid ?>')"
                                            aria-label="Delete message">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-envelope-open-text me-2"></i> No New Messages
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ---------- Styles ---------- -->
<style>
    /* subtle unread highlight */
    .table-row-unread {
        background-color: #f6fbff;
    }

    /* hover background */
    .table-hover tbody tr:hover {
        background-color: #f8faff;
    }

    /* reserve space for actions so table won't shift */
    .actions-col {
        position: relative;
        width: 110px;
        vertical-align: middle;
    }

    /* row actions (hidden by default) */
    .row-actions {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%) translateX(8px);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s;
        white-space: nowrap;
        z-index: 2;
    }

    /* show on row hover */
    tbody tr:hover .row-actions {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(0);
    }

    /* avatar */
    .avatar {
        font-weight: 600;
    }

    /* truncate subject */
    td.text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .time-ago {
        font-size: 0.85rem;
    }

    .row-actions .btn {
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    /* Proper checkbox alignment in thead */
    .select-col {
        width: 48px;
        text-align: center;
        vertical-align: middle !important;
    }

    .select-col .form-check {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        height: 100%;
    }

    .select-col .form-check-input {
        margin: 0;
        transform: scale(1.1);
        /* optional: slightly larger for consistency */
    }
</style>

<!-- ---------- JavaScript (time update, search, check-all, placeholders) ---------- -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // ---- Helpers ----
        function humanTimingJS(ts) {
            if (!ts || isNaN(ts)) return '';
            const now = Math.floor(Date.now() / 1000);
            let diff = now - parseInt(ts, 10);
            if (diff < 1) return 'just now';

            // seconds -> units
            const units = [{
                    sec: 31536000,
                    name: 'year'
                },
                {
                    sec: 2592000,
                    name: 'month'
                },
                {
                    sec: 604800,
                    name: 'week'
                },
                {
                    sec: 86400,
                    name: 'day'
                },
                {
                    sec: 3600,
                    name: 'hour'
                },
                {
                    sec: 60,
                    name: 'minute'
                },
                {
                    sec: 1,
                    name: 'second'
                }
            ];

            // Days special-case for "Yesterday" and "x days ago" (under a week)
            if (diff >= 86400 && diff < 86400 * 7) {
                const days = Math.floor(diff / 86400);
                return days === 1 ? 'Yesterday' : days + ' days ago';
            }

            for (let i = 0; i < units.length; i++) {
                let u = units[i];
                if (diff >= u.sec) {
                    let num = Math.floor(diff / u.sec);
                    if (u.name === 'second' && num < 10) return 'just now';
                    return num + ' ' + u.name + (num > 1 ? 's' : '') + ' ago';
                }
            }
            return 'just now';
        }

        function formatExact(ts) {
            // Format example: "Sep 21, 2025 07:15 PM"
            if (!ts || isNaN(ts)) return '';
            const d = new Date(parseInt(ts, 10) * 1000);
            // options produce: "Sep 21, 2025, 7:15 PM" (remove comma between date/time)
            const opts = {
                month: 'short',
                day: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            // Using user's locale/timezone
            let s = d.toLocaleString(undefined, opts);
            // remove extra comma between date and time if present
            s = s.replace(', ', ' ');
            return s;
        }

        // ---- Update time-ago fields (every second) ----
        function updateTimeAgo() {
            document.querySelectorAll('.time-ago').forEach(el => {
                const ts = el.getAttribute('data-time');
                if (!ts) return;
                el.textContent = humanTimingJS(ts);
                el.setAttribute('title', formatExact(ts));
                el.setAttribute('aria-label', formatExact(ts));
            });
        }
        updateTimeAgo(); // initial
        setInterval(updateTimeAgo, 1000); // every second

        // ---- Check All functionality ----
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('#inboxRows .row-check').forEach(cb => cb.checked = this.checked);
            });
        }

        // ---- Search filter (sender + subject) ----
        const inboxSearch = document.getElementById('inboxSearch');
        if (inboxSearch) {
            inboxSearch.addEventListener('input', function() {
                const val = this.value.trim().toLowerCase();
                document.querySelectorAll('#inboxRows .inbox-row').forEach(row => {
                    const s = (row.dataset.sender || '').toLowerCase();
                    const sub = (row.dataset.subject || '').toLowerCase();
                    const visible = val === '' || s.includes(val) || sub.includes(val);
                    row.style.display = visible ? '' : 'none';
                });
            });
        }

        // ---- Filter function (used by filter dropdown) ----
        window.filterInbox = function(type) {
            document.querySelectorAll('#inboxRows .inbox-row').forEach(row => {
                row.style.display = '';
                if (type === 'unread' && !row.classList.contains('unread')) row.style.display = 'none';
                if (type === 'starred' && row.dataset.starred !== '1') row.style.display = 'none';
            });
        };

        // ---- readMsge placeholder (replace with actual implementation) ----
        window.readMsge = window.readMsge || function(threadEncoded, isReply, repliedEncoded, employeeId) {
            // Replace with your navigation / modal / AJAX call
            console.log('readMsge called:', threadEncoded, isReply, repliedEncoded, employeeId);
            // e.g. open modal: openThread(threadEncoded);
        };

        // ---- deleteMessage placeholder (replace with AJAX) ----
        window.deleteMessage = function(encodedMsgId) {
            if (!confirm('Delete this message?')) return;
            console.log('deleteMessage called for', encodedMsgId);
            // Example AJAX:
            /*
            fetch('/opl/messages/delete/' + encodedMsgId, { method: 'POST', credentials: 'same-origin' })
              .then(res => res.json())
              .then(data => {
                  if (data.success) location.reload();
                  else alert('Delete failed');
              });
            */
        };
    });
</script>