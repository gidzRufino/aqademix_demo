<?php
echo Modules::run('mobile/html_header');
?>
<div style="display:none;" class="submitLoad" id="submitLoad">
    <img style="width:100px; height: 100px;" alt="loading gif" src="<?php echo base_url('assets/img/loading.gif');?>" />
</div>
<div id="secretContainer" class="hide submitLoad " >
    
</div>

<div style="width:100%; margin:0 auto;">
   <?php $this->load->view($modules.'/'.$main_content); ?> 
</div>
<?php
echo Modules::run('mobile/html_footer');