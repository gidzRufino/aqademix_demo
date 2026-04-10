<div class="col-md-10">
    <b>Credentials</b><br />
    <span>Username: <?php echo $this->session->username ?></span><br />
    <span>Password: <em id="dotdot">* * * * * *</em>&nbsp;&nbsp;
        <i class="fas fa-edit pointer" data-toggle="modal" data-target="#changePass" title="click to change password"></i>
    </span><br />
    <!-- <span>
        <button class="btn btn-primary btn-xs" onclick="reqOtp('<?php echo $this->session->basicInfo->ice_contact ?>')"><i class="fas fa-retweet"></i> Reset Password</button>
    </span> -->
</div>
<hr>
Parents Information

<div class="modal fade" id="changePass" tabindex="-1"
    role="dialog" aria-labelledby=" exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row justify-content-center">
                        <form>
                            <?php if ($this->session->basicInfo->secret_key != ''): ?>
                                <div class="col-md-12">
                                    <label>Enter Old Password</label>
                                    <div class="input-group" id="oldPassword">
                                        <input type="password" name='oldPass' id='oldPass'>
                                        <div class="input-group-addon">
                                            <a href="" class="cPass" tid="oldPassword">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter New Password</label>
                                    <div class="input-group" id="newPassword">
                                        <input type="password" name='newPass' id='newPass'>
                                        <div class="input-group-addon">
                                            <a href="" class="cPass" tid="newPassword">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-group" id="confPassword">
                                        <input type="password" name='confirmPass' id='confirmPass'>
                                        <div class="input-group-addon">
                                            <a href="" class="cPass" tid="confPassword">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
                </div>
            </div>
            <div class="modal-footer">
                <button class='btn btn-sm btn-success pull-right' onclick='updatePassword()'>Update Password</button>
                <button class='btn btn-sm btn-danger pull-right' onclick='' data-dismiss="modal">Cancel</button><br>
            </div>
        </div>
    </div>
</div>

<div id="otpCode" style="width:10%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h6>Enter OTP Code</h6>

        </div>
        <div class="panel-body">
            <h2 id="otp" style="text-align: center; letter-spacing: 3px"></h2>
        </div>
        <div class="paenl-footer">
            <input type="hidden" id="oCode" />
            <input type="hidden" id="pid" />
            <button class="btn-success" style="width: 100%; height: 50px" onclick="resetPassword()">Reset Password</button>
        </div>
    </div>
</div>
<?php
// print_r($this->session->basicInfo->secret_key);
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cPass').on('click', function(event) {
            event.preventDefault();
            var id = $(this).attr('tid');
            if ($('#' + id + ' input').attr('type') == 'text') {
                $('#' + id + ' input').attr('type', 'password');
                $('#' + id + ' i').addClass('fa-eye-slash');
                $('#' + id + ' i').removeClass('fa-eye');
            } else if ($('#' + id + ' input').attr('type') == 'password') {
                $('#' + id + ' input').attr('type', 'text');
                $('#' + id + ' i').removeClass('fa-eye-slash');
                $('#' + id + ' i').addClass('fa-eye');
            }
        });
    });

    function showHide(id) {
        if ($('#' + id + ' input').attr('type') == 'text') {
            $('#' + id + ' input').attr('type', 'password');
            $('#' + id + ' i').addClass('fa-eye-slash');
            $('#' + id + ' i').removeClass('fa-eye');
        } else if ($('#' + id + ' input').attr('type') == 'password') {
            $('#' + id + ' input').attr('type', 'text');
            $('#' + id + ' i').removeClass('fa-eye-slash');
            $('#' + id + ' input').addClass('fa-eye');
        }
    }

    function updatePassword() {
        var sKey = '<?php echo $this->session->basicInfo->secret_key ?>';
        if (sKey == '') {
            var oldPass = '';
        } else {
            var oldPass = $('#oldPass').val();
        }

        var newpass = $('#newPass').val();
        var confirmpass = $('#confirmPass').val();
        var pid = '<?php echo base64_encode($this->session->basicInfo->parent_id) ?>';
        //        alert(sKey + ' ' + oldPass + ' ' + newpass + ' ' + confirmpass);

        if (sKey == oldPass) {
            if (newpass == '') {
                errorMsg('New Password is empty!!!');
            } else {
                if (newpass != confirmpass) {
                    errorMsg('Password did not match!!!');
                } else {
                    $('#changePass').hide();
                    var url = '<?php echo base_url() . 'opl/p/changePass' ?>';

                    $.ajax({
                        type: 'POST',
                        data: 'pid=' + pid + '&newpass=' + newpass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                        url: url,
                        success: function(data) {
                            alert('Password Successfuly change!!!');
                            location.reload();
                        }
                    });
                }
            }
        } else {
            errorMsg('Old Password entered is incorrect!!!');
        }

    }

    function errorMsg(msg) {
        $('#errorMsg').show().delay(5000).queue(function(n) {
            $(this).hide();
            n();
        });
        $('#errorMsg').text('Error: ' + msg);
    }

    function reqOtp(val) {
        var url = '<?php echo base_url('registrar/requestOTP') ?>';

        $.ajax({
            type: 'POST',
            data: 'value=' + val + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#otpCode').modal('show');
                    $('#otp').text(data.otp);
                    $('#oCode').val(data.otp);
                    $('#pid').val(data.pid);
                }
            }
        })
    }

    function resetPassword() {
        var otp = $('#oCode').val();
        var pid = $('#pid').val();
        var url = '<?php echo base_url('registrar/resetPassword/') ?>' + otp + '/' + pid;

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                if (data) {
                    alert('Password Successfuly Reset');
                } else {
                    alert('An Error Occured');
                }
                location.reload();
            }
        })
    }
</script>

<style type="text/css">
    a,
    a:hover {
        color: #333;
    }

    form i {
        margin-left: -30px;
        cursor: pointer;
    }
</style>