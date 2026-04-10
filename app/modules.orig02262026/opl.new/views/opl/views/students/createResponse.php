<div class="card card-widget card-blue card-outline" >
    <div class="card-header">
        <h6 class="text-center">Answer</h6>
    </div>
    <div class="card-body">
        <div class="form-group col-xs-12 col-lg-12 float-left">
            <label>Submission Type</label>
            <select id="submissionType" class="form-control">
                <option>Select Submission Type</option>
                <option value="1">File Submission</option>
                <option value="2">Use Editor</option>
                <option value="3">Online Form</option>

            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-lg-12 float-left" id="fileSubmission" style="display: none;">
            <label>Select File to Submit</label><br />
            <input type="file" name="userfile" id="userfile"><br><br />
            <div class="progress" id="progressBarWrapper"  style="display: none;">
                <div class="progress-bar progress-bar-striped" role="progressbar"
                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                    UPLOADING RECEIPT...
                </div>
            </div><br />
            <input class="btn btn-success" type="button" value="Submit File" id="fileSubmit" /> <br /> <br />
        </div>
        <div class="form-group col-lg-12" id="useEditor" style="display: none;">
            <label for="exampleInputEmail1">Answer Details</label>
            <textarea class="textarea" id="answerDetails" placeholder="Place some text here"
                      style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>

            <button onclick="createResponse()" class="btn btn-success">Submit Response</button>          
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#submissionType').on('select2:select', function (e) {
        var option = $(this).val();

        switch (option) {
            case '1':
                $('#fileSubmission').show(), $('#useEditor').hide();
                break;
            case '2':
                $('#fileSubmission').hide(), $('#useEditor').show();
                break;
            case '3':

                break;
        }
    });

</script>