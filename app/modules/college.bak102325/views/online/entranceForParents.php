<?php
$settings = Modules::run('main/getSet');
?>
<div id="parentLogin" class="modal fade col-lg-3 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo base_url() . 'entrance' ?>'">
            <span aria-hidden="true">&times;</span>
        </button>
        <div style="width:165px;margin:0 auto;">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:165px; background: white; margin:0 auto;" />
        </div>
        <h1 class="text-center" style="font-size:30px; color:black;"><?php echo $settings->set_school_name ?></h1>
        <h6 class="text-center" style="font-size:15px; color:black;"><?php echo $settings->set_school_address ?></h6>
        <h4 class="text-center text-primary"><i class="fa fa-users fa-4x"></i></h4>
        <h4 class="text-center text-primary">- PARENT'S LOGIN -</h4>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px; padding: 20px">
        <div class="form-group">
            <label for="input" style="text-align: center">Username</label>
            <input class="form-control" name="parentUname" type="text" id="parentUname" placeholder="Type Your Username Here" />
        </div>
        <div class="form-group">
            <label for="input" style="text-align: center">Password</label>
            <input class="form-control" onkeypress="if (event.keyCode == 13) {
                        requestParentEntry()}" name="parentPass" type="password" id="parentPass" placeholder="Type Your Password Here" />
        </div>

        <div class="form-group">
            <a style="font-size: 12px;" data-toggle="modal" href="#forgotPass">
                Forgot Password?
            </a>
            <span style="font-size: 12px;" class="pull-right">Don't have an account?
                <a data-toggle="modal" href="#signUp">
                    Register here
                </a>
            </span>
        </div>
        <div class="form-group">
            <span id="errMsg"></span>
        </div>
        <div class="form-group success">
            <div class="controls">
                <button id="requestBtn" onclick="requestParentEntry()" class="btn btn-info btn-block" aria-hidden="true">REQUEST ENTRY</button>
            </div>

        </div>
    </div>
</div>

<div id="verifyOTP" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
            <h1 class="text-center" style="height:30px; color: white ;font-size: 20px;"><?php echo $settings->set_school_name ?></h1>
            <h4 class="text-center" style="color:white;">Final Account Verification</h4>
        </div>
        <div class="modal-body" style="background: white;">
            <div class="form-group">
                <label for="input" style="text-align: center">Verification Code</label>
                <input class="form-control" name="otp" type="password" id="otp" placeholder="Enter Verification Code" />
            </div>
            <div class="control-group hide" id="verifyConfirmWrapper">
                <span id="verifyConfirmation"></span> <br />
                <button class="btn btn-warning btn-xs">Request Another OTP</button>

            </div>
        </div>
        <div class="modal-footer" style="background: white;">
            <div class="form-group success">
                <div class="controls">
                    <button id="parentRequestBtn" onclick="verifyParentOTP()" class="btn btn-info btn-block" aria-hidden="true">VERIFY</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div id="parentLogin" style="display: none;">
    <div class="modal-body">
        <div class="form-group">
            <label for="input" style="text-align: center">Username</label>
            <input class="form-control" name="parentUname" type="text" id="parentUname" placeholder="Type Your Username Here" />
        </div>
        <div class="form-group">
            <label for="input" style="text-align: center">Password</label>
            <input class="form-control" onkeypress="if (event.keyCode == 13) {
                        requestParentEntry()}" name="parentPass" type="password" id="parentPass" placeholder="Type Your Password Here" />
        </div>

        <div class="form-group">
            <a style="font-size: 12px;" data-toggle="modal" href="#forgotPass">
                Forgot Password?
            </a>
            <span style="font-size: 12px;" class="pull-right">Don't have an account?
                <a data-toggle="modal" href="#signUp">
                    Register here
                </a>
            </span>
        </div>

    </div>
    <div class="modal-footer">
        <div class="form-group success">
            <div class="controls">
                <button id="parentRequestBtn" onclick="requestParentEntry()" class="btn btn-info btn-block" aria-hidden="true">REQUEST ENTRY</button>
            </div>
        </div>
    </div>
