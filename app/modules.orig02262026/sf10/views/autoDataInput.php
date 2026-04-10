<div class="modal" id="autoDataInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header clearfix">
                Generate Record
                <i class="fa fa-close pull-right pointer" data-dismiss="modal"></i>
                <button onclick="getRecords()" class="btn btn-primary pull-right"><i class="fa fa-database fa-fw"></i>Fetch Records</button>
            </div>
            <div class="modal-body clearfix">
                <div class="col-lg-12" id="autoFetchRecords">

                </div> 

            </div>
        </div>
    </div>
</div>
<input type="hidden" id="saveController" value="0" />

<script type="text/javascript">

    function getRecords()
    {
        var user_id = $('#st_id').val();
        var grade_level = $('#pgLevel').val();
        var isSave = $('#saveController').val();
        var sySelect = $('#inputSchoolYear').val();
        var strand = $('#strand-id').val();
        var semester = $('#acadSemester').val();

//        alert(user_id + ' ' + grade_level + ' ' + isSave + ' ' + sySelect + ' ' + strand);

        var url = "<?php echo base_url() . 'sf10/searchRecords/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: { 
                    csrf_test_name  : $.cookie('csrf_cookie_name'),
                    st_id           : $('#st_id').val(),
                    user_id         : user_id,
                    grade_level     : grade_level,
                    ifSave          : isSave,
                    spr_id          : $('#acadSPRId').val(),
                    sySelect        : sySelect,
                    strand_id       : strand,
                    semester        : semester
            },
            beforeSend: function () {
                showLoading('autoFetchRecords');
            },
            success: function (data)
            {
                $('#autoFetchRecords').html(data);
                if (isSave == 1)
                {
                    alert('Records Successfully Processed')
                }
                if (isSave == 2)
                {
                    alert('Record is Successfully Reprocessed');
                    $('#autoDataInput').modal('hide');
                    getAcad(grade_level)
                }
            }



        })
    }


</script>    