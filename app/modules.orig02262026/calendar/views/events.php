<div class="list-group">
    
    <?php
    foreach ($event as $e){
        ?>
        <a id="deleteEvent" rel="clickover" 
                       data-content="
                       <button onclick='deleteEvent(<?php echo $e->id ?>, <?php echo $e->category_id ?>)' class='btn btn-danger'><i class='fa fa-trash'></i></button>
                       <button data-dismiss='clickover' class='btn btn-warning'><i class='fa fa-close'></i></button>
                       "
            style="padding:10px 5px; cursor: pointer;" class='list-group-item'>
            <input type="hidden" id="event_cat" value="<?php echo $e->category_id ?>" />
            <small class="pull-right"></small>
            <?php echo $e->event ; ?>
            <span class="pull-right text-muted small">
                <em><?php echo date('g:i a', strtotime($e->time_start)).' - '.  date('g:i a', strtotime($e->time_end)) ; ?></em>
            </span>
            <input type="hidden" id="access" value="<?php echo $this->session->userdata('is_admin') ?>" />
        </a>
        <?php
        }
    ?>
</div>


<script type="text/javascript">
   function deleteEvent(id, cat_id)
    {
        if($('#access').val()){
            var url = "<?php echo base_url().'calendar/deleteEvent/'?>"+id // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+id+'&csrf_test_name='+$.cookie('csrf_cookie_name')  , // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data)
                       location.reload()
                        
                   }
                 });

            return false;
        }else{
           if(cat_id==3){
            
            var url = "<?php echo base_url().'calendar/deleteEvent/'?>"+id // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+id  , // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data)
                       location.reload()
                        
                   }
                 });

            return false;
        }else{
            alert('Sorry, You are not authorized to delete this event!')
            location.reload()
        } 
        } 
            
            
        
    }
    
 $(document).ready(function() {
  $('#deleteEvent').clickover({
                    placement: 'left',
                    html: true
                  });  
});
     
</script>