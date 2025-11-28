<?php
echo Modules::run('templates/html_header');
$website = Modules::run('main/getSet');
echo link_tag('assets/css/mobile/mobile.css');
?>
 <style>
     body{
   // background: url('<?php echo base_url("mobile-bg.jpg") ?>') no-repeat top center fixed !important; 
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important; 
     }
 </style>
<div class="col-lg-12">
    <?php $this->load->view($modules.'/'.$main_content); ?>     
</div>
 <script type="text/javascript">
     function logout()
     {
         var con = confirm('Are you sure you want to logout?');
         if(con==true)
         {
             document.location = "<?php echo base_url('login/logout'); ?>"
         }
     }
 </script>

<?php
echo Modules::run('templates/html_footer');