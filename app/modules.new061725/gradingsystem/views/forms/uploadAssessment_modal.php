<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload e-sKwela GS Template</h4>
        </div>
             <?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'reports/importAssessment', $attributes);
        ?>
        <div class="panel-body">
            <input type="hidden" id="importTerm" name="importTerm" />
            <input style="height:30px" type="file" name="userfile" ><br />
            <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>

<!--
<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Deped e-classRecord Template</h4>
        </div>
             <?php
        $attributes = array('class' => '', 'id'=>'importCSV', 'style'=>'margin-top:20px;');
        echo form_open_multipart(base_url().'reports/importAssessment', $attributes);
        ?>
        <div class="panel-body">
                    <div class="form-group">
                                <label class="control-label" for="ww"># of Written Work</label>
                                <input class="form-control" value="0"  name="ww" type="text" id="ww" placeholder="# of Written Work">
                    </div> 
                    <div class="form-group">
                                <label class="control-label" for="PT"># of Performance Task</label>
                                <input class="form-control" value="0"  name="pt" type="text" id="pt" placeholder="# of Performance Task">
                    </div> 
                    <input type="hidden" id="importTempSub" name="importTempSub" />
                    <input type="hidden" id="importTempSection" name="importTempSection" />
                    <input type="hidden" id="importTempTerm" name="importTempTerm" />
                    <input style="height:30px" type="file" name="userfile" ><br />
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>-->