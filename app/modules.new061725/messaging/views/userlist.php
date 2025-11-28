<?php
session_start();
$_SESSION['username'] = $this->session->userdata('username');
?>

<div id="main_container">
    <input type="hidden" id="chat_url" value="<?php echo base_url().'chat_system/chat/' ?>"/>
<a href="javascript:void(0)" onclick="javascript:chatWith('Principal')">Chat With Principal</a>
<a href="javascript:void(0)" onclick="javascript:chatWith('babydoe')">Chat With Baby Doe</a>
<!-- YOUR BODY HERE -->

</div>