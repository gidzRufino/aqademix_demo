<?php
if(Modules::run('main/isMobile'))
{
    echo Modules::run('mobile/index');
}else{

    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/plugins/morris.css');
    echo link_tag('assets/css/plugins/select2.css');
    echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/datepicker.css');
	
?>
   <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
  </head>
  <script type="text/javascript">
      function handleEnter(inField, e) {
    var charCode;
    
    if(e && e.which){
        charCode = e.which;
    }else if(window.event){
        e = window.event;
        charCode = e.keyCode;
    }

    if(charCode == 13) {
        
    }
}
  </script>
<body style="background: #000">
<style scoped>
    body{
        background: url('<?php echo base_url("images/css.png") ?>') no-repeat 0 center fixed #004160 !important;
        -webkit-background-size: cover !important;
        -moz-background-size: cover !important;
        -o-background-size: cover !important;
        background-size: cover !important;
    }
     
</style>  
<div class="row" style="background:#000;">
   <?php
        //echo base_url();
        $attributes = array('class' => 'form', 'style'=>' width:500px; position:absolute; top:20%; left:30%;', 'id'=>'addEmForm');
        echo form_open(base_url().'index.php/login/verify', $attributes);
        
    ?> 
    
    <input type="hidden" id="setAction" />
    <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
    <h1 class="text-center"style="height:30px; color: white ;font-size: 20px;"><?php echo $settings->set_school_name ?></h1>
  </div>
    <fieldset style="background: rgba(137,137,137,0.85); border-radius:0 0 15px 15px ; padding: 0px 10px 10px;">
        <div class="col-lg-6 col-md-6 pull-left">
            <div style="margin:0 auto;">
                <img class="img-circle" src="<?php echo base_url().'images/forms/'.$settings->set_logo ?>"  style="width:165px; margin:5px 30px; background: white;"/>
            </div>
            
<!--            <i class="fa fa-lock" style="font-size: 12em; color: #ff9f00; margin: 20px 0px 0px 50px; position: absolute;"></i>
            <i class="fa fa-lock" style="font-size:12em; margin:23px 0 0 55px;"></i><br />-->
            
        </div>
        <div class="col-lg-6 col-md-6 pull-right " style="margin:10px 0;">
            <?php echo validation_errors('<p style="color:red;">','</p>') ;
                    ?>
            <div class="form-group">
              <div class="">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input class="form-control" name="uname" id="uname" onclick="this.value=''"  placeholder="UserName" type="text">
                </div>
              </div>
            </div>
            <div class="form-group">
              
              <div class="">
                   <div class="input-prepend" id="password">
                    <input class="form-control" name="pass" id="pass" onclick="this.value=''"  onkeypress="if (event.keyCode==13){ getInside(this.value);}" placeholder="Password" type="password">
                   </div>
                </div>
            </div>
            <div class="form-group">
                 <button target="_blank"  type="submit" class="btn btn-lg btn-default btn-block">LOGIN</button>
                 <div id="result" class="help-block success"></div>
            </div>   
            
        </div>   
        <div class="col-lg-12 col-md-12">
            <a style="color:white; font-size: 12px; margin:0 20%;   " class="clearboth text-center" data-toggle="modal" href="#signUp">
                <i class="fa fa-pencil"></i>
                Sign Up for an Account (Note: For Parents Only)
            </a> 
        </div>
    </fieldset>     
   <?php
        echo form_close();
   ?>       
    

    
</div>
<div id="signUp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
            <h1 class="text-center"style="height:30px; color: white ;font-size: 20px;"><?php echo $settings->set_school_name ?></h1>
            <h4 class="text-center" style="color:white;">Sign Up for a New Account</h4>
         </div>
          <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;" class="modal-body" >
            <!--<form class="form-horizontal" id="formRegister">-->
            <fieldset >
                <label class="text-center text-info">Please Enter Your Phone Number or Email and click the Search button to Verify</label>
                <div style="margin:0 25%; " >
                    <div>
                        <div id="verifyP" class="form-group input-group ">
                            <input onblur="verifyParent($('#verify').val())" onkeypress="if(event.keycode==13){verifyParent(this.value)}" class="error form-control" id="verify" placeholder="Enter Email or Phone Number" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-default">
                                    <i id="verify_icon" onclick="verifyParent($('#verify').val())" class="fa fa-search" style="font-size:20px;"></i>
                                </button>   
                            </span>
                        </div>

                        <div id="confirm">
                             <input type="hidden" id="vResults" value="0" />
                             <input type="hidden" id="parent_id" value="0" />
                             <span id="confirmation"></span>
                        </div>

                    </div>
                    <div id="inputForms" class="hidden" >
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input class="form-control" id="regUname"  placeholder="username" type="text">
                        </div>
                        
                       <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input class="form-control"  id="pass0" placeholder="password" type="password" >
                       </div>
                        <div id="pass_error">
                            <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input onkeyup="checkPass(this.value, $('#pass0').val())" class="error form-control"  id="pass1" placeholder="Retype Password" type="password">

                            </div>
                            <div>
                                 <span id="pass_error_msg"></span>
                           </div>
                        </div>
                    </div>
                    
                </div>

                </fieldset>

            <!--</form>-->  

          <div class="modal-footer">
              <div class="form-group">
                  <div class="controls">
                      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                      <a href="#verifyStudentNumber" id="verifySubmit" data-dismiss="modal" data-toggle="modal" class="btn success hide">SUBMIT</a>
                      <div id="resultSection" class="help-block success" ></div>
                  </div>

              </div>
           </div> 
    </div>
    
  </div>
</div>  
<div id="verifyStudentNumber" class="modal fade" style="width:500px; margin:50px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
        <h1 class="text-center"style="font-size:30px; color:white;"><?php echo $settings->set_school_name ?></h1>
        <h4 class="text-center" style="color:white;">( Register Student ID )</h4>
  </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;">  
        <div class="modal-body">
            <div class="form-group">
                <label for="input">Please Enter Your Student's ID Number</label>
                <input style="width:300px;" class="select2-offscreen" name="inputStudentNumber" type="text" id="inputStudentNumber" placeholder="Type Here">
            </div>
        </div>
        <div class="modal-footer">
          <div class="form-group success">
                      <div class="controls">
                          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                          <button class="btn" onclick="getRegister()" onmouseover= "document.getElementById('setAction').value='getRegister' " aria-hidden="true" >REGISTER</button>

                          <div id="resultSection" class="help-block success" ></div>
                      </div>

                    </div>
       </div>
    </div>     
</div>
<?php //$this->load->view('includes/footer'); ?>
<script type="text/javascript"> 
    
    function verifyParent(value)
    {
        $('#verify_icon').removeClass('fa-search')
        $('#verify_icon').addClass('fa-spinner fa-spin');
        var url = "<?php echo base_url().'login/getVerified/'?>"+value ;
          $.ajax({
           type: "GET",
           url: url,
           dataType:'json',
           data: 'value='+value, // serializes the form's elements.
           success: function(data)
           {
              
              if(data.status){
                    $('#inputForms').removeClass('hidden')
                    $('#confirmation').html(data.msg)
                    $('#confirmation').attr('style',"color:#3C6AC4");
                    $('#vResults').val(1)
                    $('#parent_id').val(data.p_id)
                    $('#confirmation').fadeOut(5000)
                    $('#verify_icon').removeClass('fa-spinner fa-spin')
                    $('#verify_icon').addClass('fa-search');
              }else{
                   // $('#regUname').attr('disabled', 'disabled');
                    $('#verifyP').addClass('form-group error');
                    $('#confirmation').attr('style',"color:red");
                    $('#confirmation').html(data.msg)
                    $('#confirmation').fadeOut(5000)
                    $('#verify_icon').removeClass('fa-spinner fa-spin')
                    $('#verify_icon').addClass('fa-search');
                    setTimeout(function(){
                        $("#verify").focus();
                    }, 0);
                   
                    

                }

           }
         });
      
    }
    function getInside(){

        var data = new Array();
         
         data[0] = document.getElementById('uname').value;
         data[1] = document.getElementById('pass').value;
         
         saveAdmission(data);
        
    }
    
    function checkPass(pass, pass1)
    {
        if(pass1.length == pass.length){
            if(pass!==pass1)
                {
                    $('#pass_error_msg').html("Sorry Password did not match")
                    $('#pass_error_msg').attr('style',"color:red");
                    $('#pass_error').addClass('form-group error');
                    $('#pass_error_msg').fadeOut(5000)

                }else{
                    setTimeout(function(){
                            $('#pass_error_msg').html("Congratulations, Password Matched!")
                            $('#pass_error_msg').fadeOut(5000)
                            $('#pass_error_msg').attr('style',"color:#3C6AC4");
                            $('#pass_error').removeClass('error');
                            $('#verifySubmit').removeClass('hide');
                    }, 0);


                }
        }
        
    }
    
    function getRegister(){

         var studentNumber = document.getElementById('inputStudentNumber').value;
         var verify = document.getElementById('verify').value;
         var regUname = document.getElementById('regUname').value;
         var regPass = document.getElementById('pass1').value;
         var parent_id = $('#parent_id').val()

          var url = "<?php echo base_url().'login/getRegister/'?>";
          $.ajax({
           type: "POST",
           url: url,
           dataType:'json',
           data: 'child_links='+studentNumber+"&u_id="+regUname+"&uname="+regUname+"&pass="+regPass+'&csrf_test_name='+$.cookie('csrf_cookie_name')+'&parent_id='+parent_id, // serializes the form's elements.
           success: function(data)
           {   
               alert(data.msg)
               if(data.status)
                   { 
                       document.location = '<?php echo base_url() ?>'
                   }else{
                       document.location = '<?php echo base_url() ?>'
                   }
           }
         });
      
        }
    
    $(document).ready(function(){
         
          $('#inputStudentNumber').select2({tags:[]});
          $("#verify").keypress(function(e){
              var key = e.keyCode || e.which;
              if(key=='13'){
                  verifyParent($(this).val())
              }
          })
    });

</script>
<script src="<?php echo base_url(); ?>assets/js/attendanceRequest.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/select2.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.clickover.js"></script> 
 <!--Cookie Javascript-->
<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script> 

<?php } ?>