<!DOCTYPE html >
<?php
 //   echo header("Content-Type: text/html; charset=UTF-8");   
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php
    echo link_tag('assets/css/jquery.mobile-1.4.0.min.css');
    echo link_tag('assets/css/jquery.mobile.structure-1.4.0.min.css');
    echo link_tag('assets/css/dp.css');
    echo link_tag('assets/css/bootstrap.css');
    echo link_tag('assets/css/bootstrap-responsive.css');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/datepicker.css');
    echo link_tag('assets/css/select2.css');
    echo link_tag('assets/css/myStyle.css');
    echo link_tag('assets/css/bootstrap-editable.css');
    ?>
</head>
    <body style="height:100%;">
        
        <?php $this->load->view($main_content); ?>
        
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.mobile-1.4.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ajaxfileupload.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/validation.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.cookie.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/fingerprint.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-limit.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/select2.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/js/bootstrap.clickover.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-editable.js'); ?>"></script>
        
        <script type="text/javascript">
        $(document).ready(function() { 
            $('#2').hide();
            $('#3').hide();
            $('#backBtn').hide();
            $('#registerBtn').hide();
        });
        
        if(navigator.userAgent.match(/Android/i)){
            window.scrollTo(0,1);
        }
        </script>
    </body>
</html>