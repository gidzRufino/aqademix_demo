<?php
    echo Modules::run('templates/portal_header');

    echo $this->load->view($modules."/".$mobile_content);

    echo Modules::run('templates/portal_footer');