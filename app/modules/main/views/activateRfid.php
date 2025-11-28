<h5 id="myModalLabel">Upload the excel file with rfid numbers</h5>
<?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'main/uploadRFID', $attributes);
        ?>
    <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
    <br /><br />

    <input type="submit" value="upload" class="btn-info"/>

 </form>