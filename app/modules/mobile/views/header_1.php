<?php
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>'; 
    echo link_tag('assets/css/jquery.mobile-1.4.0.min.css');
    echo link_tag('assets/css/jquery.mobile.structure-1.4.0.min.css');
    echo link_tag('assets/css/mobile.css');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/bootstrap-responsive.css');
    echo link_tag('assets/css/datepicker.css');
    echo link_tag('assets/css/select2.css');
    echo link_tag('assets/css/calendar.css');
?>
 <title>Integrated Student Management Systems</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.mobile-1.4.0.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/bootstrap.clickover.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/countdown.js'); ?>"></script> 
<script src="<?php echo base_url('assets/js/attendanceRequest.js'); ?>"></script>
<!--<script src="<?php echo base_url('assets/js/smsRequest.js'); ?>"></script>-->
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.tablesorter.js'); ?>"></script>
</head>
<div class="modal-header" style="background: #02008C; color:white; height:50px;" >
    <?php if($this->session->userdata('is_logged_in')): ?>
    <a href="<?php echo base_url('main/dashboard'); ?>" />
        <img style="background: rgba(255,255,255,0.5); padding:5px; border-radius: 5px; float:left; margin:5px 0 0;" src="<?php echo base_url().'images/eskwela_logo.png' ?>" width="32" />
    </a>
    <?php endif; ?>
    
    <div class=" text-center">
       <h4 style="margin:0;"><?php echo $settings->short_name ?></h4>
        <h4>( e-sKwela )</h4> 
    </div>
    
</div> 