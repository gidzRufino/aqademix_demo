<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">ROOMS MANAGEMENT
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                <button data-toggle="modal" data-target="#addRoomsForm" class="btn btn-warning">Add Rooms</button>
              </div>
        </h3>
    </div>
     <div class="col-lg-12 no-padding">
        <div class="col-lg-12">
            <div style="width:70%; margin: 50px auto">
                
            <table class="table table-striped table-hover col-lg-6">
                <thead>
                    <tr>
                        <th colspan="3" style="text-align:center;"><H4>LIST OF ROOMS</H4></th>
                    </tr>
                    <tr>
                        <th style="width:50%;">Rooms</th>
                        <th style="width:50%;">Description</th>
                        <!--<th style="width:10%;">Pre-requisite</th>-->
                    </tr>
                </thead>
                <tbody id="subjectsWrapper" style="overflow-y: scroll;">
                    <?php foreach($rooms as $r): ?>
                    <tr class="pointer" onmouseover="" id="<?php echo $r->rm_id ?>_li">
                        <td><?php echo $r->room ?></td>
                        <td><?php echo $r->rm_desc ?></td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            </div>

        </div>
    </div> 
</div>
<?php 
    $this->load->view('addRooms'); ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#dcms_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    })
    
    function getAdd(data)
    {
        $('#add'+data).modal('show');
    }
    
    function loadSubject(course)
    {
        $('#courseTitle').html(course);
        var url = '<?php echo base_url().'college/coursemanagement/loadSubject/' ?>'+$('#course_id').val()
         $.ajax({
               type: "GET",
               url: url,
               dataType: 'json',
               data: '', // serializes the form's elements.
               success: function(data)
               {
                   $('#11_Sem').html(data.fyfs);
                   $('#12_Sem').html(data.fyss);
                   $('#21_Sem').html(data.syfs);
                   $('#22_Sem').html(data.syss);
                   $('#31_Sem').html(data.tyfs);
                   $('#32_Sem').html(data.tyss);
               }
             });

        return false;
    }
    
    function getLevel(level)
    {
        alert(level)
        if(level=='k12'){
            $('#k12').show()
            $('#college').hide()
        }else if(level=='college'){
            $('#k12').hide()
            $('#college').removClass('hide')
            
        }
    }
    
    function addSection()
    {
        var section = $('#txtAddSection').val()
        var grade_id = $('#grade_id').val()
        var url = '<?php echo base_url().'coursemanagement/addSection/' ?>'+section+'/'+grade_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   dataType: 'json',
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data.msg)
                       if(data.status){
                            $('#'+grade_id+'_section').append('<li>'+section+'</li>');
                       }
                   }
                 });

            return false;
    }
    
    function addCourse()
    {
        var course = $('#inputCourse').val()
        var short_code = $('#inputShortCode').val()
        var url = '<?php echo base_url().'coursemanagement/addCourse/' ?>'+course+'/'+short_code;
             $.ajax({
                   type: "GET",
                   url: url,
                   dataType: 'json',
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data.msg)
                       if(data.status){
                            $('#college').append('<li>'+course+'</li>');
                       }
                   }
                 });

            return false;
    }
    
    function deleteSection()
    {
        var section_id = $('#sec_id').val()
        var section = $('#sec_name').val()
        var answer = confirm("Do you really want to delete this Section name '"+section+"'? You cannot undo this action, so be careful.");
        if(answer==true){
            var url = '<?php echo base_url().'coursemanagement/deleteSection/' ?>'+section_id;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully Deleted')
                       $('#'+section_id+'_li').hide();
                   }
                 });

            return false;
        }
    }
</script>