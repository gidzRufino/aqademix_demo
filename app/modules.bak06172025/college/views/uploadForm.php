
<?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'main/do_upload', $attributes);
        ?>
    <input style="height:35px;" class="btn-mini" type="file" name="userfile" size="20" />
    <br /><br />

    <input type="hidden" name="picture_option" value="sign" />
    <input type="submit" value="upload" class="btn-info"/>
    <input type="hidden" name="id" value="<?php echo $user_id?>" />
    <input type="hidden" name="location" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" />

 </form>