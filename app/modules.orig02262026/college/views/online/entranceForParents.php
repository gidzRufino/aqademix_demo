<?php
$settings = Modules::run('main/getSet');
?>
<div id="parentLogin"
    class="modal fade"
    tabindex="-1" role="dialog"
    aria-labelledby="parentLoginLabel"
    aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered modal-animate">
        <div class="modal-content shadow-lg rounded-2xl border-0">

            <!-- Header -->
            <div class="modal-header border-0 text-center bg-light rounded-top-2xl" style="position:relative;">
                <button type="button" class="close"
                    style="position:absolute; right:12px; top:10px;"
                    data-dismiss="modal" aria-label="Close"
                    onclick="window.location='<?php echo base_url('entrance') ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>

                <img src="<?php echo base_url('images/forms/' . $settings->set_logo) ?>"
                    alt="School Logo"
                    style="max-width:140px; display:block; margin:6px auto 8px;" />

                <h2 class="h4 text-dark fw-bold" style="margin:0;">
                    <?php echo $settings->set_school_name ?>
                </h2>
                <p class="text-muted small" style="margin-bottom:8px;">
                    <?php echo $settings->set_school_address ?>
                </p>

                <div style="margin-bottom:4px;">
                    <i class="fa fa-users fa-3x text-primary"></i>
                </div>
                <h5 class="text-primary fw-bold" style="margin-bottom:0;">PARENT'S LOGIN</h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding:16px 20px;">

                <div class="form-group">
                    <label class="fw-semibold">Username</label>
                    <input type="text"
                        class="form-control input-lg rounded-pill"
                        name="parentUname"
                        id="parentUname"
                        placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label class="fw-semibold">Password</label>
                    <div style="position: relative; width:100%;">
                        <input type="password"
                            class="form-control input-lg rounded-pill"
                            name="parentPass"
                            id="parentPass"
                            placeholder="Enter your password"
                            style="padding-right: 45px;"
                            onkeypress="if (event.keyCode === 13) requestParentEntry()">

                        <!-- Eye icon inside input -->
                        <span class="toggle-password"
                            onclick="togglePassword()"
                            style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#666; font-size:18px;">
                            <i id="toggleIcon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="clearfix" style="margin-bottom:6px;">
                    <a href="#forgotPass" data-toggle="modal" class="small text-decoration-none pull-left">
                        Forgot Password?
                    </a>
                    <span class="small pull-right">
                        Don’t have an account?
                        <a href="#signUp" data-toggle="modal" class="text-primary fw-semibold">
                            Register here
                        </a>
                    </span>
                </div>

                <div id="errMsg" class="text-danger small text-center" style="min-height:18px; margin-bottom:10px;"></div>

                <button id="requestBtn"
                    onclick="requestParentEntry()"
                    class="btn btn-primary btn-lg btn-block rounded-pill shadow-lg pulse-btn">
                    REQUEST ENTRY
                </button>

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
<div id="signUp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-header text-center" style="background: #000; color: #fff;">
                <h4 class="modal-title" style="margin: 0; font-weight: bold;">
                    <?php echo $settings->set_school_name ?>
                </h4>
                <p class="small">Sign Up for a New Account</p>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <fieldset>
                    <p class="text-center text-info">
                        Please enter the registered emergency contact number
                    </p>

                    <!-- Phone verification -->
                    <div class="form-group" style="max-width: 320px; margin: 0 auto;">
                        <div class="input-group">
                            <input id="verify" type="text"
                                class="form-control"
                                placeholder="Enter Phone Number"
                                onblur="verifyParent(this.value)"
                                onkeypress="if(event.keyCode==13){verifyParent(this.value)}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="verifyParent($('#verify').val(), 0)">
                                    <i id="verify_icon" class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div id="confirm" class="text-center" style="margin-top: 10px;">
                            <input type="hidden" id="vResults" value="0">
                            <input type="hidden" id="parent_id" value="0">
                            <span id="confirmation" class="text-success"></span>
                        </div>
                    </div>

                    <!-- Registration Inputs -->
                    <div id="inputForms" class="hidden" style="max-width: 320px; margin: 20px auto 0;">

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="regUname" class="form-control" placeholder="Username">
                        </div>

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" id="pass0" class="form-control" placeholder="Password">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="togglePassword('pass0', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>
                        </div>

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" id="pass1" class="form-control" placeholder="Retype Password"
                                onkeyup="checkPass(this.value, $('#pass0').val())">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="togglePassword('pass1', this)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>
                        </div>

                        <div id="pass_error_msg" class="text-danger small"></div>
                    </div>
                </fieldset>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="verifySubmit" onclick="getRegister()" class="btn btn-success hidden">Submit</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-labelledby="forgotPassLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background:#337ab7; color:#fff;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="forgotPassLabel"><i class="fa fa-lock"></i> Reset Password</h4>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Contact Input -->
                <div id="cnInput">
                    <label for="eContactNum" class="control-label">Emergency Contact Number</label>
                    <input type="text" id="eContactNum" name="eContactNum"
                        class="form-control"
                        placeholder="Enter your registered number"
                        onkeypress="if(event.keyCode==13){isRegistered(this.value)}" />
                </div>

                <!-- OTP Input -->
                <div id="otpInput" class="hidden" style="margin-top:15px;">
                    <div class="panel panel-primary text-center">
                        <div class="panel-body">
                            <h5>Please enter the One-Time Password (OTP)</h5>
                            <p>A code has been sent to <strong id="maskedNumber">*******9897</strong></p>

                            <input type="hidden" id="cnum" />
                            <div id="otp" style="display:flex; justify-content:center; flex-wrap:wrap; gap:5px; margin:10px 0;">
                                <input class="form-control text-center otp-input" type="text" id="first" maxlength="1">
                                <input class="form-control text-center otp-input" type="text" id="second" maxlength="1">
                                <input class="form-control text-center otp-input" type="text" id="third" maxlength="1">
                                <input class="form-control text-center otp-input" type="text" id="fourth" maxlength="1">
                                <input class="form-control text-center otp-input" type="text" id="fifth" maxlength="1">
                                <input class="form-control text-center otp-input" type="text" id="sixth" maxlength="1">
                            </div>

                            <button id="validateBtn" class="btn btn-success btn-block">Validate</button>
                        </div>
                    </div>
                </div>

                <!-- Password Reset Notice -->
                <div id="passDisplay" class="hidden panel panel-default text-center" style="margin-top:15px;">
                    <div class="panel-body">
                        <p>Your password has been reset.<br>
                            Please use the generated password sent via text to log in.
                        </p>
                        <p style="color:red; font-weight:bold;">Important: Change your password once logged in.</p>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errMsg" class="text-danger text-center" style="margin-top:10px;"></div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default ftr" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ftr" onclick="isRegistered($('#eContactNum').val())">Submit</button>
            </div>
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
        var url = '<?php echo base_url() ?>' + 'opl/p/verifyParent/' + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'value=' + value, // serializes the form's elements.
            success: function(data) {
                $('#loadingModal').modal('hide');
                if (data.status) {
                    if (!data.isReg) {
                        $('#inputForms').removeClass('hidden')
                        $('#confirmation').html('Hi Parent/Guardian! Please indicate below your desired Username and Password')
                        $('#confirmation').attr('style', "color:#3C6AC4");
                        $('#vResults').val(1);
                        details = data.details;
                        $('#verify_icon').removeClass('fa-spinner fa-spin')
                        $('#verify_icon').addClass('fa-search');
                    } else {
                        $('#confirmation').html('The number you entered is already associated with an existing account. <b>Username: ' + data.uAccounts.uname + '</b>');
                        $('#confirmation').attr('style', "color:red");
                        details = data.details;
                        $('#verify_icon').removeClass('fa-spinner fa-spin')
                        $('#verify_icon').addClass('fa-search');
                    }
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
                    // $('#first').val(data.otp.slice(0, 1));
                    // $('#second').val(data.otp.slice(1, 2));
                    // $('#third').val(data.otp.slice(2, 3));
                    // $('#fourth').val(data.otp.slice(3, 4));
                    // $('#fifth').val(data.otp.slice(4, 5));
                    // $('#sixth').val(data.otp.slice(5, 6));
                    $('.ftr').addClass('hidden');
                    $('#cnInput').addClass('hidden');
                    $('#otpInput').removeClass('hidden');
                    $('#maskedNumber').text('*******' + masked);
                    $('#cnum').val(number);
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
        console.log(details)
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
                    $('#verifySubmit').removeClass('hidden');
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
            var contact_num = $('#cnum').val();
            var pid = $('#parent_id').val();
            var url = '<?php echo base_url('registrar/resetPassword/') ?>' + otp + '/' + pid + '/gg/' + contact_num;

            $.ajax({
                type: 'GET',
                url: url,
                // dataType: 'json',
                success: function(data) {
                    $('#passDisplay').removeClass('hidden');
                    $('#otpInput').addClass('hidden');
                    // $('#newpass').html(data.newPass);
                }
            })
        });
    });

    function togglePassword() {
        const passField = document.getElementById("parentPass");
        const toggleIcon = document.getElementById("toggleIcon");
        if (passField.type === "password") {
            passField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
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

    /* -------- Animation: support BS3 (.in) and BS4/5 (.show) -------- */
    .modal.fade .modal-dialog.modal-animate {
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
        opacity: 0;
        transition: transform .25s ease, opacity .25s ease;
    }

    .modal.in .modal-dialog.modal-animate,
    .modal.show .modal-dialog.modal-animate {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 1;
    }

    /* -------- Button hover + pulse -------- */
    .pulse-btn {
        position: relative;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        animation: btn-pulse 2.2s infinite;
    }

    .pulse-btn:hover {
        transform: translateY(-2px) scale(1.03);
    }

    .pulse-btn:active {
        transform: scale(0.98);
    }

    @keyframes btn-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, .35);
        }

        70% {
            box-shadow: 0 0 0 14px rgba(0, 123, 255, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
        }
    }

    /* -------- Light utility shims (so BS3 gets the “modern” look) -------- */
    .rounded-pill {
        border-radius: 50rem !important;
    }

    .rounded-2xl {
        border-radius: 1rem !important;
    }

    .rounded-top-2xl {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    .border-0 {
        border: 0 !important;
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    .fw-bold {
        font-weight: 700;
    }

    .fw-semibold {
        font-weight: 600;
    }

    /* Center dialog vertically for BS3 */
    .modal-dialog-centered {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        min-height: calc(100% - 2rem);
    }

    /* Prevent tall content from cropping */
    .modal-dialog-centered .modal-content {
        width: 100%;
    }

    .otp-input {
        width: 40px;
        height: 40px;
        font-size: 18px;
        display: inline-block;
    }
</style>