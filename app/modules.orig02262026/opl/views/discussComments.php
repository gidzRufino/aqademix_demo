<style>
    .fa {
        font-size: 0.8em;
        cursor: pointer;
    }

    .card-comments {
        padding: 1rem;
    }

    .comment-card {
        border: 1px solid #e1e1e1;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.85rem;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.2s ease;
    }

    .comment-card:hover {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .comment-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
        border: 2px solid #f1f1f1;
    }

    .comment-name {
        font-weight: 600;
        margin: 0;
    }

    .comment-time {
        font-size: 0.78em;
        color: #888;
        margin-left: 4px;
    }

    .comment-text {
        margin-bottom: 0.5rem;
        line-height: 1.45;
    }

    /* Replies (Base style) */
    .reply-card {
        border-left: 3px solid #d6d6d6;
        padding: 0.6rem 0.85rem;
        border-radius: 6px;
        margin-left: 3rem;
        margin-bottom: 0.5rem;
        font-size: 0.92em;
    }

    .reply-card strong {
        font-weight: 600;
        color: #333;
    }

    .reply-card .comment-time {
        font-size: 0.75em;
        color: #999;
    }

    /* Student replies */
    .reply-student {
        background: #fdfdfd;
        border-left-color: #bbb;
    }

    /* Teacher replies */
    .reply-teacher {
        background: #f7faff;
        /* very light blue */
        border-left-color: #4a90e2;
    }

    .action-icons {
        margin-left: auto;
        display: flex;
        align-items: center;
    }

    .action-icons i {
        margin-left: 0.6rem;
        color: #aaa;
        transition: color 0.2s ease;
    }

    .action-icons i:hover {
        color: #000;
    }

    textarea.form-control {
        border-radius: 6px;
        font-size: 0.9em;
    }

    button.btn-sm {
        padding: 0.25rem 0.65rem;
    }
</style>

