<div id='addressInfo'>
    <div class='panel panel-info' style='margin:0;'>
        <div class='panel-heading '>
            Edit Address
        </div>
        <div class='panel-body'>
            <div class='form-group'>
                <label class='control-label'>Street</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='text' name='street' value='<?php echo $street ?>' placeholder='<?php echo $street ?>' id='street' />
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>Barangay</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='text' name='barangay' value='<?php echo $barangay ?>' placeholder='<?php echo $barangay ?>' id='barangay' />
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label' for='inputCity'>City / Municipality:</label>
                <select onclick='getProvince(this.value)' placeholder='Select A Municipality / City' style='width:100%;'  id='city' name='inputCity'>
                    <?php
                    foreach ($cities as $cit):
                        if ($city == $cit->cid):
                            $selected = 'selected';
                        else:
                            $selected = '';
                        endif;
                        ?>
                        <option <?php echo $selected; ?> value='<?php echo $cit->cid ?>'><?php echo $cit->mun_city . ' [ ' . $cit->province . ' ]' ?></option>
                    <?php endforeach; ?>
                </select>  
                <div class='controls'>

                    <!--<input class='form-control col-lg-12' type='text' name='lastname' value='<?php echo $city ?>' placeholder='<?php echo $city ?>' id='city' />-->
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>province</label>
                <div class='controls'>
                    <input style='margin-bottom:0;' value='<?php echo $province ?>' class='form-control'  name='inputProvince' type='text' id='inputProvince' placeholder='State / Province' required>
                    <input style='margin-bottom:0;' value='<?php echo $pid ?>' class='form-control'  name='inputPID' type='hidden' id='inputPID' placeholder='State / Province' required>
                </div>

            </div>
            <div class='control-group'>
                <label class='control-label'>Zip Code</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='text' name='barangay' value='<?php echo $zip_code ?>' placeholder='<?php echo $zip_code ?>' id='zip_code' />
                </div>

            </div>
        </div>

        <div class='panel-footer clearfix'>

            <input type='hidden' id='address_id' value='<?php echo $address_id ?>' />
            <input type='hidden' id='address_user_id' value='<?php echo $user_id ?>' />
            <input type='hidden' id='is_home' value='<?php echo $is_home ?>' />
            <input type='hidden' id='gsYr' value='<?php echo $gsYr ?>' />
            <input type='hidden' id='schID' value='<?php echo $sch_id ?>' />

            <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='clickover' onclick='editAddressInfo()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
        </div>         
    </div>


</div>
