<?php 
   // echo Modules::run('chat_system/onlineUsers');
?>
<script>
        $(function(){

        $('#inputBdate').datepicker();
        $('[rel="clickover"]').clickover({
            placement: 'top',
            html: true
          });

        });

</script>


<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/js/plugins/metisMenu/metisMenu.min.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap.clickover.js'); ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/js/sb-admin-2.js'); ?>"></script>
    
    <!--table sorter javascript -->
    
    <script src="<?php echo base_url('assets/js/plugins/jquery.tablesorter.js'); ?>"></script>
    
    <!-- chat Javascript -->
    <!-- <script src="<?php echo base_url('assets/js/plugins/chat.js'); ?>"></script> -->
    
    <!--Editable Table Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap.editable.js'); ?>"></script>   
    
    <!--Tootip Plugin Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-tooltip.js'); ?>"></script>   
    
    <!--Cookie Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>   
  </body>
</html>