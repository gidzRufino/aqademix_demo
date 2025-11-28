<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Calendar </h2>
        <input type="hidden" id="year" value="<?php echo $this->uri->segment(3) ?>" />
        <input type="hidden" id="month" value="<?php echo $this->uri->segment(4) ?>" />
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <?php 
                echo $showCal;
        ?>
    </div>
    <div class="col-lg-4 cal_highlights">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h5>Schedule of Events
                         <a style="margin-right:5px;" id="addEvent" class="help-inline pull-right hide" 
                                    rel="clickover" 
                                    data-content=" 
                                         <?php 
                                         $event['category'] = $event_category;
                                         $this->load->view('addEvent', $event) 

                                          ?>
                                          "   
                                          href="#"><i style="color:white;" class="fa fa-plus-square fa-2x"></i></a>
                </h5>
            </div>
            <div class="panel-body">
                <div id="cal_highlights">
                    <?php 
                        echo Modules::run('calendar/getEvent', $this->uri->segment(3), $this->uri->segment(4),'', $this->session->userdata('username'));
                    ?>
                </div>
                <input type="hidden" value="0" id="showAddImage" />
                <input type="hidden" value="" id="getDay" />
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    
    function addEvent()
    {
        var ev = $('#inputEvent').val()
        var evCat = $('#inputEventCategory').val()
        if(evCat==3){
            var Person_involved = "<?php echo $this->session->userdata('user_id') ?>"
        }else{
            Person_involved = "All"
        }
        var evFrom = $('#inputFinalFrom').val()
        var evTo = $('#inputFinalTo').val()
        var day = $('#getDay').val()
        var month = $('#month').val()
        var year = $('#year').val()
        
        var date = year+'-'+month+'-'+day;
        
         var url = "<?php echo base_url().'calendar/addEvent'?>" // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "event="+ev+"&category="+evCat+"&ev_from="+evFrom+"&ev_to="+evTo+"&date="+date+"&person_involved="+Person_involved+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                        alert('Event Successfully Saved')
                        location.reload()
                   }
                 });

            return false;
        
    }
    
    
    function getEvents(day){
         if(day<10)
             {
                 day = '0'+day
             }
          var Person_involved = "<?php echo $this->session->userdata('user_id') ?>"
          
          var url = "<?php echo base_url().'calendar/getSpecificEvent/'?>"+$('#year').val()+'/'+$('#month').val()+'/'+day+'/'+Person_involved; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "day="+day+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#cal_highlights').html(data)
                       $('#getDay').val(day)
                        
                   }
                 });

            return false;
    }
    
    
    
    $(".addEvent").click(function () 
    {
        //alert('ey')
        $('#addEvent').removeClass('hide')
        $('.popover-content').attr({style: 'padding:0'});
        $('#getDay').val($(this).children().first().html())
        if($(this).children().first().hasClass('highlight')){
          $(this).children().first().addClass('cal_selected highlight_selected')             
          $(this).children().first().removeClass('highlight')             
        }else{
           if($(".addEvent a").hasClass('highlight_selected')){
              $('.highlight_selected').addClass('highlight') 
              $('.highlight').removeClass('cal_selected highlight_selected') 
           }
           
        }
        
        if($(this).children().first().hasClass('has_event')){
          $(this).children().first().addClass('cal_selected is_selected')             
          $(this).children().first().removeClass('has_event')             
        }else{
           if($(".addEvent a").hasClass('is_selected')){
              $('.is_selected').addClass('has_event') 
              $('.has_event').removeClass('cal_selected is_selected') 
           }
           
        }
        
        
        if($(".addEvent a").hasClass('no_event_selected')){
           $('.no_event_selected').addClass('no_event') 
           $('.no_event').removeClass('cal_selected no_event_selected') 
         }   
         
        if($(this).children().first().hasClass('no_event'))
           {
               $(this).children().first().addClass('cal_selected no_event_selected')  
               $(this).children().first().removeClass('no_event')
           }
           
    }); 
$(document).ready(function() {
  $('#addEvent').clickover({
                    placement: 'left',
                    html: true
                  });  
});

function finalTime(fromTo)
{
    var hour = $('#inputHour'+fromTo).val()
    var minutes = $('#inputMinutes'+fromTo).val()
    var AmPm = $('#'+fromTo).val()
    
    if(AmPm=="PM"){
        hour = parseInt(hour) + 12;
    }
    
    $('#inputFinal'+fromTo).val(hour+minutes)
}

        
    
</script>

