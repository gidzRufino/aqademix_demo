<?php
$settings = Modules::run('main/getSet');
?>
<div id="studentLogin" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-lg shadow-lg border-0">

            <!-- Modal Header -->
            <div class="modal-header text-center" style="background: linear-gradient(135deg, #2e7d32, #43a047); border-radius: 15px 15px 0 0; color:white;">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo base_url() . 'entrance' ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="text-center">
                    <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" class="img-responsive center-block" style="max-width:120px; margin:10px auto; border-radius:10px;" />
                </div>
                <h3 class="modal-title" style="margin-top:10px; font-weight:600;"><?php echo $settings->set_school_name ?></h3>
                <p style="margin:0; font-size:13px;"><?php echo $settings->set_school_address ?></p>
                <h4 class="text-center" style="margin-top:15px; font-weight:bold;">- STUDENT LOGIN -</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding:25px;">

                <?php if ($st_id == NULL): ?>
                    <!-- Student ID Input -->
                    <div class="form-group text-center">
                        <label for="studentNumber" style="font-weight:600;">Enter Student ID Number</label>
                        <input class="form-control input-lg rounded-pill-input"
                            onkeypress="if (event.keyCode == 13) { requestEntry(this.value) }"
                            name="studentNumber"
                            type="text"
                            id="studentNumber"
                            placeholder="Type Here" />
                    </div>
                    <button id="requestBtn" onclick="requestEntry()" class="btn btn-success btn-block btn-lg rounded-pill">REQUEST ENTRY</button>

                <?php else: ?>
                    <?php if (base64_decode($passKey) != NULL): ?>
                        <?php if ($changeKey != NULL): ?>
                            <!-- Change Password -->
                            <div class="form-group">
                                <label for='newPass'>Enter New Password</label>
                                <div class="input-group">
                                    <input type='password' class="form-control rounded" name='newPass' id='newPass'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button" data-target="#newPass"><i class="fa fa-eye"></i></button>
                                    </span>
                                </div>
                                <label for='confirmPass' class="m-t-10">Confirm Password</label>
                                <div class="input-group">
                                    <input type='password' class="form-control rounded" name='confirmPass' id='confirmPass'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button" data-target="#confirmPass"><i class="fa fa-eye"></i></button>
                                    </span>
                                </div>
                            </div>
                            <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
                            <div class="text-right">
                                <button class='btn btn-success rounded-pill' onclick='updatePassword()'>Update Password</button>
                                <button class='btn btn-danger rounded-pill' onclick='document.location = "<?php echo base_url() . 'college/enrollment/entrance' ?>"'>Cancel</button>
                            </div>
                        <?php else: ?>
                            <!-- Enter Password -->
                            <form onsubmit="event.preventDefault(); verifyLogin(document.getElementById('studentPassword').value)">
                                <div class="form-group" id="passwordGroup">
                                    <label for="studentPassword" style="font-weight:600;">Password</label>
                                    <div class="password-wrapper">
                                        <input class="form-control input-lg"
                                            onkeypress="if (event.keyCode == 13) { verifyLogin(this.value) }"
                                            type="password"
                                            name="studentPassword"
                                            id="studentPassword"
                                            placeholder="Enter Password"
                                            required />
                                        <i class="fa fa-eye toggle-password" data-target="#studentPassword"></i>
                                    </div>
                                </div>

                                <div class="reset-msg-row">
                                    <a id="resetPass" href="#" onclick="resetPassword()" class="text-danger">
                                        Forgot Password? Click to reset!
                                    </a>
                                    <span id="lgnMsg"></span>
                                </div>

                                <br>

                                <!-- Submit Button -->
                                <button type="submit" id="loginBtn" onclick="verifyLogin()" class="btn btn-primary btn-submit">
                                    Login
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- OTP Input -->
                        <div id="otpInput" class="text-center" style="padding:20px;">
                            <h4 style="font-weight:600; margin-bottom:10px;">One-Time Password</h4>
                            <p style="margin-bottom:15px;">
                                <small>A code has been sent to</small>
                                <b id="maskedNumber" class="text-success"><?php echo base64_decode($encrypt_num) ?></b>
                            </p>

                            <!-- OTP Boxes -->
                            <div id="otp" class="d-flex justify-content-center otp-inputs" style="gap:10px; margin-bottom:20px;">
                                <?php for ($i = 0; $i < 6; $i++): ?>
                                    <input class="form-control otp-box text-center"
                                        type="text"
                                        maxlength="1"
                                        value="<?php echo substr($otp, $i, 1) ?>" />
                                <?php endfor; ?>
                            </div>

                            <!-- Validate Button -->
                            <button id="validateBtn" class="btn btn-success btn-lg rounded-pill w-50">Validate</button>
                        </div>
                        <input type="hidden" id="department" value="<?php echo $department ?>" />
                        <input type="hidden" id="infoS" value="<?php echo $semester ?>" />
                        <input type="hidden" id="otpNum" value="<?php echo $otp ?>" />
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="verifyNumberModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-lg shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header text-center" style="background: linear-gradient(135deg, #2e7d32, #43a047); border-radius: 15px 15px 0 0; color:white;">
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title w-100 font-weight-bold">Verify Mobile Number</h4>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding:25px;">

                <!-- Confirm Section -->
                <div id="confirmNum">
                    <p class="text-center" style="font-size:15px; font-weight:500;">Please confirm if this is the number you registered in the system:</p>
                    <h5 class="text-center text-success" id="enPhone" style="font-weight:bold; font-size:18px;"></h5>

                    <button id="numConfirm" class="btn btn-success btn-block btn-lg rounded-pill" style="margin-top:15px;">Yes, It is</button>
                    <button id="numReject" class="btn btn-danger btn-block btn-lg rounded-pill" style="margin-top:10px;">No, It's not</button>
                </div>

                <!-- Change Number Section -->
                <div id="changeNum" hidden>
                    <p class="text-center">Change the contact number registered in the system?</p>
                    <p class="text-center small">Click <a class="pointer text-success" onclick="$('#cnInfo').show(); $('#confirmNum').hide(); $('#saveNewNum').show();">here</a> to update.</p>

                    <div id="cnInfo" hidden>
                        <input type="text" class="form-control input-lg rounded" name="newNum" id="newNum" placeholder="Enter New Number" style="margin-top:15px;" />
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button class="btn btn-success btn-lg rounded-pill" style="display:none;" id="saveNewNum">Update</button>
                        <button class="btn btn-danger btn-lg rounded-pill" onclick="location.reload()">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius:15px;">
            <div class="modal-header" style="background:#4a90e2; color:white; border-radius:15px 15px 0 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="forgotPasswordLabel">
                    <i class="fa fa-unlock-alt"></i> Reset Password
                </h4>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Enter registered Emergency Contact Number to reset the password.</p>

                <div class="form-group">
                    <label for="pnumber" style="font-weight:600;">Contact Number</label>
                    <input type="number" id="pnumber" class="form-control" placeholder="Enter Contact Number" required>
                </div>

                <span id="resetMsg" style="display:none; font-size:13px; font-weight:600;"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="submitResetPassword()">
                    <i class="fa fa-paper-plane"></i> Reset Password
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="st_id" value="<?php echo $st_id ?>" />
<input type="hidden" id="dept" value="<?php echo $department ?>" />
<input type="hidden" id="sem" value="<?php echo $semester ?>" />
<input type="hidden" id="isEnrollment" value="<?php echo $isEnrollment ?>" />

