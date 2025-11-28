<div data-role="panel" id="leftpanel3" data-position="left" data-display="overlay" data-theme="b">
        <?php
         if($this->session->userdata('is_logged_in')):
              echo Modules::run('nav/getUserMenus');
         endif;
        ?>


</div>
