<div id="cardPreview" style="width:800px; margin: 15px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading clearfix">
            <h4 class="no-margin col-lg-4">Grades Review</h4>
            <button style="margin-left:5px;" data-dismiss="modal" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close fa-2x"></i></button>
            <button  onclick="printCard('<?php echo base64_encode($student->uid) ?>', '<?php echo $sy ?>', '<?php echo $term ?>','<?php echo $strand ?>')" class="pull-right btn btn-danger btn-xs"><i class="fa fa-print fa-2x"></i></button>
        </div>
        <div id="cardPreviewData" class="panel-body">
            
        </div>
        <div id="admittedToWrapper" style="display: none;" class="panel-footer clearfix">
            <div class="form-group col-lg-6 ">
                <label>Admitted To: </label>
                <input type="text" id="admittedTo" placeholder="Grade Level " class="form-control"  />
            </div>
            <div class="form-group col-lg-6">
                <label>Date: </label>
                <input type="text" id="dateAdmitted" value="2020-04-01" placeholder="Date format: YYYY-MM-DD" class="form-control"  />
            </div>
        </div>
    </div>
</div>

       