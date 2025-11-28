<div class='panel panel-primary' id='passChange'>
    <div class='panel-heading'>
        Change Password
    </div>
    <div class='panel-body'>
        <label class='control-label' for='OldPassword'>Enter Old Password</label>
        <div class='controls'>
            <input type='password' name='oldPass' id='oldPass' value=''>
        </div>
        <label class='control-label' for='NewPassword'>Enter New Password</label>
        <div class='controls'>
            <input type='password' name='newPass' id='newPass' value=''>
        </div>
        <label class='control-label' for='ConfirmPassword'>Confirm Password</label>
        <div class='controls'>
            <input type='password' name='confirmPass' id='confirmPass' value=''>
        </div>
    </div>
    <button class='btn btn-sm btn-success pull-right' onclick='updatePassword()'>Update Password</button>
    <button class='btn btn-sm btn-danger pull-right' onclick='' data-dismiss='clickover'>Cancel</button>
    <div class='panel-footer'>
        <p id='errorMsg' class='alert alert-danger' hidden=''></p>
    </div>
</div>