<?php 
    $checkStatus =  Modules::run('cueingsystem/checkOnlineStatus',$this->session->userdata('user_id') );
    if(!$checkStatus):
        $status = '0';
        $dataTarget = '#selectSection';
        $hide = "hide";
        $label = 'GO ONLINE';
        $class = 'btn-default';
        $station_id = '';
    else:
        $status = '1';
        $dataTarget = '';
        $hide = "";
        $label = 'GO OFFLINE';
        $class='btn-success';
        $station_id = $checkStatus['data']->row()->station_id;
    endif;
?>
<li>
    <div class="panel panel-default" style="margin:0; padding:0">
        <div class="panel-heading " style="padding:0;">
            <h6 class="text-center">Cue System</h6>
            <input type="hidden" id="station_id" value="<?php echo $station_id ?>" />
        </div>
        <div class="panel-body">
            <button id="cue_button" status="<?php echo $status ?>" data-target="<?php echo $dataTarget ?>" data-toggle="modal" class="btn btn-block <?php echo $class ?>"><?php echo $label ?></button>
            <div id="cue_body" class="<?php echo $hide ?>">
                <?php
                    $Cue = Modules::run('cueingsystem/checkCue', $this->session->userdata('dept_id'));
                    //print_r($Cue->row()->cue_number);
                    $onCue = Modules::run('cueingsystem/checkCue', $this->session->userdata('dept_id'), $station_id);
                    
                    $onCue = Modules::run('cueingsystem/addZero', $onCue);
                    if($onCue==0):
                        $onCue = $Cue->row()->cue_number;
                    endif;
                    
                    $onCue = Modules::run('cueingsystem/addZero', $onCue);
                    
                    
                ?>
                <span class="list-group-item clearfix">
                    <h6 style="margin:0;" class="pull-left">NOW SERVING</h6>
                    <h6 style="margin:0;" id="nowServing" class="pull-right text-danger"><?php echo $onCue ?></h6>
                    <input type="hidden" id="cue_id" value="<?php echo $Cue->row()->cue_number; ?>" />
                </span>
               
                <button onclick="serveNext()" class="btn btn-block btn-primary">Serve Next</button>
                
            </div>
            
        </div>
    </div>
    
    <!-- /input-group -->
</li>


<script type="text/javascript">
        $(document).ready(function() { 
            
             $("#cue_button").mouseover(function() {
                 if($(this).attr('status')==1){
                     $(this).removeAttr('data-target')
                 }else{
                     $(this).attr('data-target', '#selectStation')
                 }
             })
             $("#cue_button").click(function() {
                 if($(this).attr('status')==1){
                     var station_id = $('#cue_station').val()
    
                     $('#cue_body').addClass('hide')
                     $(this).attr('status', '0')
                     $(this).html('GO ONLINE')
                     $(this).removeClass('btn-success')
                     $(this).addClass('btn-default')
                     
                      var url = "<?php echo base_url().'cueingsystem/checkInStation/0'?>";
                        $.ajax({
                         type: "GET",
                         url: url,
                         dataType: 'json',
                         data: 'details=1', // serializes the form's elements.
                         success: function(data)
                         {
                             $('#cue_station').html(data)
                         }
                       });
                     
                 }else{
                      var url = "<?php echo base_url().'cueingsystem/getStationDrop/'?>" ;
                    $.ajax({
                     type: "GET",
                     url: url,
                     //dataType: 'json',
                     data: 'details=1', // serializes the form's elements.
                     success: function(data)
                     {
                         $('#cue_station').html(data)
                     }
                   });
                 }
             })
        })
        
function checkStatus()
{
    if($('#cue_button').attr('status')=='1'){
       $('#cue_body').addClass('hide')
       $("#cue_button").attr('status', '1')
       $("#cue_button").html('GO OFFLINE')
       $("#cue_button").addClass('btn-success')
       $("#cue_button").removeClass('btn-default')
    }
           
}


function serveNext()
{
 var station_id = $('#station_id').val()
 var dept_id = '<?php echo $this->session->userdata('dept_id') ?>'
 var cue_id = $('#cue_id').val()
  var url = "<?php echo base_url().'cueingsystem/nextStation/'?>"+dept_id+'/'+station_id+'/'+cue_id;
  $.ajax({
   type: "GET",
   url: url,
   //dataType: 'json',
   data: 'details=1', // serializes the form's elements.
   success: function(data)
   {
       $('#nowServing').html(data)
   }
 });
}

        
function goOnline()
{
    var station_id = $('#cue_station').val()
    
     if($("#cue_button").attr('status')==0){
         $("#cue_button").attr('status', '1')
         $("#cue_button").html('GO OFFLINE')
         $("#cue_button").removeClass('btn-default')
         $("#cue_button").addClass('btn-success')
         $('#cue_body').removeClass('hide')
         
         var url = "<?php echo base_url().'cueingsystem/checkInStation/'?>"+'/1/'+station_id;
          $.ajax({
           type: "GET",
           url: url,
           dataType: 'json',
           data: 'details=1', // serializes the form's elements.
           success: function(data)
           {
               $('#cue_station').html(data)
           }
         });
     }
     
     
     

}        
</script>