<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Migrate Data Files</h3>


    <div class="col-lg-4"></div>
        
    <div class="col-lg-4">
        <?php
        $attributes = array('class' => '', 'id' => 'uploadFileForm', 'style' => 'margin-top:20px;');
        echo form_open_multipart(base_url() . 'coopmanagement/importFileData', $attributes);
        ?>
        <div class="form-group col-lg-12">
            <label class="control-label" for="Height">Type of File</label>
            <select id="typeOfFile" name="typeOfFile">
                <option value="0">Share Capital</option>
                <option value="1">Loan Balance</option>
            </select>

            <input style="height:35px;" class="pull-right" type="file" name="userfile" size="20" />
        </div>
        <br /><br />

        <input type="submit" id="uploadFile" value="upload" class="btn btn-mini btn-info pull-right"/>
        <input type="hidden" name="location" value="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) ?>" />
        <?php echo form_close(); ?>
    </div>

</div>


