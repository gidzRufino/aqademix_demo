<?php 
    echo doctype('html5');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/bootstrap-responsive.css');
    echo link_tag('assets/css/select2.css');
?>
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
<?php 
//foreach ($settings as $s){
//    $logo = $s->set_logo;
//    $schoolName = $s->set_school_name;
//}

?>
<body style="background: #000">
<div class="clearfix row-fluid" style="background:#000;">
   <?php
        $attributes = array('class' => 'form-horizontal', 'style'=>' idth:500px; position:absolute; top:20%; left:30%;', 'id'=>'addEmForm');
        echo form_open(base_url().'index.php/login/verify', $attributes);
        
    ?> 
    
    <input type="hidden" id="setAction" />
    <div class="modal-header" style="background:#02008C; border-radius:15px 15px 0 0; ">
    <h1 class="text-center"style="height:30px; color:white; font-size: 20px;"><?php echo $settings->set_school_name ?></h1>
    <h4 class="text-center" style="color:white">( Integrated Student Management System )</h4>
  </div>
    <fieldset style="background: #fff; border-radius:0 0 15px 15px ;">
        <div style="margin:5% 23%; " >
            <?php echo validation_errors('<p style="color:red;">','</p>') ?>
            <div class="control-group">
              <div class="">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input class="" name="uname" id="uname" onclick="this.value=''"  placeholder="UserName" type="text">
                </div>
              </div>
            </div>
            <div class="control-group">
              
              <div class="">
                   <div class="input-prepend" id="password">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input class="" name="pass" id="pass" onclick="this.value=''"  onkeypress="if (event.keyCode==13){ getInside(this.value);}" placeholder="Password" type="password">
                   </div>
                    <a class="help-block" role="button"  class="btn" data-toggle="modal" href="#signUp">Sign Up for an Account (Note: For Parents Only)</a> 
                </div>
            </div>
        </div>     
       
       <div class="control-group success">
          <div class="controls">
              <button target="_blank"  type="submit" class="btn success">LOGIN</button>
              <div id="result" class="help-block success"></div>
          </div>

        </div>
    </fieldset>     
   <?php
        echo form_close();
   ?>       
    

    
</div>
<!-- Modal -->
<div id="signUp" class="modal hide fade" style="top:10%; left:47%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background:#02008C;">
    <h1 class="text-center"style="height:35px; color:white;"><?php //echo $schoolName; ?></h1>
    <h4 class="text-center" style="color:white;">( Integrated Student Management System )</h4>
    <h4 class="text-center" style="color:white;">Sign Up for a New Account</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="formRegister">
    <fieldset>
        <label class="text-center text-info">Please Enter Your Phone Number or Email and click the Search button to Verify</label>
        <div style="margin:0 25%; " >
            <div class="control-group">
                <div id="verifyP" class="input-prepend input-append">
                    
                    <span class="add-on"><i class="icon-pencil"></i></span>
                    <input class="error" id="verify" placeholder="Enter Email or Phone Number" type="text">
                    <span style="cursor: pointer" class="add-on"><i onclick="verifyParent()" class="icon-search"></i></span>
                </div>
                
                <div id="confirm">
                    
                </div>
                
            </div>
            <div id="inputForms" >
                <div class="control-group">
              
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input class="" id="regUname" disabled  placeholder="username" type="text">
                </div>

            </div>
            <div class="control-group">

                   <div class="input-prepend" id="pw">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input value="" class="add"   id="pass0"  disabled placeholder="password" type="text">
                   </div>
            </div>
            <div>
                <div id="pass_error" class="control-group">
                    <div class="input-prepend" id="pw">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input class="error"  id="pass1" disabled placeholder="Retype Password" type="password">
                       

                    </div>
                </div>
            </div>
            </div>
            
        </div>
            
        </fieldset>

    </form>  
      
  <div class="modal-footer">
      <div class="control-group success">
                  <div class="controls">
                      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                      <a href="#verifyStudentNumber" onclick="//getRegister()" data-dismiss="modal" data-toggle="modal" class="btn success">SUBMIT</a>
                      <div id="resultSection" class="help-block success" ></div>
                  </div>
                  
                </div>
   </div> 
  </div>
</div>  
<div id="verifyStudentNumber" class="modal hide fade" style="top:10%; left:47%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="background:#02008C;">
        <h1 class="text-center"style="height:35px; color:white;"><?php// echo $schoolName; ?></h1>
        <h4 class="text-center" style="color:white;">( Integrated Student Management System )</h4>
        <h4 class="text-center" style="color:white;">Register Student ID</h4>
  </div>
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label" for="input">Please Enter Your Student's ID Number</label>
            <div class="controls">
                <input style="width:250px;" class="select2-offscreen" name="inputStudentNumber" type="text" id="inputStudentNumber" placeholder="Type Here">
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <div class="control-group success">
                  <div class="controls">
                      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                      <button class="btn" onclick="getRegister()" onmouseover= "document.getElementById('setAction').value='getRegister' " aria-hidden="true" >REGISTER</button>
                      
                      <div id="resultSection" class="help-block success" ></div>
                  </div>
                  
                </div>
   </div> 
</div>
<?php //$this->load->view('includes/footer'); ?>
<script type="text/javascript"> 
    
    function verifyParent()
    {
        document.getElementById('setAction').value = "getVerified";
        var data = document.getElementById('verify').value;
        
        
        AttendRequest(data);
    }
    function getInside(){

        var data = new Array();
         
         data[0] = document.getElementById('uname').value;
         data[1] = document.getElementById('pass').value;
         
         saveAdmission(data);
        
    }
    
    function getRegister(){

        var data = new Array();
         
         //data[0] = document.getElementById('st_id').value;
         var studentNumber = document.getElementById('inputStudentNumber').value;
         data[0] = document.getElementById('verify').value;
         data[1] = document.getElementById('regUname').value;
         data[2] = document.getElementById('pass0').value;
         data[3] = document.getElementById('pass1').value;
         data[4] = studentNumber.replace(/,/g, "-");
         //data[4] = document.getElementById('account').value;
         //alert(data);
         //alert(data[1]+"="+data[2]);
         
         if(data[2]!= data[3]){
             alert("Sorry Password did not match")
             document.getElementById("pass_error").className = "control-group error";
         }else{
             document.location = '<?php echo base_url()?>index.php/login/getRegister/'+data;
         }
      
        }
    
    $(document).ready(function() {
         
          $('#inputStudentNumber').select2({tags:[<?php
            
                       ?>]});
            });

</script>
<script src="<?php echo base_url(); ?>assets/js/attendanceRequest.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.clickover.js"></script> 