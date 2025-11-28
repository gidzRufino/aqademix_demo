<?php
echo Modules::run('mobile/html_header');
?>

 <div style="height:55px;" data-role="header" data-theme="b">
     <!--<img style="width:50px;" src="<?php echo base_url('images/form/').$settings->set_logo ?>"/>-->
    <h1 style="margin:0; font-size:18px; font-weight: bold"><?php echo $settings->set_school_name ?></h1>
</div>
 <div data-role="content" >
 
<?php     
                $attributes = array('class' => 'form-horizontal loginFormMobile', 'style'=>'width:100%; float:right;', 'id'=>'mobileLogin');
                echo form_open(base_url('login/verify/'), $attributes);  

                ?> 
                <?php echo validation_errors('<p style="color:red;">','</p>') ?>
                <div class="ui-field-contain">
                    <input name="uname" data-clear-btn="true" id="uname" placeholder="username" value="" data-mini="true" type="text">
                    <input name="pass" onkeypress="if (event.keyCode==13){submitLogin()}" data-clear-btn="true" id="pass" placeholder="password" value="" data-mini="true" type="password">
                </div>
                <div class="ui-field-contain" data-theme="b">
                    <button type="button" onclick="submitLogin()" class="ui-shadow ui-btn ui-corner-all ui-mini ui-btn-b">LOGIN</button>
                </div>
           <?php
                echo form_close();
            ?>  
 </div> 
<script type="text/javascript"> 
    
 $(document).ready(function() {   
    $('#btnSubmit').click(function() {
        var url = "<?php echo base_url().'login/verify/' ?>";
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: $('#mobileLogin').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   if(data.status)
                   {
                       document.location = '<?php echo base_url('main/dashboard') ?>';
                   }else{
                       alert('Sorry you have entered a wrong username or password, Please try again.');
                       location.reload();
                   }
               }
        })
    });
 
 });
 
 function submitLogin()
 {
     var url = "<?php echo base_url().'login/verify/' ?>";
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: $('#mobileLogin').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               beforeSend: function() {
                    $('#load').show();
                    
               },
               success: function(data)
               {
                   if(data.status)
                   {
                       document.location = '<?php echo base_url('main/dashboard') ?>';
                   }else{
                       alert('Sorry you have entered a wrong username or password, Please try again.');
                       location.reload();
                   }
               }
            })
}
    
    </script>

<?php
echo Modules::run('mobile/html_footer');




