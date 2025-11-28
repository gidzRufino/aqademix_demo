<h2 style="color: red; text-align: center">No Records Found!!!</h2>

<div class="col-lg-12">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <button onclick="$('#createnew').modal('show')" class="btn btn-sm btn-success btn-block">Create New Record</button>
    </div>
</div>

<div style="margin: 50px auto 0;" class="modal col-lg-3" id="createnew" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="createNewBody" class="alert alert-success clearfix text-center" style="margin-bottom: 0; padding: 3px;">
        Are you sure you want to Create a New Record ?<br />
        <button class="btn btn-success btn-sm" onclick="createNewRecord()">YES</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">NO</button>
    </div>
</div>

<script type="text/javascript">
    
    function createNewRecord()
    {
        var url = "<?php echo base_url() . 'sf10/newRecord/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: { 
                    csrf_test_name  : $.cookie('csrf_cookie_name'),
                    st_id           : '<?php echo $user_id ?>',
                    school_year     : '<?php echo $school_year ?>',
                    current_year    : '<?php echo $this->sesion->school_year ?>',
                    grade_level_id  : '<?php echo $grade_id ?>'
            },
            beforeSend: function () {
                showLoading('createNewBody');
            },
            success: function (data)
            {
               alert(data);
               location.reload();
            }



        })
    }
    
    
</script>    