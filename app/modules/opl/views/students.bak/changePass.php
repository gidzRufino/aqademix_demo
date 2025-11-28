<div class = "modal fade" id = "changePass" tabindex = "-1" 
     role = "dialog" aria-labelledby =" exampleModalLabel" aria-hidden = "true">
    <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title" id = "exampleModalLabel">Change Password</h5>
                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    <span aria-hidden = "true">×</span>
                </button>
            </div>

            <div class = "modal-body">
                <?php if ($key != ''): ?>
                    <label class='control-label' for='OldPassword'>Enter Old Password</label>
                    <div class='controls'>
                        <input type='password' name='oldPass' id='oldPass' value=''>
                    </div>
                <?php endif; ?>
                <label class='control-label' for='NewPassword'>Enter New Password</label>
                <div class='controls'>
                    <input type='password' name='newPass' id='newPass' value=''>
                </div>
                <label class='control-label' for='ConfirmPassword'>Confirm Password</label>
                <div class='controls'>
                    <input type='password' name='confirmPass' id='confirmPass' value=''>
                </div><br>
                <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
            </div>
            <div class="modal-footer">
                <button class='btn btn-sm btn-success pull-right' onclick='updatePassword()'>Update Password</button>
                <button class='btn btn-sm btn-danger pull-right' onclick='' data-dismiss = "modal">Cancel</button><br>
            </div>
        </div>
    </div>
</div>