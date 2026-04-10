            
<?php foreach($news->result() as $ticker){ ?>   
            <div class="text"><span style="color:navyblue;"><?php echo $ticker->ticker_title ?> </span><?php echo $ticker->ticker_msg ?></div>
            <div class="text"><span style="color:navyblue;">Good Day! </span>Welcome to your library </div>
<?php } ?>
            <!-- <div class="text"><span style="color:navyblue;">Good Day! </span>Welcome to your library </div> -->
            
<script type="text/javascript">
$(function(){
	$('.marquee')
        .marquee({
		//speed in milliseconds of the marquee
		speed: 10000,
		//gap in pixels between the tickers
		gap: 100,
		//gap in pixels between the tickers
		delayBeforeStart: 0,
		//'left' or 'right'
		direction: 'left',
		//true or false - should the marquee be duplicated to show an effect of continues flow
		duplicated: false,
		//on hover pause the marquee - using jQuery plugin https://github.com/tobia/Pause
		//pauseOnHover: true,
                
                //finished: checkTicker()
	})
        .bind('finished', function () {
            var loopCounter = $('#tickerLoopCounter').val();
            var rfid = $('#ifScan').val();
            loopCounter = parseInt(loopCounter)+ parseInt(1);
            $('#tickerLoopCounter').val(loopCounter);
            if(loopCounter==5){
                checkTicker();
               $('#tickerLoopCounter').val('0');
               
                var loopSummary = $('#loopSummary').val();
                loopSummary = parseInt(loopSummary)+ parseInt(1);
                $('#loopSummary').val(loopSummary);
                
                if(loopSummary==2)
                    {   
                        if(rfid==""){
                            location.reload();
                            $('#loopSummary').val(0)
                            $('#tickerLoopCounter').val();
                        }else{
                            loopCounter = parseInt(loopCounter)- parseInt(1);
                            $('#tickerLoopCounter').val(loopCounter);
                            loopSummary = parseInt(loopSummary)- parseInt(1);
                            $('#loopSummary').val(loopSummary);
                        }
                        
                        
                    }
            }
           
        })
});

</script>