<div data-role="page" data-theme="a" id="registrationForm">
    
        <div data-role="header" data-position="inline" data-fullscreen="true">
            <h1>SIGN UP <br /> FOR AN ACCOUNT</h1>

        </div>
    <?php 
        $attributes = array('id'=>'mobileRegistrationForm', 'class' => 'form-horizontal', 'style'=>'width:100%; float:right;');;
        echo form_open(base_url('index.php/mobile/getInside'), $attributes);
    ?>
        <div id="1" data-role="content" data-theme="a" data-position="fixed">
            <h5>Basic Information</h5>
                <input name="firstname" value="<?php echo set_value('firstname'); ?>" type="text" id="firstname" placeholder="First Name">  
                <input name="lastname"  value="<?php echo set_value('lastname'); ?>" type="text" id="lastname" placeholder="Last Name"> 
                <input class="" name="username" onblur="checkEmail(this.value)" id="username" value="<?php echo set_value('username'); ?>"  placeholder="Email Address" type="text">
                <input class="" name="password" value="<?php echo set_value('password'); ?>" id="password"  placeholder="Password" type="password">
                <input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50" placeholder="Verify Password" />
        </div>
        <div id="2" data-role="content" data-theme="a" data-position="fixed">
            <div>
                <h6>Main Contact Information:</h6>
                          <select name='country' tabindex="-1" id="inputCountry" class="">
                              <option>Search Your Country Here</option>
                              <?php 
                                        foreach ($countries as $country)
                                     {
                                      if($country->ccode=='US'){
                                          $selected = 'selected="selected"';
                                      }else{
                                          $selected = '';
                                      }
                                    ?>                        
                                  <option <?php echo $selected;    ?> value="<?php echo $country->ccode; ?>"><?php echo $country->country; ?></option>
                                  <?php }?>
                          </select>

                      <input class="" name="address" id="address"  placeholder="Complete Address" type="text">
                      <input class="" name="city" id="city"  placeholder="City" type="text">
                      <select name='state' tabindex="-1" id="state" >
                              <option>Search State</option>
                              <?php 
                                        foreach ($us_states as $states)
                                     {

                                    ?>                        
                                  <option value="<?php echo $states->state_code; ?>"><?php echo $states->state; ?></option>
                                  <?php }?>
                       </select>
                      <input class="" name="zip" id="zip"  placeholder="Zip Code" type="text">
                      <input class="" name="phone" id="phone"  placeholder="Phone Number" type="text">
                      <input class="" name="fax" id="fax"  placeholder="Fax Number" type="text">
                      <label style="font-size:12px;"><input type='checkbox' id="billing" onclick="sameBilling()" name="billing" value="1" /> Make Billing Address same as above</label>
                      <input type="hidden" id="checkTrigger" name="checkTrigger" value="0" />
            </div>
            <div id='billingAddress'>
                <h5>Billing Information:</h5>
                  <input class="" name="contactName" id="contactName" value="<?php echo set_value('contactName'); ?>"  placeholder="Complete Name" type="text">
                 
                  <input class="" name="bemail"  id="bemail" value="<?php echo set_value('bemail'); ?>"  placeholder="Email Address" type="text">
                  
                          <select name='bcountry' tabindex="-1" id="bcountry">
                              <option>Search Your Country Here</option>
                              <?php 
                                        foreach ($countries as $country)
                                     {
                                      if($country->ccode=='US'){
                                          $selected = 'selected="selected"';
                                      }else{
                                          $selected = '';
                                      }
                                    ?>                        
                                  <option <?php echo $selected;    ?> value="<?php echo $country->ccode; ?>"><?php echo $country->country; ?></option>
                                  <?php }?>
                          </select>
                     
                      <input class="" name="baddress" id="baddress"  placeholder="Address Line 1" type="text">
                      
                      <input class="" name="bcity" id="bcity"  placeholder="City" type="text">
                      
                      <select name='bstate' tabindex="-1" id="bstate">
                              <option>Search State</option>
                              <?php 
                                        foreach ($us_states as $states)
                                     {

                                    ?>                        
                                  <option value="<?php echo $states->state_code; ?>"><?php echo $states->state; ?></option>
                                  <?php }?>
                          </select>
                      
                      <input class="" name="bzip" id="bzip"  placeholder="Zip Code" type="text">
                      
                      <input class="" name="bphone" id="bphone"  placeholder="Phone Number" type="text">
                    
                      <input class="" name="bfax" id="bfax"  placeholder="Fax Number" type="text">
                  </div>
        </div>
        <div id="3" data-role="content" data-theme="a" data-position="fixed">
            <h6>Company Information</h6>  
            <input name="companyName" style="background: #fff;" id="companyName"  placeholder="Company Name" type="text">
            <label for="Email">Captcha <img src="<?php echo base_url().APPPATH;?>/views/forms/captcha.php"/></label>
            <input name="captcha" style="background: #fff;" id="captcha"  placeholder="Enter Captcha" type="text">
            
              
        </div>
    </form>

    <div data-role="footer" data-position="fixed">
        <fieldset class="ui-grid-a">
                <div class="ui-block-a">
                    <button id="backBtn" data-transition="slideup" onclick="backPage(document.getElementById('currentpage').value)" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-carat-l">Back</button>
                </div>
                <div class="ui-block-b">
                    <button id="nextBtn" onclick="nextPage(document.getElementById('currentpage').value)" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-right ui-icon-carat-r">Next</button>
                    <button id="registerBtn" onclick="" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-right ui-icon-carat-r">Register</button>
                </div>
            </fieldset> 
        <h2>Copyright &COPY; <?php echo date('Y') ?> <a href="http://digitizingpro.com/">DigitizingPro.com</a> </h2>
    <input type="hidden" id="currentpage" value="1" />
    </div>
</div>
<input type="hidden" id="previouspage" />

<script type="text/javascript">

$("#registerBtn").click(function() {
     
    var url = "<?php echo base_url().'index.php/dp/checkCaptcha' ?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#mobileRegistrationForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
              alert(data)
              document.location = "<?php echo base_url()?>"
              $("#msgResult").innerHTML='<textarea id="inputMessage" name="message"  onclick="" placeholder="Type in Your Message..." style="margin-left:4px;width:550px; "></textarea>'
               //alert(data); // show response from the php script.
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    });
    

function sameBilling(){

        if( document.getElementById("billing").checked) 
        {
            $("#billingAddress").fadeOut();
            $("#checkTrigger").val(1);
        } else {
            $("#billingAddress").fadeIn();
            $("#checkTrigger").val(0)
            //alert('hey')
        }
}

function nextPage(current)
{
    var next = parseFloat(current) + parseFloat(1)
    //document.getElementById('previouspage').value = prev
    document.getElementById('currentpage').value = next
    $('#'+current).hide();
    $('#'+next).show();
    $('#backBtn').show();
    if(next==3)
     {
         $('#nextBtn').hide();
         $('#registerBtn').show();
     }else{
         $('#nextBtn').show();
         $('#registerBtn').hide();
     }
}

function backPage(current)
{
     
     var next = parseFloat(current) - parseFloat(1)
    //document.getElementById('previouspage').value = prev
    document.getElementById('currentpage').value = next
    $('#'+current).hide();
    $('#'+next).show();
    if(next==1)
     {
         $('#backBtn').hide();
         
     }
     if(next<3)
     {
         $('#nextBtn').show();
         $('#registerBtn').hide();
     }
}
</script>
    

