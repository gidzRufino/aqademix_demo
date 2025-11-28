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
          // echo Modules::run('nav/getSideNav');
          
      ?>
   </nav>

   <?php $this->load->view($modules.'/'.$main_content); ?> 

   <input type="hidden" id="chat_url" value="<?php echo base_url().'chat_system/chat/' ?>"/>
   <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
   <div id="submitLoad" class="hide">
      <div class="submitLoadDesktop " style="z-index: 2000">
         <!-- <img src="<?php // echo base_url().'images/loading.gif' ?>" style="width:150px" /> -->
      </div>
   </div>
   <div id="notify_me" style="position:absolute; bottom:5%; right:1%;display: none; " class="alert alert-danger" data-dismiss="alert-message">

   </div>

<!-- /#page-wrapper -->
<script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
   
<!-- chat Javascript -->
<script src="<?php echo base_url('assets/js/plugins/chat.js'); ?>"></script>

<?php
echo Modules::run('templates/html_footer');