<div id="addObservedValues" style="width:500px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Add Observed Values </h4>
        </div>
        <div class="panel-body">
                    <div class="form-group">
                                <select name="selectOV" id="selectOV" onclick="selectOVOPtion(this.value)" style="width:80%;"  class="pull-left controls-row span12" required>
                                <option>Select Option</option> 
                                <option value="core">Core Values</option> 
                                <option value="bs">Behavioral Statements</option> 
                                <option value="indi">Indicators</option> 
                              
                           </select>
                        
                    </div> <br />
                    <div style="display: none;" id="core" class="form-group">
                        <input type="text" class="form-control" name="inputCore" id="inputCore" placeholder="Name of Core Value" />
                    </div>
                    <div style="display: none;" id="bs" class="form-group">
                        <select class="form-control" name="selectCore" id="selectCore" >
                            
                        </select>  <br />
                        <textarea style="text-align: left;" class="form-control text-left" name="inputBS" id="inputBS" placeholder="Name of Behavior Statements"></textarea>
                    </div>
                    <div style="display: none;" id="indi" class="form-group">
                        <select class="form-control" name="selectbs" id="selectbs" >
                            
                        </select>  <br />
                        <textarea class="form-control" name="inputIndi" id="inputIndi" placeholder="Name of Indicators"></textarea>
                    </div>
                    <button onclick="addBhSettings()" class="btn btn-success btn-sm pull-right">Save</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    
</div>

<script type="text/javascript">
    
    function selectOVOPtion(option)
    {
        var prev = $('#prevSelected').val();
        $('#'+option).show();
        $('#prevSelected').val(option);
        $('#'+prev).hide();
        //alert(prev);
        switch(option)
        {
            case 'bs':
                getCore();
            break;
            case 'indi':
                getBS();
            break;
        }
    }
    
    function getCore()
    {
        var url = '<?php echo base_url().'gradingsystem/getCoreValuesInSelect' ?>';
        $.ajax({
           type: "POST",
           url: url,
           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
              $('#selectCore').html(data)
           }
       }) 
    }
    
    function getBS()
    {
        var url = '<?php echo base_url().'gradingsystem/getCustomizedListInSelect' ?>';
        $.ajax({
           type: "POST",
           url: url,
           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
              $('#selectbs').html(data)
           }
       }) 
    }
    
    function addBhSettings()
    {
        var option = $('#prevSelected').val();
        var table;
        var value;
        var cat_id;
        switch(option)
        {
            case 'core':
                table = 'gs_behavior_core_values';
                value = $('#inputCore').val();
                cat_id = '';
            break;
            case 'bs':
                value = $('#inputBS').val();
                table = 'gs_behavior_rate';
                cat_id = $('#selectCore').val();
            break;
            case 'indi':
                table = 'gs_behavior_rate_customized';
                value = $('#inputIndi').val();
                cat_id = $('#selectbs').val();
            break;
        }
        var url = '<?php echo base_url().'gradingsystem/addBHSettings' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: 'table='+table+'&value='+value+'&cat_id='+cat_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function(data)
           {
               if(data.status)
               {
                   alert('Successfully Added');
                   $('#inputIndi').val('');
               }else{
                   alert('Sorry, Something went wrong');
               }
           }
       })
        
        
    }
    
</script>