<!-- Cropper CSS/JS -->
<link rel="stylesheet" href="<?php echo base_url() . 'assets/imgCropper/cropper.min.css' ?>">
<script src="<?php echo base_url() . 'assets/imgCropper/cropper.min.js' ?>"></script>

<!-- Modal -->
<div class="modal fade" id="imgUpload" tabindex="-1" aria-labelledby="imgUploadLabel" aria-hidden="true">
    <?php
    $attributes = array('id' => 'importCSV', 'class' => '');
    echo form_open_multipart(base_url() . 'main/do_upload', $attributes);
    ?>
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold" id="imgUploadLabel">
                    <i class="fa fa-image me-2"></i> Upload, Crop & Save Picture
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row g-4">

                        <!-- Upload & Crop -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body">
                                    <label class="form-label fw-semibold">Select Image</label>
                                    <input type="file" id="file-input" class="form-control mb-3">

                                    <div class="result border rounded-3 p-2 bg-light text-center" style="min-height:300px">
                                        <span class="text-muted small">Image preview will appear here</span>
                                    </div>

                                    <div class="options hide mt-3">
                                        <label class="form-label small fw-semibold">Width (px)</label>
                                        <input type="number" class="img-w form-control form-control-sm"
                                            value="300" min="300" max="350">
                                    </div>

                                    <button class="btn btn-success mt-3 save hide">
                                        <i class="fa fa-crop-alt me-1"></i> Crop Image
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cropped Result -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body text-center">
                                    <h6 class="fw-semibold text-muted mb-3">Cropped Preview</h6>
                                    <div class="img-result hide">
                                        <img class="cropped img-fluid rounded shadow-sm" src="" alt="">
                                    </div>
                                    <div class="text-muted small">Preview after cropping</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <div id="croppedImg" class="me-auto"></div>

                <?php if ($students->account_type == 5) {
                    $user_id = $user_id - 2;
                } ?>

                <input type="hidden" id="picture_option" name="picture_option" />
                <input type="hidden" name="id" id="stdUID" />
                <input type="hidden" name="location" value="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) ?>" />
                <input type="hidden" id="syUpload" name="syUpload" value="<?php echo $this->uri->segment(5) ?>" />

                <button class="btn btn-primary download hide">
                    <i class="fa fa-upload me-1"></i> Upload Cropped Image
                </button>
            </div>

        </div>
    </div>
    </form>
</div>


<!--- end crop and upload -->

<script type="text/javascript">
    let result = document.querySelector('.result'),
        img_result = document.querySelector('.img-result'),
        img_w = document.querySelector('.img-w'),
        img_h = document.querySelector('.img-h'),
        options = document.querySelector('.options'),
        save = document.querySelector('.save'),
        cropped = document.querySelector('.cropped'),
        dwn = document.querySelector('.download'),
        upload = document.querySelector('#file-input'),
        cropper = '';


    // on change show image with crop options
    upload.addEventListener('change', (e) => {
        if (e.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = (e) => {
                if (e.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'image';
                    img.src = e.target.result;
                    // clean result before
                    result.innerHTML = '';
                    // append new image
                    result.appendChild(img);
                    // show save btn and options
                    save.classList.remove('hide');
                    options.classList.remove('hide');
                    // init cropper
                    cropper = new Cropper(img);
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // save on click
    save.addEventListener('click', (e) => {
        e.preventDefault();
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            width: img_w.value // input value
        }).toDataURL();
        // remove hide class of img
        cropped.classList.remove('hide');
        img_result.classList.remove('hide');
        // show image cropped
        cropped.src = imgSrc;
        $('#file-input').prop('disabled', false);
        dwn.classList.remove('hide');

        var fileImg = $('#file-input')[0].files[0];
        var profImg = cropped.src;
        var imgMimeType = profImg.substring("data:image/".length, profImg.indexOf(";base64"));
        $('#croppedImg').prepend('<input type="hidden" style="height:35px;" class="btn-mini" name="userfile" value="' + profImg + '" /><input type="hidden" name="imgMime" id="imgMime" value="' + imgMimeType + '">')
    });

    $('.download').click(function() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('imgUpload'));
        modal.hide();
    });
</script>

<style type="text/css">
    /* -- crop image style -- */

    .page {
        margin: 1em auto;
        max-width: 768px;
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        height: 100%;
    }

    .box,
    .boxSign {
        padding: 0.5em;
        width: 100%;
        margin: 0.5em;
    }

    .box-2,
    .boxSign-2 {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .options label,
    .options input {
        width: 4em;
        padding: 0.5em 1em;
    }

    .btn {
        background: white;
        color: black;
        border: 1px solid black;
        padding: 0.5em 1em;
        text-decoration: none;
        margin: 0.8em 0.3em;
        display: inline-block;
        cursor: pointer;
    }

    /* Cropper layout tweaks */
    .result img {
        max-width: 100%;
    }

    .hide {
        display: none !important;
    }

    img {
        max-width: 100%;
    }
</style>