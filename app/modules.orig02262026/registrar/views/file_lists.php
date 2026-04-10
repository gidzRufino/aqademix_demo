<style>
        .file-card {
            border-radius: 14px;
            transition: all .25s ease;
            cursor: pointer;
        }

        .file-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,.15);
        }

        .file-thumb {
            height: 160px;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px 14px 0 0;
            overflow: hidden;
        }

        .file-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-icon {
            font-size: 52px;
        }

        .file-name {
            font-size: .85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

<div class="container py-5">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">
        <i class="fa fa-folder-open text-primary me-1"></i>
        File Manager
    </h4>

    <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#uploadModal">
        <i class="fa fa-upload me-1"></i> Upload Files
    </button>
</div>

<!-- Alerts -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- File Grid -->
<div class="row g-4">

    <?php if (empty($files)): ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="fa fa-folder-open fa-3x mb-3"></i>
            <p>No files uploaded yet</p>
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

            <div class="card file-card position-relative" style="overflow: visible;">
                
                <!-- Action buttons overlay -->
                <div class="position-absolute" style="top: 10px; right: 10px; z-index: 10; display: flex; gap: 5px;">
                    <!-- Rename button -->
                    <button type="button"
                            class="btn btn-sm btn-info" 
                            style="padding: 5px 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                            title="Rename <?= htmlspecialchars($file->original_name); ?>"
                            onclick="openRenameModal(<?= $file->file_id; ?>, '<?= htmlspecialchars(addslashes($file->original_name)); ?>', '<?= htmlspecialchars(addslashes($file->extension)); ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    
                    <!-- Download button -->
                    <a href="<?= $download_url; ?>" 
                       class="btn btn-sm btn-primary" 
                       style="padding: 5px 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                       title="Download <?= htmlspecialchars($file->original_name); ?>">
                        <i class="fa fa-download"></i>
                    </a>
                    
                    <!-- Delete button -->
                    <a href="<?= $delete_url; ?>" 
                       class="btn btn-sm btn-danger" 
                       style="padding: 5px 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                       title="Delete <?= htmlspecialchars($file->original_name); ?>"
                       onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars(addslashes($file->original_name)); ?>?\\n\\nThis action cannot be undone.');">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>

                <div class="file-thumb" style="position: relative;">
                    
                    <!-- Image preview or file icon -->
                    <?php if (in_array($file->extension, ['.jpg','.jpeg','.png','.gif'])): ?>
                        <img src="<?= base_url('uploads/personal_files/'. $current_st_id.'/'.$file->file_name); ?>" alt="<?= htmlspecialchars($file->original_name); ?>">
                        <!-- View button for images -->
                        <a href="<?= base_url('uploads/personal_files/'.$current_st_id.'/'.$file->file_name); ?>" 
                           target="_blank" 
                           class="btn btn-sm btn-info position-absolute" 
                           style="bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 10;"
                           title="View image">
                            <i class="fa fa-eye"></i>
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

                <div class="card-body text-center p-2">
                    <div class="file-name fw-medium" title="<?= htmlspecialchars($file->original_name) ?>">
                        <?= htmlspecialchars($file->original_name) ?>
                    </div>

                    <small class="text-muted d-block mb-2">
                        <?= number_format($file->file_size / 1024, 1); ?> KB
                    </small>
                    
                    <!-- Action buttons -->
                    <div class="d-flex gap-1 mt-1">
                        <!-- Rename button -->
                        <button type="button"
                                class="btn btn-sm btn-outline-info"
                                title="Rename <?= htmlspecialchars($file->original_name); ?>"
                                onclick="openRenameModal(<?= $file->file_id; ?>, '<?= htmlspecialchars(addslashes($file->original_name)); ?>', '<?= htmlspecialchars(addslashes($file->extension)); ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        
                        <!-- Download button -->
                        <a href="<?= $download_url; ?>" 
                           class="btn btn-sm btn-outline-primary flex-fill"
                           title="Download <?= htmlspecialchars($file->original_name); ?>">
                            <i class="fa fa-download me-1"></i> Download
                        </a>
                        
                        <!-- Delete button -->
                        <a href="<?= $delete_url; ?>" 
                           class="btn btn-sm btn-outline-danger"
                           title="Delete <?= htmlspecialchars($file->original_name); ?>"
                           onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars(addslashes($file->original_name)); ?>?\\n\\nThis action cannot be undone.');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>

</div>
</div>

<!-- ================= UPLOAD MODAL ================= -->

<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-upload me-1"></i> Upload Files
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
            </div>

            <?= form_open_multipart('registrar/uploadPersonalFiles'); ?>

            <div class="modal-body">

                <input type="hidden" name="st_id" value="<?= isset($st_id) ? $st_id : (isset($students) ? $students->uid : '') ?>">
                <input type="hidden" name="redirect_url" value="<?= current_url() ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Files</label>
                    <input type="file"
                        name="files[]"
                        class="form-control"
                        multiple
                        required>

                    <small class="text-muted">
                        Allowed: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Max 2MB per file)
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button class="btn btn-primary">
                    Upload
                </button>
            </div>

            <?= form_close(); ?>

        </div>
    </div>
</div>

<!-- ================= RENAME MODAL ================= -->

<div class="modal fade" id="renameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fa fa-edit me-1"></i> Rename File
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
            </div>

            <?= form_open('registrar/renamePersonalFile', array('id' => 'renameForm')); ?>

            <div class="modal-body">

                <input type="hidden" name="file_id" id="rename_file_id" value="">
                <input type="hidden" name="st_id" value="<?= isset($st_id) ? $st_id : (isset($students) ? (isset($students->uid) ? $students->uid : (isset($students->st_id) ? $students->st_id : '')) : '') ?>">
                <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
                <input type="hidden" name="file_extension" id="rename_file_extension" value="">

                <div class="mb-3">
                    <label class="form-label fw-semibold">File Name</label>
                    <input type="text"
                        name="new_name"
                        id="rename_new_name"
                        class="form-control"
                        required
                        autocomplete="off">
                    <small class="text-muted">
                        Enter the new name for the file (extension will be preserved automatically)
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fa fa-save me-1"></i> Save
                </button>
            </div>

            <?= form_close(); ?>

        </div>
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
    
    // Show modal
    $('#renameModal').modal('show');
    
    // Focus on input and select text
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