<div class="card-comments" id="commentsContainer">
    <?php foreach ($comments as $comment): ?>
        <div class="comment-card" id="comment-<?php echo $comment->com_sys_code; ?>">
            <div class="comment-header">
                <img src="<?php echo (isset($comment->avatar) ? base_url('uploads/' . $comment->avatar) : base_url('images/forms/' . $this->eskwela->getSet()->set_logo)); ?>"
                    class="comment-avatar" alt="avatar">
                <div>
                    <p class="comment-name"><?php echo ucwords(strtolower($comment->firstname . ' ' . $comment->lastname)); ?></p>
                    <span class="comment-time"><?php echo date('M d, Y h:i A', strtotime($comment->com_timestamp)); ?></span>
                </div>
                <div class="action-icons">
                    <i class="fa fa-reply" title="Reply" onclick="focusReplyInput('<?php echo $comment->com_sys_code; ?>')"></i>
                    <?php if (!$this->session->isParent && ($this->session->st_id == $comment->com_from)): ?>
                        <i class="fa fa-trash text-danger" title="Delete" onclick="openDeleteModal('comment','<?php echo $comment->com_sys_code; ?>')"></i>
                    <?php endif; ?>
                </div>
            </div>

            <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment->com_details)); ?></div>

            <!-- Replies list -->
            <div id="replies-<?php echo $comment->com_sys_code; ?>">
                <?php
                $replies = Modules::run('opl/opl_variables/getReplies', $comment->com_sys_code, $this->session->school_year);
                if (count($replies) > 0):
                    foreach ($replies as $reply):
                        $rprofile = ($reply->com_isStudent) ?
                            Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $reply->com_from, $this->session->school_year) :
                            Modules::run('opl/opl_variables/getBasicEmployee', $reply->com_from, $this->session->school_year);

                        $ravatar = site_url("/uploads/") . $rprofile->avatar;
                        $ravloc = FCPATH . "uploads/" . ($rprofile->avatar ? $rprofile->avatar : "none.png");
                        if (file_exists($ravloc) == FALSE) {
                            $ravatar = site_url("images/forms/") . $this->eskwela->getSet()->set_logo;
                        }
                ?>
                        <div class="reply-card <?php echo $reply->com_isStudent ? 'reply-student' : 'reply-teacher'; ?>"
                            id="reply-<?php echo $reply->com_sys_code; ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong><?php echo ucwords(strtolower($rprofile->firstname . ' ' . $rprofile->lastname)); ?></strong>
                                    <span class="comment-time"> · <?php echo date('M d, Y h:i A', strtotime($reply->com_timestamp)); ?></span>
                                    <div><?php echo nl2br(htmlspecialchars($reply->com_details)); ?></div>
                                </div>
                                <?php if (!$this->session->isParent && ($this->session->st_id == $reply->com_from || $this->session->employee_id == $reply->com_from)): ?>
                                    <i class="fa fa-trash text-danger" title="Delete reply" onclick="openDeleteModal('reply','<?php echo $reply->com_sys_code; ?>')"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

            <!-- Reply input -->
            <div class="mt-2">
                <textarea id="reply-input-<?php echo $comment->com_sys_code; ?>" class="form-control" rows="2" placeholder="Write a reply..."></textarea>
                <div class="mt-1">
                    <button class="btn btn-primary btn-sm" onclick="submitReply('<?php echo $comment->com_sys_code; ?>', '<?php echo $comment->com_to; ?>')">Reply</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Central Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirm Delete</h5>
                <button type="button" class="close text-white" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this <span id="deleteItemType"></span>?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    function getCsrfCookie() {
        if (typeof $.cookie === 'function') {
            return $.cookie('csrf_cookie_name');
        } else {
            const name = 'csrf_cookie_name=';
            const decoded = decodeURIComponent(document.cookie);
            const parts = decoded.split(';');
            for (let p of parts) {
                p = p.trim();
                if (p.indexOf(name) === 0) return p.substring(name.length);
            }
            return '';
        }
    }

    let deleteTarget = {
        type: null,
        id: null
    };

    function openDeleteModal(type, sysCode) {
        deleteTarget.type = type;
        deleteTarget.id = sysCode;
        document.getElementById('deleteItemType').innerText = type;
        $('#deleteModal').modal('show');
        document.getElementById('confirmDeleteBtn').onclick = function() {
            submitDelete();
        };
    }

    function closeDeleteModal() {
        $('#deleteModal').modal('hide');
        deleteTarget = {
            type: null,
            id: null
        };
        document.getElementById('confirmDeleteBtn').onclick = null;
    }

    function submitDelete() {
        if (!deleteTarget.type || !deleteTarget.id) return;

        let url = '';
        let data = {};
        const csrf = getCsrfCookie();

        if (deleteTarget.type === 'comment') {
            url = '<?php echo site_url("opl/opl_variables/deleteComment"); ?>';
            data = {
                commentid: deleteTarget.id,
                csrf_test_name: csrf
            };
        } else {
            url = '<?php echo site_url("opl/opl_variables/deleteReply"); ?>';
            data = {
                replyid: deleteTarget.id,
                csrf_test_name: csrf
            };
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(resp) {
                try {
                    const json = (typeof resp === 'object') ? resp : JSON.parse(resp);
                    if (json.success) {
                        if (deleteTarget.type === 'comment') {
                            const el = document.getElementById('comment-' + deleteTarget.id);
                            if (el) el.remove();
                        } else {
                            const el = document.getElementById('reply-' + deleteTarget.id);
                            if (el) el.remove();
                        }
                    } else {
                        alert(json.message || 'Delete failed');
                    }
                } catch (e) {
                    location.reload();
                }
            },
            error: function() {
                alert('An error occurred when deleting. Please try again.');
            },
            complete: function() {
                closeDeleteModal();
            }
        });
    }

    function focusReplyInput(sysCode) {
        const el = document.getElementById('reply-input-' + sysCode);
        if (el) el.focus();
    }

    function submitReply(commentSysCode, to) {
        const textarea = document.getElementById('reply-input-' + commentSysCode);
        if (!textarea) return;
        const replyText = textarea.value.trim();
        if (!replyText) {
            alert('Reply cannot be empty');
            return;
        }

        const url = '<?php echo site_url("opl/opl_variables/sendReply"); ?>';
        const csrf = getCsrfCookie();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                code: commentSysCode,
                reply: replyText,
                to: to,
                csrf_test_name: csrf
            },
            success: function(resp) {
                try {
                    const json = (typeof resp === 'object') ? resp : JSON.parse(resp);
                    if (json.success) {
                        if (json.html) {
                            $('#replies-' + commentSysCode).append(json.html);
                        } else {
                            location.reload();
                        }
                        textarea.value = '';
                    } else {
                        alert(json.message || 'Could not post reply');
                    }
                } catch (e) {
                    $('#replies-' + commentSysCode).append(resp);
                    textarea.value = '';
                }
            },
            error: function() {
                alert('An error occurred while sending reply. Please try again.');
            }
        });
    }
</script>