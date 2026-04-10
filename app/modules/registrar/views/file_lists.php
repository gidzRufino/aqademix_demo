<style>
    .fm-header {
        background: linear-gradient(135deg, #0d6efd, #4dabf7);
        border-radius: 16px;
        padding: 18px 22px;
        color: #fff;
        box-shadow: 0 8px 24px rgba(13,110,253,.25);
    }

    .fm-header h4 {
        letter-spacing: .3px;
    }

/* File card hover actions */
.file-card {
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    transition: all 0.25s ease;
    cursor: pointer;
}

.file-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* File thumbnail */
.file-thumb {
    height: 160px;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px 14px 0 0;
    overflow: hidden;
    position: relative;
}

.file-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* File actions buttons */
.file-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.25s ease;
    z-index: 10;
}

.file-card:hover .file-actions {
    opacity: 1;
    transform: translateY(0);
}

.file-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    color: #fff; /* icons inherit button text color */
    transition: all 0.2s ease;
}

.file-btn i {
    pointer-events: none; /* icon clicks go to button */
}

.file-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}


    .file-icon {
        font-size: 58px;
        opacity: .85;
    }

    .file-name {
        font-size: .88rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-meta {
        font-size: .75rem;
        color: #6c757d;
    }

    .file-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 6px;
        opacity: 0;
        transform: translateY(-5px);
        transition: all .25s ease;
        z-index: 20; /* added */
    }

    .file-card:hover .file-actions,
    .file-card.active .file-actions {
        opacity: 1;
        transform: translateY(0);
    }

    .file-actions .btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        box-shadow: 0 3px 8px rgba(0,0,0,.2);
        color: inherit; /* inherit button text color */
    }

    .empty-state {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 60px 20px;
    }

    .empty-state i {
        opacity: .4;
    }

    .modal-header.gradient {
        background: linear-gradient(135deg,#0d6efd,#4dabf7);
        color: #fff;
    }
</style>

<div class="container py-4">

    <!-- Elegant Header -->
    <div class="fm-header d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fa fa-folder-open me-2"></i> File Manager
            </h4>
            <small class="opacity-75">Manage and organize student uploaded files</small>
        </div>

        <button class="btn btn-light fw-semibold shadow-sm" onclick="$('#stid_pf').val('<?= isset($st_id) ? $st_id : (isset($students) ? $students->uid : '') ?>'), $('#redirect_url').val('<?= current_url() ?>')"
        data-bs-toggle="modal"
        data-bs-target="#uploadModal">
    <i class="fa fa-upload me-1 text-primary"></i> Upload Files
</button>

    </div>

    <!-- Alerts -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger shadow-sm border-0">
            <i class="fa fa-exclamation-circle me-1"></i>
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success shadow-sm border-0">
            <i class="fa fa-check-circle me-1"></i>
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- File Grid -->
    <div class="row g-4">

        <?php if (empty($files)): ?>
            <div class="col-12">
                <div class="empty-state text-center text-muted">
                    <i class="fa fa-folder-open fa-4x mb-3"></i>
                    <h6 class="fw-semibold mb-1">No files uploaded yet</h6>
                    <small>Upload documents to start building the student archive</small>
                </div>
            </div>
        <?php endif; ?>

        <?php 
        $current_st_id = isset($st_id) ? $st_id : (isset($students) ? (isset($students->uid) ? $students->uid : (isset($students->st_id) ? $students->st_id : '')) : '');
        foreach ($files as $file): 
            $download_st_id = !empty($file->st_id) ? $file->st_id : $current_st_id;
            $download_url = site_url('registrar/downloadPersonalFile/' . base64_encode((string)$file->file_id) . (!empty($download_st_id) ? '?st_id=' . urlencode($download_st_id) : ''));
            $delete_url = site_url('registrar/deletePersonalFile/' . base64_encode((string)$file->file_id) . (!empty($download_st_id) ? '?st_id=' . urlencode($download_st_id) : ''));
        ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">

                <div class="file-card position-relative">

                    <!-- Hover Actions -->
                    <div class="file-actions">
                        <!-- Rename -->
                        <button type="button" class="file-btn btn-info" 
                                title="Rename"
                                onclick="openRenameModal(<?= $file->file_id; ?>, '<?= htmlspecialchars(addslashes($file->original_name)); ?>', '<?= htmlspecialchars(addslashes($file->extension)); ?>')">
                            <i class="fa fa-edit"></i>
                        </button>

                        <!-- Download -->
                        <a href="<?= $download_url; ?>" class="file-btn btn-primary" title="Download">
                            <i class="fa fa-download"></i>
                        </a>

                        <!-- Delete -->
                        <a href="<?= $delete_url; ?>" class="file-btn btn-danger" 
                        title="Delete"
                        onclick="return confirm('Delete <?= htmlspecialchars(addslashes($file->original_name)); ?>?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>

                    <!-- Thumbnail -->
                    <div class="file-thumb">
                        <?php if (in_array($file->extension, ['.jpg','.jpeg','.png','.gif'])): ?>
                            <img src="<?= base_url('uploads/personal_files/'. $current_st_id.'/'.$file->file_name); ?>" alt="">
                            <a href="<?= base_url('uploads/personal_files/'.$current_st_id.'/'.$file->file_name); ?>" 
                            target="_blank" 
                            class="btn btn-dark position-absolute bottom-0 mb-2 shadow-sm">
                                <i class="fa fa-eye me-1"></i> View
                            </a>
                        <?php elseif ($file->extension === '.pdf'): ?>
                            <i class="fa fa-file-pdf text-danger file-icon"></i>
                        <?php elseif (in_array($file->extension, ['.doc','.docx'])): ?>
                            <i class="fa fa-file-word text-primary file-icon"></i>
                        <?php elseif (in_array($file->extension, ['.xls','.xlsx'])): ?>
                            <i class="fa fa-file-excel text-success file-icon"></i>
                        <?php elseif (in_array($file->extension, ['.ppt','.pptx'])): ?>
                            <i class="fa fa-file-powerpoint text-warning file-icon"></i>
                        <?php else: ?>
                            <i class="fa fa-file text-secondary file-icon"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<script>
    function openRenameModal(fileId, currentName, extension) {
        // Remove extension from current name for editing
        let nameWithoutExt = currentName;
        if (extension && nameWithoutExt.toLowerCase().endsWith(extension.toLowerCase())) {
            nameWithoutExt = nameWithoutExt.substring(0, nameWithoutExt.length - extension.length);
        }

        // Set form values
        document.getElementById('rename_file_id').value = fileId;
        document.getElementById('rename_new_name').value = nameWithoutExt;
        document.getElementById('rename_file_extension').value = extension;
        document.getElementById('stid_renamePF').value = '<?= isset($st_id) ? $st_id : (isset($students) ? (isset($students->uid) ? $students->uid : (isset($students->st_id) ? $students->st_id : '')) : '') ?>';
        document.getElementById('rename_redirect_url').value = '<?= current_url() ?>';

        // Show modal using Bootstrap 5 JS
        var renameModalEl = document.getElementById('renameModal');
        var modal = new bootstrap.Modal(renameModalEl);
        modal.show();

        // Focus input
        setTimeout(function() {
            var input = document.getElementById('rename_new_name');
            input.focus();
            input.select();
        }, 300);
    }


// Handle form submission
document.getElementById('renameForm').addEventListener('submit', function(e) {
    var newName = document.getElementById('rename_new_name').value.trim();
    var extension = document.getElementById('rename_file_extension').value;
    
    if (!newName) {
        e.preventDefault();
        alert('Please enter a file name.');
        return false;
    }
    
    // Ensure extension is preserved
    if (extension && !newName.toLowerCase().endsWith(extension.toLowerCase())) {
        document.getElementById('rename_new_name').value = newName + extension;
    }
});
</script>