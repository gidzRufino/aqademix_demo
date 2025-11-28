<?php
    echo link_tag('assets/calendar/fullcalendar.min.css');
?>
<link href="<?php echo base_url('assets/calendar//fullcalendar.print.min.css'); ?>" media="print" rel="stylesheet" />
<script src="<?php echo base_url('assets/calendar/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/calendar/fullcalendar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/calendar/fullcalendar-rightclick.js'); ?>"></script>
<div class="col-lg-12">
    <h4 style="margin-top: 20px;" class="page-header clearfix"><i class="fa fa-calendar fa-2x"></i>  CALENDAR</h4>
    
</div>
<div class="col-lg-8">
    <div id="calendar"></div>
</div>
<div class="col-lg-4">
    <h5 class="no-margin" >List of Events</h5>
    <div id="list-calendar">
        
    </div>
</div>
 <?php 
 if($this->uri->segment(3)==NUll):
     $year = date('Y');
 else:
     $year = $this->uri->segment(3);
 endif;
 if($this->uri->segment(4)==NUll):
     $month = date('m');
 else:
     $month = $this->uri->segment(4);
 endif;
 $events = Modules::run('calendar/getAllEvents',$year, $month);     
 $event['category'] = $event_category;
 $this->load->view('addEvent', $event);
 ?>

<script>
    
    //alert('hey')
   $(document).ready(function() {

        $('#calendar').fullCalendar({
                    
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek'
                },
                
                dayClick: function(date, jsEvent, view) { 
                    //alert('Clicked on: ' + date.format());  
                },
                
                height: 650,
                defaultDate: '<?php echo $year.'-'.$month ?>-01',
                navLinks: true, // can click day/week names to navigate views
                select: function(start, end) {
                    start=moment(start).format('YYYY-MM-DD'); 
                    end=moment(end).format('YYYY-MM-DD'); 
                    $('#addEventModal').modal('show');
                    $('#fromDate').val(start)
                    $('#toDate').val(end)
                    //var title = prompt('Event Title:');
//                    var eventData;
//                    if (title) {
//                            eventData = {
//                                    title: title,
//                                    start: start,
//                                    end: end
//                            };
//                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
//                    }
//                    $('#calendar').fullCalendar('unselect');
                },
                selectable: true,
                selectHelper: true,
                editable: true,
                events: [
                    
                        <?php 
                         foreach ($events as $e):
                             if($e->category_id==4):
                                $color = 'red';
                            else:
                                $color = '#00b70f';
                            endif;
                            echo '{title:"'.$e->event.'",start:"'.$e->event_date.'",color:"'.$color.'"},';
                         endforeach;
                        ?>
                        
                ]
        });
	
        $('.fc-prev-button').click(function () {
            var moment = $('#calendar').fullCalendar('getDate');
            document.location = '<?php echo base_url().'calendar/showCal/' ?>'+moment.format('Y')+'/'+moment.format('MM');
            
            //alert("The current date of the calendar is " + moment.format('MM'));
        });	
        $('.fc-next-button').click(function () {
            var moment = $('#calendar').fullCalendar('getDate');
            document.location = '<?php echo base_url().'calendar/showCal/' ?>'+moment.format('Y')+'/'+moment.format('MM');
        });	
        
        $('#list-calendar').fullCalendar({
                 header: {
                    left: false,
                    center: false,
                    right: false
                },
                defaultView: 'listMonth',
                height: 600,
                defaultDate: '<?php echo $year.'-'.$month ?>-01',
                navLinks: false, // can click day/week names to navigate views
                editable: false,
                events: [
                    
                        <?php 
                         foreach ($events as $e):
                             if($e->category_id==4):
                                $color = 'red';
                            else:
                                $color = '#00b70f';
                            endif;
                            echo '{id:"'.$e->id.'", title:"'.$e->event.'",start:"'.$e->event_date.'",color:"'.$color.'"},';
                         endforeach;
                        ?>
                        
                ],
                eventClick: function(event){
                    var ans = confirm('Are you sure you want to delete this event?');
                //$('#myCalendar').fullCalendar('removeEvents',event._id);
                if (ans) {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'calendar/deleteEvent/' ?>' + event._id,
                        success: function (result) {
                            alert(result);
                           location.reload();
                        }
                    });
                }
                 }
                 
                 
        });
        
        $("#addEvent").click(function () 
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
            var dateFrom = $('#fromDate').val()
            var dateTo = $('#toDate').val()

             var url = "<?php echo base_url().'calendar/addEvent'?>" // the script where you handle the form input.

                $.ajax({
                       type: "POST",
                       url: url,
                       data: "event="+ev+"&category="+evCat+"&ev_from="+evFrom+"&ev_to="+evTo+"&fromDate="+dateFrom+"&toDate="+dateTo+"&person_involved="+Person_involved+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                           //alert(data)
                            alert('Successfully Added')
                            //location.reload()
                       }
                     });

                return false;
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

