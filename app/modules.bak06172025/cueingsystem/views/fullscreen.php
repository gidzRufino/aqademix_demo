<?php 
    echo Modules::run('templates/html_header');
    echo link_tag('assets/css/plugins/li-scroll.css');
     

?>

 <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.marquee.js'); ?>"></script>
  </head>
  <body style="overflow-y: hidden;">
<style scoped>
body{
    /*background: url('<?php echo base_url("assets/css/scanner_bg.jpg") ?>') no-repeat top center fixed !important;*/
    background: #000 no-repeat top center fixed !important;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important;
}
     
</style>    
<script type="text/javascript">
   window.onload = function() {
    }
    document.addEventListener("keydown", function(e) {
        if (e.keyCode == 13) {
          launchFullScreen(document.documentElement);
        }
      }, false);
   
</script>
<style type="text/css">

</style>
<span class="hide" id="countdown"></span>
<div style="display:none;" id="tickChecker"></div>
<input type="hidden" id="tickerLoopCounter" value="1" />
<input type="hidden" id="loopSummary" value="0" />
<input type="hidden" id="ifScan" value="" />
<div class="col-lg-12" style="margin:0; padding:0;">
    <div class="col-lg-8">
    </div>
    <div class="col-lg-4 panel panel-primary" style="margin:0;padding:0; border-left: 5px solid black; height:750px; background: rgba(255,255,255,.5)">
        <div class="panel-heading">
            <h1 class="text-center">NOW SERVING</h1>
        </div>
        <div class="panel-body" id="onlineServants" style="padding:0;">
            <?php $online = Modules::run('cueingsystem/checkOnlineStation');
                foreach ($online->result() as $ol):
             ?>
                <span class="list-group-item clearfix">
                    <h2><i class="fa fa-user fa-fw"></i> <?php echo $ol->station_name; ?> <span class="text-danger pull-right">0001</span> </h2>
                </span>
            <?php endforeach; ?>
            
        </div>
    </div>
    
</div>

<div class='marquee' id="marquee" style="background: black; border-top:2px solid #fff; bottom: 0; padding-top:5px;">
    <?php echo Modules::run('messaging/getAnnouncementTicker', 1); ?>
</div>



<script type="text/javascript">
$(document).ready(function() { 
    startCount(5, 1000, checkStatus,'countdown');

    var idleMouseTimer;
    var forceMouseHide = false;

    $("body").css('cursor', 'none');

    $("#wrapper").mousemove(function(ev) {
            if(!forceMouseHide) {
                    $("body").css('cursor', '');

                    clearTimeout(idleMouseTimer);

                    idleMouseTimer = setTimeout(function() {
                            $("body").css('cursor', 'none');

                            forceMouseHide = true;
                            setTimeout(function() {
                                    forceMouseHide = false;
                            }, 200);
                    }, 1000);
            }
    });
});

function checkStatus()
{
    var url = "<?php echo base_url().'cueingsystem/checkOnlineStationJson/'?>";
      $.ajax({
       type: "GET",
       url: url,
       //dataType: 'json',
       data: 'details=1', // serializes the form's elements.
       success: function(data)
       {
           $('#onlineServants').html(data);
           
       }
      })
      startCount(5, 1000, checkStatus,'countdown');
}

function checkTicker()
{
    var url = "<?php echo base_url().'messaging/getAnnouncementTicker/1'?>"; // the script where you handle the form input.
     $.ajax({
           type: "POST",
           url: url,
           data: 'status=1', // serializes the form's elements.
           success: function(data)
           {
              $('#marquee').html(data);  
             
           }
         });

    return false;  
    
}

function checkTime()// this will not function without countdown.js loaded
{
    var register = document.getElementById("instance").value; 

   // var now =    
    if(register == 1){

        startCount(15, 1000, pageRefresh,'refreshTimer');

    }
    $('#refreshController').val(1)
    
}

function pageRefresh()
{
    $('#refreshController').val(0)
    
    
}



</script>
<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>

  </body>
  </html>

