<?php
    echo Modules::run('mobile/html_header'); 
    
    ?>
<div id="secretContainer" class="hide submitLoad " >
    
</div>
<div id="mobile_body">
 <?php
    $this->load->view($modules.'/'.$main_content); 
  ?>
</div>
<?php
echo Modules::run('mobile/html_footer');