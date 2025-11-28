<?php
echo Modules::run('templates/print_header');
$this->load->view($modules.'/'.$main_content);
echo Modules::run('templates/print_footer');