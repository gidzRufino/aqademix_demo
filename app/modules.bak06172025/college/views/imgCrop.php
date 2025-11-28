<!--- crop and upload image modal -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/imgCropper/cropper.min.css' ?>">
<script type="text/javascript" src="<?php echo base_url() . 'assets/imgCropper/cropper.min.js' ?>"></script>

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

    .box, .boxSign {
        padding: 0.5em;
        width: 100%;
        margin:0.5em;
    }

    .box-2, .boxSign-2 {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .options label,
    .options input{
        width:4em;
        padding:0.5em 1em;
    }
    .btn{
        background:white;
        color:black;
        border:1px solid black;
        padding: 0.5em 1em;
        text-decoration:none;
        margin:0.8em 0.3em;
        display:inline-block;
        cursor:pointer;
    }

    .hide {
        display: none;
    }

    img {
        max-width: 100%;
    }
</style>
<div class="modal fade" id="imgUpload" role="dialog" align="left">
    <?php
    $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
    echo form_open_multipart(base_url() . 'main/do_upload', $attributes);
    ?>
    <div class="modal-dialog modal-lg-12" style="width: 60%">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h2>Upload picture, Crop and save!</h2>
                <div id="testID"></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="page">
                        <!-- input file -->
                        <div class="box">
                            <input type="file" id="file-input">
                        </div>
                        <!-- leftbox -->
                        <div class="box-2">
                            <div class="result"></div>
                        </div>
                        <!--rightbox-->
                        <div class="box-2 img-result hide">
                            <!-- result of crop -->
                            <img class="cropped" src="" alt="">
                        </div>
                        <!-- input file -->
                        <div class="box">
                            <div class="options hide">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> Width</span>
                                    </div>
                                    <input type="number" class="img-w form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="300" min="300" max="350" >
                                </div>
                            </div>
                            <!-- save btn -->
                            <button class="btn save hide">Crop Image</button>
                            <!-- download btn 
                            <a class="btn download hide">Use Image</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="croppedImg"></div>
            <?php if($students->account_type == 5)
                {
                    $user_id = $user_id-2;
                } ?>
                <input type="hidden" id="picture_option" name="picture_option" />
                <input type="hidden" name="id" id="stdUID" value="<?php echo $user_id; ?>" />
                <input type="hidden" name="location" value="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) ?>" />
                <input type="hidden" id="syUpload" name="syUpload" value="<?php echo $this->uri->segment(5) ?>"/>
                <button class="btn btn-primary download hide">Upload Cropped image</button>
            </div>
        </div>
    </div>
</form>
</div>

<!--- end crop and upload -->

<script type="text/javascript">
            var result = document.querySelector('.result'),
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
                    var img = document.createElement('img');
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
        var imgSrc = cropper.getCroppedCanvas({
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

    $('.download').click(function () {
        $('#imgUpload').modal('hide');
    });


</script>
