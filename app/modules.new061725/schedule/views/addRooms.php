<div id="addRoomsForm"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Rooms
        </div>
        <div class="panel-body clearfix">
            <?php
                $attributes = array('class' => '','role'=>'form', 'id'=>'addRoom');
                echo form_open(base_url().'', $attributes);
            ?>
                <div class="control-group">
                    <label class="control-label">Room</label>
                        <div class="controls">
                        <input name="room" type="text" id="room" placeholder="room">
                        </div>
                    </div>
                <div class="control-group">
                    <label class="control-label">Room Description</label>
                        <div class="controls">
                            <textarea name="room_desc" cols="45" rows="4" class="text-left">

                            </textarea>
                        </div>
               </div>

            <?php
                echo form_close();
            ?>            
            <div class="control-group pull-right">
                <button onclick="addRooms()" id="addRoomBtn" class="btn btn-small btn-primary">Add Room</button>
            </div>
            
        </div> 
        
    </div>
</div>  

<script type="text/javascript">
    
    function addRooms()
    {
        var url = "<?php echo base_url().'schedule/addRooms/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               data: $('#addRoom').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
               }
             });

        return false;
    }
</script>