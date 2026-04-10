<?php 
    echo doctype('html5');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/plugins/li-scroll.css');
    echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');
       // $timeIn = $settings->time_in_employee_am;
       // $timeInPM = $settings->time_in_employee_pm;

?>

 <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.marquee.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/cam/webcam.js'); ?>"></script>
    <!--Cookie Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>  
  </head>
  <body style="overflow-y: hidden;">
<style scoped>
body{
    background: #FFF;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: 102% 103% !important;
}
     
</style>    

<style type="text/css">

</style>
<div style="background:#003399;" class="col-lg-12 no-margin">
    <div style="margin:0 auto; width:80%;">
         <img src="<?php echo base_url().'images/icons/pecit_election_header.jpg' ?>"  style="width:100%; height:150px; "/>
    </div>
    <h1 class="text-center" style="color: white; font-size: 30px; margin:0 0 10px !important;">[ Automated Election System ]</h1>
</div>
<div id="electionBody" class="col-lg-12" style="margin-top:30px;">
    <?php echo Modules::run('college/election/electionBody');
    $totalVotes = Modules::run('college/election/getVotes', 1)->num_rows();
    ?>
    
</div>

<div class="footer navbar-fixed-bottom" style="background:#003399; height: 100px;"  >

    <h1 style="color:white; font-size: 30px;">Unofficial Count as of <?php echo date('F d, Y G:i a') ?> </h1>
    <div class="col-lg-12 footer navbar-fixed-bottom"><h6 style="text-align: right; font-size:20px; color:#39dd4f; font-weight: bold;">POWERED BY: e-sKwela  [ CSSCore Inc. ] </h6></div>
</div>




<script type="text/javascript">
$(document).ready(function() { 
  
  getLiveResult();
  
    
    });
    
    document.addEventListener("keydown", function(e) {
        if (e.keyCode == 13) {
          launchFullScreen(document.documentElement);
        }
        
    })
    
    function getLiveResult()
    {
      
            var url = '<?php echo base_url().'college/election/electionBody/' ?>';
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {    
                      $('#electionBody').html(data)
                      
                        $('.carousel').carousel({
                         interval: 5000
                       });
                       
                      setTimeout(function(){
                           getLiveResult();
                      }, <?php echo (count($candidate_position)*5000)+10000 ?>);
                   }
                 });
            

            return false;
    }
    

</script>
<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>

  </body>
  </html>