</div> -->
<div id="signUp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
            <h1 class="text-center" style="height:30px; color: white ;font-size: 20px;"><?php echo $settings->set_school_name ?></h1>
            <h4 class="text-center" style="color:white;">Sign Up for a New Account</h4>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;" class="modal-body">
            <fieldset>
                <label class="text-center text-info">Please Enter the Emergency Contact Number Registered</label>
                <div style="margin:0 25%; ">
                    <div style="margin-bottom: 15px;">
                        <div id="verifyP" class="form-group input-group ">
                            <input onblur="verifyParent($('#verify').val())" onkeypress="if(event.keycode==13){verifyParent(this.value)}" class="error form-control" id="verify" placeholder="Enter Phone Number" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-default">
                                    <i id="verify_icon" onclick="verifyParent($('#verify').val(), 0)" class="fa fa-search" style="font-size:20px;"></i>
                                </button>
                            </span>
                        </div>

                        <div id="confirm">
                            <input type="hidden" id="vResults" value="0" />
                            <input type="hidden" id="parent_id" value="0" />
                            <span id="confirmation"></span>
                        </div>

                    </div>
                    <div id="inputForms" class="hidden">
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input class="form-control" id="regUname" placeholder="username" type="text">
                        </div>

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input class="form-control" id="pass0" placeholder="password" type="password">
                        </div>
                        <div id="pass_error">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input onkeyup="checkPass(this.value, $('#pass0').val())" class="error form-control" id="pass1" placeholder="Retype Password" type="password">

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
                        <button class="btn" onclick="location.reload()">Cancel</button>
                        <button id="verifySubmit" onclick="getRegister()" class="btn success hide">SUBMIT</button>
                        <div id="resultSection" class="help-block success"></div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
            </div>
            <div class="modal-body">
                <div id="cnInput">
                    <input type="text" id="eContactNum" name="eContactNum" style="width: 100%;" onkeypress="if(event.keycode==13){isRegistered(this.value)}" placeholder="Enter Registered Emergency Contact Number" />
                </div>
                <div id="otpInput" class="hidden">
                    <div class="card p-2 text-center">
                        <h6>Please enter the one time password <br> to verify your account</h6>
                        <div style="font-weight: bold;"> <span>A code has been sent to</span> <small id="maskedNumber">*******9897</small> </div>
                        <div id="otp" class="inputs">
                            <input class="text-center form-control rounded" type="text" id="first" maxlength="1" />
                            <input class="text-center form-control rounded" type="text" id="second" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
                        </div>
                        <div class="mt-4"><br />
                            <button id="validateBtn" class="btn btn-danger px-4 validate">Validate</button>
                        </div>
                    </div>
                </div>
                <div id="passDisplay" class="hidden card text-center">
                    <span style="margin-top: 150px">
                        Your Password has been reset. Use this Generated Password Temporarily to log in.<br /><b style="color: red;">Important:</b> Change your password when logged in<br /><br /><br />
                        <h1 id="newpass" style="font-weight: bold;"></h1>
                    </span>
                </div>
                <span id="errMsg"></span>
                <div style="padding-top: 10px;" class="text-right">
                    <button type="button" class="btn btn-secondary ftr" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary ftr" onclick="isRegistered($('#eContactNum').val())">Sumbit</button>
                </div>
            </div>
            <!-- <div class="modal-footer">
            </div> -->
        </div>
    </div>
</div>
<input type="hidden" id="parent_id" />