<!-- ================= JS (with original functions preserved) ================= -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#studentLogin').modal('show');
    });

    //--------------------------------- otp -----------------------------------------------------//
    document.addEventListener("DOMContentLoaded", function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0];
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus();
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
        if (validateBtn) {
            validateBtn.addEventListener('click', function() {
                let otp = '';
                document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
                verifyOTP(otp);
            });
        }
    });

    //------------------------------- end otp ---------------------------------------------------//

    function requestEntry() {
        var isEnrollment = 0;
        var id = $('#studentNumber').val();
        if (id != "") {
            var url = '<?php echo base_url() ?>' + 'college/enrollment/requestEntry/';
            if ($("#departmentSelect").val() == "none") {
                alert('Please Select a Department');
            } else {
                var department = $("#departmentSelect").val();
                var semester = $('#semesterSelect').val();
                if (department != 5 && semester != 3) {
                    semester = 0;
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'id=' + id + '&isEnrollment=' + isEnrollment + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#requestBtn').html('System is requesting entry... Please wait');
                    },
                    success: function(data) {
                        $('#requestBtn').html('REQUEST ENTRY');
                        if (data.status) {
                            if (data.contact_num == "") {
                                alert('No contact info found. Please contact the registrar.');
                            } else {
                                if (data.option == 0) {
                                    $('#verifyNumberModal').modal('show');
                                    $('#enPhone').html(data.encrypt_num);
                                    $('#numConfirm').click(function() {
                                        var msg = 'Your One-Time Pin is ' + data.otp + '.';
                                        // alert(msg);
                                        document.location = data.url;
                                    });
                                    $('#numReject').click(function() {
                                        $(this).addClass('disabled');
                                        $('#numConfirm').addClass('disabled');
                                        $('#changeNum').show();
                                    });
                                    $('#saveNewNum').click(function() {
                                        var newNum = $('#newNum').val();
                                        if (newNum == '') {
                                            alert('Please enter a number');
                                        } else {
                                            var urlNew = base + 'college/enrollment/changeContacNumber';
                                            $.ajax({
                                                type: 'POST',
                                                url: urlNew,
                                                data: 'newNum=' + newNum + '&user_id=' + data.user_id + '&dept=' + data.department + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                                                success: function() {
                                                    alert('New Number Successfully Saved');
                                                    location.reload();
                                                },
                                                error: function() {
                                                    alert('Error saving number');
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    document.location = data.url;
                                }
                            }
                        } else {
                            reqMsg('Sorry, ID not registered');
                        }
                    }
                });
            }
        } else {
            reqMsg('You need to input your ID Number');
        }
    }

    function reqMsg(msg) {
        const reqBtn = document.getElementById('requestBtn');
        reqBtn.disabled = true;
        reqBtn.innerHTML = msg;
        reqBtn.style.backgroundColor = 'red';
        setTimeout(function() {
            reqBtn.disabled = false;
            reqBtn.innerHTML = 'REQUEST ENTRY';
            reqBtn.style.backgroundColor = 'green';

            const studentNumber = document.getElementById('studentNumber');
            studentNumber.value = '';
            studentNumber.focus();
        }, 3000)
    }

    function verifyOTP(otp) {
        var isEnrollment = 0;
        var semester = 0;
        var department = 1;
        var isPass = 0;
        var sy = '<?php echo $sy ?>';
        var url = '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/';
        $.ajax({
            type: "POST",
            url: url,
            data: 'pass=' + otp + '&stid=' + $('#st_id').val() + '&department=' + department + '&semester=' + semester + '&isEnrollment=' + isEnrollment + '&isPass=' + isPass + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',
            beforeSend: function() {
                $('#requestBtn').html('System is requesting entry... Please wait');
            },
            success: function(data) {
                if (data.status) {
                    document.location = data.url;
                } else {
                    alert('Wrong One Time Password');
                    document.location = '<?php echo base_url() ?>' + 'studentsEntrance';
                }
            }
        });
    }

    function verifyPassword(pass) {
        var stid = $('#st_id').val();
        var department = $("#dept").val();
        var semester = $('#sem').val();
        var sy = '<?php echo $sy ?>';
        var isPass = 1;
        $.ajax({
            type: 'POST',
            data: 'stid=' + stid + '&pass=' + pass + '&department=' + department + '&semester=' + semester + '&sy=' + sy + '&isPass=' + isPass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/',
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#lgnMsg').show().css('color', 'green').text(data.msg).delay(3000).fadeOut();
                    document.location = data.url;
                } else {
                    $('#lgnMsg').show().css('color', 'red').text(data.msg).delay(3000).fadeOut();
                }
            },
            error: function() {
                alert('Error verifying password');
            }
        });
    }

    function verifyLogin() {
        var id = $('#st_id').val();
        var pass = $('#studentPassword').val();

        if (id === "" || pass === "") {
            $('#loginMsg').show().css('color', 'red').text('Please fill in both fields.');
            return false;
        }

        var url = '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/';
        var sy = '<?php echo $sy ?>';
        var department = $("#dept").val() || 1;
        var semester = $("#sem").val() || 0;
        var isPass = 1;

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                stid: id,
                pass: pass,
                department: department,
                semester: semester,
                sy: sy,
                isPass: isPass,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loginBtn').html('System is requesting entry... Please wait').prop('disabled', true);
            },
            success: function(data) {
                $('#loginBtn').html('LOGIN').prop('disabled', false);
                if (data.status) {
                    $('#lgnMsg').show().css('color', 'green').text(data.msg);
                    setTimeout(function() {
                        document.location = data.url;
                    }, 1000);
                } else {
                    showLoginError("Incorrect password. Please try again!");
                    $('#lgnMsg').show().css('color', 'red').text(data.msg);
                }
            },
            error: function() {
                $('#loginBtn').html('LOGIN').prop('disabled', false);
                $('#lgnMsg').show().css('color', 'red').text('Login failed. Please try again.');
            }
        });

        return false;
    }

    // Toggle show/hide password
    document.querySelectorAll(".toggle-password").forEach(function(eyeIcon) {
        eyeIcon.addEventListener("click", function() {
            const target = document.querySelector(this.getAttribute("data-target"));
            const type = target.getAttribute("type") === "password" ? "text" : "password";
            target.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });

    // Example: trigger shake on login fail
    function showLoginError(message) {
        var group = document.getElementById("passwordGroup");
        var msg = document.getElementById("lgnMsg");

        msg.style.display = "block";
        msg.style.color = "red";
        msg.innerHTML = message;

        group.classList.add("shake");

        // remove shake class after animation to allow retrigger
        setTimeout(function() {
            group.classList.remove("shake");
        }, 500);
    }

    // Open modal on click
    document.getElementById("resetPass").addEventListener("click", function(e) {
        e.preventDefault();
        $('#forgotPasswordModal').modal('show');
    });

    // Handle reset request
    function submitResetPassword() {
        var number = document.getElementById("pnumber").value;
        var msg = document.getElementById("resetMsg");
        var stid = '<?= $st_id ?>';

        if (number.trim() === "") {
            msg.style.display = "block";
            msg.style.color = "red";
            msg.innerHTML = "⚠ Please enter Contact Number registered on the system.";
            return;
        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'college/enrollment/checkEcontactNum' ?>',
            data: 'num=' + number + '&stid=' + stid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    // Simulate sending request
                    msg.style.display = "block";
                    msg.style.color = "green";
                    msg.innerHTML = "✔ " + data.msg;
                } else {
                    msg.style.display = "block";
                    msg.style.color = "red";
                    msg.innerHTML = "⚠ " + data.msg;
                }
            }
        })

        //Close modal after 2s (simulate success)
        setTimeout(function() {
            $('#forgotPasswordModal').modal('hide');
            msg.style.display = "none";
            document.getElementById("resetPassword").value = "";
        }, 5000);
    }
