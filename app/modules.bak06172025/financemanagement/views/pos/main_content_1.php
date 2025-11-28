<?php
echo Modules::run('financemanagement/html_header');
?>
<div class="submitLoad hide" style="z-index: 2000;" id="loading">
    <!--<img src="<?php echo base_url()?>images/loading.gif" style="width:200px" />-->
</div>
<div id="wrapper">
   <?php $this->load->view($modules.'/'.$main_content); ?> 
        
<?php
echo Modules::run('financemanagement/html_footer');