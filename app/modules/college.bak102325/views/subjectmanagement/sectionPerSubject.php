
<div class="col-lg-12">
    <table class="table table-stripe">
        <thead>
         <tr>
            <th>Course</th>
            <th>Subject</th>
            <th>Section</th>
            <th>Semester</th>
            <th></th>
        </tr>   
        </thead>
        
        <?php

            foreach ($section as $sec):
                ?>
                <tr id="tr_<?php echo $sec->sec_id ?>">
                    <td><?php echo $sec->short_code; ?></td>
                    <td><?php echo $sec->sub_code; ?></td>
                    <td id="td_<?php echo $sec->sec_id ?>" class="td_edit" ><?php echo $sec->section; ?></td>
                    <td id="td_<?php echo $sec->sec_id ?>_sem" class="td_edit" ><?php echo $sec->sec_sem; ?></td>
                    <td class="text-center">
                        <button title="Edit Section" onclick="editSection('<?php echo $sec->sec_id ?>','<?php echo $sec->is_requested ?>')" class="btn btn-xs btn-success"><i class="fa fa-pencil-square fa-fw"></i></button>
                        <button title="Delete Section" onclick="deleteSection('<?php echo $sec->sec_id ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></button>
                    </td>
                </tr>
            <?php
            endforeach;
?>
    </table>
</div>

<script type="text/javascript">
    
    function editSection(sec_id, isRequested)
    {
            var OriginalContent = $("#td_"+sec_id).text(); 

            $("#td_"+sec_id).addClass("cellEditing"); 
            $("#td_"+sec_id).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
            $("#td_"+sec_id).children().first().focus(); 
            $("#td_"+sec_id).children().first().keypress(function (e) 
            {   if(e.which == 13) {
                    var newContent = $(this).val(); 
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'college/subjectmanagement/editSection' ?>",
                        dataType: 'json',
                        data: 'sec_id='+sec_id+'&value='+newContent+'&isRequested='+isRequested+'&school_year='+$("#inputSY").val()+'&csrf_test_name='+$.cookie('csrf_cookie_name') ,
                        cache: false,
                        success: function(data) {
                             alert('Section Updated Successfully');
                             location.reload();
                        }
                    });
                    
                    
                    $(this).parent().text(newContent); 
                    $(this).parent().removeClass("cellEditing");
                }
            })  
    }
    
    function deleteSection(sec_id)
    {
            
       var confirmDelete = confirm('Are you sure you want to Delete this Section? Please note that you cannot undo this action.');
       if(confirmDelete)
       {
           var url = "<?php echo base_url().'college/subjectmanagement/deleteSection/' ?>"+sec_id+"/"+$('#inputSY').val(); // the script where you handle the form input.
            $.ajax({
                   type: "GET",
                   url: url,
                   data:'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data);
                       location.reload();
                   }
                 });

            return false;
       }
    }
</script>   