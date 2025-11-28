<?php
$this->load->view('mobile_header');
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
<div class="col-lg-12 no-padding">
    <?php $this->load->view($modules.'/'.$main_content); ?>     
</div>
<?php
$this->load->view('mobile_footer');