<script type="text/javascript">
    var details = {};
    var parent_id = 0;

    $(document).ready(function() {
        $('#parentLogin').modal('show');
    })

    function requestParentEntry() {
        var u = $('#parentUname').val();
        var p = $('#parentPass').val();

        var url = '<?php echo base_url() ?>' + 'opl/p/requestEntry';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                u: u,
                p: p,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                $('#errMsg').show();
                if (data.status) {
                    $('#errMsg').html('<p style="background-color: green; color: white; padding: 10px">' + data.msg + ' <img src="<?php echo base_url('assets/img/loading.gif') ?>" style="width: 20px; height: 20px" /></p>');
                    setTimeout(function() {
                        document.location = '<?php echo base_url() ?>' + data.url;
                    }, 2000);
                } else {
                    $('#errMsg').html('<div class="row" style="background-color: red; padding: 5px; border: thin solid red; border-radius: 5px"><div class="col-md-1"><i class="fa fa-exclamation-triangle fa-2x" style="color: white"></i></div><div class="col-md-9 text-center" style="margin-left: 10px; color: white">' + data.msg + '. Please check your username and password and try again.</div></div>');
                    // $('#errMsg').html('<div style="padding: 10px; border: thin solid red; border-radius: 5px"><div class<i class="fa fa-exclamation-triangle fa-2x" style="color: red"></i> <span style="padding-left: 5px">' + data.msg + '. Please check your username and password and try again.</span></div>');
                    setTimeout(function() {
                        $('#errMsg').fadeOut();
                    }, 3000);
                }
            }
        });
    }

    function verifyParentOTP() {
        var OTP = $('#otp').val();

        var url = '<?php echo base_url() ?>' + 'opl/p/verifyOTP/';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                otp: OTP,
                parent_id: parent_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                if (data.status) {
                    document.location = '<?php echo base_url() ?>' + data.url;
                } else {
                    alert(data.msg);
                    $('#verifyConfirmWrapper').removeClass('hide');
                    $('#verifyConfirmation').attr('style', "color:red");
                    $('#verifyConfirmation').html(data.msg);

                }
            }
        });

    }

    function verifyParent(value) {
        $('#verify_icon').removeClass('fa-search')
        $('#verify_icon').addClass('fa-spinner fa-spin');
        var url = '<?php echo base_url() ?>' + 'opl/p/verifyParent/' + value + '/';
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'value=' + value, // serializes the form's elements.
            success: function(data) {
                $('#loadingModal').modal('hide');
                if (data.status) {
                    $('#inputForms').removeClass('hidden')
                    $('#confirmation').html('Hi Parent/Guardian! Please indicate below your desired Username and Password')
                    $('#confirmation').attr('style', "color:#3C6AC4");
                    $('#vResults').val(1);
                    details = data.details;
                    $('#verify_icon').removeClass('fa-spinner fa-spin')
                    $('#verify_icon').addClass('fa-search');
                } else {
                    // $('#regUname').attr('disabled', 'disabled');
                    $('#verifyP').addClass('form-group error');
                    $('#confirmation').attr('style', "color:red");
                    $('#confirmation').html('Sorry, This number cannot be found, Please Contact the School\'s Registrar.');
                    $('#confirmation').fadeOut(5000)
                    $('#verify_icon').removeClass('fa-spinner fa-spin')
                    $('#verify_icon').addClass('fa-search');
                    setTimeout(function() {
                        $("#verify").focus();
                    }, 0);

                }

            }
        });
    }

    function isRegistered(number) {
        var url = '<?php echo base_url() ?>' + 'registrar/requestOTP';
        var masked = number.substring(number.length - 4);
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'value=' + number + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                if (data.status) {
                    $('#first').val(data.otp.slice(0, 1));
                    $('#second').val(data.otp.slice(1, 2));
                    $('#third').val(data.otp.slice(2, 3));
                    $('#fourth').val(data.otp.slice(3, 4));
                    $('#fifth').val(data.otp.slice(4, 5));
                    $('#sixth').val(data.otp.slice(5, 6));
                    $('.ftr').addClass('hidden');
                    $('#cnInput').addClass('hidden');
                    $('#otpInput').removeClass('hidden');
                    $('#maskedNumber').text('*******' + masked);
                    $('#parent_id').val(data.pid);
                } else {
                    $('#errMsg').attr('style', "color:red");
                    $('#errMsg').html('<h5><i class="fa fa-exclamation-triangle"></i> No Account Registered. Please Register an Account</h5>');
                    $('#errMsg').fadeOut(5000);
                }
            }
        })
    }

    function getRegister() {
        var u = $('#regUname').val();
        var p = $('#pass1').val();
        var url = '<?php echo base_url() ?>' + 'opl/p/registerParent/';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                u: u,
                p: p,
                details: details,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                $('#loadingModal').modal('hide');
                if (data.status) {
                    $('#signUp').modal('hide');
                    $('#verifyOTP').modal('show');
                    $('#otp').val(data.vcode);
                    parent_id = data.parent_id;
                } else {
                    if (data.codeError == '2') {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }
            }
        });

    }


    function checkPass(pass, pass1) {
        if (pass1.length == pass.length) {
            if (pass !== pass1) {
                $('#pass_error_msg').html("Sorry Password did not match")
                $('#pass_error_msg').attr('style', "color:red");
                $('#pass_error').addClass('form-group error');
                $('#pass_error_msg').fadeOut(5000);

            } else {
                setTimeout(function() {
                    $('#pass_error').removeClass('error');
                    $('#verifySubmit').removeClass('hide');
                    console.log(JSON.stringify(details));
                }, 0);


            }
        }

    }
    //--------------------------------- otp -----------------------------------------------------//
    document.addEventListener("DOMContentLoaded", function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0]; //    
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus(); //   
                    }
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                    }
                });
            }
        }

        OTPInput();

        const validateBtn = document.getElementById('validateBtn');
        validateBtn.addEventListener('click', function() {
            let otp = '';
            document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
            // alert(`Entered OTP: ${otp}`);
            var pid = $('#parent_id').val();
            var url = '<?php echo base_url('registrar/resetPassword/') ?>' + otp + '/' + pid + '/gg';

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    $('#passDisplay').removeClass('hidden');
                    $('#otpInput').addClass('hidden');
                    $('#newpass').html(data.newPass);
                }
            })
        });
    });
</script>

<style type="text/css">
    .height-100 {
        height: 100vh
    }

    .card {
        width: 100%;
        border: none;
        height: 205px;
        box-shadow: 0px 5px 20px 0px #d2dae3;
        padding-top: 10px;
        z-index: 1;
        /* display: flex; */
        justify-content: center;
        align-items: center
    }

    .card h6 {
        color: red;
        font-size: 20px;
    }

    .inputs input {
        width: 40px;
        height: 40px;
        display: inline-block;
    }

    /* input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    } */

    .card-2 {
        background-color: #fff;
        padding: 10px;
        width: 350px;
        height: 100px;
        bottom: -50px;
        left: 20px;
        position: absolute;
        border-radius: 5px
    }

    .card-2 .content {
        margin-top: 50px
    }

    .card-2 .content a {
        color: red
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }

    .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
    }
</style>