<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/bootstrap.clickover.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/countdown.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/attendanceRequest.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.tablesorter.js'); ?>"></script>
<!--Cookie Javascript-->
<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>  
<script>
        $(function(){
        window.prettyPrint && prettyPrint();

        $('#dp2').datepicker();
        $('#inputBdate').datepicker();
        $('#inputDueDate').datepicker();
        $('[rel="clickover"]').clickover({
            placement: 'top',
            html: true
          });
          
         

        });
        $.mobile.loading('hide');
        
        $('#mobile_body').click(function(){
            fullScreen()
        });
        
        $(document).ready(function(){
            setTimeout(fullScreen, 1000)
        });
        
        function fullScreen()
        {
             var el = document.documentElement,
                rfs = el.requestFullscreen
              || el.webkitRequestFullScreen
              || el.mozRequestFullScreen
              || el.msRequestFullscreen
              ;
             rfs.call(el);
        }
        
</script>
</body>