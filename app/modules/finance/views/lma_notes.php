<?php
    $notes = Modules::run('finance/finance_lma/getNotes', $st_id, $school_year);
?>
<div class="col-lg-12">
    <button id="nt_edit" onclick="$(this).hide(), $('#nt_save').show(), $('#notes').hide(), $('#notes').hide(), $('#notes_edit').show(), $('#notes_edit').val($('#notes_details').html())" style="display:none;" class="btn btn-warning btn-xs pull-right"><i class="fa fa-edit"></i></button>
    <button id="nt_save" onclick="saveNotes()" class="btn btn-success btn-xs pull-right" style="display:none;"><i class="fa fa-save"></i></button><br />
    <blockquote onmouseover="$('#nt_edit').show()" onmouseout="setTimeout(function(){ $('#nt_edit').hide(); }, 5000);" id="notes" class="blockquote" style="border-left: 1px solid #ccc; background: white; height:130px;">
        <p style="font-size:14px;" id="notes_details" class="mb-0"> <?php echo $notes->notes ?> </p>
    </blockquote>

</div>

<textarea cols="42" rows="6" id="notes_edit" style="display:none;">

</textarea>

<script type="text/javascript">
    
    function saveNotes()
    {
        var st_id = $('#st_id').val();
        var notes = $('#notes_edit').val();
        var school_year = '<?php echo $this->session->school_year; ?>';
       // alert(st_id)
        var url = "<?php echo base_url() . 'finance/finance_lma/saveNotes' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                    st_id           : st_id,
                    notes           : notes,
                    school_year     : school_year,
                    csrf_test_name  : $.cookie('csrf_cookie_name')
            
                  }, // serializes the form's elements.
            success: function (data)
            {
                alert(data);
                location.reload()
                //console.log(data)
            }
        });

        return false;
    }
</script>