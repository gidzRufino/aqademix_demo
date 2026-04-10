<?php
//echo $this->session->department;
$eRequirements = Modules::run('college/enrollment/displayCheckListPerDept', $this->session->department, 1);
?>
<h4>Enrollment Requirements</h4>
<?php
foreach ($eRequirements as $er):
    $check = Modules::run('college/enrollment/checkReq', base64_encode($this->session->st_id), $er->eReq_id);
    if ($check):
        $style = 'background-color: green';
        $status = '';
        $fa = 'fa fa-check-circle';
    else:
        $style = 'background-color: gray';
        $status = '';
        $fa = 'fa fa-minus-circle';
    endif;
    ?>
    <div class="row">    
        <div class="col-md-6" style="padding: 6px">
            <span class="badge badge-pill badge-light nowrap" style="cursor: pointer; <?php echo $style ?>" data-toggle="modal" data-target="#updateProgress" onclick="$('#clid').val()"><i class="<?php echo $fa ?>"></i>&nbsp;</span>
            <span class="nowrap">
                <?php echo $er->eReq_desc ?>
            </span>
        </div>
        <div class="col-md-3">
            <span class="nowrap pull-right">
                <button class="btn btn-small btn-primary" onclick="$('#uploadEFile').modal('show'), $('#reqDesc').text('<?php echo $er->eReq_desc ?>'), $('#req_id').val('<?php echo $er->eReq_id ?>')"><i class="fa fa-upload"></i>&nbsp;Upload</button>
            </span>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<div id="uploadEFile" class="modal fade col-lg-4 col-xs-4" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <span id="reqDesc"></span>
            <button type="button" class="close" onclick="$('#uploadEFile').modal('hide')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <?php
            $attributes = array('class' => '', 'id' => '', 'style' => 'margin-top:20px;');
            echo form_open_multipart(base_url() . 'college/enrollment/do_upload', $attributes);
            ?>
            <input type="file" name="userfile" />
            <p style="text-align: right">
                <input type="submit" value="Upload Files" class="sui-button" />
            </p>
            <input type="hidden" id="req_id" name="req_id" />
            <input type="hidden" id="fileType" name="fileType" value="" />
            <input type="hidden" id="stid" name="stid" value="<?php echo base64_encode($this->session->st_id) ?>"> 
            </form>
        </div>
    </div>
</div>


<style>
    .container
    {
        max-width: 500px;
        margin: auto;
    }
</style>