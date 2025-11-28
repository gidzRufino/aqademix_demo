
<div id='basicInfo'>
    <div class='control-group pull-left'>
              <label class='control-label'>First Name</label>
              <div class='controls'>
                <input type='text' name='firstname' value='<?php echo $firstname ?>' placeholder='<?php echo $firstname ?>' id='firstname' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Middle Name</label>
              <div class='controls'>
                <input type='text' name='middlename' value='<?php echo $middlename ?>' placeholder='<?php echo $middlename ?>' id='middlename' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Last Name</label>
              <div class='controls'>
                <input type='text' name='lastname' value='<?php echo $lastname ?>' placeholder='<?php echo $lastname ?>' id='lastname' />
              </div>
              
    </div>
            
            
</div>
<div style='margin:5px 0 10px; float:right;'>
    <input type='hidden' id='pos' value='<?php echo $pos?>' />
    <input type='hidden' id='st_user_id' value='<?php echo $st_user_id?>' />
    <input type='hidden' id='rowid' value='<?php echo $parent_id?>' />
    <input type='hidden' id='name_id' value='<?php echo $name_id?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='editParentInfo()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    

<script type='text/javascript'>
    
    function editParentInfo()
    {
        var url = '<?php echo base_url() . 'registrar/editParentInfo/' ?>'; // the script where you handle the form input.
        $.ajax({
            type: 'POST',
            url: url,
            //dataType: 'json',
            data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&parent_id=' + $('#rowid').val() + '&user_id=' + $('#st_user_id').val() + '&sy=' + <?php echo $school_year ?> +'&pos='+ $('#pos').val()+'&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                //$('#' + name_id).html(data);
                location.reload();
            }
        });

    }
</script>


