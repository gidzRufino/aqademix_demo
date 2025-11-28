<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:5px auto">Daily Time Record Summary
            <small class="pull-right" >
                <div class="form-group input-group">
                    <input style="height:34px;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $date; ?>" id="inputBdate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button class="btn btn-success"onclick="searchAttendance($('#inputBdate').val())">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                
            </small>
        
        </h3>
        
    </div>
</div>