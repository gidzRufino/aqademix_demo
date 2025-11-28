

<input type="hidden" id="pageController" value="<?php echo $this->uri->segment(3) ?>" />
<script type="text/javascript">

function showWindow(show, hide, titleBar)
{
    $('#'+hide).hide('500');
    $('#'+show).show('500');
    $('#title').html(titleBar);
    $('#titleBar').html($('#'+titleBar+'Replace').html());
}

$('body').bind("swiperight", function(e){
   var page =  $('#pageController').val();
    if(page==0){
        showWindow('showCalendar', 'quickAccess', 'smallCalendar'); 
        $('#pageController').val(1) 
    }
    if(page==2){
        showWindow('quickAccess', 'notifications', 'quickAccess'); 
        $('#pageController').val(0) 
    }
       
});

$('body').bind("swipeleft", function(e){
   var page =  $('#pageController').val();
    if(page==1){
        showWindow('quickAccess', 'showCalendar', 'quickAccess'); 
        $('#pageController').val(0) 
    }
    if(page==0){
        showWindow('notifications', 'quickAccess', 'Notification'); 
        $('#pageController').val(2) 
    }
       
});
</script>