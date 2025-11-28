<?php
echo Modules::run('templates/html_header');
$website = Modules::run('main/getSet');
?>

<div id="wrapper">
    <input type="hidden" id="portal_address" value="<?php echo base64_encode($website->web_address); ?>" />
    <input type="hidden" id="web_address" value="<?php echo $website->web_address; ?>" />
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; ">
            <?php
                echo Modules::run('nav/getDashIcons');
                echo Modules::run('nav/getSideNav');
                
            ?>
        </nav>

        <div id="page-wrapper">
            <span class="hide" id="countdown"></span>
                   <?php $this->load->view($modules.'/'.$main_content); ?> 
            
        </div>
        <input type="hidden" id="chat_url" value="<?php echo base_url().'chat_system/chat/' ?>"/>
        <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
        <div id="submitLoad" class="hide">
            <div class="submitLoadDesktop " style="z-index: 2000">
               <img src="<?php echo base_url().'images/loading.gif' ?>" style="width:150px" />
           </div>
        </div>
        <div id="notify_me" style="position:absolute; bottom:5%; right:1%;display: none; " class="alert alert-danger" data-dismiss="alert-message">
           
        </div>
        <!-- /#page-wrapper -->
        <script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
        <script type="text/javascript">
             startCount(15, 1000, checkPortal,'countdown');
        
            function checkPortal()
            {
                var web_address = $('#portal_address').val()
                var url = "<?php echo base_url().'main/checkPortal/'?>"+web_address; // the script where you handle the form input.

                $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          // alert(data.msg)
                           if(data.status){

                               $('#portal_status').removeClass('fa-spinner fa-spin')
                               $('#portal_status').addClass('fa-circle')
                               $('#portal_status').attr('status', '1')
                               $('#portal_status').attr('style', 'color:#33EF26')
                           }else{
                               if($('#portal_status').attr('status')==1){
                                  $('#portal_status').attr('status', '0')
                                  $('#portal_status').removeClass('fa-wifi')
                                  $('#portal_status').addClass('fa-spinner fa-spin')
                               }

                           }
                           startCount(15, 1000, checkPortal,'countdown');
                           
                       }
                     });

                return false;

            }
</script>  
   
<!-- chat Javascript -->
<script src="<?php echo base_url('assets/js/plugins/chat.js'); ?>"></script>

<?php
echo Modules::run('templates/html_footer');