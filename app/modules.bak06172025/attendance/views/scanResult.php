<input type="hidden" id="ifScan" value="<?php echo $profile->st_id ?>" />
<div class="clearfix row-fluid scan" style="margin: 0 auto 0"  >
        <input type="hidden" id="setAction" />
        <div class="span4">
            <img style="border:2px solid white;" src="<?php echo base_url();?>images/avatar/noImage.png" />
        </div>
        <div class="span7 row" style="margin-left:50px;">
            <div class="row-fluid">
                <div class="span8">
                </div>
                <div class="span3">
                    <h2 class="oswald" style="color:white; font-size: 55px; font-weight:normal; margin-top:25px;"><?php echo date('m/d/y');?></h2>
                    <h2 class="oswald" style="color:white; font-size: 45px; font-weight:normal; margin-top:15px; margin-left:0;"><?php echo strtoupper(date('l')) ;?></h2>
                </div>
            </div>
            <div class="row-fluid" style=" margin-top:55px;">
                <div class="span10">
                    <h2 class="oswald" id="lastname" style="color:white; font-size: 55px; font-weight:normal;"><?php echo $profile->lastname ?></h2>
                    <h2 class="oswald" id="firstname" style="color:white; font-size: 55px; font-weight:normal; margin-top:20px;"><?php echo $profile->firstname ?></h2>
                    <h3 id="user_id" style="color:white; font-family: Helvetica; font-size: 35px; font-weight:normal; margin-top:20px;"><span style="color:green;">ID #: <?php echo $profile->user_id ?></span></h3>
                </div>
            </div>
            <div class="row-fluid" style=" margin-top:30px;">
                <div class="hide">
                        <img id="check_in" style="width:40%;" src="" />
                </div>
            </div>
        </div>
</div>