<?php
echo Modules::run('templates/html_header');
echo Modules::run('financemanagement/get_finance_menus');
?>
<div style="display:none;" class="submitLoad" id="submitLoad">
    <img style="width:100px; height: 100px;" alt="loading gif" src="<?php echo base_url('assets/img/loading.gif');?>" />
</div>
<div id="secretContainer" class="hide submitLoad " >
    
</div>
<div style="width:1080px; margin:0 auto;">
   <?php $this->load->view($modules.'/'.$main_content); ?> 
</div>
<?php
echo Modules::run('templates/html_footer');