</script>

<!-- ================= CSS Enhancements ================= -->
<style type="text/css">
    .rounded {
        border-radius: 10px !important;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .rounded-pill-input {
        border-radius: 50px !important;
    }

    /* inputs are fully rounded */
    .modal-content {
        border-radius: 15px;
    }

    .btn:hover {
        opacity: 0.9;
    }

    /* Password field wrapper */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 40px;
        /* space for the eye icon */
        border-radius: 30px;
        /* rounded pill style */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .password-wrapper .form-control:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 8px rgba(74, 144, 226, 0.3);
    }

    .password-wrapper .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
        transition: color 0.3s;
    }

    .password-wrapper .toggle-password:hover {
        color: #4a90e2;
    }

    /* Reset + message row */
    .reset-msg-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
    }

    #resetPass {
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
    }

    #resetPass:hover {
        text-decoration: underline;
    }

    #lgnMsg {
        display: none;
        font-size: 13px;
        font-weight: 600;
    }

    /* Shake animation */
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-6px);
        }

        40%,
        80% {
            transform: translateX(6px);
        }
    }

    .shake {
        animation: shake 0.4s ease-in-out;
    }

    /* Submit button styling */
    .btn-submit {
        width: 100%;
        border-radius: 30px;
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
        transition: background 0.3s, transform 0.2s;
    }

    .btn-submit:hover {
        background: #357abd;
        transform: translateY(-2px);
    }

    .otp-inputs {
        display: flex;
        justify-content: center;
    }

    .otp-box {
        width: 50px;
        height: 55px;
        font-size: 22px;
        font-weight: bold;
        border-radius: 10px;
        border: 2px solid #ccc;
        transition: all 0.2s ease-in-out;
    }

    .otp-box:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 8px rgba(46, 125, 50, 0.4);
        outline: none;
    }
</style>