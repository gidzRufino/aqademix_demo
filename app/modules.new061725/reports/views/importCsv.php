<div style="width:300px; margin:20px auto; ">
    <div class="modal-header">
        <h4>Upload CSV File</h4>
    </div>
    <?php
    $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
    echo form_open_multipart(base_url().'reports/processImportUser', $attributes);
    ?>
        <input type="file" name="userfile" ><br><br>
        <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary pull-right">
    <?php
        echo form_close();
    ?>
        <br />
        <br />
<button class="btn btn-success" onclick="window.history.back()"><< Back</button>
</div>

